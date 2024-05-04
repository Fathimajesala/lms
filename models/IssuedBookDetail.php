<?php

require_once 'BaseModel.php';

class IssuedBookDetail extends BaseModel
{
    public $BookId;
    public $bookImage;
    public $idcard;
    public $IssuesDate;
    public $ReturnDate;
    public $fine;
    public $ReturnStatus;

    protected function getTableName()
    {
        return "issuedbook";
    }

    protected function addNewRec()
    {
        $param = array(
            ':bookImage' => $this->bookImage,
            ':idcard' => $this->idcard,
            ':IssuesDate' => $this->IssuesDate,
            
            ':ReturnStatus' => $this->ReturnStatus
        );
        return $this->pm->run(
            "INSERT INTO 
            issuedbook(bookImage, idcard,IssuesDate, ReturnStatus) 
            values(:bookImage, :idcard, :IssuesDate, :ReturnStatus)",
            $param
        );
    }

    protected function updateRec()
    {
        
    
        $param = array(
            ':idcard' => $this->idcard,
            ':IssuesDate' => $this->IssuesDate,
            ':ReturnDate' => $this->ReturnDate,
            ':fine' => $this->fine,
            ':ReturnStatus' => $this->ReturnStatus,
            ':id' => $this->id
        );
        return $this->pm->run(
            "UPDATE " . $this->getTableName() . " 
            SET 
            idcard = :idcard,   
            IssuesDate = :IssuesDate,
            ReturnDate = :ReturnDate,
            fine = :fine,
            ReturnStatus = :ReturnStatus
            WHERE id = :id",
            $param
        );
    }
    
    function createIssuedBook($bookImage, $idcard, $IssuesDate, $ReturnStatus = 0)
    {

        $issuedbookDetailModel = new IssuedBookDetail();

        $issuedbookDetail = new IssuedBookDetail();
        $issuedbookDetail->bookImage = $bookImage;
        $issuedbookDetail->idcard = $idcard;
        $issuedbookDetail->IssuesDate = $IssuesDate;    
        $issuedbookDetail->ReturnStatus = $ReturnStatus;
        $issuedbookDetail->addNewRec();

        if ($issuedbookDetail) {
            return $issuedbookDetail; // Issuedbook created successfully
        } else {
            return false; // Issuedbook creation failed (likely due to database error)
        }
    }
    

    function updateIssuedBook($id, $idcard, $IssuesDate, $ReturnDate, $fine = 1, $ReturnStatus = 1)
    {
        $issuedbookDetailModel = new IssuedBookDetail();

        $issuedbookDetail = new IssuedBookDetail();
        $issuedbookDetail->id = $id;
        $issuedbookDetail->idcard = $idcard;
        $issuedbookDetail->IssuesDate = $IssuesDate;
        $issuedbookDetail->ReturnDate = $ReturnDate;
        $issuedbookDetail->fine = $fine;
        $issuedbookDetail->ReturnStatus = $ReturnStatus;
        $issuedbookDetail->updateRec();

        if ($issuedbookDetail) {
            return true; // Issuedbook udapted successfully
        } else {
            return false; // Issuedbook update failed (likely due to database error)
        }
    }

    

   
    function deleteIssuedBookDetail($id)
    {
        $issuedbookDetail = new IssuedBookDetail();
        $issuedbookDetail->deleteRec($id);

        if ($issuedbookDetail) {
            return true; // Issuedbook udapted successfully
        } else {
            return false; // Issuedbook update failed (likely due to database error)
        }
    }
}

