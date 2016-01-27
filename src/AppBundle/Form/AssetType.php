<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\MimeType;

class AssetType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $type = new MimeType();
        $types = $type->getTypes();
        
        $builder
    
            //->add('name')
            ->add('mimeType', 'choice' ,array(
                'label' => 'Type',
                'choices' => $types,
            ))
            ->add('ownerGroup')
            ->add('uriFile', 'vich_file')
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Asset'
        ));
    }
}
