<?php

namespace WW\Gastro\ApiBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class EmployeeControllerTest extends WebTestCase
{
    public function testGetemployee()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'employee');
    }

    public function testGetemployees()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', 'employees');
    }

}
