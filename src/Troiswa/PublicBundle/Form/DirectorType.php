<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class DirectorType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('sexe')
            ->add('naissance', 'date',
                array( 'widget' => 'single_text',
                    'format' => 'dd/MM/yyyy' ))
            ->add('biographie')
            ->add('image', new ImageType())
            ->add('films', 'entity',
                array( 'class' => 'Troiswa\PublicBundle\Entity\Film',
                    'property' => 'titre',
                    'expanded' => false,
                    'multiple' => true ));
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Director'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_director';
    }
}
