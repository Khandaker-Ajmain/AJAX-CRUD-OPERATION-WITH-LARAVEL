{{-- importing layout --}}
@extends('layout.app')

{{-- Set page title --}}
@section('title', 'Student CRUD')


{{-------------Page Content Start--------------}}
@section('content')

    <div class="content py-5">

        <div id="success_message"></div>

        <h2 class="text-center pb-3">Student Data</h2>
        <a href="#" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#AddStudentModal" style="margin: 10px">Add Student</a>
        <table class="table table-dark table-striped">
            <thead>
                <tr>
                    <th>SL No</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Course</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
            </tbody>
        </table>

        {{-------------Add Modal Start--------------}}
        
        <div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Add Student</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="save_errorList"></ul>

                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="name form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="email form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input type="text" class="phone form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Course</label>
                        <input type="text" class="course form-control" id="">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary add_student">Save</button>
                </div>
              </div>
            </div>
        </div>

        {{-------------Add Modal End--------------}}

        {{-------------Edit Modal Start--------------}}

        <div class="modal fade" id="editStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Student</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <ul id="update_errorList"></ul>

                    <input type="hidden" id="edit_student_id">

                    <div class="mb-3">
                        <label for="" class="form-label">Name</label>
                        <input type="text" class="edit_name form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Email</label>
                        <input type="text" class="edit_email form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Phone</label>
                        <input type="text" class="edit_phone form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Course</label>
                        <input type="text" class="edit_course form-control" id="">
                    </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary update_student">Update</button>
                </div>
              </div>
            </div>
        </div>

        {{-------------Edit Modal End--------------}}

        {{------------- Delete Modal Start--------------}}

        <div class="modal fade" id="deleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Delete Student</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <input type="hidden" id="delete_student_id">
                    <h4>Are you sure? You want to delete this data</h4>
                   
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                  <button type="button" class="btn btn-primary confirm_delete_student">Delete</button>
                </div>
              </div>
            </div>
        </div>

        {{------------- Delete Modal End--------------}}
        
    </div>

@endsection

{{-------------Page Content End--------------}}

{{-------------Script Start--------------}}
@section('scripts')

    <script>
        $(document).ready(function () {

            fetchStudent();

            function fetchStudent() {
                var counter = 1;                
                $.ajax({
                    type: 'GET',
                    url: '/fetch-students',
                    dataType: 'JSON',
                    success: function (response) {

                        $('tbody').html("");
                        $.each(response.students.reverse(), function (key, item){
                            $('tbody').append('<tr>\
                                    <td>'+counter++ +'</td>\
                                    <td>'+item.name+'</td>\
                                    <td>'+item.email+'</td>\
                                    <td>'+item.phone+'</td>\
                                    <td>'+item.course+'</td>\
                                    <td>\
                                        <button type="button" class="edit_student btn btn-success" value="'+item.id+'">Edit</button>\
                                        <button type="button" class="delete_student btn btn-danger" value="'+item.id+'">Delete</button>\
                                    </td>\
                                </tr>')
                        });
                    }

                }) 
            }

            $(document).on('click', '.edit_student', function (e) {
                e.preventDefault();
                var studentId = $(this).val();

                $('#editStudentModal').modal('show');

                $.ajax({
                    type: 'GET',
                    url: '/edit-student/'+studentId,
                    dataType: 'JSON',
                    success: function (response) {
                        if(response.status == 404) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                        }else {
                            $('#edit_student_id').val(response.student.id);
                            $('.edit_name').val(response.student.name);
                            $('.edit_email').val(response.student.email);
                            $('.edit_phone').val(response.student.phone);
                            $('.edit_course').val(response.student.course);
                        }
                    }
                })
            });

            $(document).on('click', '.update_student', function (e) {
                e.preventDefault;

                $(this).text('Updating..');

                var student_id = $('#edit_student_id').val();
                var data = {
                    'name': $('.edit_name').val(),
                    'email': $('.edit_email').val(),
                    'phone': $('.edit_phone').val(),
                    'course': $('.edit_course').val(),
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                
                $.ajax({
                    type: 'PUT',
                    url: '/update-student/'+student_id,
                    data: data,
                    dataType: 'JSON',
                    success: function (response) {
                        if(response.status == 400) {
                            $('#update_errorList').html("");
                            $('#update_errorList').addClass('alert alert-danger');

                            $.each(response.error, function(key, err_values) {
                                $('#update_errorList').append('<li>'+err_values+'</li>');
                            });
                            $('.update_student').text('Update');
                        }else if (response.status == 404) {
                            $('#success_message').html('');
                            $('#success_message').addClass('alert alert-danger');
                            $('#success_message').text(response.message);
                            $('.update_student').text('Update');
                        }else {
                            $('#update_errorList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStudentModal').modal('hide');
                            $('#AddStudentModal').find('input').val('');
                            $('#editStudentModal').modal('hide');
                            $('.update_student').text('Update');
                            fetchStudent();
                        }
                    }
                });
            });

            $(document).on('click', '.add_student', function (e) {
                e.preventDefault();
                $(this).text("Saving..");

                var data = {
                    'name': $('.name').val(),
                    'email': $('.email').val(),
                    'phone': $('.phone').val(),
                    'course': $('.course').val() 
                }

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: "POST",
                    url: "/students",
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        if(response.status == 400) {

                            $('#save_errorList').html("");
                            $('#save_errorList').addClass('alert alert-danger');

                            $.each(response.error, function(key, err_values) {
                                $('#save_errorList').append('<li>'+err_values+'</li>');
                            });
                            $('.add_student').text("Save");

                        }else {
                            $('#save_errorList').html("");
                            $('#success_message').addClass('alert alert-success');
                            $('#success_message').text(response.message);
                            $('#AddStudentModal').modal('hide');
                            $('.add_student').text("Save");
                            $('#AddStudentModal').find('input').val('');
                            fetchStudent();
                        }
                    },
                    error: function (response) {
                        console.log(response);
                    }
                })

            });

            $(document).on('click', '.delete_student', function (e) {
                var student_id = $(this).val();
                $('#delete_student_id').val(student_id);

                $('#deleteStudentModal').modal('show');
            });

            $(document).on('click', '.confirm_delete_student', function (e) {
                e.preventDefault;
                $(this).text("Deleting..");
                var student_id = $('#delete_student_id').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    type: 'DELETE',
                    url: '/student/'+student_id,
                    success: function (response) {
                        $('#success_message').addClass('alert alert-success');
                        $('#success_message').text(response.message);
                        $('#deleteStudentModal').modal('hide');
                        $('.confirm_delete_student').text("Delete");
                        fetchStudent();
                    } 
                });
            });
       });
    </script>

@endsection
{{-------------Script End--------------}}