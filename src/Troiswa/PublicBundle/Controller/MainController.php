<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MainController extends AbstractController
{

//    vue appelé directement dans la route
// ....

    public function categoriesWidgetAction()
        // ============================ pour camembert categories
    {

        $categories = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Category')->findAll();

        $films = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Film')->findAll();
        $nbFilms = count($films);

        return $this->render('TroiswaPublicBundle:Main\Widgets:donutCategoriesWidget.html.twig', array(
            'categories' => $categories,
            "nbFilms" => $nbFilms
        ));

    }

    public function commentWidgetAction()
        //============================ pour commentaires recents
    {

        $recentsComments = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Comment')->findRecents();

        return $this->render('TroiswaPublicBundle:Main\Widgets:commentWidget.html.twig', array(
            'comments' => $recentsComments,

        ));

    }

    public function globalStatsWidgetAction()
        // ============================ pour statistiques  nb Films, acteurs, realisateurs etc
    {
        $films = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Film')->findAll();
        $nbFilms = count($films);

        $acteurs = $this->getDoctrine()->getRepository('TroiswaPublicBundle:Actor')->findAll();
        $nbActeurs = count($acteurs);

        return $this->render('TroiswaPublicBundle:Main\Widgets:globalStatsWidget.html.twig', array(

            "nbFilms" => $nbFilms,
            "nbActeurs" => $nbActeurs
        ));
    }

    public function searchAction(Request $request)
    {
        $search = $request->query->get('recherche');

        $resultats = array();

        if ($search) {
            $filmS = $this->container->get('fos_elastica.index.search.film');
            $actorS = $this->container->get('fos_elastica.index.search.actor');

            $resFilms = $filmS->search($search);
            $resActors = $actorS->search($search);

            $resultats = array(
                'resFilms' => $resFilms,
                'resActors' => $resActors
            );

//             die(\Doctrine\Common\Util\Debug::dump($resultats));
// die(var_dump($resultats));

        }

        if ($request->isXmlHttpRequest()) {
            return new JsonResponse( $resultats );
        } else {
            return $this->render('TroiswaPublicBundle:Main:index2.html.twig', array(
                'resultats' => $resultats
            ));
        }

    }
}
