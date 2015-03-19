<?php
namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Entity\DocumentHelper;

class DocumentAccessService extends AbstractService{
    public function getDocumentByID($id)
    {
       // return DocumentHelper::fetchDocumentByID($this->getEM(),$id);
        return ServiceHelper::fetchEntityByID($this->getEM(),'Document',$id);
    }
    public function getDocuments(){
        $query = $this->getEM()->createQuery('SELECT d FROM sciploreDataAccessBundle:Document d');
        return $query->getResult();
    }
}

?>
