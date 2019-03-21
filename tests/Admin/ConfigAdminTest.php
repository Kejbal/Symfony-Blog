<?php

namespace App\Tests\Admin;

use App\Entity\Config;

class ConfigAdminTest extends BaseWeb
{

    public function testList()
    {
        $config = self::$container->get('doctrine')->getRepository(Config::class)->findOneBy(array());

        $crawler = $this->client->request('GET', 'admin/app/config/list');

        if (!$config) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a.sonata-action-element:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Base")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Value")')->count()
            );

        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Base")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Value")')->count()
        );

    }

    public function testAddEdit()
    {

        $crawler = $this->client->request('GET', 'admin/app/config/create');

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            's7d07f9e8fc[base]' => 'Config',
            's7d07f9e8fc[value]' => 'Value',
            's7d07f9e8fc[group_config]' => '5',
        ));

        $crawler = $this->client->submit($form);

        $config = self::$container->get('doctrine')->getRepository(Config::class)->findOneBy(array('base' => 'Config', 'value'=>'Value'));
        $this->assertTrue(!empty($config));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');

        $form = $send_button->form(array(
            's7d07f9e8fc[base]' => 'meiJai0p',
            's7d07f9e8fc[value]' => 'Ot9Pahfa',
            's7d07f9e8fc[group_config]' => '5',
        ));

        $crawler = $this->client->submit($form);

        $config = self::$container->get('doctrine')->getRepository(Config::class)->findOneBy(array('base' => 'meiJai0p', 'value'=>'Ot9Pahfa'));
        $this->assertTrue(!empty($config));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $crawler = $this->client->request('GET', $link);

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $this->client->click($button);

        $send_button = $crawler->selectButton('Yes, delete');

        $form = $send_button->form();

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $config= self::$container->get('doctrine')->getRepository(Config::class)->findOneBy(array('base' => 'Bahd4Sut'));
        $this->assertTrue(!$config);

    }

}