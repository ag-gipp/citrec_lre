<?php

namespace sciplore\DataAccessBundle\Tests\Entity;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use sciplore\DataAccessBundle\Entity\Document;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Entity\DocumentHelper;

class DocumentTest extends WebTestCase{
    private $em;
    private $doc;

    public function setUp()
    {
        $kernel = static::createKernel();
        $kernel->boot();
        $this->em = $kernel->getContainer()->get('doctrine.orm.entity_manager');
        $this->doc = DocumentHelper::fetchDocumentByID($this->em,2);

    }

    public function testDocumentByTitle()
    {

       // var_dump($this->doc);
        $this->assertEquals('Noninvasive monitoring of myocardial function after surgical and cytostatic therapy in a peritoneal metastasis rat model: assessment with tissue Doppler and non-Doppler 2D strain echocardiography', $this->doc->getTitle());
        $this->assertEquals('http://www.ncbi.nlm.nih.gov/pmc/articles/PMC1965460/pdf/', $this->doc->getPMCUrl());
    }
    public function testAbstractRef(){
        $abs = $this->doc->getAbstractText();
        $this->assertNotNull($abs);
    }
}

?>
