<?php


namespace App\Controller\Admin\Article;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin")
 * Class DeleteArticleController
 * @package App\Controller\Admin\Article
 */
class DeleteArticleController extends AbstractController
{
    /**
     * @Route("/{id}/delete", name="admin_post_delete")
     * @param Request $request
     * @param Article $article
     * @return Response
     */
    public function delete(Request $request, Article $article): Response
    {
        $submittedToken = $request->get('token');

        if (!$this->isCsrfTokenValid('admin_post_delete', $submittedToken)) {
            return $this->redirectToRoute('app_home');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();

        $this->addFlash('success', 'Article delete');

        return $this->redirectToRoute('app_home');
    }
}