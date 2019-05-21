<?php

namespace App\Tests\Admin;

use App\Entity\Category;
use App\Tests\Admin\BlogPostAdminTest;

class CategoryAdminTest extends BaseWeb
{

    public function testList()
    {
        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array());

        $crawler = $this->client->request('GET', 'admin/app/category/list');

        if (!$category) {

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
                $crawler->filter('th:contains("Language")')->count()
            );

        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Name")')->count()
        );

        /*$this->assertGreaterThan(
    0,
    $crawler->filter('a.sonata-toggle-filter:contains("Language")')->count()
    );*/

    }

    public function testAddEdit()
    {

        $crawler = $this->client->request('GET', 'admin/app/category/create');

        $send_button = $crawler->selectButton('Create');

        $form = $send_button->form(array(
            'sec4809de79[name]' => 'Tessfdt',
            'sec4809de79[language]' => '1',
        ));

        $crawler = $this->client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Tessfdt', 'language' => '1'));
        $this->assertTrue(!empty($category));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->client->request('GET', $link);

        $send_button = $crawler->selectButton('Update');

        $form = $send_button->form(array(
            'sec4809de79[name]' => 'Hu4thahr',
            'sec4809de79[language]' => '2',
        ));

        $crawler = $this->client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Hu4thahr', 'language' => '2'));
        $this->assertTrue(!empty($category));

        $blogPostTest = new BlogPostAdminTest();
        $blogPostTest->setUp();
        $blogPostTest->AddEdit();

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->client->request('GET', '/admin/app/category/' . $category->getId() . '/edit');

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $this->client->click($button);

        $send_button = $crawler->selectButton('Yes, delete');

        $form = $send_button->form();

        $crawler = $this->client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'thiX4sei'));
        $this->assertTrue(!$category);

    }

}