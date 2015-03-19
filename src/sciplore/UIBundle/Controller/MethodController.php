<?php
namespace sciplore\UIBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


use sciplore\DataAccessBundle\Method;
use Symfony\Component\HttpFoundation\Response;

class MethodController extends Controller{
        /**
     * @Route("/method/{id}")
     * @Template()
     */
    public function indexAction($id)
    {
         $method = $this->getDoctrine()
        ->getRepository('sciploreDataAccessBundle:Method');
        $m = $method->find($id);
    if (!$m) {
        throw $this->createNotFoundException('No method found for id '.$id);
}
        return array('method' => $m);
    }
}

?>
