<?php

namespace Troiswa\PublicBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AbstractController extends Controller
{
    //function pagination pour class controller filles
    public function pagination($data, $limit)
    {
        $pagination = $this->get('knp_paginator');

        return $pagination->paginate($data, $this->get('request')->query->get('page', 1), $limit);
    }
}
