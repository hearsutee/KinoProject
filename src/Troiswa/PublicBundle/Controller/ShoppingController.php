<?php

namespace Troiswa\PublicBundle\Controller;

class ShoppingController extends AbstractController
{
    //Afaire Shopping work in progress
    public function displayAction()
    {
        return $this->render('TroiswaPublicBundle:Shopping:shopping.html.twig');
    }
}
