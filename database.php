<?php

class Database
{
    private PDO $connection;
    public function __construct()
    {
        $host = 'localhost';
        $dbname = 'spa';
        $user = 'root';
        $pass = '';

        $this->connection = new PDO('mysql:host=' . $host . ';dbname=' . $dbname, $user, $pass);
    }

    public function checkMail(User $user): bool
    {
        $sql = $this->connection->prepare("SELECT * FROM user WHERE email=?");
        $sql->execute([
            $user->email
        ]);
        $exist = $sql->fetch();

        if($exist){
            return false;
        }
        else{
            return true;
        }


        
    }
    public function saveUser(User $user): void
    {
    
        $sql = $this->connection->prepare('
            INSERT INTO user (`email`, `first_name`, `last_name`, `password`)
            VALUES (?, ?, ?, ?)
            
        ');

        $sql->execute([
            $user->email,
            $user->firstName,
            $user->lastName,
            md5($user->password),
        ]);
        header('Location: login.php');
    }

    public function login(LoginUser $user): bool
    {
        $sql = $this->connection->prepare('
            SELECT * FROM user WHERE email = :eml AND password = :passwd
        ');
        $sql->execute([
            ':eml' => $user->email,
            ':passwd' => md5($user->password),
        ]);
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        if ($result == true) {
            $_SESSION['id'] = $result['id'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['first_name'] = $result['first_name'];
            $_SESSION['last_name'] = $result['last_name'];
            $_SESSION['admin'] = $result['admin'];
            header('Location: userInterface.php');
            return true;
        } else {
            return false;
        }
    }

    public function addPet(AddPet $pet): void
    {
        $sql = $this->connection->prepare('
            INSERT INTO pets (`name`, `type`, `user_id`)
            VALUES (?, ?, ?)
        ');

        $sql->execute([
            $pet->name,
            $pet->petType,
            $pet->userId
        ]);
    }

    public function deletePet($pet_id): void
    {
        $sql = $this->connection->prepare('DELETE FROM pets WHERE id = :pet_id');
        $sql->execute([
            ':pet_id' => $pet_id
        ]);
    }

    // Pets
    public function getPets($user_id): array
    {
        $pets = [];
        $sql = $this->connection->prepare('SELECT * FROM pets WHERE user_id = :usr_id');
        $sql->execute([
            ':usr_id' => $user_id
        ]);

        while ($row = $sql->fetch(PDO::FETCH_ASSOC)) {
            $pet = new Pet($row['id'], $row['name'], $row['type'], $row['user_id']);
            $pets[] = $pet;
        }

        return $pets;
    }




    public function getUsers(): array
    {
        $users = [];

        $query = $this->connection->query('SELECT * FROM user');

        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            $user = new UserList($row['id'], $row['first_name'], $row['last_name'], $row['email'], $row['admin']);
            $users[] = $user;
        }

        return $users;
    }
}
