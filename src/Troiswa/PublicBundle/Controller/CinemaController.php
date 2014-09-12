<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Cinema;
use Troiswa\PublicBundle\Form\CinemaType;

class CinemaController extends AbstractController
{

    //affichage tous les cinemas
    public function displayAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cinemas = $em->getRepository('TroiswaPublicBundle:Cinema')
            ->findAll();

        foreach ($cinemas as $cinema) {
            if (null != $cinema->getImage()) {
                $cinema->getImage()->setFolder('Cinema');
            }
        }

        $pagination = $this->pagination($cinemas, 5);

        return $this->render('TroiswaPublicBundle:Cinema:displayCinemas.html.twig', array( 'cinemas' => $pagination, ));
    }

    //affichage d'un seul cinema
    public function displayOneAction($unCinema_Slug)
    {
        $leCinema = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Cinema')->findOneBySlug($unCinema_Slug);

        if ($leCinema == null) {
            throw $this->createNotFoundException('Cinema inexistant');
        }

        return $this->render('TroiswaPublicBundle:Cinema:displayOneCinema.html.twig', array( 'leCinema' => $leCinema ));

    }

    //modification d'un cinema
    public function addCinemaAction(Request $request)
    {
        $cinema = new Cinema();

        $form = $this->createForm(new CinemaType(), $cinema)
            ->add('Ajouter', 'submit');

        //on clone le formulaire à l'état vide:
        $formCloned = clone $form;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $cinema->getImage()->setFolder('Cinema');

            $em->persist($cinema);
            $em->flush();

            //on vide le formulaire:
            $form = $formCloned;

            $this->get('session')->getFlashBag()->add('notice', 'Votre cinema à bien eté ajouté !');

        }

        return $this->render('TroiswaPublicBundle:Cinema:addCinema.html.twig', array( 'form' => $form->CreateView() ));

    }

    //modification d'un cinema
    public function editCinemaAction($unCinema_Slug, Request $request)
    {
        $leCinema = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Cinema')->findOneBySlug($unCinema_Slug);

        if ($leCinema == null) {
            throw $this->createNotFoundException('Cinema inexistant');
        }

        $form = $this->createForm(new CinemaType(), $leCinema);
        $form->add('Modifier', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {

            //EDIT-UPLOAD IMAGE
            //$request contient toutes les variables globales.
            //On parcour le Tableau request->File->get('troiswa_publicbundle_actor')['picture']['file']
            //Si il y a une image Dans file

            $picture = $request->files->get('troiswa_publicbundle_actor');
            if ($picture['image']['file']) {
                $leCinema->getImage()->setOldNom($leCinema->getImage()->getNom());
                $leCinema->getImage()->setNom(' ');
            }

            $leCinema->getImage()->setFolder('Cinema');

            $em = $this->getDoctrine()->getManager();
            $em->persist($leCinema);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre Cinema a bien eté modifié ');
        }

        return $this->render('TroiswaPublicBundle:Cinema:editCinema.html.twig', array( 'form' => $form->createView() ));
    }

    //suppression d'un cineama
    public function deleteCinemaAction($unCinema_id)
    {
        $leCinema = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Cinema')->findOneById($unCinema_id);

        $leCinema->getImage()->setFolder('Cinema');

        $em = $this->getDoctrine()->getManager();
        $em->remove($leCinema);
        $em->flush();

        $this->get('session')->getFlashBag()->add('supp', "l'cinema à eté supprimé !");

//
        return $this->redirect($this->generateUrl('troiswa_public_actors'));
    }

}
