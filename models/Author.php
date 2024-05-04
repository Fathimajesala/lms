<?php

require_once 'BaseModel.php';

class Author extends BaseModel
{
    public $AuthorName;
    public $AuthorImage;

   

    protected function getTableName()
    {
        return "authors";
    }

    

    protected function addNewRec()
    {
       

        $param = array(
            ':AuthorName' => $this->AuthorName,
            ':AuthorImage' => $this->AuthorImage
           
        );

        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(AuthorName,AuthorImage) values(:AuthorName, :AuthorImage)", $param);
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
            ':username' => $this->username,
            ':password' => $this->password,
            ':permission' => $this->permission,
            ':email' => $this->email,
            ':is_active' => $this->is_active,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET 
                username = :username, 
                password = :password,
                permission = :permission,  
                email = :email,
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

    function createUser($username, $password, $permission, $email, $is_active = 1)
    {
        $userModel = new User();

        // Check if username or email already exists
        $existingUser = $userModel->getUserByUsernameOrEmail($username, $email);
        if ($existingUser) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $user = new User();
        $user->username = $username;
        $user->password = $password;
        $user->permission = $permission;
        $user->email = $email;
        $user->is_active = $is_active;
        $user->addNewRec();

        if ($user) {
            return true; // User created successfully
        } else {
            return false; // User creation failed (likely due to database error)
        }
    }



    function updateUser($id, $username, $password, $permission, $email, $is_active = 1)
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
        $user->username = $username;
        $user->password = $password;
        $user->permission = $permission;
        $user->email = $email;
        $user->is_active = $is_active;
        $user->updateRec();

        if ($user) {
            return true; // User udapted successfully
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
}
