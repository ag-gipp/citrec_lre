<?php
namespace sciplore\FlowManagementBundle\Services;
use Symfony\Component\HttpFoundation\Session;
define('SESSION_KEY_REF_DOCS','ref_docs');

class FlowManagementService {
    protected $session;
    //private static $arrayCache = null;
    public function __construct(Session $s)
    {
        $this->session = $s;
    }

    protected function getSession(){
        return $this->session;
    }
    protected function getArrayFromSession(){
        //if(FlowManagementService::$arrayCache == null){
            //FlowManagementService::$arrayCache = $this->getSession()->get(SESSION_KEY_REF_DOCS);
        //}
        //return FlowManagementService::$arrayCache;
        return $this->getSession()->get(SESSION_KEY_REF_DOCS);
    }

    protected function setArrayToSession($arr){
        $this->getSession()->set(SESSION_KEY_REF_DOCS, $arr);
    }

    //This method is called from ExperimentController to hand in a new set of ref_doc_ids
    public function initializeArray($arr_of_doc_ids, $randomize_order){
        $tmp_arr = $arr_of_doc_ids;
        if($randomize_order){
            shuffle($tmp_arr);//randomize the order of the elements
        }
        $arr = array();
        foreach($tmp_arr as $id){
            $arr[$id] = true;
        }
        $this->setArrayToSession($arr);
    }

    protected function getFilteredArray(){
        return array_filter($this->getArrayFromSession());
    }

    public function getNextUnmarkedDocument(){
        $arr = $this->getFilteredArray();
        if(count($arr)>0) return current(array_keys($arr));
        else              return null;
    }

    public function markDocument($doc_id){
        $arr = $this->getArrayFromSession();
        $arr[$doc_id] = false;
        $this->setArrayToSession($arr);
    }
    
    public function getSize(){
        return count($this->getArrayFromSession());
    }

    public function getNumberOfUnMarkedDocuments(){
        $marked_doc = count($this->getFilteredArray());
        return $this->getSize()-$marked_doc;
    }
}

?>
