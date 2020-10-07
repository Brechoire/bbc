<?php

namespace App\Controller\Admin\Article;

use App\Exception\RedirectException;
use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class EditArticleController
 * @package App\Controller\Admin\Article
 */
class EditArticleController extends AbstractController
{
    /**
     * @Route("/modifier-article/{id}", name="edit_article_admin")
     * @param Request $request
     * @param ArticleService $articleService
     * @param $id
     * @return Response
     * @throws RedirectException
     */
    public function index(Request $request, ArticleService $articleService, $id): Response
    {
        $article = $articleService->editArticle($request, $id);

        return $this->render('admin/edit_article.html.twig', [
            'form' => $article->createView()
        ]);
    }
}