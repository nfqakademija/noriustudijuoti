<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/7/16
 * Time: 8:31 PM
 */
namespace AppBundle\Crawler;

use GuzzleHttp\Psr7\Response;

interface CrawlerInterface
{
    /**
     * Crawls through given Response, returns one Entity;
     * @return
     */
    public function crawl(Response $response);

    /**
     * Crawsl through given response, returns all found Entities;
     * @return
     */
    public function crawlMany(Response $response);

}