<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
class ServiceHelper {
    public static function fetchEntityByID(EntityManager $em,$entity_name,$id){
//        $query_string = "SELECT x FROM sciploreDataAccessBundle:${entity_name} x WHERE x.id = :id";
//        print $query_string;
//        $query =  $em->createQuery($query_string)
//                          ->setParameter('id', $id);
//       return $query->getSingleResult();
        $qb = $em->createQueryBuilder();
        $qb->select('u')
              ->from('sciploreDataAccessBundle:'.$entity_name, 'u')
              ->where('u.id = ?1');
        $qb->setParameter(1, $id);
        
        $query = $qb->getQuery();
        
        $res = $query->getSingleResult();
        return $res;
    }
}

?>
