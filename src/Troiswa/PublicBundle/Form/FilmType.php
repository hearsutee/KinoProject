<?php

namespace Troiswa\PublicBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class FilmType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')

            ->add('contenu', 'textarea', array(
                'required' => false
            ))

            ->add('dateCreation', 'date', array(
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
            ))

            ->add('active')

            ->add('acteurs', 'entity',
                array( 'class' => 'Troiswa\PublicBundle\Entity\Actor',
                    'property' => 'nom',
                    'expanded' => false,
                    'multiple' => true,
                    'by_reference' => false ))

            ->add('categories', 'entity',
                array( 'class' => 'Troiswa\PublicBundle\Entity\Category',
                    'property' => 'titre',
                    'expanded' => false,
                    'multiple' => false ))

            ->add('image', new ImageType(), array( 'required' => false ))

            ->add('tags', 'collection',
                array(
                    'type' => new FilmTagType(),
                    'allow_add' => true,
                    'allow_delete' => true,
                    'by_reference' => false ))
//        by_reference true :
//        $film->getTags()->setpoids(4);
//
//        by_reference false :
//        $tags =$film->getTags()
//                     ->setPoids(4);
//
//        $film->addTag($tag);
//        ici on passe par le add


            ->getForm();

    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Troiswa\PublicBundle\Entity\Film'
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'troiswa_publicbundle_film';
    }
}
