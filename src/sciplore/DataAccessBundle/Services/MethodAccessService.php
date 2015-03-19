<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Services\ServiceHelper;

class MethodAccessService extends AbstractService{
    public function getMethodByID($id){
        return ServiceHelper::fetchEntityByID($this->em,'Method',$id);
    }
}

?>
