<?php
require_once 'BaseModel.php';

class Book extends BaseModel
{
    public $BookName;
    public $CatId;
    public $AuthorId;
    public $ISBNNumber;
    public $bookImage;
    public $BookPrice;
    public $isIssued;

    protected function getTableName()
    {
        return "books";
    }

    protected function addNewRec()
    {
        $param = array(
            ':BookName' => $this->BookName,
            ':CatId' => $this->CatId,
            ':AuthorId' => $this->AuthorId,
            ':ISBNNumber' => $this->ISBNNumber,
            ':BookPrice' => $this->BookPrice,
            ':bookImage' => $this->bookImage,
            ':isIssued' => $this->isIssued



        );

        return $this->pm->run("INSERT INTO books(BookName, CatId, AuthorId, ISBNNumber, BookPrice, bookImage, isIssued) VALUES (:BookName, :CatId, :AuthorId, :ISBNNumber, :BookPrice, :bookImage, :isIssued)", $param);
    }

    protected function updateRec()
    {
        $param = array(
            ':BookName' => $this->BookName,
            ':CatId' => $this->CatId,
            ':AuthorId' => $this->AuthorId,
            ':ISBNNumber' => $this->ISBNNumber,
            ':BookPrice' => $this->BookPrice,
            ':bookImage' => $this->bookImage,
            ':isIssued' => $this->isIssued

        );

        return $this->pm->run("UPDATE doctors SET name = :name, about = :about, photo = :photo, is_active = :is_active, user_id = :user_id WHERE id = :id", $param);
    }


    function createDoctor($name, $about, $user_id, $photo = null, $is_active = 1)
    {
        $doctorModel = new Doctor();
        $doctorModel->name = $name;
        $doctorModel->about = $about;
        $doctorModel->user_id = $user_id;
        $doctorModel->is_active = $is_active;
        $doctorModel->photo = $photo;
        $doctorModel->addNewRec();

        if ($doctorModel) {
            return true; // Doctor created successfully
        } else {
            return false; // Doctor creation failed (likely due to database error)
        }
    }
}
