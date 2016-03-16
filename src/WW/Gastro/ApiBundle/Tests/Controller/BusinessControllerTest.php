<?php

namespace WW\Gastro\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BusinessControllerTest extends WebTestCase
{
    public function testGetbusinesses()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'businesses');
    }

}
