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

    {{-- <style>
        .container {
            padding: 0.5%;
        }
    </style> --}}
</head>

<body>
    <div class="container">
        <div>
            <h2 style="margin-top: 12px;" class="alert alert-success">Laravel ajax crude model</h2>

        </div><br><br>
        <div class="row">
            <div class="col-12">

                    <a href="" class="btn btn-info btn-rounded mb-4 " id="add-record" data-toggle="modal" data-target="#modalLoginForm">
                     Add Record</a>


                <table class="table table-bordered" id="laravel_crud">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>email</th>
                            <th>password</th>
                            <th colspan="2">Action</th>
                        </tr>
                    </thead>
                    <tbody id="posts-crud">
                        @foreach ($posts as $key=>$post )
                            <tr id="post_id_{{ $post->id }}">
                                <td>{{ ++$key }}</td>
                                <td>{{ $post->name }}</td>
                                <td>{{ $post->email }}</td>
                                <td>{{ $post->password }}</td>
                                <td><a href="" id="edit-post"
                                        class="btn btn-warning edit-post" data-toggle="modal" data-id="{{ $post->id }}"
                                        data-target="#modalLoginForm">Edit</a>
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
            <div class="col-md-12">
                {!! $posts->links() !!}
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header text-center">
          <h4 class="modal-title w-100 font-weight-bold" id="change-text">ADD RECORD</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="modal-body mx-2">
            <form id="form">
            <div class="md-form mb-5">
                <label data-error="wrong" data-success="right" for="defaultForm-name">Name</label></label>
                <input type="text" id="name" name="name" class="form-control validate">
                <input type="hidden" name="id" id="id">

              </div>
          <div class="md-form mb-5">
            <label data-error="wrong" data-success="right" for="defaultForm-email">Email</label>
            <input type="text" id="email" name="email" class="form-control validate">
          </div>

          <div class="md-form mb-4">
         <label data-error="wrong" data-success="right" for="defaultForm-pass">Password</label>
         <input type="password" id="password" name="password" class="form-control validate">
        </div>
    </form>
        </div>

        <div class="modal-footer d-flex justify-content-center">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" id="btn-save" class="btn btn-primary">Send message</button>

        </div>
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

        $('#add-record').click(function(){
            $('#btn-save').val('create-post');
            $('#form').trigger('reset');
            $('#change-text').html('Create Record');

        });



        //edit

        $('.edit-post').click(function(){
            var post_id=$(this).data('id');
            $('#form').trigger('reset');
            $.ajax({
                data:$('#form').serialize(),
                url:'product-edit/'+post_id,
                type:"GET",
                dataType:'json',
                success:function(data){
                    $('#change-text').html('Edit Record');
                    $('#btn-save').val('edit-post');
                    $('#id').val(data.id);
                    $('#name').val(data.name);
                    $('#email').val(data.email);
                    $('#password').val(data.password);

                }
            });
        });
//store
$('#btn-save').click(function(){
        $('#btn-save').html('sending...');
        var store= $('#btn-save').val();
        console.log(store);
        if(store== 'create-post')
            $.ajax({
                data:$('#form').serialize(),
                url:"./product-store",
                type:"POST",
                dataType:'json',
                success:function(data){

                        $('#form').trigger("reset");
                        $('#modalLoginForm').modal('hide')
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
                    data: $('#form').serialize(),
                    url: "./product-update",
                    type: "POST",
                    dataType: 'json',
                    success: function(data) {

                        $('#form').trigger("reset");
                        $('#modalLoginForm').modal('hide')

                        location.reload();

                    },
                    error: function(data) {
                        console.log('Error:', data);
                        $('#btn-save').html('Save Changes');
                    }
                });
            }
    });

    //delete

$('.delete-post').click(function(){
    var delete_id = $(this).data("id");
    if(confirm("Are you sure want to delete the record !"))
    {
        $.ajax({
            type:"DELETE",
            url:"product-delete/"+ delete_id,
            success:function(data)
            {
                $('#post_id_'+ delete_id).remove();
                location.reload();
            },
            error: function(data) {
                    console.log('Error:', data);
                }
        });
    }
});




    });


</script>
