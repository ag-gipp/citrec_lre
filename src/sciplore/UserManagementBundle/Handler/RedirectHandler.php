<?php
namespace sciplore\UserManagementBundle\Handler;

use \Symfony\Component\HttpFoundation\Session;
use \Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\EventDispatcher\Event;
use Symfony\Component\HttpFoundation\RedirectResponse;
class RedirectHandler
{
public function __construct(Router $router, SecurityContext $security, Session $session)
  {
    $this->router = $router;
    $this->security = $security;
    $this->session = $session;
  }
  
  
  
  public function onSecurityInteractiveLogin(Event $event)
    {
        echo 'interception';
        if ($this->security->isGranted('ROLE_USER'))
        {
            // redirect the user to where they were before the login process begun.
            $experiment_id = $this->session->get('experiment_id',null);
            if(!is_null($experiment_id)){
                print("test1234");
                return new RedirectResponse($this->router->generate('experiment_selection',array(id=>$experiment_id)));
            }
            else
            {
                
                $referer_url = $event->getRequest()->headers->get('referer');
                if(is_null($referer_url))
                    return new RedirectResponse($this->router->generate('experiment_index'));
                else
                    return new RedirectResponse($referer_url);
            }

        }
    }

    
}

?>
