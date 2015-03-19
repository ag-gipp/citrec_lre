<?php

namespace sciplore\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ExperimentController extends AbstractController{
    public function indexAction()
    {
        $exs = $this->getExperimentAS()->getExperiments();
        return $this->render('sciploreUIBundle:Experiment:list.html.twig', array('experiments' => $exs));

    }
    public function selectionAction(Request $request,$id){
        //put selected experiment in session
        //redirect to first recommendation
        $ex = $this->getExperimentAS()->getExperimentByID($id);
        $arr = $ex->getTasks()->toArray();
        $session_arr = array();
        foreach($arr as $t){
            $session_arr[]= $t->getReferenceDocument()->getId();
        }
        $this->get('sciplore.flow_manager')->initializeArray($session_arr, $ex->getRandomizeOrder());
  

        $session = $request->getSession();

        //Serialising Entities runs into problem. Therefore only seralize the id an ask a ExperimentDataAccessService for an instance.
        $session->set('experiment_id', $ex->getId());
        $session->set('options', $this->retrieveOptionArray($ex));
        $next_id = $this->get('sciplore.flow_manager')->getNextUnmarkedDocument();
        $url = SessionHelper::getNextRefDocUrl($this,$next_id);
        if(!is_null($url)) return $this->redirect ($url);
        else return $this->redirect($this->generateUrl ('finished'));
        
    }
    public function resetAction($id){
        $user = $this->get('security.context')->getToken()->getUser();
        $this->getExperimentAS()->resetExperimentResults($id, $user->getId());
        return $this->redirect($this->generateUrl ('experiment_index'));

    }
    
    public function progressAction(){
        $fm = $this->get('sciplore.flow_manager');
        $arr_export = array('cur'=>$fm->getNumberOfUnMarkedDocuments(), 'max'=>$fm->getSize());
        $response = new Response();
        $response->setContent(json_encode($arr_export));
        $response->setStatusCode(200);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }
    
    private function getExperimentAS(){
        return $this->get('sciplore.experiment_manager');
        
    }
    

}

?>
