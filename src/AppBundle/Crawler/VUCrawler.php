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
use Symfony\Component\DomCrawler\Crawler;
use AppBundle\Entity\Program;

class VUCrawler implements CrawlerInterface
{

    private $parser;

    public function __construct()
    {
        $this->parser = new VUParser();
    }

    private function getProgramUrls(string $url)
    {
        try {
            return $this->parser->getProgramUrls(BodyGetter::getBody($url));
        } catch (\Exception $e) {
            throw new ParserException;
        }
    }
    private function getProgram(string $url)
    {
        try {
            return $this->parser->getProgram(BodyGetter::getBody($url));
        } catch (\Exception $e) {
            throw new ParserException;
        }
    }

    public function crawlPrograms(string $url)
    {
        try {
            $array = $this->getProgramUrls($url);
            $entityArray = [];
            foreach ($array as $item) {
                if ($item !== null) {
                    $entity = $this->getProgram($item);
                    $entity->setUrl($item);
                    $entityArray[] = $entity;
                }
            }
        } catch (\Exception $e) {
            throw new ParserException;
        }
    }
}