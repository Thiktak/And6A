<?php

namespace And6a\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{

    public function buildForm(FormBuilder $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /*$builder
            ->remove('current', 'password')
        ;*/
    }

    public function buildUserForm(FormBuilder $builder, array $options)
    {
        parent::buildUserForm($builder, $options);

        $builder
            ->add('name')
            ->add('fname')
            ->add('birthday', 'birthday', array(
                'format' => 'dd-MM-yyyy',
                'years' => range(date('Y')-15, date('Y')-50),
            ))
        ;

        $builder->remove('email')->remove('username');
    }
    
    public function getDefaultOptions(array $options)
    {
        $options = parent::getDefaultOptions($options);
        $options['data_class'] = null;
        return $options;
    }
    
    public function getName()
    {
        return 'and6a_user_profile';
    }
}
