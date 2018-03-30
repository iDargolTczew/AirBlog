<?php

namespace Common\UserBundle\Manager;

use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface as Templating;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Common\UserBundle\Mailer\UserMailer;

class UserManager {
    
    /**
     * @var Doctrine
     */
    protected $doctrine;
    
    /*
     * @var Router
     */
    protected $router;
    
    /*
     * @var Templating
     */
    protected $templating;
    
    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;
    
    /*
     * @var UserMailer
     */
    protected $userMailer;
    
    
    function __construct(Doctrine $doctrine, Router $router, Templating $templating, EncoderFactory $encoderFactory, UserMailer $userMailer) {
        $this->doctrine = $doctrine;
        $this->router = $router;
        $this->templating = $templating;
        $this->encoderFactory = $encoderFactory;
        $this->userMailer = $userMailer;
    }
}
