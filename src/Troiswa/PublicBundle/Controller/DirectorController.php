<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Director;
use Troiswa\PublicBundle\Form\DirectorType;

class DirectorController extends AbstractController
{
    //affichage tous les realisateurs
    public function displayAction()
    {
        $em = $this->getDoctrine()->getManager();

        $realisateurs = $em->getRepository('TroiswaPublicBundle:Director')
            ->findAll();

        $pagination = $this->pagination($realisateurs, 2);

        return $this->render('TroiswaPublicBundle:Director:displayDirectors.html.twig', array( 'realisateurs' => $pagination, ));
    }

    //affichage d'un seul realisateur
    public function displayOneAction($unRealisateur_Slug)
    {
        $leRealisateur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Director')->findOneBySlug($unRealisateur_Slug);

        if ($leRealisateur == null) {
            throw $this->createNotFoundException('Realisateur inexistant');
        }

        return $this->render('TroiswaPublicBundle:Director:displayOneDirector.html.twig', array( 'leRealisateur' => $leRealisateur ));

    }

    //ajout d'un realisateur
    public function addDirectorAction(Request $request)
    {
        $realisateur = new Director();

        $form = $this->createForm(new DirectorType(), $realisateur)
            ->add('Ajouter', 'submit');
//

//        on clone le formulaire à l'état vide:
        $formCloned = clone $form;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($realisateur);
            $em->flush();

//            on vide le formulaire:
            $form = $formCloned;

            $this->get('session')->getFlashBag()->add('notice', 'Votre realisateur à bien eté ajouté !');

        }

        return $this->render('TroiswaPublicBundle:Director:addDirector.html.twig', array( 'form' => $form->CreateView() ));

    }

    //modification d'un realisateur
    public function editDirectorAction($unRealisateur_Slug, Request $request)
    {
        $leRealisateur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Director')->findOneBySlug($unRealisateur_Slug);

        if ($leRealisateur == null) {
            throw $this->createNotFoundException('Realisateur inexistant');
        }

        $form = $this->createForm(new DirectorType(), $leRealisateur);
        $form->add('Modifier', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {

            //EDIT-UPLOAD IMAGE
            $picture = $request->files->get('troiswa_publicbundle_director');
            if ($picture['image']['file']) {
                $leRealisateur->getImage()->setOldNom($leRealisateur->getImage()->getNom());
                $leRealisateur->getImage()->setNom(' ');
            }
            //EDIT-UPLOAD IMAGE END

            $em = $this->getDoctrine()->getManager();
            $em->persist($leRealisateur);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre Realisateur a bien eté modifié ');
        }

        return $this->render('TroiswaPublicBundle:Director:editDirector.html.twig', array( 'form' => $form->createView() ));
    }

    public function deleteDirectorAction($unRealisateur_id)
    {
        $leRealisateur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Director')->findOneById($unRealisateur_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($leRealisateur);
        $em->flush();

        $this->get('session')->getFlashBag()->add('supp', "le realisateur à eté supprimé !");

        return $this->redirect($this->generateUrl('troiswa_public_directors'));
    }

}
