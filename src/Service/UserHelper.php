<?php 

namespace App\Service;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserHelper
{
    // encoder 
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }
    
    // encode pwd 
    public function encodePassword($form, $user)
    {
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            $form->getData()->getPassword()
        ));
        return $user;
    }

    // edit roles 
    public function editRoles($form) 
    {
        if($form['roles']->getData()) {
            $role[] = $form['roles']->getData();
            $user = $form->getData();
            $user->setRoles($role);
        }
        return $user;
    }
    
}