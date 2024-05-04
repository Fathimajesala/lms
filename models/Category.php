<?php

require_once 'BaseModel.php';

class Category extends BaseModel
{
    public $CategoryName;
    public $CategoryImage;
    public $Status;

    protected function getTableName()
    {
        return "category";
    }

    protected function addNewRec()
    {
        $param = array(
            ':CategoryName' => $this->CategoryName,
            ':CategoryImage' => $this->CategoryImage,
            ':Status' => $this->Status
        );
        return $this->pm->run("INSERT INTO " . $this->getTableName() . "(CategoryName, CategoryImage, Status) values(:CategoryName,:CategoryImage,:Status)", $param);
    }

    protected function updateRec()
    {
        // Check if the new username or email already exists (excluding the current user's record)
        $existingCategory = $this->getCategoryByCategoryNameWithId($this->CategoryName, $this->id);
        if ($existingCategory) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }
    
        $param = array(
            ':CategoryName' => $this->CategoryName,
            ':CategoryImage' => $this->CategoryImage,
            ':Status' => $this->Status,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET             
            CategoryName = :CategoryName, 
            CategoryImage = :CategoryImage,
            Status = :Status
            WHERE id = :id",
            $param
        );
    }

 
    public function getCategoryByCategoryNameWithId($CategoryName, $excludeCategoryId = null)
    {
        $param = array(':CategoryName' => $CategoryName);

        $query = "SELECT * FROM " . $this->getTableName() . " 
                  WHERE (CategoryName = :CategoryName)";

        if ($excludeCategoryId !== null) {
            $query .= " AND id != :excludeCategoryId";
            $param[':excludeCategoryId'] = $excludeCategoryId;
        }

        $result = $this->pm->run($query, $param);

        return $result;
    }
    

    public function createCategory($CategoryName, $CategoryImage, $Status = 1)
    {
        $categoryModel = new Category();

        $existingCategory = $this->getCategoryByCategoryName($CategoryName);
        if ($existingCategory) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }      
        $category = new Category();
        $category->CategoryName= $CategoryName;
        $category->CategoryImage= $CategoryImage;
        $category->Status = $Status;
        $category->addNewRec();

        if ($category) {
            return $category; // Book created successfully
        } else {
            return false; // Book creation failed (likely due to database error)
        }
    }
    

    function updateCategory($id, $CategoryName, $CategoryImage, $Status = 1)
    {
        $existingCategory = $this->getCategoryByCategoryNameWithId($CategoryName, $id);
        if ($existingCategory) {
            // Handle the error (return an appropriate message or throw an exception)
            return false; // Or throw an exception with a specific error message
        }

        $category = new Category();
        $category->id = $id;
        $category->CategoryName = $CategoryName;
        $category->CategoryImage = $CategoryImage;
        $category->Status = $Status;
        $category->updateRec();

        if ($category) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }

    public function getCategoryByCategoryName($CategoryName)
    {
        $param = array(
            ':CategoryName' => $CategoryName
        );

        $sql = "SELECT * FROM " . $this->getTableName() . " WHERE CategoryName = :CategoryName";
        $result = $this->pm->run($sql, $param);

        if (!empty($result)) {  
            $category = $result[0]; 
            return $category;
        } else {
            return null;
        }
    }

   
    function deleteCategory($id)
    {
        $category = new Category();
        $category->deleteRec($id);

        if ($category) {
            return true; // User udapted successfully
        } else {
            return false; // User update failed (likely due to database error)
        }
    }

}