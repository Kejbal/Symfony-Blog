<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;

class BlogPostAdminTest extends BaseWeb
{   
    /**
     * @group admin
     * @group admin-blog-post
     * @group admin-blog-post-list
     */

    public function testList()
    {

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array());

        $crawler = $this->_client->request('GET', 'admin/app/blogpost/list');

        if (!$post) {

            $this->assertGreaterThan(
                0,
                $crawler->filter('a.sonata-action-element:contains("Add new")')->count()
            );

        } else {

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Category Name")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Title")')->count()
            );

            $this->assertGreaterThan(
                0,
                $crawler->filter('th:contains("Language")')->count()
            );

        }

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Title")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Category Name")')->count()
        );

        $this->assertGreaterThan(
            0,
            $crawler->filter('a.sonata-toggle-filter:contains("Language")')->count()
        );

    }

    public function AddEdit()
    {
        $category = self::$container->get('doctrine')->getRepository(Category::class)->findOneBy(array());
        $categoryId = $category->getId();

        $crawler = $this->_client->request('GET', 'admin/app/blogpost/create');

        $this->assertGreaterThan(
            0,
            $crawler->filter('textarea.ckeditor')->count()
        );

        $sendButton = $crawler->selectButton('Create');
        $form = $sendButton->form(array(
            's5d37a1acbf[title]' => 'Meik8ree',
            's5d37a1acbf[subtitle]' => 'uT6eSh9h',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $categoryId,
            's5d37a1acbf[draft]' => true,
            's5d37a1acbf[language]' => '1',
        ));
        $crawler = $this->_client->submit($form);

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Meik8ree', 'category' => $categoryId, 'subtitle'=>'uT6eSh9h', 'language'=>'1'));
        
        $this->assertTrue(!empty($post));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link1 = $crawler->filter('a')->attr('href');

        $crawler = $this->_client->request('GET', '/admin/app/blogpost/create');

        $this->assertGreaterThan(
            0,
            $crawler->filter('textarea.ckeditor')->count()
        );

        $sendButton = $crawler->selectButton('Create');
        $form = $sendButton->form(array(
            's5d37a1acbf[title]' => 'Meik8ree',
            's5d37a1acbf[subtitle]' => 'uT6eSh9h',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $categoryId,
            's5d37a1acbf[draft]' => true,
            's5d37a1acbf[language]' => '1',
        ));
        $crawler = $this->_client->submit($form);

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Meik8ree', 'category' => $categoryId, 'subtitle'=>'uT6eSh9h', 'language'=>'1', 'slug'=>'meik8ree-0'));
        
        $this->assertTrue(!empty($post));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

        $link = $crawler->filter('a')->attr('href');

        $crawler = $this->_client->request('GET', $link1);
        
        $sendButton = $crawler->selectButton('Update');
        $form = $sendButton->form(array(
            's5d37a1acbf[title]' => 'Aaphoo9k',
            's5d37a1acbf[subtitle]' => 'wepuL4qu',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $categoryId,
            's5d37a1acbf[draft]' => true,
            's5d37a1acbf[date][date][month]' => 3,
            's5d37a1acbf[date][date][day]' => 22,
            's5d37a1acbf[date][date][year]' => 2018,
            's5d37a1acbf[date][time][hour]' => 2,
            's5d37a1acbf[date][time][minute]' => 55,
            's5d37a1acbf[language]' => '2',
        ));
        $crawler = $this->_client->submit($form);
        
        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $categoryId, 'subtitle'=>'wepuL4qu', 'language'=>'2', 'slug'=>'aaphoo9k'));
        $this->assertTrue(!empty($post));

        $crawler = $this->_client->request('GET', $link);
        
        $sendButton = $crawler->selectButton('Update');
        $form = $sendButton->form(array(
            's5d37a1acbf[title]' => 'Aaphoo9k',
            's5d37a1acbf[subtitle]' => 'wepuL4qu',
            's5d37a1acbf[body]' => '<div>test</div>',
            's5d37a1acbf[category]' => $categoryId,
            's5d37a1acbf[draft]' => true,
            's5d37a1acbf[date][date][month]' => 3,
            's5d37a1acbf[date][date][day]' => 22,
            's5d37a1acbf[date][date][year]' => 2018,
            's5d37a1acbf[date][time][hour]' => 2,
            's5d37a1acbf[date][time][minute]' => 55,
            's5d37a1acbf[language]' => '2',
        ));
        $crawler = $this->_client->submit($form);
        
        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $categoryId, 'subtitle'=>'wepuL4qu', 'language'=>'2', 'slug'=>'aaphoo9k-0'));
        $this->assertTrue(!empty($post));

        $this->assertTrue($crawler->filter('html:contains("Redirecting to")')->count() > 0);

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

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $categoryId, 'slug'=>'aaphoo9k-0'));
        $this->assertTrue(!$post);

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

        $post = self::$container->get('doctrine')->getRepository(BlogPost::class)->findOneBy(array('title' => 'Aaphoo9k', 'category' => $categoryId, 'slug'=>'aaphoo9k'));
        $this->assertTrue(!$post);

    }

}
