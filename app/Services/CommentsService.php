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
}