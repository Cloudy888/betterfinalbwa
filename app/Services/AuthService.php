<?php

namespace App\Services;

use App\Http\Resources\AuthRepository;;
use App\Models\User;
use Illuminate\Http\UploadedFile;

class AuthService
{
    private AuthRepository $authRepository;

    public function __construct(AuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function register(array $data)
    {
            if (issert($data['photo']) && $data['photo'] instanceof UploadedFile) {
                $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->authRepository->register($data);
    }

    public function login(array $data)
    {
        return $this->authRepository->login($data);
    }

    public function tokenLogin(array $data)
    {
        return $this->authRepository->tokenLogin($data);
    }

    public functiion uploadPhoto(UploadedFile $photo)
    {
        return $photo->store('users', 'public');
    }
}