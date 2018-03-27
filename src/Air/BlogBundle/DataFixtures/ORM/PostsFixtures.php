<?php

namespace Air\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Air\BlogBundle\Entity\Post;


class PostsFixtures extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager) {
        
        //inna lepsza metoda ładowania fixtur do bazy
        //w terminalu odpala sie to przez: ﻿php app/console doctrine:fixtures:load
        $postsList = array( 
                array(
                    'title' => 'Pan Tadeusz',
                    'content' => 'blablablablablabla',
                    'category' => 'osobowe',
                    'tags' => array('raz', 'dwa', 'trzy'),
                    'author' => 'Krzysztof Dargiewicz',
                    'createDate' => '2018-03-15 11:21:13',
                    'publishedDate' => '2018-03-15 11:21:13',
                    ),
                array(
                    'title' => 'Jan Kowalski',
                    'content' => 'blablablablablabla',
                    'category' => 'ciezarowe',
                    'tags' => array('cztery', 'piec'),
                    'author' => 'Krzysztof Dargiewicz',
                    'createDate' => '2018-03-15 11:21:13',
                    'publishedDate' => '2018-03-15 11:11:11',
                    ),
                array(
                    'title' => 'Gerard Przebżydły',
                    'content' => 'blablablablablabla',
                    'category' => 'tiry',
                    'tags' => array('dwa', 'trzy'),
                    'author' => 'Dargolek',
                    'createDate' => '2018-03-15 11:21:13',
                    'publishedDate' => '2018-02-25 12:12:12',
                    ),
                array(
                    'title' => 'Jakub Kowalski',
                    'content' => 'blablablablablabla',
                    'category' => 'osobowe',
                    'tags' => array('raz', 'piec'),
                    'author' => 'Artur Dargiewicz',
                    'createDate' => '2018-03-15 11:21:13',
                    'publishedDate' => '2018-03-15 11:11:11',
                    ),
                array(
                    'title' => 'Pierdyliard Przebżydły',
                    'content' => 'blablablablablabla',
                    'category' => 'tiry',
                    'tags' => array('dwa', 'trzy'),
                    'author' => 'Dargolek',
                    'createDate' => '2018-03-15 11:21:13',
                    'publishedDate' => null,
                    ),
                array(
                    'title' => 'Pierdyliard drugi Przebżydły',
                    'content' => 'blablablablablaqcouqecoqecoubla',
                    'category' => 'ciezarowe',
                    'tags' => array('raz', 'trzy'),
                    'author' => 'DargolekPierdolek',
                    'createDate' => '2018-02-15 11:21:13',
                    'publishedDate' => '2018-01-20 11:00:00',
                    ),
                );
        
        foreach($postsList as $details){
            $post = new Post();
            
            $post->setAuthor($details['author'])
                    ->setContent($details['content'])
                    ->setCreateDate(new \DateTime($details['createDate']))
                    ->setTitle($details['title'])
                    ->setCategory($this->getReference('category_'.$details['category']));
            
                if(null !== $details['publishedDate']){
                    $post->setPublishedDate(new \DateTime($details['publishedDate']));                            
                }
            
            foreach($details['tags'] as $tagName){
                $post->addTag($this->getReference('tag_'.$tagName));
            }
            
            $manager->persist($post);
            
            
        }
        
        $manager->flush();
        
        //bardziej lamerska metoda dodawania fixtur do bazy:
        
//        $category = new Category;
//        $category->setName('Nowa kategoria')
//                ->setSlug('nowa-kategoria');
//        
//        $manager->persist($category);
//        
//        $category2 = new Category;
//        $category2->setName('kategoria 2')
//                ->setSlug('kategoria-2');
//        
//        $manager->persist($category2);
//        
//        $category3 = new Category;
//        $category3->setName('chlanie')
//                ->setSlug('chlanie ;)');
//        
//        $manager->persist($category3);
        
        //$manager->flush();
    }

    public function getOrder(){
        return 1;
    }

}
