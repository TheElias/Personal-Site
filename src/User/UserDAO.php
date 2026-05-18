<?php

Namespace Site\User;

    use PDO;

Class UserDAO {

    protected $database;
    protected $conn;

    public function __construct(PDO $conn)
    {
        $this->conn = $conn;
    }

    public function getUserById(int $id): ?User 
    {
        $sql = "SELECT *
        FROM personal_website.user 
        WHERE id =  ?";

        $result = $this->conn->prepare($sql);
        $result->execute([$id]);
        $userInfo = $result -> fetch();  
        
        if (!$userInfo) {
            return null;
        }
        else {
            return User::fromArray($userInfo);
        }
    }

    public function getUserByUsername(string $username): ?User 
    {
        $sql = "SELECT *
        FROM personal_website.user 
        WHERE username =  ?";

        $result = $this->conn->prepare($sql);
        $result->execute([$username]);
        $userInfo = $result -> fetch();  
        
        if (!$userInfo) {
            return null;
        }
        else {
            return User::fromArray($userInfo);
        }
        
    }

    public function getPasswordHashByUserId(int $userId): ?string
    {
        $sql = "SELECT password_hash
        FROM personal_website.user 
        WHERE id =  ?";

        $result = $this->conn->prepare($sql);
        $result->execute([$userId]);
        $hashInfo = $result -> fetch();  
        
        if (!$hashInfo) {
            return null;
        }
        else {
            return $hashInfo['password_hash'];
        }
    }

    public function createUser(User $user): int
    {
        $sql = "INSERT INTO personal_website.user (username, first_name, last_name, password_hash, email, date_of_birth, user_level) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $result = $this->conn->prepare($sql);
        if ($result->execute([
            $user->getUsername(),
            $user->getFirstName(),
            $user->getLastName(),
            $user->getPasswordHash(),
            $user->getEmail(),
            $user->getDOB()->format('Y-m-d'),
            $user->getUserLevel()
        ])) {
            throw new \RuntimeException('Failed to create user');
        }
        return (int) $this->conn->lastInsertId();
    }


    // function doesUserExistByUsername($username = '')
    // function doesUserExistByEmail($email = '')
    // function createUser($username, $email, $password)
    // function updateUser($id, $username, $email, $password)
    // function deleteUser($id)
    // function getAllUsers()
    // function getUserByUsername($username)
    // function getUserByEmail($email)
    //


}

?>