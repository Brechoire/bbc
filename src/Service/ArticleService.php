<?php


namespace App\Service;


use App\Entity\Article;
use App\EventListener\RedirectExceptionListener;
use App\Exception\RedirectException;
use App\Form\ArticleType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class ArticleService
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var FormFactoryInterface
     */
    private $form;
    /**
     * @var UserPasswordEncoderInterface
     */
    private $passwordEncoder;
    /**
     * @var TokenGeneratorInterface
     */
    private $tokenGenerator;
    /**
     * @var FlashBagInterface
     */
    private $flashBag;
    /**
     * @var RouterInterface
     */
    private $router;
    /**
     * @var RedirectExceptionListener
     */
    private $redirect;
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * ArticleService constructor.
     * @param EntityManagerInterface $entityManager
     * @param FormFactoryInterface $form
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param TokenGeneratorInterface $tokenGenerator
     * @param FlashBagInterface $flashBag
     * @param RouterInterface $router
     * @param RedirectExceptionListener $redirect
     * @param SessionInterface $session
     * @param TokenStorageInterface $tokenStorage
     */
    public function __construct(EntityManagerInterface $entityManager,
                                FormFactoryInterface $form,
                                UserPasswordEncoderInterface $passwordEncoder,
                                TokenGeneratorInterface $tokenGenerator,
                                FlashBagInterface $flashBag,
                                RouterInterface $router,
                                RedirectExceptionListener $redirect,
                                SessionInterface $session,
                                TokenStorageInterface $tokenStorage)
    {

        $this->entityManager = $entityManager;
        $this->form = $form;
        $this->passwordEncoder = $passwordEncoder;
        $this->tokenGenerator = $tokenGenerator;
        $this->flashBag = $flashBag;
        $this->router = $router;
        $this->redirect = $redirect;
        $this->session = $session;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * @param Request $request
     * @return FormInterface
     * @throws RedirectException
     */
    public function addArticle(Request $request)
    {
        $article = new Article();

        $form = $this->form->create(ArticleType::class, $article);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $article->setUser($this->tokenStorage->getToken()->getUser());
            $this->entityManager->persist($article);
            $this->entityManager->flush();

            $this->flashBag->add('success', 'Article ajouté.');
            throw new RedirectException($this->router->generate('app_home'));
        }

        return $form;
    }
}