<?php

/**
 * Created by PhpStorm.
 * User: sandra
 * Date: 4/19/16
 * Time: 6:39 PM
 */
class Test extends Symfony\Bundle\FrameworkBundle\Test\WebTestCase
{
    public function testHomePageStatus()
    {
        $client = static::createClient();

         $client->request('GET', '/');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
//        $this->assertGreaterThan(
//            0,
//            $crawler->filter('html:contains("Hello World")')->count()
//        );

    }
}
