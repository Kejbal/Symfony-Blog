<?php

namespace App\Tests\Admin;

use App\Entity\Category;
use App\Tests\Admin\BlogPostAdminTest;

class CategoryAdminTest extends BaseWeb
{
    /**
     * @group admin
     * @group admin-category
     * @group admin-category-list
     */

    public function testList()
    {
        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array());

        $crawler = $this->_client->request('GET', 'admin/app/category/list');

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

    }

    /**
     * @group admin
     * @group admin-category
     * @group admin-category-add-edit
     * @group admin-blog-post-add-edit
     */

    public function testAddEdit()
    {

        $crawler = $this->_client->request('GET', 'admin/app/category/create');

        $sendButton = $crawler->selectButton('Create');

        $form = $sendButton->form(array(
            'sec4809de79[name]' => 'Tessfdt',
            'sec4809de79[language]' => '1',
        ));

        $crawler = $this->_client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Tessfdt', 'language' => '1','slug'=>'tessfdt'));
        $this->assertTrue(!empty($category));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link1 = $crawler->filter('a')->attr('href');

        $crawler = $this->_client->request('GET', '/admin/app/category/create');

        $sendButton = $crawler->selectButton('Create');

        $form = $sendButton->form(array(
            'sec4809de79[name]' => 'Tessfdt',
            'sec4809de79[language]' => '1',
        ));

        $crawler = $this->_client->submit($form);
        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Tessfdt', 'language' => '1', 'slug'=>'tessfdt-0'));
        $this->assertTrue(!empty($category));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->_client->request('GET', $link1);
        $sendButton = $crawler->selectButton('Update');
        $form = $sendButton->form(array(
            'sec4809de79[name]' => 'Hu4thahr',
            'sec4809de79[language]' => '2',
        ));
        $crawler = $this->_client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Hu4thahr', 'language' => '2', 'slug'=>'hu4thahr'));
        $this->assertTrue(!empty($category));

        $crawler = $this->_client->request('GET', $link);
        $sendButton = $crawler->selectButton('Update');
        $form = $sendButton->form(array(
            'sec4809de79[name]' => 'Hu4thahr',
            'sec4809de79[language]' => '2',
        ));
        $crawler = $this->_client->submit($form);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'Hu4thahr', 'language' => '2','slug'=>'hu4thahr'));
        $this->assertTrue(!empty($category));

        $blogPostTest = new BlogPostAdminTest();
        $blogPostTest->setUp();
        $blogPostTest->AddEdit();

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->_client->request('GET', $link);

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $this->_client->click($button);

        $sendButton = $crawler->selectButton('Yes, delete');

        $form = $sendButton->form();

        $crawler = $this->_client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'thiX4sei'));
        $this->assertTrue(!$category);

        $crawler = $this->_client->request('GET', $link1);

        $button = $crawler
            ->filter('a:contains("Delete")')
            ->eq(0)
            ->link();

        $crawler = $this->_client->click($button);

        $sendButton = $crawler->selectButton('Yes, delete');

        $form = $sendButton->form();

        $crawler = $this->_client->submit($form);

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array('name' => 'thiX4sei'));
        $this->assertTrue(!$category);

    }

}