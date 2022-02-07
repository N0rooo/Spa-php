<?php

class User
{

    public string $email;
    public string $password;
    public string $firstName;
    public string $lastName;

    public function __construct($email, $password, $firstName, $lastName)
    {

        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
    }
}

