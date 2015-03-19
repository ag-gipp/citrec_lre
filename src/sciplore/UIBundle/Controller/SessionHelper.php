<?php

namespace sciplore\UIBundle\Controller;
use Symfony\Component\HttpFoundation\Controller;

class SessionHelper {    
    public static function getNextRefDocUrl($controller,$document_id){
            if(!is_null($document_id)){
                $url = $controller->generateUrl('recommendation_single_view', array('id' => $document_id));
                return $url;
        }
        else{
            return null;
        }
    }
}

?>
