<?php

namespace sciplore\DataAccessBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use sciplore\DataAccessBundle\Entity\Recommendation;
use sciplore\DataAccessBundle\Entity\DocumentHelper;
use \sciplore\DataAccessBundle\Services\RecommendationAccessService;
use sciplore\DataAccessBundle\Services\ServiceHelper;
class RecommendationTest extends WebTestCase{
    private $em;
    private $rec;
    private $doc;
    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        
        $query = $this->em->createQuery('SELECT r FROM sciploreDataAccessBundle:Recommendation r WHERE r.rec_id = :id')
                            ->setParameter('id', 5);
        $this->rec = $query->getSingleResult();
        $this->doc = DocumentHelper::fetchDocumentByID($this->em,2);
    }
    
    public function testRelations(){
        $this->assertEquals($this->doc,$this->rec->getDocument());
       $query = $this->em->createQuery('SELECT m FROM sciploreDataAccessBundle:Method m WHERE m.id = :id')
                            ->setParameter('id', 1);
       $method = $query->getSingleResult();
       $this->assertEquals($method, $this->rec->getMethod());
       $rec_doc = $this->rec->getRecommendedDocument();
       //var_dump($rec_doc);
       $expteced_doc = DocumentHelper::fetchDocumentByID($this->em, 91);
       $this->assertEquals($rec_doc, $expteced_doc);
    }
    
    public function testCreateScore(){
        $ras = new RecommendationAccessService($this->em);
        $user =  ServiceHelper::fetchEntityByID($this->em,'User',0);
        var_dump($user->getId());
        $selected_document_id = DocumentHelper::fetchDocumentByID($this->em, 91);
        $doc = DocumentHelper::fetchDocumentByID($this->em, 2);
        $result = $ras->scoreRecommendation($doc,$selected_document_id,3,100,$user);
        $this->assertNotNull($result);
    }
}
?>
