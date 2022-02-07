<?php

class AddPet
{

    public string $name;
    public string $petType;
    public int $userId;

    public function __construct($name, $pet_type, $user_id)
    {

        $this->name = $name;
        $this->petType = $pet_type;
        $this->userId = $user_id;
        }
}