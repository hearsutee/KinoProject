<?php
namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Tag;

class TagController extends AbstractController
{

    public function addTagAction(Request $request)
    {
        $tag = new Tag();

        $form = $this->createFormBuilder($tag)
            ->add('titre')

            ->add('Ajouter', 'submit')
            ->getForm();

        //on clone le formulaire à l'état vide:
        $formCloned = clone $form;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($tag);
            $em->flush();

            //on vide le formulaire:
            $form = $formCloned;

            $this->get('session')->getFlashBag()->add('notice', 'Votre tag à bien eté ajouté !');

        }

        return $this->render('TroiswaPublicBundle:Tag:addTag.html.twig', array( 'form' => $form->CreateView() ));

    }

}
