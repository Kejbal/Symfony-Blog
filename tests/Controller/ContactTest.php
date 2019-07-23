<?php

namespace App\Tests\Controller;

use App\Controller\ContactController;
use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Config;
use App\Entity\GroupConfig;
use App\Entity\Language;
use Symfony\Component\HttpFoundation\Request;

class ContactTest extends BaseWeb
{
    /**
     * @group controller
     * @group controller-contact
     */

    public function testContact()
    {
        $crawler = $this->client->request('GET', '/contact');
        $this->assertEquals(
            1,
            $crawler->filter('.page-heading h1:contains("Contact Me")')
                ->count()
        );

        $this->assertEquals(2, $crawler->filter('form')->count());

        $this->assertEquals(1, $crawler->filter('input[type=text]#name')->count());
        $this->assertEquals(1, $crawler->filter('input[type=email]#email')->count());
        $this->assertEquals(1, $crawler->filter('input[type=tel]#phone')->count());
        $this->assertEquals(1, $crawler->filter('textarea#message')->count());
        $this->assertEquals(1, $crawler->filter('button#sendMessageButton')->count());

        $category = self::$container->get('doctrine')->getRepository(Category::class);
        $blogPost = self::$container->get('doctrine')->getRepository(BlogPost::class);
        $language = self::$container->get('doctrine')->getRepository(Language::class);
        $requestStack = self::$container->get('request_stack');

        $request = new Request;
        $mailer = self::$container->get('swiftmailer.mailer.default');
        $config = self::$container->get('doctrine')->getRepository(Config::class);
        $groupConfig = self::$container->get('doctrine')->getRepository(GroupConfig::class);
        $translator = self::$container->get('translator.default');

        $request->request->set('name', '12');

        $controller = new ContactController($category, $blogPost, $language, $requestStack);
        $result = $controller->index($request, $mailer, $config, $groupConfig, $translator);
        $result = json_decode($result->getContent());

        $this->assertEquals(0, $result->success);

        $request->request->set('name', 'Test');
        $request->request->set('email', 'admin@admin.com');
        $request->request->set('phone', '213243324');
        $request->request->set('message', 'Wiadomość testowa');

        $controller = new ContactController($category, $blogPost, $language, $requestStack);
        $result = $controller->index($request, $mailer, $config, $groupConfig, $translator);
        $result = json_decode($result->getContent());

        $this->assertEquals(1, $result->success);
    }
}
