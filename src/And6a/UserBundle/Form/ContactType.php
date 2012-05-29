<?php

namespace And6a\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('type', 'choice', array(
                'choices' => array(
                    'Sites web' => array(
                        'www'       => 'Site web',
                        'www_p'     => 'Site web (perso)',
                        'www_blog'  => 'Blog',
                    ),
                    'Adresses' => array(
                        'addr'        => 'Adresse (perso)',
                        'addr_p'      => 'Adresse (parents)',
                    ),
                    'Téléphone' => array(
                        'tel'        => 'Téléphone',
                        'tel_p'      => 'Téléphone (parents)',
                    ),
                    'email' => 'Email'
                ),
            ))
            ->add('value')
            ->add('private')
        ;
    }

    public function getName()
    {
        return 'and6a_userbundle_contacttype';
    }
}
