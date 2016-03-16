<?php
/*******************************************************************************
 *  The MIT License (MIT)
 *
 * Copyright (c) 2016 WW Software House
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated
 * documentation files (the "Software"), to deal in the Software without restriction, including without limitation the
 * rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the
 * Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE
 * WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
 * OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR
 * OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 ******************************************************************************/

namespace WW\Gastro\ApiBundle\DataFixtures\MongoDB;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use OAuth2\OAuth2;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class LoadOAuthClient
 * @package WW\Gastro\ApiBundle\DataFixtures\MongoDB
 * @codeCoverageIgnore
 */
class LoadOAuthClient implements FixtureInterface, OrderedFixtureInterface, ContainerAwareInterface
{

    /**
     * PHPUnit OAuth Client Name
     */
    const CLIENT_NAME = 'sammui-php-unit';

    /**
     * Application OAuth Client Name
     */
    public static $appClientName = 'sammui';

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $clientManager = $this->container->get('fos_oauth_server.client_manager.default');

        $client = $clientManager->createClient();
        $client->setName(static::CLIENT_NAME);
        $client->setRedirectUris(['/']);
        $client->setAllowedGrantTypes([
                                          OAuth2::GRANT_TYPE_AUTH_CODE,
                                          OAuth2::GRANT_TYPE_USER_CREDENTIALS,
                                          OAuth2::GRANT_TYPE_REFRESH_TOKEN,
                                          OAuth2::GRANT_TYPE_IMPLICIT,
                                          OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS
                                      ]);

        $clientManager->updateClient($client);

        $client = $clientManager->createClient();
        $client->setName(static::$appClientName);
        $client->setRedirectUris(['/']);
        $client->setAllowedGrantTypes([
                                          OAuth2::GRANT_TYPE_CLIENT_CREDENTIALS,
                                          OAuth2::GRANT_TYPE_USER_CREDENTIALS,
                                          OAuth2::GRANT_TYPE_REFRESH_TOKEN
                                      ]);

        $clientManager->updateClient($client);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}