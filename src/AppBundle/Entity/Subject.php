<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/10/16
 * Time: 5:45 PM
 */
namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity
 */
class Subject
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
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $credits;

    /**
     * @var int
     *
     * @orm\Column(type="integer")
     */
    private $semester;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $assessment;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $arbitrary;

    /**
     * @var Program
     *
     * @ORM\ManyToOne(targetEntity="Program", inversedBy="subjects")
     * @ORM\JoinColumn(name="program_id", referencedColumnName="id")
     */
    private $program;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Subject
     */
    public function setName(string $name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set credits
     *
     * @param integer $credits
     *
     * @return Subject
     */
    public function setCredits($credits)
    {
        $this->credits = $credits;

        return $this;
    }

    /**
     * Get credits
     *
     * @return integer
     */
    public function getCredits()
    {
        return $this->credits;
    }

    /**
     * Set program
     *
     * @param Program $program
     *
     * @return Subject
     */
    public function setProgram(Program $program = null)
    {
        $this->program = $program;

        return $this;
    }

    /**
     * Get program
     *
     * @return \AppBundle\Entity\Program
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Set semester
     *
     * @param integer $semester
     *
     * @return Subject
     */
    public function setSemester($semester)
    {
        $this->semester = $semester;

        return $this;
    }

    /**
     * Get semester
     *
     * @return integer
     */
    public function getSemester()
    {
        return $this->semester;
    }

    /**
     * Set assessment
     *
     * @param string $assessment
     *
     * @return Subject
     */
    public function setAssessment($assessment)
    {
        $this->assessment = $assessment;

        return $this;
    }

    /**
     * Get assessment
     *
     * @return string
     */
    public function getAssessment()
    {
        return $this->assessment;
    }

    /**
     * Set arbitrary
     *
     * @param bool $arbitrary
     *
     * @return Subject
     */
    public function setArbitrary(bool $arbitrary)
    {
        $this->arbitrary = $arbitrary;

        return $this;
    }

    /**
     * Get arbitrary
     *
     * @return bool
     */
    public function getArbitrary()
    {
        return $this->arbitrary;
    }
}
