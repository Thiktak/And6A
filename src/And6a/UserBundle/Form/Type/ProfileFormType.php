<?php

namespace And6a\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    public function buildUserForm(FormBuilder $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
            ->add('name')
            ->add('fname')
            ->add('birthday', 'birthday', array(
                'format' => 'dd-MM-yyyy'
            ))
        ;

        $builder->remove('email');
    }

    public function getName()
    {
        return 'and6a_user_profile';
    }
}
