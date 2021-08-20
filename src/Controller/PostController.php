<?php

namespace App\Controller;

use Exception;
use App\Entity\Post;
use App\Entity\UserVote;
use App\Form\PostType;
use App\Repository\PostRepository;
use App\Repository\UserVoteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

class PostController extends AbstractController
{
    /**
     * @Route("/", name="posts")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        $sort = $request->query->get('sort') ?? "date";

        if ($sort == "votes") {
            $posts = $postRepository->findAll();
            usort($posts, function($post1, $post2) {
                $userVotes1 = $post1->getUserVotes();
                $userVotes2 = $post2->getUserVotes();

                $totalVotes1 = $post1->getVotes();
                $totalVotes2 = $post2->getVotes();
                
                if ($totalVotes1 == $totalVotes2) {
                    return 0;
                }
                return ($totalVotes1 < $totalVotes2) ? -1 : 1;
            });
            $posts = array_reverse($posts);
        } else {
            $posts = $postRepository->findBy([], ['created_at' => 'DESC']);
        }

        $userVoteRepository = $this->getDoctrine()->getManager()->getRepository(UserVote::class);

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
            'userVoteRepository' => $userVoteRepository
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
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($post);
            $entityManager->flush();

            return $this->redirectToRoute('posts');
        }

        return $this->render('/post/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/vote/{id}/{value}/{token}", name="vote", methods={"GET", "POST"})
     */
    public function vote(Post $post, $value, $token, PostRepository $postRepository, UserVoteRepository $userVoteRepository)
    {
        if (!$this->isCsrfTokenValid('vote_post' . $post->getId(), $token)) {
            throw new Exception('Invalid CSRF Token');
        }

        $userVote = new UserVote();
        $post = $postRepository->find($post);
        $userVoteForPost = $userVoteRepository->findBy(['user' => $this->getUser(), 'post' => $post]);
        $entityManager = $this->getDoctrine()->getManager();
        
        if (!empty($userVoteForPost) && $userVoteForPost[0]->getValue() != $userVote->transformValueToInt($value)) {

            $entityManager->remove($userVoteForPost[0]);
            $entityManager->flush();

        } elseif (empty($userVoteForPost)) {

            $userVote->setUser($this->getUser());
            $userVote->setPost($post);
            $userVote->setValue($value);
            
            $entityManager->persist($userVote);
            $entityManager->flush();

        }

        return $this->redirectToRoute('posts');
    }

    /**
     * @Route("/delete/{id}/{token}", name="delete", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Post $post, $token)
    {
        if (!$this->isCsrfTokenValid('delete_post' . $post->getId(), $token)) {
            throw new Exception('Invalid CSRF Token');
        }

        $em = $this->getDoctrine()->getManager();
        $em->remove($post);
        $em->flush();

        return $this->redirectToRoute('posts');
    }
}
