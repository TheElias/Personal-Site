<?php

Namespace Site\User;

use DateTime;

class User {
    private int $id;
    private string $username;
    private string $firstName;
    private string $lastName;
    private string $passwordHash;
    private string $email;
    private DateTime $DOB;
    private DateTime $joinDate;
    private int $userLevel;

    public function __construct(int $id, string $username, string $firstName, string $lastName, string $passwordHash, string $email, DateTime $DOB, DateTime $joinDate, int $userLevel)
    {
        $this->id = $id;
        $this->username = $username;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->passwordHash = $passwordHash;
        $this->email = $email;
        $this->DOB = $DOB;
        $this->joinDate = $joinDate;
        $this->userLevel = $userLevel;
    }

    public function getId(): int { return $this->id;}
    public function getUsername(): string { return $this->username; }
    public function getEmail(): string{ return $this->email; }
    public function getFirstName(): string { return $this->firstName; }
    public function getLastName(): string { return $this->lastName; }
    public function getPasswordHash(): string { return $this->passwordHash; }
    public function getDOB(): ?DateTime { return $this->DOB; }
    public function getJoinDate(): DateTime { return $this->joinDate; }
    public function getUserLevel(): int { return $this->userLevel; }

    public static function fromArray(array $row): self
    {
        return new self(
            (int) $row['id'],
            $row['username'],
            $row['first_name'],
            $row['last_name'],
            $row['password_hash'],
            $row['email'],
            new \DateTime($row['date_of_birth']),
            new \DateTime($row['date_joined']),
            (int) ($row['user_level'] ?? 1)
        );
    }

    
}
?>