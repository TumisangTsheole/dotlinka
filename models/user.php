<?php

class User {
    private $idNumber;
    private $firstName;
    private $lastName;
    private $hashedPassword;
    private $dateOfBirth; // see if you can get that from the id number
    private $address;
    private $dateRegistered;
    //add avatar
    // Add data validation
    // Make a routing folder

    public function __construct(
        $idNumber,
        $firstName,
        $lastName
    ){
        $this->idNumber = $idNumber;
        $this->$firstName = $firstName;
        $this->$lastName = $lastName;
        //implement validation logic
    }
}