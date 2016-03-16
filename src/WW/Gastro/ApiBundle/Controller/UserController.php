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

namespace WW\Gastro\ApiBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Core\Authentication\Token\AnonymousToken;

/**
 * Class UserController
 * @package WW\Gastro\ApiBundle\Controller
 */
class UserController extends Controller
{

    /**
     * @return JsonResponse
     */
    public function infoAction()
    {
        $auth       = $this->get('security.authorization_checker');
        $secToken   = $this->get('security.token_storage')->getToken();
        $oauthToken = $this->get('fos_oauth_server.access_token_manager.default');

        $user   = null;
        $client = null;

        if (!$secToken instanceof AnonymousToken) {
            if ($accessToken = $oauthToken->findTokenByToken($secToken->getToken())) {
                $c      = $accessToken->getClient();
                $client = [
                    'name' => $c->getName(),
                    'id'   => $c->getPublicId()
                ];
            }
        }

        if ($u = $this->getUser()) {
            $user = [
                'username' => $u->getUsername(),
                'email'    => $u->getEmail(),
                'roles'    => $u->getRoles(),
            ];
        }

        $info = [
            'authenticated'             => $secToken->isAuthenticated(),
            'authenticated_fully'       => $auth->isGranted('IS_AUTHENTICATED_FULLY'),
            'authenticated_anonymously' => $auth->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'),
            'role_user'                 => $auth->isGranted('ROLE_USER'),
            'role_admin'                => $auth->isGranted('ROLE_ADMIN'),
            'role_anonymous'            => $auth->isGranted('IS_AUTHENTICATED_ANONYMOUSLY'),
            'client'                    => $client,
            'user'                      => $user
        ];

        return new JsonResponse(
            json_decode(json_encode($info))
        );
    }
}
