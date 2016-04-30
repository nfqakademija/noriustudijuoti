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
     * Crawls through given url, returns all parsed Programs.
     * @param string $url
     * @return
     */
    public function crawlPrograms(string $url);

}