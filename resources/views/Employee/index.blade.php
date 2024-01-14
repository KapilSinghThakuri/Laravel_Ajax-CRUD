@extends('layout.app')

@section('content')


{{-- AddEmployeeModal --}}
<div class="modal fade" id="AddEmployeeModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">Add Employee Details</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      
        <form id="AddEmployeeForm" method="POST" enctype="multipart/form-data">

            <div class="modal-body">

                <!-- For Listing Error -->
            <ul id="save_errList" style="list-style-type: none;" class="alert alert-danger d-none"></ul>

                <div class="form-group mb-3 ">
                    <label for="name">Name</label>
                    <input type="text" name="name" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" class="form-control">
                </div>
                <div class="form-group mb-3">
                    <label for="profile">Profile</label>
                    <input type="file" name="profile" class="form-control">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save</button>
            </div>
        </form>
    </div>
  </div>
</div>
{{-- End - AddEmployeeModal --}}

<!-- FRONT PAGE ( Employee Details Dashboard ) -->

<div class="container mt-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h2>Employee Details Dashboard
                        <a href="" data-bs-toggle="modal" data-bs-target="#AddEmployeeModal" class="btn btn-primary float-end">Add Employee</a>
                    </h2>
                </div>
                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')

<script>

    $(document).ready(function(){
        
        // CSRF TOKENS
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).on('submit','#AddEmployeeForm', function (event) {
            event.preventDefault();

            // FormData() this function take all the input fields input
            let formData = new FormData( $('#AddEmployeeForm')[0] );

            // console.log(formData);
            $.ajax({
                type: "POST",
                contentType: false,
                processData: false,
                // dataType: json,
                url: "/employee",
                data: formData,
                success: function (response) {
                    

                    if(response.status == 400 )
                    {
                        // MAKING EMPTY ARRAY TO SHOW ERROR MESSAGE IN ARRAY
                        var myArry =[];

                        $.each(response.errors, function (key, err_value) { 
                            $('#save_errList').html('');
                            $('#save_errList').removeClass('d-none');
                             
                            // INSERTING ERROR VALUE IN ARRAY
                             myArry.push('-' +err_value + '<br>');
                            //  console.log(myArry);


                            // $('#save_errList').append('<li>'+myArry+'</li>');
                        });

                        // USING FOR LOOPS INSTEAD OF JQ.EACH LOOPS

                        for(let i = 0; i<myArry.length; i++)
                        {
                        $('#save_errList').append('<li>'+myArry[i]+'<br>'+'</li>');
                        }

                        // ANOTHER METHODS

                        // $.each(myArry, function (indexInArray, valueOfElement) { 
                        // $('#save_errList').append('<li>'+valueOfElement+'<br>'+'</li>');
                        // });

                    }
                    else if( response.status == 200 ){
                        $('#save_errList').html('');
                        $('#save_errList').addClass('d-none');

                        // $(this).reset();
                        $('#AddEmployeeForm').find('input').val('');

                        $('#AddEmployeeModal').modal('hide');
                        alert(response.message);
                    }
                }
            });
        });
    });


</script>

@endsection