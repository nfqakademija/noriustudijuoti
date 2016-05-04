<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/21/16
 * Time: 2:37 PM
 */
namespace AppBundle\Crawler;

use AppBundle\Parser\ParserException;
use AppBundle\Parser\VUParser;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\Program;

class VUCrawler implements CrawlerInterface
{

    private $parser;
    private $em;

    public function __construct(EntityManager $entityManager)
    {
        $this->parser = new VUParser();
        $this->em = $entityManager;
    }

    private function getProgramUrls(string $url)
    {
        try {
            return $this->parser->getProgramUrls(BodyGetter::getBody($url));
        } catch (\Exception $e) {
            throw new CrawlerException;
        }
    }
    private function getProgram(string $url)
    {
        try {
            return $this->parser->getProgram(BodyGetter::getBody($url));
        } catch (\Exception $e) {
            throw new CrawlerException;
        }
    }

    public function crawlPrograms(string $url)
    {
        try {
            $array = $this->getProgramUrls($url);
            foreach ($array as $item) {
                if ($item !== null) {
                    $entity = $this->getProgram($item);
                    $entity->setUrl($item);
                    $this->persistProgram($entity);
                }
            }
        } catch (\Exception $e) {
            throw new CrawlerException;
        }
    }

    public function persistProgram(Program $program)
    {
        $this->em->persist($program);
        $this->em->flush();
    }
}