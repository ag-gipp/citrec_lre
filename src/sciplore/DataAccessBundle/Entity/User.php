<?php

namespace sciplore\DataAccessBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use sciplore\DataAccessBundle\sciploreDataAccessBundle;
/**
 * @ORM\Entity
 * 
 * @ORM\Table(name="user")
 */
class User implements UserInterface{//UserInterface is required by the symfony2 user management
     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
     /**
     * @ORM\Column(type="string", length=200, nullable=false)
     */
    protected $name;

     /**
     * @ORM\Column(type="string", length=200, nullable=true)
     */
    protected $passphrase;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function setPassword($password)
    {
        $this->passphrase = $password;
    }
    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }
    /**
     *@return Role[] 
     */
     function getRoles(){
         return array('ROLE_USER');
         
     }
    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    function getPassword(){
        $options = sciploreDataAccessBundle::getGeneralOptions();
        //$options = $container->get('sciplore.options')->getGeneralOptions();
        $require_password = $options['authentifiaction_requires_password']; 
        if($require_password==1){
            return $this->passphrase;
        }
        else{
            //hardcoded random default password. Must be sent by the authentification form in a hidden field.
            return 'WnDadvfhWqoJnHuXtyxwZxGbfHsXrNwI3Idns4d2Ie9BnEjYnr14ijyCr0YPg7i';
        }
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string The salt
     */
    function getSalt(){return '';}

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    function getUsername(){return $this->getName();}

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     *
     * @return void
     */
    function eraseCredentials(){;
    }
    /**
     * Returns whether or not the given user is equivalent to *this* user.
     *
     * The equality comparison should neither be done by referential equality
     * nor by comparing identities (i.e. getId() === getId()).
     *
     * However, you do not need to compare every attribute, but only those that
     * are relevant for assessing whether re-authentication is required.
     *
     * @param UserInterface $user
     *
     * @return Boolean
     */
    function equals(UserInterface $user){
        return $this->getUsername() == $user->getUsername() && $this->getId() == $user->getId();
    }




    /**
     * Set passphrase
     *
     * @param string $passphrase
     */
    public function setPassphrase($passphrase)
    {
        $this->passphrase = $passphrase;
    }

    /**
     * Get passphrase
     *
     * @return string 
     */
    public function getPassphrase()
    {
        return $this->passphrase;
    }
}