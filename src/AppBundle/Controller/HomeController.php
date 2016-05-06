<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Crawler\BodyGetter;

class HomeController extends Controller
{
    /**
     * Home page index action.
     * @Route("/")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        $crawler = $this->get("app.crawler.vu");
        $crawler->crawlPrograms("http://www.vu.lt/kviecia/rinkis-studijas/studiju-programos/1-pakopos-studiju-programos");
        return $this->render('AppBundle:Home:index.html.twig', array(
            // ...
        ));
    }
}
