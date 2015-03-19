<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Entity\DocumentHelper;
use sciplore\DataAccessBundle\Entity\Result;
use sciplore\DataAccessBundle\Entity\User;

class UserAccessService extends AbstractService{
    public function getUserByName($name){
        $qb = $this->em->createQueryBuilder();
        $qb->select('u')
              ->from('sciploreDataAccessBundle:User', 'u')
              ->where('u.name = ?1');
        $qb->setParameter(1, $name);
        
        $query = $qb->getQuery();
        
        $user = $query->getOneOrNullResult();//caller MUST care about null value!!
        return $user;
    }
    public function getUserById($id){
        return ServiceHelper::fetchEntityByID($this->em,'User',$id);

    }
    public function createUser($username, $password){
            $nuser = new User();
            $nuser->setName($username);
            $nuser->setPassword($password);
            //var_dump($nuser);
            $this->em->persist($nuser);
            $this->em->flush();
            return $nuser;
    }
}

?>
