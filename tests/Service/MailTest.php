<?php

namespace App\Tests\Service;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MailTest extends WebTestCase
{
    public function testMail()
    {

        $client = static::createClient();

        // enables the profiler for the next request (it does nothing if the profiler is not available)
        $client->enableProfiler();

        $crawler = $client->request('POST', '/contact/mail');

        $mailCollector = $client->getProfile()->getCollector('swiftmailer');

        // checks that an email was sent
        $this->assertSame(1, $mailCollector->getMessageCount());

        $collectedMessages = $mailCollector->getMessages();
        $message = $collectedMessages[0];

        // Asserting email data
        $this->assertInstanceOf('Swift_Message', $message);
        $this->assertSame('Hello Email', $message->getSubject());
        $this->assertSame('testkejbal@gmail.com', key($message->getFrom()));
        $this->assertSame('kejbal@gmail.com', key($message->getTo()));
        $this->assertSame(
            'You should see me from the profiler!',
            $message->getBody()
        );

    }

}