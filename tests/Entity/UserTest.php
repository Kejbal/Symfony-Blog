<?php

namespace App\Tests\Admin;

use App\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testEntity()
    {

        $user = new User();

        $user->getId();

        $user->setEmail('adsfafd');
        $this->assertEquals("adsfafd", $user->getEmail());

        $user->setPassword('Eeleej1g');
        $this->assertEquals('Eeleej1g', $user->getPassword());

        $user->setPlainPassword('zi6Oothe');
        $this->assertEquals('zi6Oothe', $user->getPlainPassword());

        $user->setStatus(true);
        $this->assertEquals(true, $user->getStatus());

        $user->setRoles(array('ROLE_ADMIN'));
        $this->assertEquals(array('ROLE_ADMIN', 'ROLE_USER'), $user->getRoles());

        $user->getSalt();

    }
}