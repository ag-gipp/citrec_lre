<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
class ExperimentAccessService  extends AbstractService{
    public function getExperiments(){
        $query = $this->em->createQuery('SELECT e FROM sciploreDataAccessBundle:Experiment e WHERE e.visible = 1');
        return $query->getResult();
    }
    public function getExperimentByID($id){
        $ex =  ServiceHelper::fetchEntityByID($this->em, 'Experiment', $id);
        return $ex;
    }
    public function resetExperimentResults($experiment_id, $user_id){
        //$ex =  ServiceHelper::fetchEntityByID($this->em, 'Experiment', $experiment_id);
        //$user =  ServiceHelper::fetchEntityByID($this->em, 'User', $user_id);

        $qb = $this->em->createQueryBuilder();
        
        $qb->select('r')
              ->from('sciploreDataAccessBundle:Result', 'r')
              ->where('r.user = :user')
              ->andWhere('r.experiment = :ex');
        $qb->setParameters(array( 'user'=>$user_id, 'ex'=>$experiment_id));
        
        $query = $qb->getQuery();
        $results = $query->getResult();
        foreach($results as $r){
            $this->em->remove($r);
        }
        $this->em->flush();
    }
    
//    public function getReferenceDocumentsForExperiment($ex_id){
//        $qb = $this->em->createQueryBuilder();
//        $qb->select('ref_doc_id')
//              ->from('sciploreDataAccessBundle:ExperimentTask')
//              ->where('e.$reference_document = ?1')
//              ->orderBy('e.position');
//        $qb->setParameter(1, $ex_id);
//        
//        $query = $qb->getQuery();
//        return $query->getResult();
//    }    
}

?>
