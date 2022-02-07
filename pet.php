<?php

class Pet
{
    public int $id;
    public string $name;
    public string $petType;
    public int $userId;

    public function __construct($id, $name, $pet_type, $user_id)
    {
        $this->id =$id;
        $this->name = $name;
        $this->petType = $pet_type;
        $this->userId = $user_id;
    }

}