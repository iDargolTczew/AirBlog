<?php

namespace Air\BlogBundle\Twig\Extension;


//klasa rozszerzajaca twig'a zarejestrowana w resources/config/services
class BlogExtension extends \Twig_Extension{
    
    /**
     * @var \Doctrine\Bundle\DoctrineBundle\Registry
     */
    private $doctrine;
    
    private $categoriesList;
    
    
    function __construct(\Doctrine\Bundle\DoctrineBundle\Registry $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    public function getName(){ //zwracam unikalna nazwę rozszerzenia
        return 'air_blog_extension';
    }
    
    /**
     * 
     * @return type
     */
    public function getFunctions() { //'printCategories... -> nazwy filtró∑
        return array(
            new \Twig_SimpleFunction('printCategoriesList', array($this, 'printCategoriesList')),
            new \Twig_SimpleFunction('printMainMenu', array($this, 'printMainMenu')),
            new \Twig_SimpleFunction('printTagsCloud', array($this, 'tagsCloud'))
        );
    }
    
    /**
     * 
     * @return type
     */
    public function getFilters() {
        return array(                                                       //is_safe -> twig nie wyswietla wtendyk znacznikow html
            new \Twig_SimpleFilter('ab_shorten', array($this, 'shorten'), array('is_safe' => array('html'))),
        );
    }
    
    //funkcja drukujaca kategorie z bazy danych uzywa serwisu doctrine wyzej
    public function printCategoriesList() {
        if(!isset($this->categoriesList)){ //jesli nie jest ustawiona -> zeby robic jedno zapytanie do b.danych
            $categoryRepo = $this->doctrine->getRepository('AirBlogBundle:Category');
            $this->categoriesList = $categoryRepo->findAll();
        }
        
        return $this->categoriesList;
    }
    
    public function printMainMenu(){
        $mainMenu = array(
            'home' => 'blog_index',
            'o mnie' => 'blog_about',
            'kontakt' => 'blog_contact'
        );
        
        return $mainMenu;
    }
    
    public function tagsCloud($limit = 40, $minFontSize = 1, $maxFontSize = 3.5) {
        $TagRepo = $this->doctrine->getRepository('AirBlogBundle:Tag');
        $tagsList = $TagRepo->getTagsListsOcc();
        $tagsList = $this->prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize);
        
        return $tagsList;
    }
    
    protected function prepareTagsCloud($tagsList, $limit, $minFontSize, $maxFontSize){
        $occs = array_map(function($row){
            return (int)$row['occ'];
        }, $tagsList);
        
        $minOcc = min($occs);
        $maxOcc = max($occs);
        
        $spread = $maxOcc - $minOcc;
        
        $spread = ($spread == 0) ? 1 : $spread;
        
        usort($tagsList, function($a, $b){
            $ao = $a['occ'];
            $bo = $b['occ'];
            
            if($ao === $bo) return 0;
            
            return ($ao < $bo) ? 1 : -1;
        });
        
        $tagsList = array_slice($tagsList, 0, $limit);
        
        shuffle($tagsList);
        
        foreach($tagsList as &$row){
            $row['fontSize'] = round(($minFontSize + ($row['occ'] - $minOcc) * ($maxFontSize - $minFontSize) / $spread), 2);
        }

        return $tagsList;
    }
    /**
     * 
     * @param type $text
     * @param type $length
     * @param type $wraptag
     */
    public function shorten($text, $length = 200, $wraptag = 'p' ) {
        
        $text = strip_tags($text);
        $text = substr($text, 0, $length).'[...]'; 
        $openTag = "<{$wraptag}>";
        $closeTag = "</{$wraptag}>";
        
        return $openTag.$text.$closeTag;
    
}
}
