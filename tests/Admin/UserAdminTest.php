<?php

namespace App\Tests\Admin;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UserAdminTest extends WebTestCase
{
    public function testList()
    {

        self::bootKernel();

        $user = self::$container->get('doctrine')->getRepository(User::class)->findOneBy(array());

        $client = static::createClient();

        $crawler = $client->request('GET', 'admin/app/user/list');

        if (!$user) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Email")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Roles")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Status")')->count()
            );

        }

    }

    public function testAddEdit()
    {
        self::bootKernel();
        $user = self::$container->get('doctrine')->getRepository(User::class)->findOneBy(array());
        $this->assertTrue(!empty($user));

        $client = static::createClient();
        $crawler = $client->request('GET', 'admin/app/user/create');

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            's8feb4ca090[email]' => 'admin1@admin.com',
            's8feb4ca090[plainPassword]' => 'El4aiyoh',
            's8feb4ca090[roles]' => array('ROLE_ADMIN'),
            's8feb4ca090[status]' => true,
        ));
        $crawler = $client->submit($form);

        $user = self::$container->get('doctrine')->getRepository(User::class)->findOneBy(array('email' => 'admin1@admin.com', 'status' => '1'));
        $this->assertTrue(!empty($user));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');
        $crawler = $client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');
        $form = $send_button->form(array(
            's8feb4ca090[email]' => 'admin2@admin.com',
            's8feb4ca090[plainPassword]' => 'El4aiyoh',
            's8feb4ca090[roles]' => array('ROLE_ADMIN'),
            's8feb4ca090[status]' => true,
        ));

        $crawler = $client->submit($form);

        $user = self::$container->get('doctrine')->getRepository(User::class)->findOneBy(array('email' => 'admin2@admin.com', 'status' => '1'));
        $this->assertTrue(!empty($user));

        $this->assertTrue(strlen($user->getPassword()) > 70);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');
        $crawler = $client->request('GET', $link);

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $client->click($button);

        $send_button = $crawler->selectButton('Yes, delete');

        $form = $send_button->form();

        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $user = self::$container->get('doctrine')->getRepository(User::class)->findOneBy(array('email' => 'admin2@admin.com', 'status' => '1'));
        $this->assertTrue(!$user);

    }
}