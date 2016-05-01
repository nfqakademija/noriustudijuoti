<?php
/**
 * Created by PhpStorm.
 * User: gv
 * Date: 4/21/16
 * Time: 1:51 PM
 */
namespace AppBundle\Crawler;

use GuzzleHttp\Client;

class BodyGetter
{
    /**
     * Takes in wanted url address and return html in string format.
     * @param string $url
     * @return string Html
     */
    public static function getBody(string $url) : string
    {
        $client = new Client();
        $response = $client->request('get', $url);
        return $response->getBody()->getContents();
    }
}