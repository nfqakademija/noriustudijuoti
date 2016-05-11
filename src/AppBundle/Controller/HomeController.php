<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Program;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Repository\ProgramRepository;

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
        $noriuValue = $request->get('noriu');
        $nenoriuValue = $request->get('nenoriu');
        $array = $this->getDoctrine()
            ->getRepository('AppBundle:Program')->getProgramList($request);
        return $this->render('AppBundle:Search:advancedSearch.html.twig', [
            'programArray' => $array,
            'noriuValue' => $noriuValue,
            'nenoriuValue' => $nenoriuValue
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
    public function detailedInfoAction($id)
    {
        $program = $this->getDoctrine()->getRepository("AppBundle:Program")->find($id);
        $subjects = $this->getDoctrine()->getRepository("AppBundle:Subject")->getSubjectsBySemester($id);
        $withSemesters = true;
        if (empty(array_filter($subjects))) {
            $withSemesters = false;
            $subjects = $this->getDoctrine()->getRepository("AppBundle:Subject")->findBy(['program' => $id]);
        }

        return $this->render('AppBundle:Search:detailedView.html.twig', [
            'program' => $program,
            'subjects' => $subjects,
            'withSemesters' => $withSemesters
        ]);
    }
    /**
     * @Route("/Programs/", name="programView")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function programViewAction()
    {
        $programRepository = $this->getDoctrine()->getRepository("AppBundle:Program");
        $programs = $programRepository->findAll();
        $programFields = $programRepository->getProgramFields();
        return $this->render('AppBundle:Search:programView.html.twig', [
            'programs' => $programs,
            'fields' => $programFields
        ]);
    }

    /**
     * @Route("/Programs/{name}", name="programViewFiltered")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function programViewFilteredAction($name)
    {
        $programRepository = $this->getDoctrine()->getRepository("AppBundle:Program");
        $programs = $programRepository->findBy(['field' => $name]);
        $programFields = $programRepository->getProgramFields();
        return $this->render('AppBundle:Search:programView.html.twig', [
            'programs' => $programs,
            'fields' => $programFields
        ]);
    }
}
