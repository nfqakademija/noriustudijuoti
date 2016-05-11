<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Program;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * Home page index action.
     * @Route("/", name="index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('AppBundle:Home:index.html.twig', [

        ]);
    }

    /**
     * @Route("/Search", name="MainSearch")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchAction(Request $request)
    {
        $name = $request->get('noriu');
        $array = $this->getDoctrine()->getRepository("AppBundle:Program")->findBy(['name' => $name]);

        return $this->render('AppBundle:Search:advancedSearch.html.twig', [
            'programArray' => $array
        ]);
    }

    /**
     * @Route("/Statistics", name="MainStatistics")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statisticsAction()
    {
        return $this->render('AppBundle:Statistics:main.html.twig', [

        ]);
    }

    /**
     * @Route("/Information/{id}", name="detailedInfo")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function detailedInfoAction()
    {
        return $this->render('AppBundle:Search:detailedView.html.twig', [

        ]);
    }
}
