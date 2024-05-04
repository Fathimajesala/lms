<?php
require_once('../layouts/header.php');
require_once __DIR__ . '/../../models/IssuedBookDetail.php';

$issuedbookDetailModel = new IssuedBookDetail();
$issuedbookDetails = $issuedbookDetailModel->getAll();


$numRows = count($issuedbookDetails);


?>

<div class="container">

    <h2 class="mx-3 my-5">

   
    If the books are not returned within 5 days, the borrowed books will be penalized with a fine of $1 
    <img src="<?= asset('assets/img/avatars/01.png') ?>" width="65" height="65" alt="library image" class="img-fluid custom-border">
         <!-- Button trigger modal -->
    
     <button type="button" class="btn rounded-pill btn-secondary float-end m-3" data-bs-toggle="modal" data-bs-target="#createIssuedBookModal">
     <img src="<?= asset('assets/img/avatars/06.png') ?>" width="40" height="40" alt="library image" class="img-fluid custom-border">
        </button>

    
    </h2>

    
    <section class="content m-3">
   
        <div class="container-fluid">
        <h3>Total number of borrowed books: <?= $numRows ?></h3>

        <div class="row my-3">
        <div class="col">
        <input type="text" id="searchInput" class="form-control" placeholder="Search Issued and Return Books">
        </div>
         <div class="col-auto">
        <button id="searchBtn" class="btn btn-dark">Search</button>
        </div>
       </div>
            <div class="card">
                
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th style="width: 10px">#</th>
                                <th class="">bookImage</th>
                                <th class="">Idcard</th>
                                <th class="">date borrowed</th>
                                <th class="">ReturnDate</th>
                                <th class="">fine</th>
                                <th class="">ReturnStatus</th>
                                <!-- <th style="width: 200px">Options</th> -->
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($issuedbookDetails as $c) {
                            ?>
                                <tr>
                                <td> <?= $c['id'] ?? ""; ?> </td>
                                <td class="text-center">
                                        <img src="<?= asset($c['bookImage']) ?>" alt="book-image" class="rounded" width="70">
                                    </td>
                                    <td> <?= $c['idcard'] ?? ""; ?> </td>
                                    <td> <?= $c['IssuesDate'] ?? ""; ?> </td>
                                    <td> <?= $c['ReturnDate'] ?? ""; ?> </td>
                                    <td> <?= $c['fine'] ?? ""; ?> </td>
                                    <td>
                                        <div class="">
                                            <?php if ($c['ReturnStatus'] == 1) { ?>
                                                <span class="badge bg-success"><i class='bx bx-check'></i></span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger"><i class='bx bx-x'></i></span>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                        <button class="btn rounded-pill btn-outline-info m-2 edit-issuedbook" data-id="<?= $c['id']; ?>">Edit</button>
                                            <button class="btn rounded-pill btn-outline-danger m-2 delete-issuedbook" data-id="<?= $c['id']; ?>">Delete</button>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </section>
</div>

<!-- Modal -->
<div class="modal fade" id="createIssuedBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-issuedbook-form" action="<?= url('services/ajax_functions.php') ?>"enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="create_issuedbook">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Issued Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                     <div class="col mb-2">
                            <label for="idcard" class="form-label">Idcard</label>
                            <input type="text" id="idcard" name="idcard" class="form-control" placeholder="Enter Idcard" required />
                        </div>
                        <div class="col mb-2">
                            <label for="IssuesDate" class="form-label">IssuesDate</label>
                            <input type="date" id="IssuesDate" name="IssuesDate" class="form-control" 
                            placeholder="Enter IssuesDate"  />
                        </div>
                        <div class="col mb-2">
                            <label for="bookImage" class="form-label">Book Image</label>
                            <input type="file" id="bookImage" name="bookImage" class="form-control" accept="image/*" required />
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
<div class="modal fade " id="editIssuedBookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="update-issuedbook-form" action="<?= url('services/ajax_functions.php') ?>" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_issuedbook">
                <input type="hidden" name="id" id="issuedbook_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Book</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    
                     <div class="col mb-2">
                            <label for="idcard" class="form-label">Idcard</label>
                            <input type="text" id="idcard" name="idcard" class="form-control" placeholder="Enter Idcard" required />
                        </div>
                        <div class="col mb-2">
                            <label for="IssuesDate" class="form-label">IssuesDate</label>
                            <input type="date" id="IssuesDate" name="IssuesDate" class="form-control" 
                            placeholder="Enter IssuesDate"  />
                        </div>
                        <div class="col mb-2">
                            <label for="ReturnDate" class="form-label">ReturnDate</label>
                            <input type="date" id="ReturnDate" name="ReturnDate" class="form-control" 
                           placeholder="Enter ReturnDate" required   />
                        </div>
                       
                        <div class="row mt-3">
                        <div class="col mb-0">
                            <label class="form-label" for="fine">Fine</label>
                            <div class="input-group">
                                <select class="form-select" id="fine" name="fine" required>
                                    <option selected="" value="">Choose...</option>
                                    <option value="Not required to be fine">Not required to be fine</option>
                                    <option value="late fine $1">late fine $1</option>
                                </select>
                            </div>
                        </div>
                    </div>
                        <div class="row mt-3">
                        <div class="col mb-0">
                            <label class="form-label" for="ReturnStatus">ReturnStatus</label>
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

<?php require_once('../layouts/footer.php'); ?>
<script>

$(document).ready(function() {
        $("#searchInput").on("input", function() {
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
            var form = $('#create-issuedbook-form')[0];
            $('#create-issuedbook-form')[0].reportValidity();

            // Check form validity
            if (form.checkValidity()) {
                // Prepare form data
                var formData = new FormData($('#create-issuedbook-form')[0]);

                // Perform AJAX request
                $.ajax({
                    url: $('#create-issuedbook-form').attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showAlert(response.message, response.success ? 'primary' : 'danger');
                        if (response.success) {
                            $('#createIssuedBookModal').modal('hide');
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

        $('.edit-issuedbook').on('click', async function() {
            var issuedbook_id = $(this).data('id');
            await getIssuedBookById(issuedbook_id);
        });

        $('.delete-issuedbook').on('click', async function() {
            var issuedbook_id = $(this).data('id');
            var is_confirm = confirm('Are you sure,Do you want to delete?');
            if (is_confirm) await deleteById(issuedbook_id);
        });

        $('#update-now').on('click', function() {

// Get the form element
var form = $('#update-issuedbook-form')[0];
$('#update-issuedbook-form')[0].reportValidity();

// Check form validity
if (form.checkValidity()) {
    // Serialize the form data
    var formAction = $('#update-issuedbook-form').attr('action');
    var formData = new FormData($('#update-issuedbook-form')[0]);

    // Perform AJAX request
    $.ajax({
        url: formAction,
        type: 'POST',
        data: formData, // Form data
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            showAlert(response.message, response.success ? 'primary' : 'danger', 'alert-container-update-form');
            if (response.success) {
                $('#editIssuedBookModal').modal('hide');
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
    var message = ('Form is not valid. Please check your inputs.');
    showAlert(message, 'danger');
}
});
});

    async function getIssuedBookById(id) {
        var formAction = $('#update-issuedbook-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                issuedbook_id: id,
                action: 'get_issuedbook'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                showAlert(response.message, response.success ? 'primary' : 'danger');
                if (response.success) {
                    var issuedbook_id = response.data.id;
                    var idcard = response.data.idcard;
                    var IssuesDate = response.data.IssuesDate;
                    var ReturnDate = response.data.ReturnDate;
                    var RetrunStatus = response.data.RetrunStatus;




                    $('#editIssuedBookModal #issuedbook_id').val(issuedbook_id);
                    $('#editIssuedBookModal #idcard').val(idcard);
                    $('#editIssuedBookModal #IssuesDate').val(IssuesDate);
                    $('#editIssuedBookModal #ReturnDate').val(ReturnDate);
                    $('#editIssuedBookModal #RetrunStatus option[value="' +RetrunStatus + '"]').prop('selected', true);      
                    $('#editIssuedBookModal').modal('show');
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
        var formAction = $('#update-issuedbook-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                issuedbook_id: id,
                action: 'delete_issuedbook'
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



