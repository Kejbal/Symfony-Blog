<?php

namespace App\Tests\Admin;

use App\Entity\GroupConfig;

class GroupConfigAdminTest extends BaseWeb
{
    /**
     * @group admin
     * @group admin-group-config
     * @group admin-group-config-list
     */

    public function testList()
    {
        $group = self::$container->get('doctrine')->getRepository(GroupConfig::class)->findOneBy(array());
        $crawler = $this->client->request('GET', 'admin/app/groupconfig/list');

        if (!$group) {
            $this->assertGreaterThan(
                0,
                $crawler->filter('a.sonata-action-element:contains("Add new")')->count()
            );
        } else {
            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Name")')->count()
            );
        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Name")')->count()
        );
    }

    /**
     * @group admin
     * @group admin-group-config
     * @group admin-group-config-add-edit
     */

    public function testAddEdit()
    {
        $crawler = $this->client->request('GET', 'admin/app/groupconfig/create');
        $send_button = $crawler->selectButton('Create');
        $form = $send_button->form(array(
            's44b5fcc36a[name]' => 'Group',
        ));
        $crawler = $this->client->submit($form);
        $category = self::$container
            ->get('doctrine')
            ->getRepository(GroupConfig::class)
            ->findOneBy(array('name' => 'Group'));
        $this->assertTrue(!empty($category));
        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');
        $crawler = $this->client->request('GET', $link);
        $send_button = $crawler->selectButton('Update');
        $form = $send_button->form(array(
            's44b5fcc36a[name]' => 'Bahd4Sut',
        ));
        $crawler = $this->client->submit($form);
        $group = self::$container
            ->get('doctrine')
            ->getRepository(GroupConfig::class)
            ->findOneBy(array('name' => 'Bahd4Sut'));
        $this->assertTrue(!empty($group));
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
        $group = self::$container
            ->get('doctrine')
            ->getRepository(GroupConfig::class)
            ->findOneBy(array('name' => 'Bahd4Sut'));
        $this->assertTrue(!$group);
    }
}
