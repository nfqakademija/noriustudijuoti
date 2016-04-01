<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Program;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DoctrineController extends Controller
{
    /**
     *
     * @Route("/Doctrine/Add/{dalykas}", name="dalykas")
     *
     */
    public function addAction($dalykas)
    {
        $programa = new Program();
        $programa->setKaina("3.14");
        $programa->setPavadinimas($dalykas);

        $em = $this->getDoctrine()->getEntityManager();

        $em->persist($programa);

        $em->flush();

        return $this->render('AppBundle:Home:doctrine.html.twig', array(
            'name' => 'Add',
            'programos' => null
        ));
    }
    /**
     *
     * @Route("/Doctrine/View")
     *
     */
    public function viewAction()
    {
        $programos = $this->getDoctrine()->getRepository("AppBundle:Program")->findAll();
        $progString = "";

        foreach ($programos as $pr)
        {
            $progString .= $pr->getPavadinimas() . " ";
            $progString .= $pr->getKaina() . " | ";
        }
        return $this->render('AppBundle:Home:doctrine.html.twig', array(
            'name' => 'View',
            'programos' => $progString
        ));
    }
    /**
     *
     * @Route("/Doctrine/View/{id}", name="id")
     *
     */
    public function viewIdAction($id)
    {
        $programa = $this->getDoctrine()->getRepository("AppBundle:Program")->findOneBy(array('id' => $id));
        $progString = "";

        $progString .= $programa->getPavadinimas() . " ";
        $progString .= $programa->getKaina() . " | ";
        return $this->render('AppBundle:Home:doctrine.html.twig', array(
            'name' => 'ViewByID',
            'programos' => $progString
        ));
    }
    /**
     *
     * @Route("/Doctrine/Delete/{id}", name="id")
     *
     */
    public function deleteAction($id)
    {
        $programa = $this->getDoctrine()->getRepository("AppBundle:Program")->findOneBy(array('id' => $id));
        $progString = "";

        $progString .= $programa->getPavadinimas() . " ";
        $progString .= $programa->getKaina() . " | ";

        $em = $this->getDoctrine()->getEntityManager();

        $em->remove($programa);
        $em->flush();

        return $this->render('AppBundle:Home:doctrine.html.twig', array(
            'name' => 'Deleted',
            'programos' => $progString
        ));
    }
    /**
     *
     * @Route("/Doctrine/Update/{id}", name="id")
     *
     */
    public function updateAction($id)
    {
        $programa = $this->getDoctrine()->getRepository("AppBundle:Program")->findOneBy(array('id' => $id));
        $progString = "";

        $progString .= $programa->getPavadinimas() . " ";
        $progString .= $programa->getKaina() . " | ";

        $em = $this->getDoctrine()->getEntityManager();

        $programa->setPavadinimas("Update");
        $em->flush();

        return $this->render('AppBundle:Home:doctrine.html.twig', array(
            'name' => 'Updated',
            'programos' => $progString
        ));
    }

}
