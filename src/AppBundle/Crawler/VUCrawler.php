<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/21/16
 * Time: 2:37 PM
 */
namespace AppBundle\Crawler;

use AppBundle\Parser\VUParser;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Program;
use GuzzleHttp\Client;

class VUCrawler implements CrawlerInterface
{

    private $parser;
    private $em;
    private $getBody;

    public function __construct(EntityManager $entityManager, VUParser $parser)
    {
        $this->parser = $parser;
        $this->em = $entityManager;
        $this->getBody = function (string $url) {
            $client = new Client();
            $response = $client->request('get', $url);
            return $response->getBody()->getContents();
        };
        $this->parser->setFunction($this->getBody);
    }

    private function getProgramUrls(string $url)
    {
        return $this->parser->getProgramUrls(call_user_func_array($this->getBody, array($url)));
    }
    private function getProgram(string $url)
    {
        return $this->parser->getProgram(call_user_func_array($this->getBody, array($url)));
    }

    public function crawlPrograms(string $url)
    {
        $array = $this->getProgramUrls($url);
        foreach ($array as $item) {
            if ($item !== null) {
                $entity = $this->getProgram($item);
                $entity->setUrl($item);
                $this->persistProgram($entity);
            }
        }
    }

    public function persistProgram(Program $program)
    {
        $this->em->persist($program);
        $this->em->flush();
    }
}
