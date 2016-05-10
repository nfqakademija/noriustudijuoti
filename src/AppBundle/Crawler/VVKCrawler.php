<?php
/**
 * Created by PhpStorm.
 * User: tadas
 * Date: 4/19/16
 * Time: 10:07 PM
 */

namespace AppBundle\Crawler;

use AppBundle\Parser\ParserException;
use GuzzleHttp\Psr7\Response;
use AppBundle\Parser\VVKParser;
use Doctrine\ORM\EntityManager;
use GuzzleHttp\Client;


class VVKCrawler implements CrawlerInterface
{
/**
 * Crawls through given url, returns all parsed Programs.
 * @param string $url
 * @return
 */

    private $parser;
    private $em;
    private $getBody;

    public function __construct(EntityManager $entityManager, VVKParser $parser)
    {
        $this->parser = new VVKParser();
        $this->em = $entityManager;
        $this->getBody = function (string $url) {
            $client = new Client();
            try {
                $response = $client->request('get', $url);
                if ($response->getStatusCode() !== '404') {
                    return $response->getBody()->getContents();
                } else {
                    return null;
                }
            } catch (\Exception $e) {
                return null;
            }
        };
        $this->parser->setFunction($this->getBody);
    }

    private function getProgramUrls(string $url)
    {
        return $this->parser->getProgramUrls(call_user_func_array($this->getBody, array($url)));
    }
    private function getProgram(string $url)
    {
        $htmlBody = call_user_func_array($this->getBody, array($url));
        if ($htmlBody !== null) {
            return $this->parser->getProgram($htmlBody);
        }
    }

    public function crawlPrograms(string $url)
    {
//        var_dump($url);
            $array = $this->getProgramUrls($url);
            $lastUrl = null;
            foreach ($array as $item) {
                if ($item !== null && ($lastUrl !== $item)) {
                    $entity = $this->getProgram($item);
                    if ($entity !== null) {
                        $entity->setUrl($item);
                        $this->persistProgram($entity);
                    }
                }
                $lastUrl = $item;
            }
    }

    public function persistProgram(Program $program)
    {
        $this->em->persist($program);
        $this->em->flush();
    }
 }
