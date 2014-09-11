<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Film;
use Troiswa\PublicBundle\Form\FilmType;

class FilmController extends AbstractController
{
    //affichage de tous les films
    public function displayAction()
    {

        $em = $this->getDoctrine()->getManager();

        //trois requetes pour chaque statut de film (en fonciton de la date de sortie) pour affichage          dans la vue tabs :

        //films à venir
        $prochainement = $em->getRepository('TroiswaPublicBundle:Film')
            ->findFandCprochainememt();

        //films à l'affiche
        $affiche = $em->getRepository('TroiswaPublicBundle:Film')
            ->findFandCaffiche();

        //films archivés
        $archive = $em->getRepository('TroiswaPublicBundle:Film')
            ->findFandCarchive();

        foreach ($affiche as $film) {
            if (null != $film->getImage()) {
                $film->getImage()->setFolder('Film');
            }
        }
        foreach ($archive as $film) {
            if(null != $film->getImage())

            {
                $film->getImage()->setFolder('Film');
            }
        }

        foreach ($prochainement as $film) {
            if (null != $film->getImage()) {
                $film->getImage()->setFolder('Film');
            }
        }

        //pagination avec la function creéé dans AbstractController :
        $prochainementPagin = $this->pagination($prochainement, 6);
        $archivePagin = $this->pagination($archive, 6);
        $affichePagin = $this->pagination($affiche, 6);

        return $this->render('TroiswaPublicBundle:Film:displayFilms.html.twig', array(
            'archive' => $archivePagin,
            'prochainement' => $prochainementPagin,
            'affiche' => $affichePagin ));

    }

    //affichage un seul film
    public function displayOneAction($unFilm_id)
    {

        //requete join 1 film ET ses commentaires :
        $leFilm = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Film')->findFilmAndComments($unFilm_id);

        if ($leFilm == null) {
            throw $this->createNotFoundException('Film inexistant');
        }

        if (null != $leFilm->getImage()) {
            $leFilm->getImage()->setFolder('Film');
        }

        $seances = $this->getDoctrine()->getRepository("TroiswaPublicBundle:Seance")
            ->findByFilm($unFilm_id);

        return $this->render('TroiswaPublicBundle:Film:displayOneFilm.html.twig', array( 'leFilm' => $leFilm, 'seances' => $seances ));

    }

    //ajout d'un film
    public function addFilmAction(Request $request)
    {
        $film = new Film();

        $form = $this->createForm(new FilmType(), $film)

            ->add('Ajouter', 'submit');

//        on clone le formulaire à l'état vide:
        $formCloned = clone $form;

        $form->handleRequest($request);

        if ($form->isValid()) {

            $film->getImage()->setFolder('Film');

            $film->getImage()->setNom($film->getTitre());

            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();

//            on vide le formulaire:
            $form = $formCloned;

            $this->get('session')->getFlashBag()->add('notice', 'Votre film à bien eté ajouté !');

        }

        return $this->render('TroiswaPublicBundle:Film:addFilm.html.twig', array( 'form' => $form->CreateView() ));

    }

    //modification d'un film
    public function editFilmAction($unFilm_id, Request $request)
    {
        $leFilm = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Film')->findOneById($unFilm_id);

        if ($leFilm == null) {
            throw $this->createNotFoundException('Film inexistant');
        }

        $form = $this->createForm(new FilmType(), $leFilm);
        $form->add('modifier', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {

            $leFilm->getImage()->setFolder('Film');

            $leFilm->getImage()->setNom($leFilm->getTitre());

            $em = $this->getDoctrine()->getManager();
            $em->persist($leFilm);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre film a bien eté modifié ');
        }

        return $this->render('TroiswaPublicBundle:Film:editFilm.html.twig', array( 'leFilm' => ' $leFilm', 'form' => $form->createView() ));

    }

    //suppression d'un film (reponse AJAX)
    public function deleteFilmAction(Request $request, $unFilm_id)
    {
        $leFilm = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Film')->findOneById($unFilm_id);

        if ($leFilm->getImage()) { // si ce film à bien une image :
            $leFilm->getImage()->setFolder('Film');
        }

        $seances = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Seance')->findByFilm($unFilm_id);

        foreach ($seances as $seance) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($seance);
            $em->flush();

        }

        $comments = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Comment')->findAllByFilm($unFilm_id);

        foreach ($comments as $comment) {

            $em = $this->getDoctrine()->getManager();
            $em->remove($comment);
            $em->flush();

        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($leFilm);
        $em->flush();

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse( true );
        } else {

            $this->get('session')->getFlashBag()->add('supp', 'le film à eté supprimé !');
//        return $this->render('TroiswaPublicBundle:Film:displayFilms.html.twig');
            return $this->redirect($this->generateUrl('troiswa_public_films'));
        }

    }

    private function removeAccent($str, $encoding = 'utf-8')
    {
        // transformer les caractères accentués en entités HTML
        $str = htmlentities($str, ENT_NOQUOTES, $encoding);

        // remplacer les entités HTML pour avoir juste le premier caractères non accentués
        // Exemple : "&ecute;" => "e", "&Ecute;" => "E", "Ã " => "a" ...
        $str = preg_replace('#&([A-za-z])(?:acute|grave|cedil|circ|orn|ring|slash|th|tilde|uml);#', '\1', $str);

        // Remplacer les ligatures tel que : Œ, Æ ...
        // Exemple "Å“" => "oe"
        $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str);
        // Supprimer tout le reste
        $str = preg_replace('#&[^;]+;#', '', $str);

        return $str;
    }

}
