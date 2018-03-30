<?php

namespace Common\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\SecurityContextInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\HttpFoundation\Request;
use Common\UserBundle\Form\Type\LoginType;
use Common\UserBundle\Form\Type\RememberPasswordType;

class LoginController extends Controller {

    /**
     * @Route(
     *      "/login",
     *      name = "blog_login"
     *      )
     * @Template()
     */
    public function loginAction(Request $request) {
        $session = $this->get('session');

        //jesli w atrybutach ządania są błedne dane logowania..
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $loginError = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } else {
            $loginError = $session->remove(Security::AUTHENTICATION_ERROR); //jeśli błędne dane w sesji -> usuwa z sesji bledne logowanie
        }

        //korzystam z loginType w Form/Type
        $loginForm = $this->createForm(new LoginType, array(
            'username' => $session->get(Security::LAST_USERNAME) //jesli nastąpiło logowanie to zapamiętam nazwę usera
        ));

        //przypomnienie hasła
        $rememberPasswordForm = $this->createForm(new RememberPasswordType);

        if ($request->isMethod('POST')) {
            $rememberPasswordForm->handleRequest($request);

            if ($rememberPasswordForm->isValid()) {
                $userEmail = $rememberPasswordForm->getEmail()->getData();

                $userManager = $this->get('user_manager');
                $userManager->sendResetPasswordLink($userEmail);
            }
        }

        return array(
            'loginError' => $loginError,
            'loginForm' => $loginForm->createView(),
            'rememberPasswordForm' => $rememberPasswordForm->createView()
        );
    }

}
