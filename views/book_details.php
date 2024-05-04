<?php
require_once('../layouts/header.php');
require_once __DIR__ . '/../../models/BookDetail.php'; 


$bookModel = new Book(); 
$books = $bookModel->getAll(); 


?>

<div class="container">

<h2 class="mx-3 my-5">
    
      If the books are not returned within 5 days, the borrowed books will be penalized with a fine of $1 
    <img src="<?= asset('assets/img/avatars/01.png') ?>" width="65" height="65" alt="library image" class="img-fluid custom-border">
      <?php if ($position == 'librarian') : ?>

         <!-- Button trigger modal -->
         <button type="button" class="btn rounded-pill btn-secondary float-end m-3" data-bs-toggle="modal" data-bs-target="#createBookModal">
            Add Book
        </button>
        <?php endif; ?>


        </h2>
   

    <section class="content m-3">
       
        <div class="container-fluid">
        <div class="row my-3">
        <div class="col">
        <input type="text" id="BookName" class="form-control" placeholder="Search books">
        </div>
         <div class="col-auto">
        <button id="searchBtn" class="btn btn-dark"><i class="bx bx-search fs-4 lh-0"></i>
        </button>
        </div>
       </div>
            <div class="card">
                <!-- /.card-header -->
                <div class="card-body p-0 table-responsive">
                    <table class="table table-striped mb-4">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th class="">Book</th>
                                <th class="">bookImage</th>
                                <th class="">AuthorName</th>
                                <th class="">AuthorImage</th>
                                <?php if ($position == 'librarian') : ?>
                                <th class="">BookId</th>
                                <th class="">ISBNNo</th>     
                                <th class="">ReturnStatus</th>
                                <?php endif; ?> 

                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($books as $book) : ?>
                                <tr>
                                    <td><?= $book['id'] ?></td>
                                    <td><?= $book['BookName'] ?></td>
                                    <td class="text-center">
                                        <img src="<?= asset($book['bookImage']) ?>" alt="book-image" class="rounded" width="70">
                                    </td>
                                    <td><?= $book['AuthorName'] ?></td>
                                    <td class="text-center">
                                        <img src="<?= asset($book['AuthorImage']) ?>" alt="author-image" class="rounded" width="70">
                                    </td>
                                    <?php if ($position == 'librarian') : ?>

                                    <td><?= $book['BookId'] ?></td>
                                    <td><?= $book['ISBNNumber'] ?></td>

                                    <?php endif; ?>
                                    <?php if ($position == 'librarian' || $position == 'student') : ?>
                                    <td>
                                        <div class="">
                                            <?php if ($book['ReturnStatus'] == 1) { ?>
                                                <span class="badge rounded-pill bg-success">available</span>
                                            <?php } else { ?>
                                                <span class="badge rounded-pill bg-danger">issued</span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <?php endif; ?>

                                    <?php if ($position == 'librarian') : ?>

                                    <td>
                                        <div>
                                            <button class="btn rounded-pill btn-sm btn-info m-2 edit-book" data-id="<?= $book['id']; ?>">Edit</button>
                                            <button class="btn rounded-pill btn-sm btn-danger m-2 delete-book" data-id="<?= $book['id']; ?>">Delete</button>

                                        </div>
                                    </td>
                                    <?php endif; ?>
 
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="createBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-book-form" action="<?= url('services/ajax_functions.php') ?>"enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="create_book">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Create Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="BookName" class="form-label">BookName</label>
                            <input type="text" id="BookName" name="BookName" class="form-control" placeholder="Enter BookName" required />
                        </div>
                     </div>
                     <div class="col mb-2">
                            <label for="BookId" class="form-label">BookId</label>
                            <input type="text" id="BookId" name="BookId" class="form-control" placeholder="Enter BookId" required />
                        </div>
                        <div class="col mb-2">
                            <label for="ISBNNumber" class="form-label">ISBNNumber</label>
                            <input type="text" id="ISBNNumber" name="ISBNNumber" class="form-control" placeholder="Enter ISBNNumber" required />
                        </div>
                        <div class="col mb-2">
                            <label for="AuthorName" class="form-label">AuthorName</label>
                            <input type="text" id="AuthorName" name="AuthorName" class="form-control" placeholder="Enter AuthorName" required />
                        </div>
                        <div class="col mb-2">
                            <label for="bookImage" class="form-label">Book Image</label>
                            <input type="file" id="bookImage" name="bookImage" class="form-control" accept="image/*" required />
                        </div>
                        <div class="col mb-2">
                            <label for="AuhorImage" class="form-label">AuthorImage</label>
                            <input type="file" id="AuthorImage" name="AuthorImage" class="form-control" accept="image/*" required />
                        </div>
                        <div id="additional-fields"></div>
                    <div class="mb-3 mt-3">
                        <div id="alert-container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn rounded-pill btn-primary" data-bs-dismiss="modal">Close</button>

                    <button type="button" id="create-now" class="btn rounded-pill btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Update Book Modal -->
<div class="modal fade " id="editBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="update-book-form" action="<?= url('services/ajax_functions.php') ?>" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_book">
                <input type="hidden" name="id" id="book_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="BookName" class="form-label">BookName</label>
                            <input type="text" id="BookName" name="BookName" class="form-control" placeholder="Enter BookName" required />
                        </div>
                     </div>
                     <div class="col mb-2">
                            <label for="BookId" class="form-label">BookId</label>
                            <input type="text" id="BookId" name="BookId" class="form-control" placeholder="Enter BookId" required />
                        </div>
                        <div class="col mb-2">
                            <label for="ISBNNumber" class="form-label">ISBNNumber</label>
                            <input type="text" id="ISBNNumber" name="ISBNNumber" class="form-control" placeholder="Enter ISBNNumber" required />
                        </div>
                        <div class="col mb-2">
                            <label for="AuthorName" class="form-label">AuthorName</label>
                            <input type="text" id="AuthorName" name="AuthorName" class="form-control" placeholder="Enter AuthorName" required />
                        </div>
                        <div class="col mb-2">
                            <label for="bookImage" class="form-label">Book Image</label>
                            <input type="file" id="EditbookImage" name="bookImage" class="form-control" accept="image/*" required />
                        </div>
                        <div class="col mb-2">
                            <label for="AuhorImage" class="form-label">AuthorImage</label>
                            <input type="file" id="EditAuthorImage" name="AuthorImage" class="form-control" accept="image/*" required />
                        </div>

                        <div class="row mt-3">
                        <div class="col mb-0">
                            <label class="form-label" for="ReturnStatus">Status</label>
                            <div class="input-group">
                                <select class="form-select" id="ReturnStatus" name="ReturnStatus" required>
                                    <option selected="" value="">Choose...</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div id="additional-fields"></div>
                    <div class="mb-3 mt-3">
                        <div id="alert-container"></div>
                    </div>
                </div>
                <div class="modal-footer">
                <button type="button" class="btn rounded-pill btn-primary" data-bs-dismiss="modal">Close</button>

                    <button type="button" id="update-now" class="btn rounded-pill btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
require_once('../layouts/footer.php');
?>

<script>

$(document).ready(function() {
        $("#BookName").on("input", function() {
            var searchTerm = $(this).val().toLowerCase();

            // Loop through each row in the table body
            $("tbody tr").filter(function() {
                // Toggle the visibility based on the search term
                $(this).toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
            });
        });
    $(document).ready(function() {

        // Handle modal button click
        $('#create-now').on('click', function() {
            // Get the form element
            var form = $('#create-book-form')[0];
            $('#create-book-form')[0].reportValidity();

            // Check form validity
            if (form.checkValidity()) {
                // Prepare form data
                var formData = new FormData($('#create-book-form')[0]);

                // Perform AJAX request
                $.ajax({
                    url: $('#create-book-form').attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showAlert(response.message, response.success ? 'primary' : 'danger');
                        if (response.success) {
                            $('#createBookModal').modal('hide');
                            setTimeout(function() {
                                location.reload();
                            }, 1000);
                        }
                    },
                    error: function(error) {
                        // Handle the error
                        console.error('Error submitting the form:', error);
                    },
                    complete: function(response) {
                        // This will be executed regardless of success or error
                        console.log('Request complete:', response);
                    }
                });
            } else {
                var message = 'Form is not valid. Please check your inputs.';
                showAlert(message, 'danger');
            }
        });

        $('.edit-book').on('click', async function() {
            var book_id = $(this).data('id');
            await getBookById(book_id);
        });

        $('.delete-book').on('click', async function() {
            var book_id = $(this).data('id');
            var is_confirm = confirm('Are you sure,Do you want to delete?');
            if (is_confirm) await deleteById(book_id);
        });

        $('#update-now').on('click', function() {
    // Get the form element
    var form = $('#update-book-form')[0];
    $('#update-book-form')[0].reportValidity();

    // Check form validity
    if (form.checkValidity()) {
        // Prepare form data
        var formData = new FormData($('#update-book-form')[0]);

        // Perform AJAX request
        $.ajax({
            url: $('#update-book-form').attr('action'),
            type: 'POST',
            data: formData, // Form data
            dataType: 'json',
            contentType: false,
            processData: false,
            success: function(response) {
                showAlert(response.message, response.success ? 'primary' : 'danger', 'alert-container-update-form');
                if (response.success) {
                    $('#editBookModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function(response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    } else {
        var message = 'Form is not valid. Please check your inputs.';
        showAlert(message, 'danger');
    }
});

});

    async function getBookById(id) {
        var formAction = $('#update-book-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                book_id: id,
                action: 'get_book'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                showAlert(response.message, response.success ? 'primary' : 'danger');
                if (response.success) {
                    var book_id = response.data.id;
                    var BookName = response.data.BookName;
                    var AuthorName = response.data.AuthorName;
                    var BookId = response.data.BookId;
                    var ISBNNumber = response.data.ISBNNumber;
                    var EditbookImage = response.data.EditbookImage;
                    var EditAuthorImage = response.data.EditAuthorImage;
                    var isIssued = response.data.isIssued;




                    $('#editBookModal #book_id').val(book_id);
                    $('#editBookModal #BookName').val(BookName);
                    $('#editBookModal #AuthorName').val(AuthorName);
                    $('#editBookModal #BookId').val(BookId);
                    $('#editBookModal #ISBNNumber').val(ISBNNumber);
                    $('#editBookModal #EditbookImage').val(EditbookImage);
                    $('#editBookModal #EditAuthorImage').val(EditAuthorImage);
                    $('#editBookModal #isIssued option[value="' + isIssued + '"]').prop('selected', true);
            
                    $('#editBookModal').modal('show');
                }
            },
            error: function(error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function(response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    }

    async function deleteById(id) {
        var formAction = $('#update-book-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                book_id: id,
                action: 'delete_book'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    setTimeout(function() {
                        location.reload();
                    }, 1000);
                }
            },
            error: function(error) {
                // Handle the error
                console.error('Error submitting the form:', error);
            },
            complete: function(response) {
                // This will be executed regardless of success or error
                console.log('Request complete:', response);
            }
        });
    }
  
});


</script>

