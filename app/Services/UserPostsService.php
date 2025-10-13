<?php

namespace Services;

use Contracts\PostRepositoryInterface;

class UserPostsService
{

    public function __construct(private PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function allPosts(int $id): array
    {
        $sessionId = $_SESSION['user']['user_id'];
        $privacy = $id == $sessionId ? 1 : 0;

        return $this->postRepository->UserPosts($id, $privacy);
    }
}