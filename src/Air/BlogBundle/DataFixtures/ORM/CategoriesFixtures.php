<?php

namespace Air\BlogBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Air\BlogBundle\Entity\Category;


class CategoriesFixtures extends AbstractFixture implements OrderedFixtureInterface {
    
    public function load(ObjectManager $manager) {
        
        //inna lepsza metoda ładowania fixtur do bazy
        //w terminalu odpala sie to przez: ﻿php app/console doctrine:fixtures:load
        $categoryList = array(
            'osobowe' => 'samochody osobowe',
            'ciezarowe' => 'samochody ciezarowe',
            'dostawcze' => 'samochodziki dostawcze ;)',
            'tiry' => 'TIRY',
            'transportowe' => 'autobusy'
        );
        
        foreach($categoryList as $key => $values){
            $category = new Category();
            $category->setName($values);
            
            $manager->persist($category);
            
            $this->addReference('category_'.$key, $category); 
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
