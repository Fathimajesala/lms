<?php

require_once 'BaseModel.php';

class User extends BaseModel
{
    public $idcard;
    public $username;
    public $position;
    public $is_active;
    private $email;
    public $mobilenumber;
    private $password;

    protected function getTableName()
    {
        return "user";
    }

    

    protected function addNewRec()
    {
        // Hash the password before storing it
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);

        $param = array(
            ':idcard' => $this->idcard,
            ':username' => $this->username,
            ':password' => $this->password,
            ':position' => $this->position,
            ':email' => $this->email,
            ':mobilenumber' => $this->mobilenumber,
            ':is_active' => $this->is_active
        );

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(idcard, username, password,position,email,mobilenumber,is_active) values(:idcard, :username, :password,:position,:email, :mobilenumber,:is_active)", $param);
    }
    

    protected function updateRec()
    {
        // Check if the new username or email already exists (excluding the current user's record)
        $existingUser = $this->getUserByUsernameOrEmailWithId($this->username, $this->email, $this->id);
        if ($existingUser) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        // Hash the password if it is being updated
        if (!empty($this->password)) {
            $this->password = password_hash($this->password, PASSWORD_DEFAULT);
        }

        $param = array(
            ':idcard' => $this->idcard,
            ':username' => $this->username,
            ':password' => $this->password,
            ':position' => $this->position,
            ':email' => $this->email,
            ':mobilenumber' => $this->mobilenumber,
            ':is_active' => $this->is_active,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET 
                idcard = :idcard, 
                username = :username, 
                password = :password,
                position = :position,  
                email = :email,
                mobilenumber = :mobilenumber, 
                is_active = :is_active
            WHERE id = :id",
            $param
        );
    }

    public function getUserByUsernameOrEmailWithId($username, $email, $excludeUserId = null)
    {
        $param = array(':username' => $username, ':email' => $email);

        $query = "SELECT * FROM " . $this->getTableName() . " 
                  WHERE (username = :username OR email = :email)";

        if ($excludeUserId !== null) {
            $query .= " AND id != :excludeUserId";
            $param[':excludeUserId'] = $excludeUserId;
        }

        $result = $this->pm->run($query, $param);

        return $result; // Return the user if found, or false if not found
    }

    function createUser($idcard, $username, $password, $position, $email, $mobilenumber, $is_active = 1)
    {
        $userModel = new User();

        // Check if username or email already exists
        $existingUser = $userModel->getUserByUsernameOrEmail($username, $email);
        if ($existingUser) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $user = new User();
        $user->idcard = $idcard;
        $user->username = $username;
        $user->password = $password;
        $user->position = $position;
        $user->email = $email;
        $user->mobilenumber = $mobilenumber;
        $user->is_active = $is_active;
        $user->addNewRec();

        if ($user) {
            return true; // User created successfully
        } else {
            return false; // User creation failed (likely due to database error)
        }
    }



    function updateUser($id, $idcard, $username, $password, $position, $email, $mobilenumber, $is_active = 1)
    {
        $userModel = new User();

        // Check if username or email already exists
        $existingUser = $userModel->getUserByUsernameOrEmailWithId($username, $email, $id);
        if ($existingUser) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $user = new User();
        $user->id = $id;
        $user->idcard = $idcard;
        $user->username = $username;
        $user->password = $password;
        $user->position = $position;
        $user->email = $email;
        $user->mobilenumber = $mobilenumber;
        $user->is_active = $is_active;
        $user->updateRec();

        if ($user) {
            return true; // User updated successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }

    public function getUserByUsernameOrEmail($username, $email)
    {
        $param = array(
            ':username' => $username,
            ':email' => $email
        );

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE username = :username OR email = :email";
        $result = $this->pm->run($sql, $param);

        if (!empty($result)) {  // Check if the array is not empty
            $user = $result[0]; // Assuming the first row contains the user data
            return $user;
        } else {
            return null;
        }
    }

    function deleteUser($id)
    {
        $user = new User();
        $user->deleteRec($id);

        if ($user) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }
    public function getLastInsertedUserId()
    {
        $result = $this->pm->run('SELECT MAX(id) as lastInsertedId FROM users', null, true);
        return $result['lastInsertedId'] ?? 100;
    }
}

