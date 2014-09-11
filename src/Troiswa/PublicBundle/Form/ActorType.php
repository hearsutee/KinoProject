<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ActorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('biographie', 'textarea')
            ->add('naissance', 'date',
                array( 'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy' ))
            ->add('films', 'entity',
                array( 'class' => 'Troiswa\PublicBundle\Entity\Film',
                    'property' => 'titre',
                    'expanded' => false,
                    'multiple' => true ))
            ->add('image', new ImageType());;

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Actor'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_actor';
    }
}
