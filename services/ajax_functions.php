<?php
require_once '../config.php';
require_once '../helpers/AppManager.php';
require_once '../models/IssuedBookDetail.php';
require_once '../models/User.php';
require_once '../models/Student.php';
require_once '../models/BookDetail.php';
require_once '../models/Category.php';


//create user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_user') {

    try {
        $idcard = $_POST['idcard'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobilenumber = $_POST['mobilenumber'];
        $password = $_POST['password'];
        $position = $_POST['position'];

        $userModel = new User();
        $created =  $userModel->createUser($idcard, $username, $password, $position, $email, $mobilenumber);

        if ($created) {
  
            echo json_encode(['success' => true, 'message' => "User created successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create user. May be user already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//Get user by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['user_id']) && isset($_GET['action']) &&  $_GET['action'] == 'get_user') {

    try {
        $user_id = $_GET['user_id'];
        $userModel = new User();
        $user = $userModel->getById($user_id);
        if ($user) {
            echo json_encode(['success' => true, 'message' => "User created successfully!", 'data' => $user]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create user. May be user already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//Delete by user id
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['user_id']) && isset($_GET['action']) &&  $_GET['action'] == 'delete_user') {

    try {
        $user_id = $_GET['user_id'];
        $userModel = new User();
        $deleted = $userModel->deleteUser($user_id);

        if ($deleted) {
            echo json_encode(['success' => true, 'message' => "User deleted successfully!", 'data' => $deleted]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete user.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//update user
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_user') {
    try {
        $idcard = $_POST['idcard'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobilenumber = $_POST['mobilenumber'];
        $password = $_POST['password'];
        $position = $_POST['position'];
        $is_active = $_POST['is_active'] == 1 ? 1 : 0;
        $id = $_POST['id'];

        // Validate inputs
        if (empty($username) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Required fields are missing!']);
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email address']);
            exit;
        }

        $userModel = new User();
        $updated =  $userModel->updateUser($id,$idcard, $username, $password, $permission, $email, $mobilenumber, $is_active);
        if ($updated) {
            echo json_encode(['success' => true, 'message' => "User updated successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update user. May be user already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}


//create student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_student') {

    try {
        $idcard = $_POST['idcard'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobilenumber = $_POST['mobilenumber'];
        $password = $_POST['password'];
        $position = $_POST['position'];

        $studentModel = new Student();
        $created =  $studentModel->createStudent($idcard, $username, $email, $mobilenumber,$password, $position);

        if ($created) {

            echo json_encode(['success' => true, 'message' => "User created successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create Student. The username, ID card, or email may already exist! Please choose a different one ']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//Get student by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['student_id']) && isset($_GET['action']) &&  $_GET['action'] == 'get_student') {

    try {
        $student_id = $_GET['student_id'];
        $studentModel = new Student();
        $student = $studentModel->getById($student_id);
        if ($student) {
            echo json_encode(['success' => true, 'message' => "Student created successfully!", 'data' => $student]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create student. May be student already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}


//Delete by student id
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['student_id']) && isset($_GET['action']) &&  $_GET['action'] == 'delete_student') {

    try {
        $student_id = $_GET['student_id'];
        $studentModel = new Student();
        $deleted = $studentModel->deleteStudent($student_id);

        if ($deleted) {
            echo json_encode(['success' => true, 'message' => "Student deleted successfully!", 'data' => $deleted]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete student.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//update student
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_student') {
    try {

        $idcard = $_POST['idcard'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $mobilenumber = $_POST['mobilenumber'];
        $password = $_POST['password'];
        $position = $_POST['position'];
        $status = $_POST['status'] == 1 ? 1 : 0;
        $id = $_POST['id'];

        // Validate inputs
        if (empty($username) || empty($email)) {
            echo json_encode(['success' => false, 'message' => 'Required fields are missing!']);
            exit;
        }

        // Validate email format
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Invalid email address']);
            exit;
        }

        $studentModel = new Student();
        $updated =  $studentModel->updateStudent($id, $idcard, $username, $email, $mobilenumber,  $password, $position, $status);
        if ($updated) {
            echo json_encode(['success' => true, 'message' => "Student updated successfully!"]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update student. May be user already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//create book
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_book') {
        try {
            // Extract form data
            $BookName = $_POST['BookName'];
            $BookId = $_POST['BookId'];
            $AuthorName = $_POST['AuthorName'];
            $ISBNNumber = $_POST['ISBNNumber'];
            
            // Handle file uploads
            $bookImage = $_FILES['bookImage']['name'];
            $bookImageTemp = $_FILES['bookImage']['tmp_name'];
            $AuthorImage = $_FILES['AuthorImage']['name'];
            $AuthorImageTemp = $_FILES['AuthorImage']['tmp_name'];
            
            // Move uploaded files to desired directory
            move_uploaded_file($bookImageTemp, 'uploads/' . $bookImage);
            move_uploaded_file($AuthorImageTemp, 'uploads/' . $AuthorImage);
            
            // Create a new Book model instance
            $bookModel = new Book();
    
            // Call the createBook method to add a new book to the database
            $created = $bookModel->createBook($BookName, $BookId, $AuthorName, $ISBNNumber, $bookImage, $AuthorImage);
    
            // Check if the book was successfully created
            if ($created) {
                echo json_encode(['success' => true, 'message' => 'Book created successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Failed to create book. May be book already exist!']);
            }
        } catch (PDOException $e) {
            // Handle database connection errors
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
        exit;
    }

// Get book by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id']) && isset($_GET['action']) && $_GET['action'] == 'get_book') {
    try {
        $book_id = $_GET['book_id'];
        $bookModel = new Book();
        $book = $bookModel->getById($book_id);
        if ($book) {
            echo json_encode(['success' => true, 'message' => "Book retrieved successfully!", 'data' => $book]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to retrieve book.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}



// Delete by book id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['book_id']) && isset($_GET['action']) && $_GET['action'] == 'delete_book') {
    try {
        $book_id = $_GET['book_id'];
        $bookModel = new Book();
        $deleted = $bookModel->deleteBook($book_id);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => "Book deleted successfully!", 'data' => $deleted]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete book.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

// Update book
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_book') {
    try {
        // Extract form data
        $BookName = $_POST['BookName'];
        $BookId = $_POST['BookId'];
        $AuthorName = $_POST['AuthorName'];
        $ISBNNumber = $_POST['ISBNNumber'];
        $ReturnStatus = $_POST['ReturnStatus'] == 1 ? 1 : 0;
        $id = $_POST['id'];

       
        // Create a new Book model instance
        $bookModel = new Book();

        // Call the updateBook method to update the book in the database
        $updated = $bookModel->updateBook($id, $BookName, $BookId, $AuthorName, $ISBNNumber, $ReturnStatus);

        // Check if the book was successfully updated
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Book updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update book.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}





//create category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_category') {
    try {
        // Extract form data
        $CategoryName = $_POST['CategoryName'];
        
        // Handle file uploads
        $CategoryImage = $_FILES['CategoryImage']['name'];
        $CategoryImageTemp = $_FILES['CategoryImage']['tmp_name'];
        
        // Move uploaded files to desired directory
        move_uploaded_file($CategoryImageTemp, 'uploads/' . $CategoryImage);
        
        // Create a new Book model instance
        $categoryModel = new Category();

        // Call the createBook method to add a new book to the database
        $created = $categoryModel->createCategory($CategoryName, $CategoryImage);

        // Check if the book was successfully created
        if ($created) {
            echo json_encode(['success' => true, 'message' => 'category created successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to create category. May be category already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

// Get category by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id']) && isset($_GET['action']) && $_GET['action'] == 'get_category') {
try {
    $category_id = $_GET['category_id'];
    $categoryModel = new Category();
    $category = $categoryModel->getById($category_id);
    if ($category) {
        echo json_encode(['success' => true, 'message' => "category created successfully!", 'data' => $category]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create category.']);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
exit;
}

// Delete by book id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['category_id']) && isset($_GET['action']) && $_GET['action'] == 'delete_category') {
try {
    $category_id = $_GET['category_id'];
    $categoryModel = new Category();
    $deleted = $categoryModel->deleteCategory($category_id);
    if ($deleted) {
        echo json_encode(['success' => true, 'message' => "Category deleted successfully!", 'data' => $deleted]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete Category.']);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
exit;
}

// Update Category
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_category') {
try {
    // Extract form data
    $CategoryName = $_POST['CategoryName'];
    $Status = $_POST['Status'] == 1 ? 1 : 0;
    $id = $_POST['id'];

    
    // Handle file uploads
    $CategoryImage = $_FILES['CategoryImage']['name'];
    $CategoryImageTemp = $_FILES['CategoryImage']['tmp_name'];
    
    
    // Move uploaded files to desired directory
    move_uploaded_file($CategoryImageTemp, 'uploads/' . $CategoryImage);
    
    // Create a new Book model instance
    $categoryModel = new Category();

    // Call the createBook method to add a new book to the database
    $updated = $categoryModel->updateCategory($id, $CategoryName, $CategoryImage, $Status);

    // Check if the book was successfully created
    if ($updated) {
        echo json_encode(['success' => true, 'message' => 'category updated successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update category.']);
    }
} catch (PDOException $e) {
    // Handle database connection errors
    echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
}
exit;
}

//book issued
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'create_issuedbook') {
    try {
        // Extract form data
        $idcard = $_POST['idcard'];
        $IssuesDate = $_POST['IssuesDate'];
    
        // Handle file uploads
        $bookImage = $_FILES['bookImage']['name'];
        $bookImageTemp = $_FILES['bookImage']['tmp_name'];
       
        
        // Move uploaded files to desired directory
        move_uploaded_file($bookImageTemp, 'uploads/' . $bookImage);
        
        // Create a new Book model instance
        $issuedbookDetailModel  = new IssuedBookDetail();

        // Call the createBook method to add a new book to the database
        $created = $issuedbookDetailModel ->createIssuedBook($bookImage, $idcard, $IssuesDate);

        // Check if the book was successfully created
        if ($created) {
            echo json_encode(['success' => true, 'message' => 'Book issued successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to book issue. May be book already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

// Get issuedbook by id
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['issuedbook_id']) && isset($_GET['action']) && $_GET['action'] == 'get_issuedbook') {
    try {
        $issuedbook_id = $_GET['issuedbook_id'];
        $issuedbookDetailModel = new IssuedBookDetail();
        $issuedbook = $issuedbookDetailModel->getById($issuedbook_id);
        if ($issuedbook) {
            echo json_encode(['success' => true, 'message' => "Book issued successfully!", 'data' => $issuedbook]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to book issue. May be book already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
    }
    
    // Delete by issuedbook id
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['issuedbook_id']) && isset($_GET['action']) && $_GET['action'] == 'delete_issuedbook') {
    try {
        $issuedbook_id = $_GET['issuedbook_id'];
        $issuedbookDetailModel = new IssuedBookDetail();
        $deleted = $issuedbookDetailModel->deleteIssuedBookDetail($issuedbook_id);
        if ($deleted) {
            echo json_encode(['success' => true, 'message' => "Book issued successfully!", 'data' => $deleted]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete issuedbook.']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}

//update issuedbook
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_issuedbook') {
    try {
        // Extract form data
        $id = $_POST['id'];
        $idcard = $_POST['idcard'];
        $IssuesDate = $_POST['IssuesDate'];
        $ReturnDate = $_POST['ReturnDate'];
        $fine = $_POST['fine'] ;
        $ReturnStatus = $_POST['ReturnStatus'] == 1 ? 1 : 0;

        
        // Create a new Book model instance
        $issuedbookDetailModel  = new IssuedBookDetail();

        // Call the createBook method to add a new book to the database
        $updated = $issuedbookDetailModel ->updateIssuedBook($id, $idcard, $IssuesDate, $ReturnDate, $fine, $ReturnStatus);

        // Check if the book was successfully created
        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'issuedBook updated successfully!']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update book. May be book already exist!']);
        }
    } catch (PDOException $e) {
        // Handle database connection errors
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
    exit;
}
?>
