<?php

namespace sciplore\DefaultOutputBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
//use sciplore\ETDataAccess\Models\Method;

class DefaultController extends Controller
{
    /**
     * @Route("/hello/{name}")
     * @Template()
     */
    public function indexAction($name)
    {

        return array('name' => $name);
    }
    /**
     *@Route("/test")
     * 
     */
    public function testAction(){
      //  $method = Method::find_by_id(1);
        $dm = $this->get('sciplore.document_manager');
        $doc = $dm->getDocumentByID(2);
        
        return new Response("HelloWorld:". $doc->getTitle());
    }
}
