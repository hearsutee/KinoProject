<?php
namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Troiswa\PublicBundle\Entity\Comment;
use Troiswa\PublicBundle\Form\CommentType;

class CommentController extends AbstractController
{
    //affichage tous les commentaires
    public function displayAllAction()
    {
        $allComments = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Comment')->findAll();

        $pagination = $this->pagination($allComments, 6);

        return $this->render('TroiswaPublicBundle:Comment:CommentsLayout.html.twig', array(
            'allComments' => $pagination ));
    }

    //ajout d'un commentaire
    public function addCommentAction($film_id)
    {

        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment,
            array( 'action' => $this->generateUrl('troiswa_public_saveComment', array( 'film_id' => $film_id )) ));

        return $this->render('TroiswaPublicBundle:Comment:addComment.html.twig', array( 'form' => $form->CreateView() ));

    }

    //sauvegarde d'un commentaire
    public function saveCommentAction(Request $request, $film_id)
    {

        $comment = new Comment();

        $form = $this->createForm(new CommentType(), $comment);

        $form->handleRequest($request);

        if ($form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $film = $em->getRepository('TroiswaPublicBundle:Film')->find($film_id);
            $comment->setFilm($film);
            $comment->setDateCreation(new \DateTime( 'now' ));
            $em->persist($comment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'Votre commentaire à bien eté ajouté !');

            return $this->redirect($this->generateUrl('troiswa_public_OneFilm', array( 'unFilm_id' => $film_id )));

        } else {
            echo 'pas valid';
        }

    }

    //Admin modifier commentaire :
    public function editCommentAction(Request $request, $unComment_id)
    {
        $leComment = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Comment')->findOneById($unComment_id);

        if ($leComment == null) {
            throw $this->createNotFoundException('Oups, Commentaire inexistant');
        }

        $form = $this->createForm(new CommentType(), $leComment);
        $form->add('modifier', 'submit');

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($leComment);
            $em->flush();

            $this->get('session')->getFlashBag()->add('notice', 'le commentaire à bien eté modifié ');
        }

        return $this->render('TroiswaPublicBundle:Comment:editComment.html.twig', array( 'comment' => ' $leComment', 'form' => $form->createView() ));
    }

    //Admin supprimer commentaire :
    public function deleteCommentAction($unComment_id)
    {
        $leComment = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Comment')->findOneById($unComment_id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($leComment);
        $em->flush();

        $this->get('session')->getFlashBag()->add('supp', 'le commentaire  à eté supprimé !');

//        return $this->render('TroiswaPublicBundle:Film:displayFilms.html.twig');
        return $this->redirect($this->generateUrl('troiswa_public_films'));
    }
}
