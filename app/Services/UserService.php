<?php

namespace App\Services;

use App\Contracts\UserContract;

/**
 * Class UserService
 * @package App\Services
 */
class UserService
{
    /**
     * Class AdminService
     * @var UserContract
     */
    protected $userRepository;

    public function __construct(UserContract $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function storeUser($request)
    {
        return $this->userRepository->storeDetails($request);
    }
}
