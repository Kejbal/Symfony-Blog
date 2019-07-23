<?php

namespace App\Tests\Admin;

use App\Entity\User as UserEntity;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Cookie;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class BaseWeb extends WebTestCase
{

    protected $_client;

    public function setUp()
    {

        self::bootKernel();

        $client = static::createClient();

        $session = $client->getContainer()->get('session');

        $firewall = 'admin';

        $user = self::$container->get('doctrine')->getRepository(UserEntity::class)->findOneBy(array('email' => 'admin@admin.com'));
        $token = new UsernamePasswordToken($user, $user->getPassword(), $firewall, $user->getRoles());
        $session->set('_security_' . $firewall, serialize($token));
        $session->save();

        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);

        $this->_client = $client;
    }
}