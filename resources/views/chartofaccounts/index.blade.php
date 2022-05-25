
@extends('layouts.app')
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>accounts</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

</head>
<body>
 @section('content')
 <!--alert -->
 @if ($message = Session::get('success'))
<div class="alert alert-success alert-server" role="alert">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p>{{ $message }}</p>
</div>
@endif
<header>
   <!--- NavBar-->
</header>
<!--end of header-->
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="container">
    <h3 class="h3"><strong>Add New Account</strong></h3><br>


<form action="{{ route('chartofaccounts.store') }}" method="POST">
    @csrf
    <input type="hidden" name="id" value="{{$chartOfAccount->id ?? ''}}" />

     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Account Name:</strong>
                <input type="text" name="account_name" value="{{$chartOfAccount->name ?? ''}}" class="form-control" placeholder="Account Name">
            </div>
        </div><br>
        <br>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Account Type:</strong>
                <input type="text" name="account_type" value="{{$chartOfAccount->account_type ?? ''}}" class="form-control" placeholder="Account Type">
            </div>
        </div><br>
        <br>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>is_parent:</strong>
                <input type="boolean" name="is_parent" value="{{$chartOfAccount->is_parent?? ''}}" class="form-control" placeholder="Is parent">
            </div>
        </div><br>
        <br>

        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Parent Account ID:</strong>
                <input type="number" name="parent_account_id" value="{{$chartOfAccount->parent_account_id ?? ''}}" class="form-control" placeholder="Parent_Account_ID">
            </div>
        </div><br>
        <br>

        <div class="col-xs-12 col-sm-12 col-md-12 text-left">
                <button type="submit"   class="btn btn-primary"style="margin:35px" >Submit</button>
        </div>
    </div>

</form>
 <table id="table" class="table table-bordered">
    <thead class="bg-success text-white">
        <tr>
            <th>No</th>
            <th>Account Name</th>
            <th>Account Type</th>
            <th>Is Parent</th>
            <th>Parent Account_ID</th>
           <th width="180px">Action</th>
        </tr>
    </thead>

     <tbody>

     </tbody>
    </table>
</div>
</body>
<script>
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var table = $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('chartofaccounts.index') }}",
            columns : [
                {data:'id',name:'id'},
                {data:'account_name',name:'account_name'},
                {data:'account_type',name:'account_type'},
                {data:'is_parent',name:'is_parent'},
                {data:'parent_account_id',name:'parent_account_id'},
                {data: 'action', name: 'action', orderable: false, searchable: false},
            ]
        });


        $('body').on('click', '.deleteAccounts', function (){
            var account_id = $(this).data("id");
            var result = confirm("Are You sure want to delete !");
            if(result){
                $.ajax({
                    type: "DELETE",
                    url: "{{ route('chartofaccounts.store') }}"+'/'+account_id,
                    success: function (data) {
                        table.draw();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }else{
                return false;
            }
        });
    });
</script>

</html>
@endsection



