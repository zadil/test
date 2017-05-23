<?php

namespace PersonneBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MemoControllerTest extends WebTestCase
{
    public function testListememo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/listeMemo');
    }

    public function testSupprimermemo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/SupprimerMemo');
    }

    public function testInserermemo()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/insererMemo');
    }

}
