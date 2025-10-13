<?php

namespace Http\Controllers;

use Core\Request;
use Core\Response;
use Exception;
use Exceptions\NotFoundException;
use Exceptions\ValidationException;
use PDOException;
use Services\FeedService;
use Support\Flash;

class FeedController extends Controller
{

    public function __construct(private readonly FeedService $feedService)
    {
    }

    /**
     * @throws Exception
     */
    public function index(): Response
    {
        return new Response($this->view('feed', [
                'posts' => $this->feedService->allPosts()]
        ));
    }

}