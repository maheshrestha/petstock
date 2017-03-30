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
     * @method("POST")
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
     * @method("POST")
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

    /**
     * @Route("/api/article/update", name="update_article")
     * @method("POST")
     *
     */
    public function updateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $article = $em->getRepository('AppBundle:Article')->find($data['id']);
        $repoAuthor = $em->getRepository('AppBundle:Author');
        $author = $repoAuthor->find($data['auther_id']);
        // Check if author posted is a valid author
        if($author && $article){
            $article->setAuthor($author)
                ->setTitle($data['title'])
                ->setContent($data['content'])
                ->setUrl($data['url'])
                ->setUpdatedAt(new \DateTime());
            $em->persist($article);
            $em->flush();
            $response = new Response('Article updated successfully');
        }
        else{
            $response = new Response('Invalid author_id and/or article_id');
        }

        return $response;
    }

    /**
     * @Route("/api/article/Delete", name="delete_article")
     * @method("POST")
     *
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $body = $request->getContent();
        $data = json_decode($body, true);
        $article = $em->getRepository('AppBundle:Article')->find($data['id']);
        if($article){
            $em->remove($article);
            $em->flush();
            $response = new Response('Article deleted successfully');
        }
        else{
            $response = new Response('Invalid article_id');
        }

        return $response;
    }

    

}
