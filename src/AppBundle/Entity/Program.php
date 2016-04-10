<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Programa
 *
 * @ORM\Table(name="program")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProgramRepository")
 */
class Program
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="Pavadinimas", type="string", length=255)
     */
    private $pavadinimas;

    /**
     * @var string
     *
     * @ORM\Column(name="Kaina", type="decimal", precision=6, scale=2)
     */
    private $kaina;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set pavadinimas
     *
     * @param string $pavadinimas
     *
     * @return Programa
     */
    public function setPavadinimas($pavadinimas)
    {
        $this->pavadinimas = $pavadinimas;

        return $this;
    }

    /**
     * Get pavadinimas
     *
     * @return string
     */
    public function getPavadinimas()
    {
        return $this->pavadinimas;
    }

    /**
     * Set kaina
     *
     * @param string $kaina
     *
     * @return Programa
     */
    public function setKaina($kaina)
    {
        $this->kaina = $kaina;

        return $this;
    }

    /**
     * Get kaina
     *
     * @return string
     */
    public function getKaina()
    {
        return $this->kaina;
    }
}

