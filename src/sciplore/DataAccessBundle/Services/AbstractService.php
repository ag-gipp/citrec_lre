<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
abstract class  AbstractService {
    protected $em;
    public function __construct(EntityManager $em)
    {
        //$this->docs = $this->em->getRepository('sciploreDataAccessBundle:Document');
        $this->em = $em;
        

    }
    protected function getEM(){
        return $this->em;
    }
}

?>
