<?php


namespace sciplore\UserManagementBundle\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use sciplore\DataAccessBundle\Entity\User;
class AutoLoginController extends Controller{
    public function loginAction(){
        $options = $this->get('sciplore.options')->getGeneralOptions();
        if($options['autologin_enable'] == 1){
            $request = $this->container->get('request');

            $session = $request->getSession();
            $username = $request->get('username');
            $password = $request->get('password');
            $experiment_id = $request->get('experiment');

            $session = $request->getSession();
            $user_service = $this->get('sciplore.user_manager');
            $user = $user_service->getUserByName($username);
            
            //check password
            if($options['authentifiaction_requires_password']==1 && !is_null($user) && $user->getPassword() != $password){     
                return
                    $this->redirect($this->generateUrl ('start_page'));
            }
            //Create User
            if($options['autologin_create_user'] == 1){
                if(is_null($user)){    
                    $user = $user_service->createUser($username, $password);
                }
            }
            else{
                if(is_null($user)){
                    return $this->redirect($this->generateUrl ('start_page'));
                }
            }
            
            $this->authenticateUser($user);

            $url = $this->generateUrl('experiment_selection',array('id'=> $experiment_id));
            return new RedirectResponse($url);
        }
        else
            return $this->redirect($this->generateUrl ('start_page'));
    }
    
    private function authenticateUser(UserInterface $user)
    {
        $providerKey = 'main'; // your firewall name
        $token = new UsernamePasswordToken($user, null, $providerKey, $user->getRoles());

        $this->container->get('security.context')->setToken($token);
    } 
}

?>
