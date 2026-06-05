<?php

class User {
    private int $idNumber;
    private string $firstName;
    private string $middleNames;
    private string $lastName;
    private string $email;
    private string $cellNumber;
    private string $hashedPassword;
    private string $dateOfBirth; // see if you can get that from the id number
    private string $physicalAddress;
    private string $dateRegistered;
    private string $idCardImagesJson; // Convert to JSON list
    private string $userImagesJson; // Convert to JSON list
    private float $walletBalance;

    //add avatar
    // Add data validation
    // Make a routing folder

    public function __construct(
        int $idNumber,
        string $firstName,
        string $middleNames,
        string $lastName,
        string $email,
        string $cellNumber,
        string $password,
        string $dateOfBirth,
        string $physicalAddress,
        string $idCardImagesJson,
        string $userimagesJson,
        float $walletBalance
    ){
        $this->idNumber = $idNumber;
        $this->firstName = $firstName;
        $this->middleNames = $middleNames;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->cellNumber = $cellNumber;
        $this->hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $this->dateOfBirth = $dateOfBirth;
        $this->idCardImagesJson = json_encode([$idCardImagesJson]);
        $this->userImagesJson = json_encode([$userimagesJson]);
        $this->physicalAddress = $physicalAddress;
        $this->walletBalance = $walletBalance;
        
        //set default properties
        // $this->setDateTime();
        
        
        //implement validation logic


    }

    public function getAllProperties() : array {
        $props = [
            $this->idNumber,
            $this->firstName,
            $this->middleNames,
            $this->lastName,
            $this->email,
            $this->cellNumber,
            $this->hashedPassword,
            $this->dateOfBirth,
            $this->physicalAddress,
            $this->idCardImagesJson,
            $this->userImagesJson,
            $this->walletBalance 
        ];
        return $props;
    }
}
