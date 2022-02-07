<?php

class UserList
{
    public int $id;
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $admin;

    public function __construct($id, $firstName, $lastName, $email, $admin)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->admin = $admin;
    }



}