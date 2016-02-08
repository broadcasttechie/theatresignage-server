<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

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
                      'data' => $date
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
                      'data' => $date->add(new \DateInterval('P1M'))
                  ]
                 )
            ->add('duration', NumberType::class,
                  [
                      'max_length' => 2,
                      'required'    => false,
                      'empty_data'  => '',
            ])
            ->add('channel')
            ->add('asset')
        ;
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
