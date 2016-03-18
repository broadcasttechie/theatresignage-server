<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\EntityRepository;

class ScheduleItemType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime();
        $builder
            ->add('start', 'datetime',
                  [
                      'widget' => 'single_text',
                      'format' => 'dd-MM-yyyy HH:00',
                      'attr' => [
                          'class' => 'form-control input-inline datetimepicker',
                          'data-provide' => 'datetimepicker',
                          'data-date-format' => 'dd-mm-yyyy hh:ii'
                      ],
                      //'data' => new \DateTime()
                  ]
                 )
            ->add('stop', 'datetime',
                  [
                      'widget' => 'single_text',
                      'format' => 'dd-MM-yyyy HH:00',
                      'attr' => [
                          'class' => 'form-control input-inline datetimepicker',
                          'data-provide' => 'datetimepicker',
                          'data-date-format' => 'dd-mm-yyyy hh:ii'
                      ],
                      //'data' => $date->add(new \DateInterval('P1M'))
                  ]
                 )
            ->add('duration', NumberType::class,
                  [
                      'max_length' => 2,
                      'required'    => false,
                      'empty_data'  => '',
            ])
            ->add('channel');
        $builder->add('asset', EntityType::class, array(
            'class' => 'AppBundle:Asset',
            'query_builder' => function (EntityRepository $er) {
            return $er->createQueryBuilder('a')->orderBy('a.updatedAt', 'DESC');},
            'placeholder' => '-- Select Asset --',
        ));
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\ScheduleItem'
        ));
    }
}
