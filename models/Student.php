
<?php

require_once 'BaseModel.php';

class Student extends BaseModel
{
    public $idcard;
    public $username;
    public $position;
    public $status;
    private $email;
    private $password;
    private $mobilenumber;

    protected function getTableName()
    {
        return "students";
    }

    protected function addNewRec()
    {
        // Hash the password before storing it
        $this->password = password_hash($this->password, PASSWORD_DEFAULT);
       
        $param = array(
            ':idcard' => $this->idcard,
            ':username' => $this->username,
            ':email' => $this->email,
            ':mobilenumber' => $this->mobilenumber,
            ':password' => $this->password,   
            ':position' => $this->position,        
            ':status' => $this->status,

        );

        return $this->pm->run(
            "INSERT INTO " . $this->getTableName() . "(idcard, username, email, mobilenumber, password, position, status) 
            VALUES (:idcard, :username, :email, :mobilenumber, :password, :position, :status)",
            $param
        );
    }  
    

    protected function updateRec()
    {
        // Check if the new username or email already exists (excluding the current user's record)
        $existingStudent = $this->getStudentByUsernameOrEmailWithId($this->username, $this->email, $this->id);
        if ($existingStudent) {
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
            ':email' => $this->email,
            ':mobilenumber' => $this->mobilenumber,
            ':password' => $this->password, 
            ':position' => $this->position, 
            ':status' => $this->status,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET 
                idcard = :idcard,
                username = :username,
                email = :email, 
                password = :password,
                position = :position,
                mobilenumber = :mobilenumber,
                status = :status
            WHERE id = :id",
            $param
        );
        
    }

    public function getStudentByUsernameOrEmailWithId($username, $email, $excludeStudentId = null)
    {
        $param = array(':username' => $username, ':email' => $email);

        $query = "SELECT * FROM " . $this->getTableName() . " 
                  WHERE (username = :username OR email = :email)";

        if ($excludeStudentId !== null) {
            $query .= " AND id != :excludeStudentId";
            $param[':excludeStudentId'] = $excludeStudentId;
        }

        $result = $this->pm->run($query, $param);

        return $result; // Return the user if found, or false if not found
    }

    function createStudent( $idcard, $username, $email, $mobilenumber, $password, $position, $status = 1)
    {
        $studentModel = new Student();

        // Check if username or email already exists
        $existingStudent = $studentModel->getStudentByidcardOrUsernameWithEmail($idcard,$username, $email);
        if ($existingStudent) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $student = new Student();
        $student->idcard = $idcard;
        $student->username = $username;
        $student->email = $email;
        $student->mobilenumber = $mobilenumber;
        $student->password = $password; 
        $student->position = $position; 
        $student->status = $status;
        $student->addNewRec();

        if ($student) {
            return true; // student created successfully
        } else {
            return false; // student creation failed (likely due to database error)
        }
    }



    function updateStudent($id, $idcard, $username, $email, $mobilenumber, $password, $position, $status = 1)
    {
        $studentModel = new Student();

        // Check if username or email already exists
        $existingStudent = $studentModel->getStudentByUsernameOrEmailWithId($username, $email, $id);
        if ($existingStudent) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $student = new Student();
        $student->id = $id;
        $student->idcard = $idcard;
        $student->username = $username;
        $student->email = $email;
        $student->mobilenumber = $mobilenumber;
        $student->password = $password;
        $student->position = $position;      
        $student->status = $status;
        $student->updateRec();

        if ($student) {
            return true; // Student updated successfully
        } else {
            return false; // Student update failed (likely due to database error)
        }
    }

    public function getStudentByidcardOrUsernameWithEmail($idcard,$username, $email)
    {
        $param = array(
            ':idcard' => $idcard,
            ':username' => $username,
            ':email' => $email
        );

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE idcard = :idcard OR username = :username OR email = :email";
        $result = $this->pm->run($sql, $param);

        if (!empty($result)) {  // Check if the array is not empty
            $student = $result[0]; // Assuming the first row contains the user data
            return $student;
        } else {
            return null;
        }
    }

    function deleteStudent($id)
    {
        $student = new Student();
        $student->deleteRec($id);

        if ($student) {
            return true; // student udapted successfully
        } else {
            return false; // student update failed (likely due to database error)
        }
    }
    public function getLastInsertedUserId()
    {
        $result = $this->pm->run('SELECT MAX(id) as lastInsertedId FROM students', null, true);
        return $result['lastInsertedId'] ?? 100;
    }
}


