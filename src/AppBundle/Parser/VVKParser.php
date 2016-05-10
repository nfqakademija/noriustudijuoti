<?php
/**
 * Created by PhpStorm.
 * User: tadas
 * Date: 5/3/16
 * Time: 4:57 PM
 */

namespace AppBundle\Parser;

use AppBundle\Entity\Program;
use AppBundle\Entity\Subject;
use AppBundle\Parser\ParserInterface;
use Symfony\Component\DomCrawler\Crawler;

class VVKParser implements ParserInterface
{
    private $subjects;

    /**
     * VVKParser constructor.
     */
    public function __construct()
    {
    }

    /**
     * @param string $htmlBody
     * @return array
     */
    public function getProgramUrls(string $htmlBody) : array
    {
            $crawler = new Crawler($htmlBody);
            $links = $crawler->filter('.sideNav li a')->each(function (Crawler $node, $i) {
                $baseUrl = "http://www.kolegija.lt/lt/";
                return $baseUrl . $node->attr("href");
            });
            //var_dump($links);
            return $links;
    }

    /**
     * @param string $htmlBody
     * @return array
     */
    public function getSubjects(string $htmlBody) : array
    {
        // TODO: Implement getSubjects() method.
    }

    /**
     * @param string $htmlBody
     * @return Program
     */
    public function getProgram(string $htmlBody) : Program
    {
            $crawler = new Crawler($htmlBody);

            $details = $crawler->filter('td.main-body')->first();
            $detailsText = $details->text();
            $programName = substr($detailsText, 0, strpos($detailsText, "Suteikiamas"));
            preg_match("/Studijų programa:(.*?)\s*Suteikiamas/",$detailsText,$programName);
            preg_match("/Suteikiamas kvalifikacinis laipsnis:(.*?)\s*Studijų/",$detailsText,$programDegree);
            preg_match("/Trukmė:(.*),/",$detailsText,$programLength);
            $programLength = preg_replace("/[^0-9]/","",$programLength[1]);
            $programPrice = $details->filter('table')->eq(2)->filter('tr')->eq(1)->filter('td')->first();
            $university = 'Vilniaus Verslo kolegija';

            $subjects = [];
            $details->filter('table')->first()->filter('tr')->each(function(Crawler $node, $i) use (&$subjects){
                if($i > 1) {
                    $node->filter('td div')->each(function(Crawler $subjectName, $i) use (&$subjects) {
                        if(strlen($subjectName->text()) > 6){
                            $subject = new Subject();
                            $textas = $subjectName->text();
                            $textas = trim($textas);
                            $subject->setName($textas);
                            $subject->setCredits($i+1);
                            $subject->setArbitrary(true);
                            array_push($subjects, $subject);
                            return $subjects;
                        }
                    });
                }
            });
            $program = new Program();
            $program->setName($programName[1])
                ->setUniversity($university)
                ->setDegree($programDegree[1])
                ->setLength($programLength)
                ->setPrice(filter_var($programPrice->text(),FILTER_SANITIZE_NUMBER_INT));
            foreach ($subjects as $subject) {
                $subject->setProgram($program);
                $program->addSubject($subject);
            }
            return $program;
    }

    public function setFunction($function)
    {
        $this->function = $function;
    }

}