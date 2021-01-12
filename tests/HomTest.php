<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class HomTest
 * @package App\Tests
 */
class HomTest extends WebTestCase
{
    /**
     * @dataProvider provideUri
     * @param string $uri
     */
    public function test(string $uri)
    {
        $client = static::createClient();
        $crawler = $client->request(Request::METHOD_GET, $uri);

        $this->assertResponseStatusCodeSame(200);
    }


    /**
     * @return \Generator
     */
    public function provideUri(): \Generator
    {
        yield ['/'];
        yield ['/?page=2'];
        yield ['/?page=3&field=title&order=desc$limit=20'];
    }
}
