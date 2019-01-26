<?php

namespace App\Tests\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginAdminTest extends WebTestCase
{
    public function testLogin()
    {
        self::bootKernel();

        $client = static::createClient();

        $crawler = $client->request('GET', 'admin/login');

        $send_button = $crawler->selectButton('Login');
        $form = $send_button->form(array(
            'admin_login_form[email]' => 'adsasdsfa@admin.com',
            'admin_login_form[password]' => 'sfdafsasf',
        ));
        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $client->request('GET', $link);

        $this->assertTrue($crawler->filter('.alert:contains("Username could not be found")')->count() > 0);

        $send_button = $crawler->selectButton('Login');
        $form = $send_button->form(array(
            'admin_login_form[email]' => 'admin@admin.com',
            'admin_login_form[password]' => 'Rei8egh2',
        ));
        $crawler = $client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $client->request('GET', $link);

        $this->assertTrue($crawler->filter('html:contains("Dashboard")')->count() > 0);

    }
}