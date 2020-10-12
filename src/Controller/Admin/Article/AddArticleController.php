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
 * Class AddArticleController
 * @package App\Controller\Admin\Article
 */
class AddArticleController extends AbstractController
{
    /**
     * @Route("/ajout-article/{token}", name="add_article_admin")
     * @param Request $request
     * @param ArticleService $articleService
     * @return Response
     * @throws RedirectException
     */
    public function index(Request $request, ArticleService $articleService): Response
    {
        $submittedToken = $request->get('token');
        dump($submittedToken);

        if (!$this->isCsrfTokenValid('add_article_admin', $submittedToken)) {
             return $this->redirectToRoute('app_home');
        }

        $article = $articleService->addArticle($request);

        return $this->render('admin/add_article.html.twig', [
            'form' => $article->createView()
        ]);
    }
}