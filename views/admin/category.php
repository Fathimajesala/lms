<?php
require_once('../layouts/header.php');
require_once __DIR__ . '/../../models/Category.php';

$categoryModel = new Category();
$category = $categoryModel->getAll();

$numRows = count($category);
?>


<div class="container">
    <h2 class="mx-3 my-5">
    These categories of books are available in our library <img src="<?= asset('assets/img/avatars/09.png') ?>" width="60" height="60" alt="library image" class="img-fluid custom-border">
        <?php if ($position == 'librarian') : ?>
     <!-- Button trigger modal -->
     <button type="button" class="btn rounded-pill btn-secondary float-end m-3" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            Add Category
        </button>
        <?php endif; ?>
        
    </h2>


    
    <section class="content m-3">
    
        <div class="container-fluid">
        <h3>Available Categories: <?= $numRows ?></h3>

        <div class="row my-3">
        <div class="col">
        <input type="text" id="CategoryName" class="form-control" placeholder="Search category" >
        </div>
         <div class="col-auto">
        <button id="searchBtn" class="btn btn-dark"><i class="bx bx-search fs-4 lh-0"></i>
        </button>
        </div>
       </div>
            <div class="row">
                <?php foreach ($category as $c) : ?>
                    <div class="col-md-3 col-lg-3">
                        <div class="card my-3">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="col-md-10 mx-auto text-center">
                                <img src="<?= asset($c['CategoryImage']) ?>" alt="book-image" class="d-block rounded m-3" width="120">
                                    <h5 class="card-title"><?= $c['CategoryName'] ?></h5>
                                    <?php if ($position == 'librarian' || $position == 'student') : ?>
                                    <div class="">
                                            <?php if ($c['Status'] == 1) { ?>
                                                <span class="badge bg-success">Enable</span>
                                            <?php } else { ?>
                                                <span class="badge bg-danger">Disable</span>
                                            <?php } ?>
                                        </div>
                                        <?php endif; ?>

                                        <?php if ($position == 'librarian') : ?>
                                        <div>
                                            <button class="btn rounded-pill btn-outline-info m-2 edit-category" data-id="<?= $c['id']; ?>">Edit</button>
                                            <button class="btn rounded-pill btn-outline-danger m-2 delete-category" data-id="<?= $c['id']; ?>">Delete</button>
                                        </div>
                                        <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>


<!-- Modal -->
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="create-category-form" action="<?= url('services/ajax_functions.php') ?>"enctype="multipart/form-data"> 
                <input type="hidden" name="action" value="create_category">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Create Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="CategoryName" class="form-label">CategoryName</label>
                            <input type="text" id="CategoryName" name="CategoryName" class="form-control" placeholder="Enter CategoryName" required />
                        </div>
                     </div>
                     
                        <div class="col mb-2">
                            <label for="CategoryImage" class="form-label">CategoryImage</label>
                            <input type="file" id="CategoryImage" name="CategoryImage" class="form-control" accept="image/*" required />
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
<div class="modal fade " id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="update-category-form" action="<?= url('services/ajax_functions.php') ?>" autocomplete="off" enctype="multipart/form-data">
                <input type="hidden" name="action" value="update_category">
                <input type="hidden" name="id" id="category_id">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel1">Edit Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col mb-3">
                            <label for="CategoryName" class="form-label">CategoryName</label>
                            <input type="text" id="CategoryName" name="CategoryName" class="form-control" placeholder="Enter CategoryName" required />
                        </div>
                     </div>
                        <div class="col mb-2">
                            <label for="CategoryImage" class="form-label">CategoryImage</label>
                            <input type="file" id="EditCategoryImage" name="CategoryImage" class="form-control" accept="image/*" required />
                        </div>

                        <div class="row mt-3">
                        <div class="col mb-0">
                            <label class="form-label" for="Status">Status</label>
                            <div class="input-group">
                                <select class="form-select" id="Status" name="Status" required>
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
    $("#CategoryName").on("input", function() {
        var searchTerm = $(this).val().toLowerCase();

        // Loop through each card body
        $(".card-body").filter(function() {
            // Toggle the visibility based on the search term
            $(this).parent().parent().toggle($(this).text().toLowerCase().indexOf(searchTerm) > -1);
        });
    });
});

    $(document).ready(function() {

        // Handle modal button click
        $('#create-now').on('click', function() {
            // Get the form element
            var form = $('#create-category-form')[0];
            $('#create-category-form')[0].reportValidity();

            // Check form validity
            if (form.checkValidity()) {
                // Prepare form data
                var formData = new FormData($('#create-category-form')[0]);

                // Perform AJAX request
                $.ajax({
                    url: $('#create-category-form').attr('action'),
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        showAlert(response.message, response.success ? 'primary' : 'danger');
                        if (response.success) {
                            $('#createCategoryModal').modal('hide');
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

        $('.edit-category').on('click', async function() {
            var category_id = $(this).data('id');
            await getCategoryById(category_id);
        });

        $('.delete-category').on('click', async function() {
            var category_id = $(this).data('id');
            var is_confirm = confirm('Are you sure,Do you want to delete?');
            if (is_confirm) await deleteById(category_id);
        });

        $('#update-now').on('click', function() {

// Get the form element
var form = $('#update-category-form')[0];
$('#update-category-form')[0].reportValidity();

// Check form validity
if (form.checkValidity()) {
    // Serialize the form data
    var formAction = $('#update-category-form').attr('action');
    var formData = new FormData($('#update-category-form')[0]);

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
                $('#editCategoryModal').modal('hide');
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

    async function getCategoryById(id) {
        var formAction = $('#update-category-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                category_id: id,
                action: 'get_category'
            }, // Form data
            dataType: 'json',
            success: function(response) {
                showAlert(response.message, response.success ? 'primary' : 'danger');
                if (response.success) {
                    var category_id = response.data.id;
                    var CategoryName = response.data.CategoryName;
                    var CategoryImage = response.data.CategoryImage;
                    var Status = response.data.Status;

                    $('#editCategoryModal #category_id').val(category_id);
                    $('#editCategoryModal #CategoryName').val(CategoryName);
                    $('#editCategoryModal #CategoryImage').val(CategoryImage);
                    $('#editCategoryModal #Status option[value="' + Status + '"]').prop('selected', true);
                    $('#editCategoryModal').modal('show');
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
        var formAction = $('#update-category-form').attr('action');

        // Perform AJAX request
        $.ajax({
            url: formAction,
            type: 'GET',
            data: {
                category_id: id,
                action: 'delete_category'
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

</script>

