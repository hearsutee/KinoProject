<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

class SeanceController extends AbstractController
{

    public function displaySeancesByCpAction($unFilm_id, Request $request)
    {

        $cp = '';
        $cp = $request->query->get('cp');

        $cpSeances = $this->getDoctrine()->getManager()->getRepository('TroiswaPublicBundle:Seance')->findByFilmAndCp($unFilm_id, $cp);

        return $this->render('TroiswaPublicBundle:Seance:displaySeancesByCp.html.twig', array(
            'seances' => $cpSeances
        ));

    }

}
