@extends('layout.app')

@section('content')


{{-- AddStudentModal --}}
<div class="modal fade" id="AddStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

      	<ul id="saveForm_errList"></ul>

    	<div class="form-group mb-3">
    		<label>Name</label>
    		<input type="" name="name" class="name form-control">
    	</div>
    	<div class="form-group mb-3">
    		<label>Email</label>
    		<input type="" name="email" class="email form-control">
    	</div>
		<div class="form-group mb-3">
    		<label>Phone</label>
    		<input type="" name="phone" class="phone form-control">
    	</div>
		<div class="form-group mb-3">
    		<label>Course</label>
    		<input type="" name="course" class="course form-control">
    	</div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary add_student">Save</button>
      </div>
    </div>
  </div>
</div>
{{-- End - AddStudentModal --}}

{{-- EditStudentModal --}}

<div class="modal fade" id="EditStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit & Update Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">

      	<ul id="updateForm_errList"></ul>
<!-- JUST FOR CHECKING THE ID IS APPEAR OR NOR THEN, HIDE  -->
		<input type="hidden" id="edit_stud_id">

    	<div class="form-group mb-3">
    		<label>Name</label>
    		<input type="" name="name" id="edit_name" class="name form-control">
    	</div>
    	<div class="form-group mb-3">
    		<label>Email</label>
    		<input type="" name="email" id="edit_email" class="email form-control">
    	</div>
		<div class="form-group mb-3">
    		<label>Phone</label>
    		<input type="" name="phone" id="edit_phone" class="phone form-control">
    	</div>
		<div class="form-group mb-3">
    		<label>Course</label>
    		<input type="" name="course" id="edit_course"  class="course form-control">
    	</div>

      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-primary update_student">Update</button>
      </div>
    </div>
  </div>
</div>

{{-- End - EditStudentModal --}}

{{-- DeleteStudentModal --}}

<div class="modal fade" id="DeleteStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Student</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
		<!-- JUST FOR CHECKING THE ID IS APPEAR OR NOR THEN, HIDE  -->
		<input type="hidden" id="delete_stud_id">
		<h4>Are you sure ?</h4>
		<p class="text-danger">If you confirm the delete , It deleted all the details of student and you can't undo it.</p>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
        <button type="button" class="btn btn-danger delete_student-btn">Yes, Delete</button>
      </div>
    </div>
  </div>
</div>

{{-- End - DeleteStudentModal --}}


<div class="container mt-4">
	<div class="row">
		<div class="col-md-12">
			<!-- for showing success message -->
			<div id="success_message"></div>

			<div class="card">
				<div class="card-header">
					<h3>Student Details
						<a href="#" data-bs-toggle="modal" data-bs-target="#AddStudentModal" class="btn 			btn-primary float-end">
							Add Student
						</a>
					</h3>
				</div>
				<div class="card-body">


			<!-- SEARCHING STUDENT DATA FUNCTIONS -->
				<div class="container m-3">
					<div class="search">
						<input type="search" name="search" id="search" class="form-control" placeholder="Search the students">
					</div>
				</div>


					<table class="table table-bordered table-striped">
						<thead>
							<tr>
								<th>Sno.</th>
								<th>Name</th>
								<th>Email</th>
								<th>Phone</th>
								<th>Course</th>
								<th>Edit</th>
								<th>Delete</th>
							</tr>
						</thead>
						<!-- Showing all data which is stored in the DB -->
						<tbody id="allContent" class="allData"> </tbody>

						<!-- Showing all Searched data  -->
						<tbody id="searchContent" class="searchData"> </tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('scripts')

