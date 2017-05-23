<?php

namespace WCS\TvShowManagerBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EpisodeControllerTest extends WebTestCase
{
    public function testAdd()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/addEpisode');
    }

    public function testDelete()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/deleteEpisode');
    }

    public function testModify()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/modifyEpisode');
    }

}
