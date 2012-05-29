<?php

namespace And6a\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;

class GroupsUserType extends AbstractType
{
    const IS_CLUB  = 0x01;
    const IS_CLASS = 0x02;

    public $type = null;

    public function __construct($type = null) {
        $this -> type = $type;
    }

    public function buildForm(FormBuilder $builder, array $options)
    {
        $_this = clone $this;

        $builder
            ->add('year', 'choice', array(
                'choices' => array_combine(range(date('Y'), 2000), range(date('Y'), 2000)),
            ))
            ->add('groups', 'entity', array(
                'class'  => 'And6aTrombiBundle:Groups',
                'query_builder' => function(\Doctrine\ORM\EntityRepository $er) use($_this) {
                    if( $_this -> type == $_this::IS_CLASS || $_this -> type == $_this::IS_CLUB )
                        return $er->createQueryBuilder('q')->where('q.isclass = :isclass')->setParameter('isclass', $_this->type == $_this::IS_CLASS ? 1 : 0)->orderBy('q.name', 'ASC');
                    else
                        return $er->createQueryBuilder('q')->orderBy('q.name', 'ASC');
                },
            ))
        ;

        if( $this -> type == self::IS_CLASS )
            $builder->add('level', 'choice', array(
                'choices' => array(
                    '1A' => '1A',
                    '2A' => '2A',
                    '3A' => '3A',
                    'autre' => 'autre',
                )
            ));

        else if( $this -> type == self::IS_CLUB )
            $builder->add('role', 'choice', array(
                'choices' => array(
                    'Membre' => 'Membre',
                    'Fonctions/Poles' => array(
                        'Président' => 'Président',
                        'Vice-président' => 'Vice-président',
                        'Secrétaire' => 'Secrétaire',
                        'Vice-secrétaire' => 'Vice-secrétaire',
                        'Trésorier' => 'Trésorier',
                        'Vice-trésorier' => 'Vice-trésorier',
                        'Informatique' => 'Informatique',
                        'Communication' => 'Communication',
                        'Qualtié' => 'Qualité',
                        'Extérieur' => 'Extérieur',
                    ),
                    'Autre' => 'Autre',
                ),
            ));
        else
            $builder
               ->add('level')
               ->add('role')
            ;


    }

    public function getName()
    {
        return 'and6a_userbundle_groupsusertype';
    }
}
