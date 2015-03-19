<?php

namespace sciplore\UIBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use sciplore\DataAccessBundle\Entity\Document;
use sciplore\DataAccessBundle\Entity\Recommendation;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
define('ERROR_SESSION_NAME', 'errors');

define('CURRENT_FORM_DATA', 'cur_form_data');
define('USER_START_TIME_SESSION', 'user_start_time');
class RecommendationController  extends AbstractController{
    
    public function showAction(Request $request,$id){
        //show all recommendations for the document with the id $id
        $recommendations = $this->getRecAS()->getRecommendationsByRefID($id);
        
        $experiment = $this->getExperimentAS()->getExperimentByID($request->getSession()->get("experiment_id"));
        $options = $request->getSession()->get("options");
        
        $confidence = null;
        $selected_document_id = null;
        
        //fetch current data from session and clear it
        //retrieve the error messages        
        $errors = $request->getSession()->get(ERROR_SESSION_NAME);//fetch errrors from session
        $request->getSession()->set(ERROR_SESSION_NAME,null);//clear errors from session
        
        $data = $request->getSession()->get(CURRENT_FORM_DATA);
        $request->getSession()->set(CURRENT_FORM_DATA,null);
        if(!is_null($data)){
            $confidence = $data['confidence'];
            $selected_document_id = $data['sel_doc_id'];
        }
        if(is_null($confidence)) $confidence = $options["def_confidence"];
        

        //begin with time measurement
        $request->getSession()->set(USER_START_TIME_SESSION,time());

        $doc = $this->getDocumentAS()->getDocumentByID($id);
        $recommendations = $this->getRecAS()->getRecommendationsForRefDocID($id);
        switch ($experiment->getResultType()->getName()) {
            case "nominal":
                $recommended_documents = array();
                //collect all ids from the recommended documents
                foreach ($recommendations as $rec){
                    array_push($recommended_documents, $rec->getRecommendedDocument());
                }
                //the order of the recommendations on the page should be randomized in every case.
                shuffle($recommended_documents);
                return $this->render('sciploreUIBundle:Recommendation:show_nominal.html.twig', array('ref_doc' => $doc, 'recommendations' => $recommendations, 'sel_doc_id'=> $selected_document_id,'options'=> $options));
            break;
                
            case "ordinal":
                return $this->render('sciploreUIBundle:Recommendation:show_ordinal.html.twig', array('ref_doc' => $doc, 'recommendations' => $recommendations,'options'=> $options));
            break;
        }
    }
    
    
    /*Proxy to the "real" data url. This emthod prevents the AnalysisBundle to be depend on the Session*/
    public function currentGraphDataAction(Request $request){
        $experiment_id = $request->getSession()->get('experiment_id');
        return $this->forward("sciploreAnalysisBundle:Analysis:userExperiment",array('experiment_id'=>$experiment_id));
    }
    public function currentGraphOptionsAction(Request $request){
        $experiment_id = $request->getSession()->get('experiment_id');
        return $this->forward("sciploreAnalysisBundle:Analysis:options",array('experiment_id'=>$experiment_id));
    }
    
    
    public function scoreAction(Request $request, $id){
        $session = $request->getSession();
        $session->set(ERROR_SESSION_NAME,null);
        $experiment_id = $request->getSession()->get("experiment_id");
        $experiment = $this->getExperimentAS()->getExperimentByID($experiment_id);
        
        $options = $this->retrieveOptionArray($experiment);
        $time = time() - ($session->get(USER_START_TIME_SESSION));
        
        $user = $this->get('security.context')->getToken()->getUser();
        $user_id = $user->getId();
        
        $ref_doc_id = $id;
        $errors = null;
        $confidence = $request->get('confidence');
        
        switch($options["result_type"]){
            case 'nominal':
                $recommendations = $this->getRecAS()->getRecommendationsByRefID($id);
                foreach($recommendations as $rec){
                    $recommended_doc_id = $rec->getRecommendedDocument()->getId();
                    $sel_doc_id = $request->get('selected_doc');
                    
                    $value = ($recommended_doc_id == $sel_doc_id)? 1:0;
                    $this->getRecAS()->createResult($user,$experiment, $rec, $value, $time, $confidence);
                }
                break;
            case 'ordinal':
                $recommendations = $this->getRecAS()->getRecommendationsByRefID($id);
                foreach($recommendations as $rec){
                    $id = $rec->getRecId();
                    $param_name = "{$options['points_selection_prefix']}{$id}";
                    $value = $request->get($param_name);
                    if(isset($value) && !$value == null){
                        $this->getRecAS()->createResult($user,$experiment, $rec, $value, $time, $confidence);
                    }
                }
                break;
        }

        $this->get('sciplore.flow_manager')->markDocument($ref_doc_id);
        $next_id = $this->get('sciplore.flow_manager')->getNextUnmarkedDocument();
        $url = SessionHelper::getNextRefDocUrl($this,$next_id);
         if(!is_null($url)){
            return $this->redirect ($url);
        }
         else{
            return $this->redirect($this->generateUrl ('finished'));
         }

            
    }

    private function getRecAS(){
        return $this->get('sciplore.rec_manager');
    }
    private function getDocumentAS(){
        return $this->get('sciplore.document_manager');
    }
        private function getExperimentAS(){
        return $this->get('sciplore.experiment_manager');
    }
}
?>
