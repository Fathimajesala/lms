<?php

require_once 'BaseModel.php';

class Book extends BaseModel
{
    public $BookName;
    public $BookId;
    public $AuthorName;
    public $ISBNNumber;
    public $bookImage;
    public $AuthorImage;
    public $ReturnStatus;


    protected function getTableName()
    {
        return "books";
    }

    protected function addNewRec()
    {
        $param = array(
            ':BookName' => $this->BookName,
            ':AuthorName' => $this->AuthorName,
            ':BookId' => $this->BookId,
            ':ISBNNumber' => $this->ISBNNumber,
            ':bookImage' => $this->bookImage,
            ':AuthorImage' => $this->AuthorImage,
            ':ReturnStatus' => $this->ReturnStatus

        );
        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(BookName, AuthorName, BookId, ISBNNumber, bookImage, AuthorImage,ReturnStatus) values(:BookName,:AuthorName,:BookId,:ISBNNumber,:bookImage,:AuthorImage,:ReturnStatus)", $param);
    }
    

    protected function updateRec()
    {
        // Check if the new username or email already exists (excluding the current user's record)
        $existingBook = $this->getBookByBookNameOrBookIdWithId($this->BookName, $this->BookId, $this->id);
        if ($existingBook) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }
    
        $param = array(
            ':BookName' => $this->BookName,
            ':BookId' => $this->BookId,
            ':AuthorName' => $this->AuthorName,
            ':ISBNNumber' => $this->ISBNNumber,
            ':ReturnStatus' => $this->ReturnStatus,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET 
            BookName = :BookName, 
            BookId = :BookId,
            AuthorName = :AuthorName,   
            ISBNNumber = :ISBNNumber,
            ReturnStatus = :ReturnStatus
            WHERE id = :id",
            $param
        );
    }
    

    public function getBookByBookNameOrBookIdWithId($BookName, $BookId, $excludeBookId = null)
    {
        $param = array(':BookName' => $BookName, ':BookId' => $BookId);

        $query = "SELECT * FROM " . $this->getTableName() . " 
                  WHERE (BookName = :BookName OR BookId = :BookId)";

        if ($excludeBookId !== null) {
            $query .= " AND id != :excludeBookId";
            $param[':excludeBookId'] = $excludeBookId;
        }

        $result = $this->pm->run($query, $param);

        return $result;
    }

    function createBook($BookName, $BookId, $AuthorName, $ISBNNumber, $bookImage, $AuthorImage, $ReturnStatus = 1)
    {

        $bookModel = new Book();

        $existingBook = $this->getBookByBookNameOrBookId($BookName, $BookId);
        if ($existingBook) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }      
        $book = new Book();
        $book->BookName= $BookName;
        $book->AuthorName = $AuthorName;
        $book->BookId = $BookId;
        $book->ISBNNumber = $ISBNNumber;
        $book->bookImage = $bookImage;
        $book->AuthorImage = $AuthorImage;
        $book->ReturnStatus = $ReturnStatus;
        $book->addNewRec();

        if ($book) {
            return $book; // Book created successfully
        } else {
            return false; // Book creation failed (likely due to database error)
        }
    }
    

    function updateBook($id, $BookName, $BookId, $AuthorName, $ISBNNumber, $ReturnStatus = 1)
    {
        $existingBook = $this->getBookByBookNameOrBookIdWithId($BookName, $BookId, $id);
        if ($existingBook) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $book = new Book();
        $book->id = $id;
        $book->BookName = $BookName;
        $book->AuthorName = $AuthorName;
        $book->BookId = $BookId;
        $book->ISBNNumber = $ISBNNumber;
        $book->ReturnStatus = $ReturnStatus;
        $book->updateRec();

        if ($book) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }


    public function getBookByBookNameOrBookId($BookName, $BookId)
    {
        $param = array(
            ':BookName' => $BookName,
            ':BookId' => $BookId
        );

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE BookName = :BookName OR BookId = :BookId";
        $result = $this->pm->run($sql, $param);

        if (!empty($result)) {  
            $book = $result[0]; 
            return $book;
        } else {
            return null;
        }
    }

   
    function deleteBook($id)
    {
        $book = new Book();
        $book->deleteRec($id);

        if ($book) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }
}


