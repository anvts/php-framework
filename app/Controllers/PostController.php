<?php

namespace App\Controllers;

use Anvts\Framework\Controller\AbstractController;
use Anvts\Framework\Http\Response;
use App\Entities\Post;

class PostController extends AbstractController
{
    public function show(int $id): Response
    {
        return $this->render('posts.html.twig', [
            'postId' => $id
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
        dd($post);
    }
}