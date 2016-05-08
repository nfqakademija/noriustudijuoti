<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Program;

class HomeController extends Controller
{
    /**
     * Home page index action.
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $this->get('app.crawler.vu')->crawlPrograms('http://www.vu.lt/kviecia/rinkis-studijas/studiju-programos/1-pakopos-studiju-programos/');


        return $this->render('AppBundle:Home:index.html.twig', array(
            // ...
        ));
    }
}
