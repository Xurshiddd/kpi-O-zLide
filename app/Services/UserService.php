<?php

namespace App\Services;

use App\Repositories\UserRepository;

class UserService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public UserRepository $userRepository,
    )
    {}
    public function index()
    {
        return $this->userRepository->getAll();
    }
}
