<?php

namespace Air\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

class PostsController extends Controller
{
    protected $itemsLimit = 3;
    
    /**
     * @Route(
     *      "/{page}", 
     *      name = "blog_index", 
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     *      )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function indexAction($page)
    {
        $postRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        //$allPosts = $postRepo->findBy(array(), array('publishedDate' => 'desc'));
        
        $qb = $postRepo->getQueryBuilder(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC'
        ));
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => 'Najnowsze wpisy'
        );
    }
    
        /**
     * @Route(
     *      "/search/{page}", 
     *      name = "blog_search", 
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     *      )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function searchAction(Request $request, $page)
    {
        $searchParam = $request->query->get('search');
        
        $postRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        //$allPosts = $postRepo->findBy(array(), array('publishedDate' => 'desc'));
        
        $qb = $postRepo->getQueryBuilder(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'search' => $searchParam
        ));
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wyniki wyszukiwania frazy %s',$searchParam)
        );
    }
    
    /**
     * @Route(
     *      "/{slug}", 
     *      name = "blog_post"
     *      )
     * 
     * @Template()
     */
    public function postAction($slug)
    {
        $postRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        $post = $postRepo->getPublishedPost($slug);
        
        if(null === $post){
            throw $this->createNotFoundException('Post nie został odnaleziony gościu kurwa...');
        }
        
        
        return array(
            'post' => $post
        );
    }
    
    /**
     * @Route(
     *      "/category/{slug}/{page}",
     *      name = "blog_category",
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\d+"}
     * )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */

    public function categoryAction($slug, $page)
    {
        $postRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        
        $qb = $postRepo->getQueryBuilder(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'categorySlug' => $slug
        ));
        
        $categoryRepo = $this->getDoctrine()->getRepository('AirBlogBundle:category');
        $category = $categoryRepo->findOneBySlug($slug);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy w kategorii "%s"',$category->getName())
        );
    }
    
    /**
     * @Route(
     *      "/tag/{slug}/{page}", 
     *      name = "blog_tag", 
     *      defaults = {"page" = 1},
     *      requirements = {"page" = "\+d"}
     *      )
     * 
     * @Template("AirBlogBundle:Posts:postsList.html.twig")
     */
    public function tagAction($slug, $page)
    {
        $postRepo = $this->getDoctrine()->getRepository('AirBlogBundle:Post');
        
        $qb = $postRepo->getQueryBuilder(array(
            'status' => 'published',
            'orderBy' => 'p.publishedDate',
            'orderDir' => 'DESC',
            'tagSlug' => $slug
        ));
        
        $tagRepo = $this->getDoctrine()->getRepository('AirBlogBundle:tag');
        $tag = $tagRepo->findOneBySlug($slug);
        
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate($qb, $page, $this->itemsLimit);
        
        return array(
            'pagination' => $pagination,
            'listTitle' => sprintf('Wpisy z tagiem "%s"',$tag->getName())
        );
    }
}
