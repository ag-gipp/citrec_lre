<?php

namespace sciplore\AnalysisBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use sciplore\DataAccessBundle\Entity\Experiment;

class AnalysisController extends Controller
{
    public function indexAction(Request $request){
        $session = $request->getSession();
        $experiments = $this->get("sciplore.experiment_manager")->getExperiments();
        $sel_exp = $session->get('experiment_id');
        $val = is_null($sel_exp)? $experiments[0]->getId() : $sel_exp;        
        return $this->render('sciploreAnalysisBundle:Analysis:index.html.twig',  array('experiments' => $experiments, 'sel_exp'=>$val));

    }
    private function getExperimentService(){
        return $this->get('sciplore.experiment_manager');
    }
    private function callService($experiment_id, $user_id=null){
        $experiment = $this->getExperimentService()->getExperimentByID($experiment_id);
        $arr = $this->get('sciplore.analysis_manager')->getDataForAnalysis($experiment->getId(), $experiment->getResultType()->getName(),$user_id);
        return $arr;
    }
    private function createResultFor($arr){
        $response = new Response();
        $response->setContent(json_encode($arr));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');        
        
        return $response;
    }
    public function ExperimentAction($experiment_id)
    {

        //$arr = DataAnalysis::analyseData($this->getDoctrine()->getEntityManager());
        //var_dump($arr);
        
        return $this->createResultFor($this->callService($experiment_id));
    }
    
    public function userExperimentAction($experiment_id){
        $user = $this->get('security.context')->getToken()->getUser();
        $user_id = $user->getId();
        $arr = $this->callService($experiment_id,$user_id);
        return $this->createResultFor($arr);
    }
/*    public function projectJsonAction($id)
    {

        $response = new Response();
        $arr = $this->get('sciplore.analysis_manager')->getDataForAnalysis($id);
        //var_dump($arr);
        $response->setContent(json_encode($arr));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');        
        
        //return $response;
    }*/
    public function optionsAction($experiment_id){
        $experiment = $this->getExperimentService()->getExperimentByID($experiment_id);
        $options = $this->retrieveOptionArray($experiment);        
        return $this->createResultFor($options);
    }
    
    private function retrieveOptionArray(Experiment $experiment){
        return $this->get('sciplore.options')->retrieveOptionsForExperiment($experiment);
    }
    
}
