<?php

class User {
    private int $idNumber;
    private string $firstName;
    private string $lastName;
    private string $hashedPassword;
    private DateTime $dateOfBirth; // see if you can get that from the id number
    private string $address;
    private DateTime $dateRegistered;
    //add avatar
    // Add data validation
    // Make a routing folder

    public function __construct(
        int $idNumber,
        string $firstName,
        string $lastName
    ){
        $this->idNumber = $idNumber;
        $this->$firstName = $firstName;
        $this->$lastName = $lastName;
        //implement validation logic
    }
}
