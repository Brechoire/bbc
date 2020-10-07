<?php


namespace App\Controller\Admin\Article;


use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class ListArticleController
 * @package App\Controller\Admin\Article
 */
class ListArticleController extends AbstractController
{
    /**
     * @Route("/liste-article", name="list_article_admin")
     * @param ArticleRepository $articleRepository
     * @return Response
     */
    public function index(ArticleRepository $articleRepository): Response
    {
        return $this->render('admin/list_article.html.twig', [
            'lists' => $articleRepository->findAll()
        ]);
    }
}