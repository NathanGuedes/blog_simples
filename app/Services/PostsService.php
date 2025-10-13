<?php

namespace Services;

use Contracts\PostRepositoryInterface;
use Exceptions\NotFoundException;
use Exceptions\ValidationException;
use Models\PostDTO;
use Support\SessionManager;
use Utils\Validator;

class PostsService
{
    private PostRepositoryInterface $postRepository;

    public function __construct(PostRepositoryInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }


    /**
     * @throws ValidationException
     */
    public function create(array $data): void
    {
        $validator = new Validator();
        $validator
            ->required('content', $data['content'] ?? null, 'Content')
            ->maxLength('content', $data['content'] ?? null, 1000, 'Content')
            ->required('privacy', $data['privacy'] ?? null, 'Privacy')
            ->csrf();

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }

        $image = getImageBase64('image');
        $user_id = new SessionManager()->get('user')['user_id'];

        $post = new PostDTO($data, $user_id, $image);
        $this->postRepository->create($post);
    }

    public function allPosts(): array
    {
        return $this->postRepository->allPosts();
    }

    /**
     * @throws NotFoundException
     */
    public function onlyPost(int $post_id): array
    {
        $result = $this->postRepository->findById($post_id);
        $post = $result['user_id'] === $_SESSION['user']['user_id'] ?? null ? $this->postRepository->onlyPostProfile($post_id) : $this->postRepository->onlyPost($post_id);

        if (!$post) {
            throw new NotFoundException("Post not found.");
        }

        return $post;
    }


    public function postComments(int $post_id): array
    {
        return $this->postRepository->postComments($post_id);
    }

    /**
     * @throws NotFoundException
     */
    public function onlyPostEdit(int $post_id): array
    {
        $post = $this->postRepository->findById($post_id);

        if (!$post) {
            throw new NotFoundException("Post not found.");
        }

        return $post;
    }

    /**
     * @throws ValidationException
     */
    public function delete(int $post_id): void
    {
        $post = $this->postRepository->findById($post_id);
        $user_id = new SessionManager()->get('user')['user_id'];

        if ($post['user_id'] != $user_id) {
            throw new ValidationException('You are not authorized to delete this post.');
        }

        $this->postRepository->delete($post_id);
    }

    /**
     * @throws ValidationException
     */
    public function update(array $data): void
    {
        $validator = new Validator();
        $validator
            ->required('content', $data['content'] ?? null, 'Content')
            ->maxLength('content', $data['content'] ?? null, 1000, 'Content')
            ->required('privacy', $data['privacy'] ?? null, 'Privacy')
            ->csrf();

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }

        if ($_FILES['image']['size'] == 0 && $data['remove_image'] == 1) {
            $this->postRepository->update(new PostDTO($data, $_SESSION['user']['user_id'], null));
        }

        if ($_FILES['image']['size'] > 0 && $data['remove_image'] == 1) {
            $image = getImageBase64('image');
            $this->postRepository->update(new PostDTO($data, $_SESSION['user']['user_id'], $image));
        }

        if ($_FILES['image']['size'] == 0 && $data['remove_image'] == 0) {
            $this->postRepository->updateWithoutImage(new PostDTO($data, $_SESSION['user']['user_id'], null));
        }

        if ($_FILES['image']['size'] > 0 && $data['remove_image'] == 0) {
            $image = getImageBase64('image');
            $this->postRepository->update(new PostDTO($data, $_SESSION['user']['user_id'], $image));
        }

    }
}