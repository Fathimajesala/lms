<?php
require_once('../layouts/header.php');
require_once __DIR__ . '/../../models/Author.php';

$authorModel = new Author();
$authors = $authorModel->getAll();
?>

<div class="container">
    <h1 class="mx-3 my-5">Authors</h1>
    <section class="content m-3">
        <div class="container-fluid">
            <div class="row">
                <?php foreach ($authors as $author) : ?>
                    <div class="col-md-6 col-lg-4">
                        <div class="card my-3">
                            <div class="card-header"></div>
                            <div class="card-body">
                                <div class="col-md-7 mx-auto text-center">
                                    <img src="<?= asset($author['AuthorImage']) ?>" alt="author-image" class="d-block rounded m-3 author-image" width="100" data-author-id="<?= $author['id'] ?>">
                                    <h5 class="card-title"><?= $author['AuthorName'] ?></h5>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</div>

<div id="bookDetailsModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="bookDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="bookDetailsModalLabel">Book Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="bookDetailsContent">
                <!-- Book details will be loaded dynamically here -->
            </div>
        </div>
    </div>
</div>

<?php require_once('../layouts/footer.php'); ?>

<script>
    $(document).ready(function() {
        $('.author-image').on('click', function() {
            var authorId = $(this).data('author-id');
            loadBookDetails(authorId);
        });

        function loadBookDetails(authorId) {
            $.ajax({
                url: 'load_book_details.php', // Replace with the actual URL to load book details
                type: 'GET',
                data: { author_id: authorId },
                success: function(response) {
                    $('#bookDetailsContent').html(response);
                    $('#bookDetailsModal').modal('show');
                },
                error: function(error) {
                    console.log('Error loading book details: ' + error.responseText);
                }
            });
        }
    });
</script>
