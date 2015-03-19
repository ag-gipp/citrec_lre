<?php

namespace sciplore\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class StarterController extends Controller{
    public function indexAction()
    {
        return $this->render('sciploreUIBundle:Starter:index.html.twig');

    }
    public function finishedAction(){
        $this->getRequest()->getSession()->set('ref_docs', array());
        $this->getRequest()->getSession()->set('ref_doc_pos', 0);
        
        return $this->render('sciploreUIBundle:Starter:finished.html.twig');

    }
}

?>
