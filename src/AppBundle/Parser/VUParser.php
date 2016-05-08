<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/25/16
 * Time: 4:27 PM
 */
namespace AppBundle\Parser;

use AppBundle\Entity\Program;
use AppBundle\Entity\Subject;
use Symfony\Component\DomCrawler\Crawler;

class VUParser implements ParserInterface
{

    private $function;

    public function getProgramUrls(string $htmlBody) : array
    {
        $crawler = new Crawler($htmlBody);
        $urls = $crawler->filter('.gk-active table tbody tr td p a')->each(
            function (Crawler $c) {
                $s = $c->link()->getUri();
                if (strpos($s, 'item') !== false) {
                    return $s;
                }
            }
        );
        return $urls;
    }
    public function getProgram(string $htmlBody) : Program
    {
        $crawler = new Crawler($htmlBody);

        $name = $crawler->filter('.itemView .nodate h1')->text();
        $university = 'Vilniaus Universitetas';
        $text = $crawler->filter('.itemView .itemFullText :not(a)')->text();
        $informationLabel = $crawler->filter('.itemView .itemExtraFieldsLabel')->each(
            function (Crawler $c) {
                return $c->text();
            }
        );
        $information = $crawler->filter('.itemView .itemExtraFieldsValue')->each(
            function (Crawler $c) {
                return $c->text();
            }
        );

        $crawledUrl = $crawler->filter('#ką-studijuosite p a');
        $subjects = null;
        if ($crawledUrl->count() > 0) {
            $subjectsUrl = $crawledUrl
            ->last()
            ->link()
            ->getUri();
            $subjects = $this->getSubjects(call_user_func_array($this->function, array($subjectsUrl)));
        }

        $program = $this->filterInformationToEntity($information, $informationLabel);

        $program->setName($name)
            ->setUniversity($university)
            ->setDescription($text);

        if ($crawledUrl->count() > 0) {
            foreach ($subjects as $subject) {
                $program->addSubject($subject);
            }
        }

        return $program;
    }
    public function getSubjects(string $htmlBody) : array
    {
        $crawler = new Crawler($htmlBody);
        $body = $crawler->filter("table[align]:not(#wrapper) > tr > td");
        if ($body->count() > 0) {
            $information = $body->each(
                function (Crawler $c) {
                    if ($c->attr('class') === 'clsSemestras') {
                        if (strpos($c->text(), 'semestras') !== false) {
                            return $c->text();
                        }
                    } elseif ($c->attr('class') === 'clsDalykuGrupe') {
                        if (strpos($c->text(), 'blokas') !== false) {
                            return $c->text();
                        }
                    } elseif ($c->attr('class') === 'clsDalykas') {
                        return $c->text();
                    }
                }
            );
            $information = array_filter($information, function ($var) {
                return !is_null($var);
            });
            $information = array_values($information);
            if (count($information) > 0) {
                return $this->getSubjectEntities($information);
            }
        }
        return array();
    }

    private function getSubjectEntities(array $info) : array
    {
        $subjectArray = [];
        $arbitrary = true;
        $currentSemester = '';
        $subject = new Subject();
        $counter = 0;
        $cycle = count($info);
        for ($i = 0; $i < $cycle; $i++) {
            if (strpos($info[$i], 'semestras') !== false) {
                $currentSemester = filter_var($info[$i], FILTER_SANITIZE_NUMBER_INT);
                continue;
            } elseif (strpos($info[$i], 'blokas') !== false) {
                if (strpos($info[$i], 'privalomieji') !== false) {
                    $arbitrary = true;
                } else {
                    $arbitrary = false;
                }
                continue;
            } else {
                if ($counter === 1) {
                    $subject = new Subject();
                    $subject->setName($info[$i]);
                } elseif ($counter === 2) {
                    $subject->setCredits($info[$i]);
                } elseif ($counter === 4) {
                    $subject->setAssessment($info[$i]);
                } elseif ($counter === 6) {
                    $counter = 0;
                    $subject->setArbitrary($arbitrary)
                        ->setSemester($currentSemester);
                    $subjectArray[] = $subject;
                    continue;
                }
                $counter++;
            }
        }
        return $subjectArray;
    }
    public function setFunction($function)
    {
        $this->function = $function;
    }

    private function filterInformationToEntity($information, $labels)
    {
        $informationLabelCount = count($labels);
        $result = new Program();
        for ($i = 0; $i < $informationLabelCount; $i++) {
            if (strpos($labels[$i], 'Padalinys') !== false) {
                $result->setFaculty($information[$i]);
            } elseif (strpos($labels[$i], 'sritis') !== false) {
                $result->setField($information[$i]);
            } elseif (strpos($labels[$i], 'kryptis') !== false) {
                $result->setBranch($information[$i]);
            } elseif (strpos($labels[$i], 'Trukmė') !== false) {
                $result->setLength(filter_var($information[$i], FILTER_SANITIZE_NUMBER_INT));
            } elseif (strpos($labels[$i], 'laipsnis') !== false) {
                $result->setDegree($information[$i]);
            } elseif (strpos($labels[$i], 'forma') !== false) {
                $result->setForm($information[$i]);
            } elseif (strpos($labels[$i], 'kaina') !== false) {
                $result->setPrice(filter_var($information[$i], FILTER_SANITIZE_NUMBER_INT));
            }
        }
        return $result;
    }
}
