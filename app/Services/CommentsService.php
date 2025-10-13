<?php

namespace Services;

use Contracts\CommentsRepositoryInterface;
use Exceptions\ValidationException;
use Models\CommentsDTO;
use Utils\Validator;

class CommentsService
{

    public function __construct(private CommentsRepositoryInterface $commentsRepository)
    {
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
            ->csrf();

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }

        $comments = new CommentsDTO($data);

        $this->commentsRepository->create($comments);

    }

    /**
     * @throws ValidationException
     */
    public function destroy(int $comment_id, array $form_data): void
    {
        if (! $form_data['post_owner_id'] === $_SESSION['user']['user_id'] || ! $form_data['comment_owner_id'] === $_SESSION['user']['user_id']){
            throw new ValidationException('error');
        }

        $this->commentsRepository->delete($comment_id);
    }

    /**
     * @throws ValidationException
     */
    public function update(mixed $comment_id, array $form_data)
    {
        $validator = new Validator();
        $validator
            ->required('content', $form_data['content'] ?? null, 'Content')
            ->maxLength('content', $form_data['content'] ?? null, 1000, 'Content');

        if ($validator->fails()) {
            throw new ValidationException($validator->getErrors());
        }
        if (! $form_data['comment_owner_id'] === $_SESSION['user']['user_id']){
            throw new ValidationException('error');
        }
        $comment = new CommentsDTO($form_data);

        $this->commentsRepository->update($comment);
    }
}