<script type="text/javascript">
	
	$(document).ready(function() {

	fetch_student();

    function fetch_student() {
        $.ajax({
            url: '/fetch-students',
            type: 'GET',
            dataType: 'json',
            success: function(response){
				$('#allContent').html("");
                $.each(response.Students, function(key, item) {
                    $('#allContent').append(
                        '<tr>\
                            <td>'+item.id+'</td>\
                            <td>'+item.name+'</td>\
                            <td>'+item.email+'</td>\
                            <td>'+item.phone+'</td>\
                            <td>'+item.course+'</td>\
                            <td><button type="button" value="'+item.id+'" class="edit_student btn btn-primary btn-sm">Edit</button></td>\
                            <td><button type="button" value="'+item.id+'" class="delete_student btn btn-danger btn-sm">Delete</butto></td>\
                        </tr>'
                    );
                });
            }
        });
    }
	

	// FOR DELETE PART
	// FOR POP-UP MODAL
	$(document).on('click', '.delete_student', function(event) {
		event.preventDefault();
		var stud_id = $(this).val();
		// alert(stud_id);

		$('#delete_stud_id').val(stud_id);
		$('#DeleteStudentModal').modal('show');
	});
	// MAIN DELETE FUNCTION
	$(document).on('click', '.delete_student-btn', function (event) {
		event.preventDefault();

	//To make when we click delete button, it show in button 'Deleting' until it's deleted done.
		$(this).text('Deleting');

		var stud_id = $('#delete_stud_id').val();

		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});

		$.ajax({
			type: "DELETE",
			url: "/Student-delete/"+stud_id,
			success: function (response) {
				// console.log(response);

				$("#success_message").addClass('alert alert-success');
				$('#success_message').text(response.message);
				$('#DeleteStudentModal').modal('hide');
				$('.delete_student-btn').text('Yes, Delete');
				fetch_student();
			}
		});
	});



	// FOR EDITING PART
	$(document).on('click', '.edit_student', function(event){
		event.preventDefault();

		var stud_id = $(this).val();
		// console.log(stud_id);
		$('#EditStudentModal').modal('show');

		$.ajax({
			type: "GET",
			url: "/edit-student/" + stud_id,
			dataType: 'json',
			success: function (response) {
				// console.log(response);
				if(response.status == 404){
					$('#success_message').html("");
					$('#success_message').addClass('alert alert-danger');
					$('#success_message').text(response.message);
				}else{
					$('#edit_name').val(response.student.name);
					$('#edit_email').val(response.student.email);
					$('#edit_phone').val(response.student.phone);
					$('#edit_course').val(response.student.course);
					$('#edit_stud_id').val(stud_id);

				}
			}
		});
		
	});

	// UPDATE PART
	$(document).on('click', '.update_student', function (event) {
		event.preventDefault();

		$(this).text("Updating");

		var stud_id = $('#edit_stud_id').val();
		var data = {
			'name' : $('#edit_name').val(),
			'email' : $('#edit_email').val(),
			'phone' : $('#edit_phone').val(),
			'course' : $('#edit_course').val(),
		}
		$.ajaxSetup({
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		});
		$.ajax({
			type: "PUT",
			url: "/student-update/" + stud_id,
			data: data,
			dataType: "json",
			success: function (response) {
				// console.log(response);
				if(response.status == 400){
					$("#updateForm_errList").html(""); // Clear previous error messages
						$("#updateForm_errList").addClass('alert alert-danger');
						$.each(response.errors, function(key, err_values) {
						  $('#updateForm_errList').append('<li>'+err_values+'</li>')
						});
					$('.update_student').text("Update");
				}
				else if(response.status == 404)
				{
					$("#updateForm_errList").html(""); 
					$("#success_message").addClass('alert alert-success');
					$("#success_message").text(response.message);	
					$('.update_student').text("Update");

				}
				else 
				{
					$("#updateForm_errList").html("");
		
					$("#success_message").html("");
					$("#success_message").addClass('alert alert-success');
					$("#success_message").text(response.message);
					
					$('#EditStudentModal').modal('hide');
					$('.update_student').text("Upadate");
					fetch_student();
				}
			}
		});
	});


	// DATA STORE PART
		// For preventing page reload/refresh while saving the data on DB.
		$(document).on('click', '.add_student', function(event) {
			event.preventDefault();

		//To make when we click save button, it show in button 'Saving' until it's Save done.
		$(this).text('Saving');

			/* Act on the event */
			// console.log('Hello jQuery ajax');

			// Taking all inputs in one variable
			var data = {
				'name' : $(".name").val(),
				'email' : $(".email").val(),
				'phone' : $(".phone").val(),
				'course' : $(".course").val(),
			}
			// To see if all data are taking or not by consoling
			// console.log(data);

			$.ajaxSetup({
			    headers: {
			        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			    }
			});

			$.ajax({
				url: '/students',
				type: 'POST',
				dataType: 'json',
				data: data,
				success: function(response){
					// console.log(response);
					if (response.status == 400) 
					{
						$("#saveForm_errList").html(""); // Clear previous error messages
						$("#saveForm_errList").addClass('alert alert-danger');
						$.each(response.errors, function(key, err_values) {
						  $('#saveForm_errList').append('<li>'+err_values+'</li>')
						});
					$('.add_student').text('Save');
					}
					else {
						$("#saveForm_errList").html(""); 
						$("#success_message").addClass('alert alert-success');
						$("#success_message").text(response.message);
						
						$("#AddStudentModal").modal('hide'); // for closing the addStudent form after saving the data
						$("#AddStudentModal").find('input').val(''); // for clearing the input field empty
						$('.add_student').text('Save');
						fetch_student();
					}
				}
			});
			
		});


	// FOR SEARCHING FUNCTION

		$('#search').on('keyup', function(){
			// alert('hello');

			$value =$(this).val();

			if($value){
				$('.allData').hide();
				$('.searchData').show();
			}
			else{
				$('.allData').show();
				$('.searchData').hide();
			}
			//  alert($value);
			$.ajax({
				type: "GET",
				url: "/search",
				data: {'search': $value },
				// dataType: 'json',
				
				success: function (data) {
					// console.log(data);
					$('#searchContent').html(data);
				}

			});
		})

	});

</script>


@endsection