<?php

namespace App\Controller;

use App\Entity\Post;
use App\Form\PostType;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $sort = $request->query->get('sort') ?? "date";

        if ($sort == "votes") {
            $posts = $postRepository->findBy([], ['votes' => 'DESC']);
        } else {
            $posts = $postRepository->findBy([], ['created_at' => 'DESC']);
        }

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    /**
     * @Route("/new", name="new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $post = new Post();
        $form = $this->createForm(PostType::class, $post);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $post->setUser($this->getUser());
            $post->setCreatedAt(new \DateTime());
            $post->setVotes(0);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('posts');
        }

        return $this->render('/post/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
