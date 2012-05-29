<?php

namespace And6a\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GroupsType extends AbstractType
{
    public function buildForm(FormBuilder $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('descr')
            ->add('isclass')
        ;
    }

    public function getName()
    {
        return 'and6a_userbundle_groupstype';
    }
}
