<?php

namespace sciplore\UIBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DocumentController extends Controller
{
   

    public function showAction($id)
    {
        $doc = $this->getDocumentAS()->getDocumentByID($id);
        return $this->render('sciploreUIBundle:Document:show.html.twig', array('doc' => $doc));
    }
    private function getDocumentAS(){
        return $this->get('sciplore.document_manager');
    }
}
