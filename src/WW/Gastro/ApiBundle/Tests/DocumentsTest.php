<?php

namespace WW\Gastro\ApiBundle\Tests;

use WW\Gastro\ApiBundle\DataFixtures\MongoDB\LoadOAuthClient;
use WW\Gastro\ApiBundle\Tests\Auth\OAuthClient;
use WW\Gastro\ApiBundle\Tests\Auth\OAuthClientInterface;
use Gastro\TestBundle\MongoDB\AssertMongoId;
use Gastro\TestBundle\MongoDB\AssertMongoIdInterface;
use Gastro\TestBundle\Rest\AssertRestUtils;
use Gastro\TestBundle\Rest\AssertRestUtilsInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Class DocumentsTest
 * @package Gastro\TranslateBundle\Tests
 */
class DocumentsTest extends WebTestCase implements AssertMongoIdInterface, OAuthClientInterface, AssertRestUtilsInterface
{

    use AssertMongoId, OAuthClient, AssertRestUtils;

    /**
     * Test Client Document
     */
    public function testClient()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $clientManager = $kernel->getContainer()->get('fos_oauth_server.client_manager.default');

        $client = $clientManager->findClientBy(['name' => LoadOAuthClient::CLIENT_NAME]);

        $this->assertNotNull($client->getId());
        $this->assertEquals(LoadOAuthClient::CLIENT_NAME, $client->getName());
        $client->setName(LoadOAuthClient::CLIENT_NAME . '-updated');
        $this->assertEquals(LoadOAuthClient::CLIENT_NAME . '-updated', $client->getName());
    }

    /**
     * Test Token Document
     */
    public function testToken()
    {
        $kernel = static::createKernel();
        $kernel->boot();

        $tokenManager = $kernel->getContainer()->get('fos_oauth_server.access_token_manager.default');

        $credentials = $this->getAnonymousCredentials();

        $token = $tokenManager->findTokenByToken($credentials->access_token);

        $this->assertMongoId($token->getId());
    }

}