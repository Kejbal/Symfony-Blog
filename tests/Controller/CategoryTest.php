<?php

namespace App\Tests\Controller;

use App\Entity\BlogPost;
use App\Entity\Category;
use App\Entity\Language;

class CategoryTest extends BaseWeb
{   
    /**
     * @group controller
     * @group controller-category
     */

    public function testCategory()
    {
        $per_page = 5;

        $languages = self::$container->get('doctrine')->getRepository(Language::class)->findBy(['status' => '1']);

        foreach ($languages as $language) {
            $categories = self::$container->get('doctrine')->getRepository(Category::class)->findBy(['language' => [$language->getId(), null]]);

            foreach ($categories as $category) {
                $all_posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0', 'category' => $category->getId(), 'language' => [$language->getId(), null]], ['id' => 'DESC']);

                $number_page = ceil(count($all_posts) / $per_page);

                if (count($all_posts) > 0) {
                    for ($page = 1; $page <= $number_page; $page++) {
                        
                        if ($language->getIsoCode()=='en') {
                            $crawler = $this->_client->request('GET', '/category/' . $category->getSlug() . '/' . $page);
                        } elseif ($language->getIsoCode()=='pl') {
                            $crawler = $this->_client->request('GET', '/kategoria/' . $category->getSlug() . '/' . $page);
                        }

                        $posts = self::$container->get('doctrine')->getRepository(BlogPost::class)->findBy(['draft' => '0', 'category' => $category->getId(), 'language' => [$language->getId(), null]], ['id' => 'DESC'], $per_page, ($page - 1) * $per_page);

                        foreach ($posts as $post) {
                            if ($language->getIsoCode()=='en') {
                                $this->assertEquals(1, $crawler->filter('.post-preview a[href="http://localhost/post/' . $post->getSlug() . '"]')->count());
                            } elseif ($language->getIsoCode()=='pl') {
                                $this->assertEquals(1, $crawler->filter('.post-preview a[href="http://localhost/wpis/' . $post->getSlug() . '"]')->count());
                            }

                            $this->assertEquals(1, $crawler->filter('h2.post-title:contains("' . $post->getTitle() . '")')->count());
                            $this->assertEquals(1, $crawler->filter('h3.post-subtitle:contains("' . $post->getSubtitle() . '")')->count());
                            $this->assertEquals(1, $crawler->filter('p.post-meta:contains("' . $post->getDate()->format('H:i:s d M Y') . '")')->count());
                        }

                        if ($page > 1) {
                            
                            if ($language->getIsoCode()=='en') {
                                $this->assertEquals(1, $crawler->filter('#newer-posts:contains("Newer Posts")')->count());
                            } elseif ($language->getIsoCode()=='pl') {
                                $this->assertEquals(1, $crawler->filter('#newer-posts:contains("Nowsze Wpisy")')->count());
                            }
                            $newer_page = $page - 1;
                            
                            if ($language->getIsoCode()=='en') {
                                $this->assertContains(
                                    '/category/' . $category->getSlug() . '/' . $newer_page,
                                    $crawler->filter('#newer-posts a:contains("Newer Posts")')->attr('href')
                                );
                            } elseif ($language->getIsoCode()=='pl') {
                                $this->assertContains(
                                    '/kategoria/' . $category->getSlug() . '/' . $newer_page,
                                    $crawler->filter('#newer-posts a:contains("Nowsze Wpisy")')->attr('href')
                                );
                            }
                        }

                        if ($page < $number_page) {
                            
                            if ($language->getIsoCode()=='en') {
                                $this->assertEquals(1, $crawler->filter('#older-posts:contains("Older Posts")')->count());
                            } elseif ($language->getIsoCode()=='pl') {
                                $this->assertEquals(1, $crawler->filter('#older-posts:contains("Starsze Wpisy")')->count());
                            }
                            $older_page = $page + 1;
                            
                            if ($language->getIsoCode()=='en') {
                                $this->assertContains(
                                    '/category/' . $category->getSlug() . '/' . $older_page,
                                    $crawler->filter('#older-posts a:contains("Older Posts")')->attr('href')
                                );
                            } elseif ($language->getIsoCode()=='pl') {
                                $this->assertContains(
                                    '/kategoria/' . $category->getSlug() . '/' . $older_page,
                                    $crawler->filter('#older-posts a:contains("Starsze Wpisy")')->attr('href')
                                );
                            }
                        }
                    }
                }
            }
        }

    }
}