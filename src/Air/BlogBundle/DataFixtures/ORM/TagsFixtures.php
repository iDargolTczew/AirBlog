<?php

namespace Air\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Air\BlogBundle\Entity\Tag;


class TagsFixtures extends AbstractFixture implements OrderedFixtureInterface{
    
    public function load(ObjectManager $manager) {
        
        //inna lepsza metoda ładowania fixtur do bazy
        //w terminalu odpala sie to przez: ﻿php app/console doctrine:fixtures:load
        $tagsList = array(
            'raz',
            'dwa',
            'trzy',
            'cztery',
            'piec'
        );
        
        foreach($tagsList as $key => $name){
            $tags = new Tag();
            $tags->setName($name);
            
            $manager->persist($tags);
            
            $this->addReference('tag_'.$name, $tags);
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
        return 0;
    }

}
