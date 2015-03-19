<?php
namespace sciplore\UIBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller; 

abstract class AbstractController extends Controller{
    protected function retrieveOptionArray($experiment){
        return $this->get('sciplore.options')->retrieveOptionsForExperiment($experiment);
    }
}

?>
