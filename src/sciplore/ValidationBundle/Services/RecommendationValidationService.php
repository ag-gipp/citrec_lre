<?php

namespace sciplore\ValidationBundle\Services;
use sciplore\DataAccessBundle\Services\RecommendationAccessService;
use sciplore\DataAccessBundle\Services\MethodAccessService;
use sciplore\ValidationBundle\sciploreValidationBundle;
use sciplore\DataAccessBundle\Entity\User;
use sciplore\DataAccessBundle\Entity\Experiment;

class RecommendationValidationService{
    protected $ra;
    protected $method_as;
    protected $container;
    public function __construct( MethodAccessService $method_service){
        //var_dump($ra);
        //$this->ra = $ra;
        $this->method_as = $method_service;
        $this->container = sciploreValidationBundle::getContainer();
    }
    //implement the visitor pattern; Instead of visit I use validate as prefix.
    //Every method should break evaluation and return an error message if an error occured, or true if no error occured
/*    protected function validateRecommendation($recommendation){//no type annotation to keep it flexible
        if(is_null($recommendation->getMethod())){
            return "For this recommendation no method is selected";
        }
        $id = $recommendation->getMethod()->getId();
        try{
            $method = $this->method_as->getMethodByID($id);
        }
        catch (Exception $e) {
            return "Problems with accessing the accsociated method. Error Message:\n"+ $e->getMessage();
            
        }
        return  $this->validateDocument($recommendation->getRecommendedDocument()) &&
                $this->validateDocument($recommendation->getDocument());
    } */
    //return false if the document is not valid
    protected function validateDocument($document,$message=null){
        $errors = array();
        if(is_null($document)){
            $errors[] =  ($message ==null)? "Document reference should not be null" : $message;
            return $errors;
        }
         $temp  = $this->check_existence_of_field($document, 'getPMCUrl','PMCUrl not found');
         if(!empty($temp))
            $errors[] =  $temp;
        $temp =  $this->check_existence_of_field($document, 'Abstract', 'No abstract for the current document found');
        if(!empty($temp))
            $errors[] =  $temp;
         return  $errors;
        
    }
    protected function validateDocumentById($document_id, $message=null){
        $doc = $this->container->get('sciplore.document_manager')->getDocumentByID($document_id);
        //var_dump($doc);
        return $this->validateDocument($doc, $message);
    }
         
      
    protected function validateUniquenessOfResult($ref_doc_id,$experiment_id,$user_id){
        $rec_manager = $this->container->get('sciplore.rec_manager');
        //$results = $this->container->get('sciplore.rec_manager')->getResultsByPK($user_id,$experiment_id,$ref_doc_id);
        $recommendations_with_user = $rec_manager->getRecommendationsByRefIDForUserInExperiment($user_id,$experiment_id,$ref_doc_id);
        $recommendations =  $rec_manager->getRecommendationsByRefID();
        $invalid = false;
        foreach($recommendations as  $rec){
            if(!$recommendations_with_user->contains($rec)){
                $invalid = true;
                break;
            }
        }
        //$count = count($results)<=1;
        //if($count <=1) return '';
        if(!invalid) return '';
        else
            return "Error: Result is not unique or null. There are ${count} entities for this primary key";
    }
    
    /**
     *@return boolean or string. Thes method return FALSE if !!NO!! error found. Otherwise returns error_message
     **/
/*    public function validateResult($ref_doc_id,$experiment_id,$confidence,$time,$user_id){
        $errors = array();
        $user = $this->container->get('sciplore.user_manager')->getUserById($user_id);
        //check user
        if(is_null($user)){
            $errors[] = 'User is not defined';
        }
        //test experiment
        $user = $this->container->get('sciplore.experiment_manager')->getExperimentByID($experiment_id);
        if(is_null($user)){
            $errors[] = 'Experiment is not defined';
        }
        $res  = $this->validateUniquenessOfResult($ref_doc_id,$experiment_id,$user_id,$options);
        if($res) $errors[] = $res;
        //test if refered documents exists
        $errors = array_merge($errors, $this->validateDocumentById($ref_doc_id));
        $errors = array_merge($errors, $this->validateDocumentById($selected_document_id,'Please make a selection to continue!'));
        //check confidence
        $min = $options['min_confidence'];
        $max = $options['max_confidence'];
        $value = intval($confidence);
        $in_correct_range = (($value >= $min) && ($value <= $max));
        //var_dump($in_correct_range);
        if(!$in_correct_range){
            $errors[] = 'Selected confidence is not within valid range.';
        }

        //check uniquess
        return $errors;//If result is valid, this method will return a empty array
    }
    */
    
    private function check_existence_of_field($entity, $field_name, $parameter=null, $message=null){

        if(preg_match('/^get(.*)/',$field_name)==1)
           $method_name = $field_name;
         else
            $method_name = 'get'.$field_name;
        if(is_null($message)){
            $mesage =  'Error by calling: '.$method_name.'\n';
        }
         try{
            $res = call_user_func(array($entity, $method_name), $parameter);
            if(is_null($res))
                return $message.'\n The method returns null';
         }
         catch (Exception $e) {
             
            return $message.$e->getMessage();
        }
        return '';
    }
    
    public function validateNominalResult(User $user, Experiment $experiment, $ref_doc_id, $selected_document_id, $value, $confidence, $options){
    $errors = array();
        //$user = $this->container->get('sciplore.user_manager')->getUserById($user_id);
        //check user
        //if(is_null($user)){
        //    $errors[] = 'User is not defined';
        //}
        //test experiment
        //$user = $this->container->get('sciplore.experiment_manager')->getExperimentByID($experiment_id);
        //if(is_null($user)){
        //    $errors[] = 'Experiment is not defined';
        //}
        $res  = $this->validateUniquenessOfResult($ref_doc_id,$experiment,$user,$options);
        if($res) $errors[] = $res;
        //test if refered documents exists
        $errors = array_merge($errors, $this->validateDocumentById($ref_doc_id));
        $errors = array_merge($errors, $this->validateDocumentById($selected_document_id,'Please make a selection to continue!'));
        //check confidence
        $min = $options['min_confidence'];
        $max = $options['max_confidence'];
        $value = intval($confidence);
        $in_correct_range = (($value >= $min) && ($value <= $max));
        //var_dump($in_correct_range);
        if(!$in_correct_range){
            $errors[] = 'Selected confidence is not within valid range.';
        }

        //check uniquess
        return $errors;//If result is valid, this method will return a empty array
    }
    

}

?>
