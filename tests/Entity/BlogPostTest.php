<?php

namespace App\Tests\Admin;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Language;
use PHPUnit\Framework\TestCase;

class BlogPostTest extends TestCase
{
    /**
     * @group entity
     * @group entity-blog-post
     */

    public function testEntity()
    {
        $post = new BlogPost();

        $post->getId();

        $post->setTitle('Title');
        $this->assertEquals("Title", $post->getTitle());

        $post->setSubtitle('SubTitle');
        $this->assertEquals("SubTitle", $post->getSubtitle());

        $post->setSlug('Ah#l4 p!Ein');
        $this->assertEquals('ah-l4-p-ein', $post->getSlug());

        $post->setBody('<div>Body</div>');
        $this->assertEquals("<div>Body</div>", $post->getBody());

        $post->setDraft(false);
        $this->assertEquals(false, $post->getDraft());

        $category = new Category();
        $category->setName('test');
        $post->setCategory($category);
        $this->assertEquals($category, $post->getCategory());

        $date = new \DateTime('2018-05-10 12:57:12');
        $post->setDate($date);
        $this->assertEquals($date, $post->getDate());

        $language = new Language;
        $post->setLanguage($language);
        $this->assertEquals($language, $post->getLanguage($language));
    }
}
