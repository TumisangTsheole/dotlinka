<?php

class UserController {
    private PDO $_dbConnection;

    public function __construct(PDO $dbConnection){
        $this->_dbConnection = $dbConnection;
    }

    //GET
    public function getUser($id) : array{
        $statement = $this->_dbConnection->prepare(
            "SELECT id FROM users
            WHERE users.id = ?;"
        );
        $statement->execute([$id]);
        $result = $statement->fetch(PD0::FETCH_ASSOC);
        return $result;
    }

    public function addUser(User $user){
        //add a password hashing alogrithm

        // save uploads to file storage


        $statement = $this->_dbConnection->prepare(
            "INSERT INTO users 
            (
            	id,
            	firstName,
            	middleNames,
            	lastName,
            	email,
            	cellNumber,
            	hashedPassword,
            	dateOfBirth,
            	physicalAddress,
            	idCardImages,
            	userImages,
            	walletBalance
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);"
        );
        $statement->execute($user->getAllProperties());

    }

    
}
