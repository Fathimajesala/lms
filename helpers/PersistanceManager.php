<?php

/**
 * Project Name: Library 
 * Author: Fathima Jesala
 */

class PersistanceManager
{
    private $pdo;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

            // Create a tables if it doesn't exist
            $this->createTables();
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }

    public function createTables()
    {
        $query_user = "CREATE TABLE IF NOT EXISTS `user` (
            `id` INT AUTO_INCREMENT PRIMARY KEY,
            `idcard` varchar(50) NOT NULL, 
            `username` varchar(200) NOT NULL,
            `email` varchar(200) NOT NULL,
            `password` varchar(240) NOT NULL,
            `mobilenumber` char(12) NOT NULL,
            `permission` enum('user','librarian','student') NOT NULL DEFAULT 'user',
            `is_active` tinyint(5) NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
          ) ENGINE=INNODB DEFAULT CHARSET=latin1;";

        $this->pdo->exec($query_user);

    

    

    $query_students = "CREATE TABLE IF NOT EXISTS `students` (
        `id` int(11) NOT NULL,
        `idcard` varchar(100) DEFAULT NULL,
        `username` varchar(120) DEFAULT NULL,
        `email` varchar(120) DEFAULT NULL,
        `mobilenumber` char(11) DEFAULT NULL,
        `password` varchar(120) DEFAULT NULL,
        `status` int(1) DEFAULT NULL,
        `RegDate` timestamp NULL DEFAULT current_timestamp(),
        `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

       $this->pdo->exec($query_students);


       $query_books = "CREATE TABLE IF NOT EXISTS `books` (
        `id` int(11) NOT NULL,
        `BookName` varchar(255) DEFAULT NULL,
        `AuthorName` int(11) DEFAULT NULL,
        `CatId` int(11) DEFAULT NULL,
        `ISBNNumber` varchar(25) DEFAULT NULL,
        `bookImage` varchar(250) NOT NULL,
        `AuthorImage` varchar(250) NOT NULL,
        `isIssued` int(1) DEFAULT NULL,
        `RegDate` timestamp NULL DEFAULT current_timestamp(),
        `UpdationDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
      ) ENGINE=InnoDB DEFAULT CHARSET=latin1;";

      $this->pdo->exec($query_books);


    }

      

    public function getCount($query, $param = null)
    {
        $result = $this->executeQuery($query, $param, true);
        return $result['c'];
    }

    public function run($query, $param = null, $fetchFirstRecOnly = false)
    {
        return $this->executeQuery($query, $param, $fetchFirstRecOnly);
    }

    public function insertAndGetLastRowId($query, $param = null)
    {
        return $this->executeQuery($query, $param, true, true);
    }

    private function executeQuery($query, $param = null, $fetchFirstRecOnly = false, $getLastInsertedId = false)
    {
        try {
            $stmt = $this->pdo->prepare($query);
            $stmt->execute($param);

            if ($getLastInsertedId) {
                return $this->pdo->lastInsertId();
            }

            if ($fetchFirstRecOnly)
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
            else
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $stmt->closeCursor();
            return $result;
        } catch (PDOException $e) {
            echo $e->getMessage();
            return -1;
        }
    }
}
