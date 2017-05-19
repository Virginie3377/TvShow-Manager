<?php

namespace WCS\TvShowManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WCSTvShowManagerBundle:Default:index.html.twig');
    }
}
