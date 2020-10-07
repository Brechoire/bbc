<?php


namespace App\Controller\Admin\Article;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class ShowArticleController
 * @package App\Controller\Admin\Article
 */
class ShowArticleController extends AbstractController
{
    /**
     * @Route("/article/{id}", name="show_article_admin")
     * @param ArticleRepository $articleRepository
     * @param $id
     * @return Response
     */
    public function index(ArticleRepository $articleRepository, $id): Response
    {
        return $this->render('admin/show_article.html.twig', [
          'article' => $articleRepository->find($id)
        ]);
    }
}