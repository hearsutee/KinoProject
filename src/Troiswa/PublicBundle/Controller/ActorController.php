<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Troiswa\PublicBundle\Entity\Actor;

use Troiswa\PublicBundle\Form\ActorType;

class ActorController extends AbstractController
{
    //afichage tous les acteurs
    public function displayAction()
    {

        $em = $this->getDoctrine()->getManager();

        $acteurs = $em->getRepository('TroiswaPublicBundle:Actor')
            ->findAll();

        foreach ($acteurs as $acteur) {
            if (null != $acteur->getImage()) {
                $acteur->getImage()->setFolder('Actor');
            }
        }

        $pagination = $this->pagination($acteurs, 5);

        return $this->render('TroiswaPublicBundle:Actor:displayActors.html.twig', array( 'acteurs' => $pagination, ));
    }

    //affichage un seul acteur
    public function displayOneAction($unActeur_id)
    {
        $leActeur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Actor')->findOneByid($unActeur_id);

        if ($leActeur == null) {
            throw $this->createNotFoundException('Acteur inexistant');
        }

        if (null != $leActeur->getImage()) {
            $leActeur->getImage()->setFolder('Actor');
        }

        return $this->render('TroiswaPublicBundle:Actor:displayOneActor.html.twig', array( 'leActeur' => $leActeur ));

    }

    //ajout d'un acteur
    public function addActorAction(Request $request)
    {
        $acteur = new Actor();

        $form = $this->createForm(new ActorType(), $acteur)
            ->add('Ajouter', 'submit');
//

//        on clone le formulaire à l'état vide:
        $formCloned = clone $form;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $acteur->getImage()->setFolder('Actor');

            $nom = $acteur->getNom();
            $acteur->getImage()->setNom($nom);

            $em->persist($acteur);
            $em->flush();

//            on vide le formulaire:
            $form = $formCloned;

            $this->get('session')->getFlashBag()->add('notice', 'Votre acteur à bien eté ajouté !');

        }

        return $this->render('TroiswaPublicBundle:Actor:addActor.html.twig', array( 'form' => $form->CreateView() ));

    }

    //modification d'un acteur
    public function editActorAction($unActeur_id, Request $request)
    {
        $leActeur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Actor')->find($unActeur_id);

        if ($leActeur == null) {
            throw $this->createNotFoundException('Acteur inexistant');
        }

        $form = $this->createForm(new ActorType(), $leActeur);
        $form->add('Modifier', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {

            //EDIT-UPLOAD IMAGE
            //$request contient toutes les variables globales.
            //On parcourt le Tableau request->File->get('troiswa_publicbundle_actor')['picture']['file']
            //Si il y a une image Dans file
            $picture = $request->files->get('troiswa_publicbundle_actor');
            if ($picture['image']['file']) {
                $leActeur->getImage()->setOldNom($leActeur->getImage()->getNom());

            }

            $nom = $leActeur->getNom();
            $leActeur->getImage()->setNom($nom);

            $leActeur->getImage()->setFolder('Actor');

            $em = $this->getDoctrine()->getManager();
            $em->persist($leActeur);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre Acteur a bien eté modifié ');
        }

        return $this->render('TroiswaPublicBundle:Actor:editActor.html.twig', array( 'form' => $form->createView() ));
    }

    //suppression acteur(reponse Ajax)
    public function deleteActorAction(Request $request, $unActeur_id)
    {
        $leActeur = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Actor')->findOneById($unActeur_id);

        if ($leActeur->getImage()) { // si cet acteur à bien une image :
            $leActeur->getImage()->setFolder('Actor');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($leActeur);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse( true );
        } else {
            $this->get('session')->getFlashBag()->add('supp', 'acteur  supprimé !');

            return $this->redirect($this->generateUrl('troiswa_public_actors'));
        }
    }

}
