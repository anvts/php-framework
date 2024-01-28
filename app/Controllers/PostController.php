<?php

namespace App\Controllers;

use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Http\Response;
use App\Entities\Post;
use App\Services\PostService;

class PostController extends AbstractController
{
    public function __construct(
        private PostService $postService
    )
    {

    }

    public function show(int $id): Response
    {
        try {
            $post = $this->postService->findOrFail($id);
        } catch (\Exception $e) {
            return $this->render('post-not-found.html.twig', [
                'message' => $e->getMessage(),
            ]);
        }

        return $this->render('posts.html.twig', [
            'post' => $post,
            'createdAt' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function create(): Response
    {
        return $this->render('create-post.html.twig');
    }

    public function store(): Response
    {
        $post = Post::create(
            $this->request->getPostData()['title'],
            $this->request->getPostData()['content']
        );

        $post = $this->postService->save($post);

        dd($post);
    }
}