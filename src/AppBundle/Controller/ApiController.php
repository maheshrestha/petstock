<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Article;
use AppBundle\Entity\Author;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\BrowserKit\Response;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api/author/add", name="add_author")
     *
     */
    public function createAuthorAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $author = new Author();
        $author->setName($data['name']);
        $em->persist($author);
        $em->flush();
        $response = new Response('Author Created successfully');
        return $response;
    }

    /**
     * @Route("/api/article/add", name="add_article")
     *
     *
     */
    public function createArticleAction(Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $article = new Article();
        $repoAuthor = $em->getRepository('AppBundle:Author');
        $author = $repoAuthor->find($data['auther_id']);
        // Check if author posted is a valid author
        if($author){
            $article->setAuthor($author)
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setUrl($data['url'])
                ->setCreatedAt(new \DateTime());
            $em->persist($article);
            $em->flush();
            $response = new Response('Article Created successfully');
        }
        else{
            $response = new Response('Invalid author_id');
        }

        return $response;
    }

}
