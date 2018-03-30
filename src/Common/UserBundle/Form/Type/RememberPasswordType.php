<?php

namespace Common\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RememberPasswordType extends AbstractType {
    
    public function getName() {
        return 'rememberPassword';        
    }
    
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
                ->add('email', 'email', array(
                    'label' => 'Twój email',
                    'constraints' => array(
                        new Assert\NotBlank(), //reguly walidacji, nie moze byc puste
                        new Assert\Email()     //to ma byc adres email
                    )
                ))
                ->add('submit', 'submit', array(
                    'label' => 'Przypomnij hasło'
                ));
    }
}
