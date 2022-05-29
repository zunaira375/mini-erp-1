@extends('layouts.master')
@section('meta')
    <!DOCTYPE html>

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>products</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
        <link rel="stylesheet"
            href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
        <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
        <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" <blade
            ___scripts_1___ />
        <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>

    </head>

    <body>
       <?php
       // print_r($accounts->toArray());
        //exit();

        ?>
    @section('content')
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title">Chart Of Accounts</h4>
                                {{-- <p class="card-category">Chart Of Accounts Information Form</p> --}}
                            </div>
                            <div class="card-body">
                                <form method="post" action="{{ route('accounts.store') }}">
                                    @csrf
                                    <div class="row">
                                        <input type="hidden" value="{{ $existing == null ? old('id') : $existing->id }}"
                                            name="id">
                                        <div class="col-md-4">
                                            <div
                                                class="form-group @if ($errors->has('account_name')) has-danger bmd-form-group @endif">
                                                {{-- <label class="bmd-label-floating">Account Name</label> --}}
                                                <input type="text" class="form-control" placeholder="Account Name"
                                                    value="{{ $existing == null ? old('account_name') : $existing->account_name }}"
                                                    name="account_name">
                                                @if ($errors->has('account_name'))
                                                    <span class="form-control-feedback">
                                                        <i class="material-icons">clear</i>
                                                    </span>
                                                    <strong
                                                        style="color: red">{{ $errors->first('account_name') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group @if ($errors->has('account_type')) has-danger bmd-form-group @endif">
                                                <select class="form-control" name="account_type">
                                                    <option @if ($existing == null) selected @endif value="0"> --
                                                        Select Account
                                                        Type -- </option>
                                                    <option @if (old('account_type') == 'Assets') selected @endif
                                                        @if ($existing != null && $existing->account_type == 'Assets') selected @endif value="Assets">
                                                        Assets
                                                    </option>
                                                    <option @if (old('account_type') == 'Liability') selected @endif
                                                        @if ($existing != null && $existing->account_type == 'Liability') selected @endif value="Liability">
                                                        Liability</option>
                                                    <option @if (old('account_type') == 'Expense') selected @endif
                                                        @if ($existing != null && $existing->account_type == 'Expense') selected @endif value="Expense">
                                                        Expense</option>
                                                    <option @if (old('account_type') == 'Capital') selected @endif
                                                        @if ($existing != null && $existing->account_type == 'Capital') selected @endif value="Capital">
                                                        Capital</option>
                                                    <option @if (old('account_type') == 'Revenue') selected @endif
                                                        @if ($existing != null && $existing->account_type == 'Revenue') selected @endif value="Revenue">
                                                        Revenue</option>
                                                </select>
                                                @if ($errors->has('account_type'))
                                                    <span class="form-control-feedback">
                                                        <i class="material-icons">clear</i>
                                                    </span>
                                                    <strong
                                                        style="color: red">{{ $errors->first('account_type') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div
                                                class="form-group @if ($errors->has('parent_id')) has-danger bmd-form-group @endif">
                                                <select class="form-control" name="parent_id">
                                                    <option @if (count($accounts) == 0) selected @endif value="0">
                                                        --
                                                        Select Parent
                                                        Account -- </option>
                                                    @foreach ($accounts as $account)
                                                        <option value="{{ $account->id }}"
                                                            @if ($existing != null && $existing->parent_id == $account->id) selected @endif>
                                                            {{ $account->account_name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                @if ($errors->has('parent_id'))
                                                    <span class="form-control-feedback">
                                                        <i class="material-icons">clear</i>
                                                    </span>
                                                    <strong style="color: red">{{ $errors->first('parent_id') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div
                                                class="form-check @if ($errors->has('is_parent')) has-danger bmd-form-group @endif">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="checkbox" name="is_parent"
                                                        @if ($existing != null && $existing->is_parent == true) checked @endif>
                                                    Is Parent ?
                                                    <span class="form-check-sign">
                                                        <span class="check"></span>
                                                    </span>
                                                </label>
                                                @if ($errors->has('is_parent'))
                                                    <span class="form-control-feedback">
                                                        <i class="material-icons">clear</i>
                                                    </span>
                                                    <strong style="color: red">{{ $errors->first('is_parent') }}</strong>
                                                @endif
                                            </div>
                                        </div>
                                    </div><br>
                                    <button type="submit" class="btn btn-primary pull-right">Save</button>
                                    <div class="clearfix"></div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-danger">
                                <h4 class="card-title ">Chart Of Account Information</h4>
                                {{-- <p class="card-category"> Here All Chart Of Account Information Available</p> --}}
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table  id="table" class="table table-bordered">
                                        <thead class="bg-secondary text-white">
                                            <th>
                                                Account Name
                                            </th>
                                            <th>
                                                Account Type
                                            </th>
                                            <th>
                                                Is Parent ?
                                            </th>
                                            <th>
                                                Parent Account
                                            </th>
                                            <th>
                                                Action
                                            </th>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var table = $('table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('accounts.index') }}",
                columns: [{
                        data: 'account_name',
                        name: 'account_name'
                    },
                    {
                        data: 'account_type',
                        name: 'account_type'
                    },
                    {
                        data: 'is_parent',
                        name: 'is_parent'
                    },
                    {
                        data: 'parent_id',
                        name: 'parent_id'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });


            $('body').on('click', '.deleteAccount', function() {
                var account_id = $(this).data("id");
                var result = confirm("Are You sure want to delete !");
                if (result) {
                    $.ajax({
                        type: "DELETE",
                        url: "{{ route('accounts.store') }}" + '/' + account_id,
                        success: function(data) {
                            table.draw();
                        },
                        error: function(data) {
                            console.log('Error:', data);
                        }
                    });
                } else {
                    return false;
                }
            });
        });
    </script>

    </html>
@endsection
