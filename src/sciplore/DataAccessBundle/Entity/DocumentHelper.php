<?php

namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Services\ServiceHelper;
class DocumentHelper {
    public static function fetchDocumentByID(EntityManager $em, $id){
//              $query = $em->createQuery('SELECT d FROM sciploreDataAccessBundle:Document d WHERE d.id = :id')
//                          ->setParameter('id', $id);
//              return $query->getOneOrNullResult();
        return ServiceHelper::fetchEntityByID($em,'Document',$id);
    }
}

?>
