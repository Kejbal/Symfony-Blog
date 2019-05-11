<?php

namespace App\Tests\Admin;

use App\Entity\Language;

class LanguageAdminTest extends BaseWeb
{

    public function testList()
    {
        $languages = self::$container->get('doctrine')->getRepository(Language::class)->findOneBy(array());

        $crawler = $this->client->request('GET', 'admin/app/language/list');

        if (!$languages) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a.sonata-action-element:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Name")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Iso Code")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Status")')->count()
            );

        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Name")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Iso Code")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Status")')->count()
        );

    }

    public function testAddEdit()
    {

        $crawler = $this->client->request('GET', 'admin/app/language/create');

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            'sb7a5b9a2c3[name]' => 'Polish11',
            'sb7a5b9a2c3[iso_code]' => 'tt',
            'sb7a5b9a2c3[status]' => '1',
        ));

        $crawler = $this->client->submit($form);

        $language = self::$container->get('doctrine')->getRepository(Language::class)->findOneBy(array('name' => 'Polish11'));
        $this->assertTrue(!empty($language));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');

        $form = $send_button->form(array(
            'sb7a5b9a2c3[name]' => 'Hu4thahr',
            'sb7a5b9a2c3[iso_code]' => 'yy',
            'sb7a5b9a2c3[status]' => '1',
        ));

        $crawler = $this->client->submit($form);

        $language = self::$container->get('doctrine')->getRepository(Language::class)->findOneBy(array('name' => 'Hu4thahr'));
        $this->assertTrue(!empty($language));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->client->request('GET', '/admin/app/language/' . $language->getId() . '/edit');

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $this->client->click($button);

        $send_button = $crawler->selectButton('Yes, delete');

        $form = $send_button->form();

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $language = self::$container->get('doctrine')->getRepository(Language::class)->findOneBy(array('name' => 'thiX4sei'));
        $this->assertTrue(!$language);

    }

}
