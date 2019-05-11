<?php

namespace App\Tests\Controller;

class ContactTest extends BaseWeb
{

    public function testContact()
    {
        $crawler = $this->_client->request('GET', '/contact');
        $this->assertEquals(1, $crawler->filter('.page-heading h1:contains("Contact Me")')->count());

        $this->assertEquals(1, $crawler->filter('form')->count());

        $this->assertEquals(1, $crawler->filter('input[type=text]#name')->count());
        $this->assertEquals(1, $crawler->filter('input[type=email]#email')->count());
        $this->assertEquals(1, $crawler->filter('input[type=tel]#phone')->count());
        $this->assertEquals(1, $crawler->filter('textarea#message')->count());
        $this->assertEquals(1, $crawler->filter('button#sendMessageButton')->count());

        $send_button = $crawler->selectButton('Send');

        $form = $send_button->form(array(
            'name' => 'Test',
            'email' => 'admin@admin.com',
            'phone' => '213243324',
            'message' => 'Wiadomość testowa',
        ));

        $crawler = $this->_client->submit($form);

    }

}
