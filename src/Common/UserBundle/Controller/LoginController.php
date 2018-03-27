<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * @Route("/login")
     * @Template()
     */
    public function loginAction(Request $request)
    {
        $session = $this->get('session');
        
        //jesli w atrybutach ządania są błedne dane logowania..
        if( $request->attributes->has(Security::AUTHENTICATION_ERROR) ){
            $loginError = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $loginError = $session->remove(Security::AUTHENTICATION_ERROR); //jeśli błędne dane w sesji -> usuwa z sesji bledne logowanie
        }
        return array(
            'loginError' => $loginError
        );
    }
}
