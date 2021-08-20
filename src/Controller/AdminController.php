<?php

namespace App\Controller;

use Exception;
use App\Entity\Post;
use App\Entity\UserVote;
use App\Repository\PostRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(Request $request, PostRepository $postRepository): Response
    {
        // get value of the template's select
        $sort = $request->query->get('sort') ?? "date";

        if ($sort == "votes") {
            $posts = $postRepository->findAll();
            // sort posts by vote score
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
            // reverse the array to be sorted by DESC
            $posts = array_reverse($posts);
        } else {
            // sort by created_at date
            $posts = $postRepository->findBy([], ['created_at' => 'DESC']);
        }

        return $this->render('admin/index.html.twig', [
            'posts' => $posts
        ]);
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
