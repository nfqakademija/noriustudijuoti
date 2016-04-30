<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/7/16
 * Time: 8:31 PM
 */
namespace AppBundle\Crawler;

interface CrawlerInterface
{
    /**
     * Crawls through given Response, returns one Entity;
     * @return
     */
    public function crawl(string $htmlBody);

    /**
     * Crawsl through given response, returns all found Entities;
     * @return
     */
    public function crawlMany(string $htmlBody);

}