<?php

namespace sciplore\DataAccessBundle\Services;
use Doctrine\ORM\EntityManager;
use sciplore\DataAccessBundle\Entity\DocumentHelper;
use sciplore\DataAccessBundle\Entity\Result;
use sciplore\DataAccessBundle\Entity\Experiment;
use sciplore\DataAccessBundle\Entity\ExperimentTask;
use sciplore\DataAccessBundle\Entity\Recommendation;
use sciplore\DataAccessBundle\Entity\User;
class RecommendationAccessService extends AbstractService{
        public function getRecommendationsByRefID($id)
        {
            $doc = DocumentHelper::fetchDocumentByID($this->getEM(),$id);
        //    $query = $this->em->createQuery('SELECT r FROM sciploreDataAccessBundle:Recommendation r WHERE r.document.pmcid = :doc')
        //                      ->setParameter('doc', $id);
            $qb = $this->em->createQueryBuilder();
            $qb->select('rec')
              ->from('sciploreDataAccessBundle:Recommendation', 'rec')
              ->innerJoin('rec.document', 'd')
              ->where('d.id = :ref');
            $qb->setParameters(array('ref'=> $id));
        
            $query = $qb->getQuery();
            return $query->getResult();
        }
         public function getRecommendationsForRefDocID($ref_doc_id){
            $qb = $this->em->createQueryBuilder();
            $qb->select('rec')
                  ->from('sciploreDataAccessBundle:Recommendation', 'rec')
                  ->where('rec.document = :ref_doc');
            $qb->setParameters(array('ref_doc'=> $ref_doc_id));
        
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;        
         }
        //should return a set of results
        public function getRecommendationsByRefIDForUserInExperiment($user_id, $experiment_id, $ref_doc_id){
//        $query = $this->em->createQuery('SELECT r FROM sciploreDataAccessBundle:Document r WHERE r.id = :id')
//                          ->setParameter('id', $ref_id)->getSingleResult();
        $ref_doc = ServiceHelper::fetchEntityByID($this->em, 'Document', $ref_doc_id);
        $user = ServiceHelper::fetchEntityByID($this->em, 'User', $user_id);
        $experiment = ServiceHelper::fetchEntityByID($this->em, 'Experiment', $experiment_id);

        
        //$query = $this->em->createQuery('SELECT r FROM sciploreDataAccessBundle:Result r WHERE r.reference_document = :ref AND r.user = :user AND r.experiment = :ex')
                          
        
        $qb = $this->em->createQueryBuilder();
        $qb->select('rec')
              ->from('sciploreDataAccessBundle:Result', 'res')
              ->innerJoin('res.recommendation', 'rec')
              ->innerJoin('rec.document', 'd')
              ->where('d.id = :ref')
              ->andWhere('res.user = :user')
              ->andWhere('res.experiment = :ex');
        $qb->setParameters(array('ref'=> $ref_doc, 'user'=>$user, 'ex'=>$experiment));
        
        $query = $qb->getQuery();
        $result = $query->getResult();
        return $result;
        
    }
    public function scoreRecommendationNominal($ref_id,$selected_document_id, $experiment_id,$confidence,$time,$user_id){
        $results = $this->getResultsByPK($user_id,$experiment_id,$ref_id);
        if(count($results) >0){
            $r = $results[0];
            $result_found = true;
        }
        else{
            $r = new Result();
        }
        $result_found = false;
         $ref_doc = ServiceHelper::fetchEntityByID($this->em, 'Document', $ref_id);
         $sel_doc = ServiceHelper::fetchEntityByID($this->em, 'Document', $selected_document_id);

        $user = ServiceHelper::fetchEntityByID($this->em, 'User', $user_id);
        $experiment = ServiceHelper::fetchEntityByID($this->em, 'Experiment', $experiment_id);       
 
        $r->setTime($time);
        $r->setConfidence($confidence);
        $r->setReferenceDocument($ref_doc);
        $r->setSelectedDocument($sel_doc);
        $r->setUser($user);
        $r->setExperiment($experiment);
       // $r->setTimestamp(time());
        //        $this->em->flush();

        //Override current result
        if($result_found)
            $this->em->merge($r);
        else
            $this->em->persist($r);
        
        $this->em->flush();

        return   $r;
    }
//    public function getDocuments(){
//        $query = $this->getEM()->createQuery('SELECT d FROM sciploreDataAccessBundle:Document d');
//        return $query->getResult();
//    }
    private function getResult(User $user, Experiment $experiment, Recommendation $rec){
        $qb = $this->em->createQueryBuilder();
        $qb->select('res')
            ->from('sciploreDataAccessBundle:Result', 'res')
            ->innerJoin('res.user', 'u')
            ->innerJoin('res.experiment', 'e')
            ->innerJoin('res.recommendation','recom')
            ->where('u = :user')
            ->andWhere('e = :experiment')
            ->andWhere('recom.rec_id = :rec');

        $qb->setParameters(array('user'=> $user, 'experiment' => $experiment, 'rec' => $rec->getRecId()));
        $q = $qb->getQuery();
        //$q->setHint("doctrine.includeMetaColumns",true);
        return $q->getOneOrNullResult();
    }
    public function createResult(User $user, Experiment $experiment, Recommendation $rec, $value, $time, $confidence){
        $result = $this->getResult($user,$experiment,$rec);
        $result_found = false;
        if($result != null){
            $r= $result;
            $result_found = true;
        }
        else{
            $r = new Result();
        }
        $r->setUser($user);
        $r->setExperiment($experiment);
        $r->setRecommendation($rec);
        $r->setValue($value);
        $r->setTime($time);
        $r->setConfidence($confidence);
        //Override current result
     
        if($result_found){    
            $this->em->merge($r);
        }
        else{
            $this->em->persist($r);
        }
        
        $this->em->flush();

        //return   $r;
    }
}

?>
