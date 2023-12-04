<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Laravel Ajax CRUD Application</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

    <style>
        .container {
            padding: 0.5%;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 style="margin-top: 12px;" class="alert alert-success">Laravel Ajax CRUD Application
        </h2><br>
        <div class="row">
            <div class="col-12">
                <a href="" class="btn btn-primary" id="create-new-post" data-toggle="modal"
                    data-target="#exampleModal">Add post</a>

                <table class="table table-bordered" id="laravel_crud">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Body</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="posts-crud">
                        @foreach ($posts as $key => $post)
                            <tr id="post_id_{{ $post->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->city }}</td>
                                <td><a href="" id="edit-post" data-id="{{ $post->id }}"
                                        class="btn btn-info edit-post" data-toggle="modal"
                                        data-target="#exampleModal">Edit</a>
                                </td>
                                <td>
                                    <a href="javascript:void(0)" id="delete-post" data-id="{{ $post->id }}"
                                        class="btn btn-danger delete-post">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>


    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">New message</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="postForm">
                        <div class="form-group">
                            <label for="recipient-name" class="col-form-label">Name:</label>
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
                        <div class="form-group">
                            <label for="message-text" class="col-form-label">City:</label>
                            <input type="text" name="city" class="form-control" id="city">
                           <input type="hidden" name="post_id" id="post_id">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" id="btn-save" class="btn btn-primary">Send message</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
<script>
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        //create
        $('#create-new-post').click(function() {
            $('#btn-save').val("create-post");
            $('#postForm').trigger("reset");
            $('#exampleModalLabel').html("Add New post");
            $('#ajax-crud-modal').modal('show');
        });

        //edit

        $('.edit-post').click(function() {
            var post_id = $(this).data('id');
            $('#postForm').trigger("reset");
            $.ajax({
                data: $('#postForm').serialize(),
                url: 'edit/' + post_id,
                type: "GET",
                dataType: 'json',
                success: function(data) {
                    $('#exampleModalLabel').html("Edit post");
                    $('#btn-save').val("edit-post");
                    $('#post_id').val(data.id);
                    $('#name').val(data.name);
                    $('#city').val(data.city);


                }
            });
        });

        //delete
        // $('body').on('click','.delete-post', function()
            $('.delete-post').click(function() {
            var post_id = $(this).data("id");
           if( confirm("Are You sure want to delete !"))
           {

            $.ajax({
                type: "DELETE",
                url: 'delete/' + post_id,
                success: function(data) {
                    $("#post_id_" + post_id).remove();
                    location.reload();
                },
                error: function(data) {
                    console.log('Error:', data);
                }
            });
           }
        });





        $('#btn-save').click(function() {
            $('#btn-save').html('Sending..');
            var btnVal = $('#btn-save').val();

            if (btnVal == 'create-post')
                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ route('store') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        console.log("dd");
                        $('#postForm').trigger("reset");
                        $('#exampleModal').modal('hide')
                        $('#btn-save').html('Save Changes');
                        location.reload();


                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            else {
                $.ajax({
                    data: $('#postForm').serialize(),
                    url: "{{ route('update') }}",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {
                        $('#postForm').trigger("reset");
                        $('#exampleModal').modal('hide')

                        location.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            }

        });




    });
</script>
