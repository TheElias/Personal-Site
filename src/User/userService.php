<?php

Namespace Site\User;


class UserService {
    public function __construct(
        private UserDAO $userDao
    ) {}

    public function getById(int $id): ?User
    {
        return $this->userDao->getUserById($id);
    }
}

?>