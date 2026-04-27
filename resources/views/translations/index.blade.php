@extends('layouts.app')

@section('content')

@section('content_header', 'Translations')
<div class="contact-area">
    <div class="container">

        <!-- box -->
        <div class="row">

            <!-- col -->
            <div class="col-md-12">
                @if(count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{$error}}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                @if($message = Session::get('success'))
                    <div class="alert alert-success">
                        <p>{{$message}}</p>
                    </div>
                @endif

                @if($message = Session::get('error'))
                    <div class="alert alert-danger">
                        <p>{{$message}}</p>
                    </div>
                @endif

            <!-- general form elements -->
                <div class="box data-table-list">

                    <div class="box-body no-padding">
                        <div class="basic-tb-hd clearfix">
                            <h2 class="panel-title pull-left" style="padding-top: 7.5px;">Language</h2>
                            <div class="btn-group pull-right">
                                <a href="{{action('TranslationController@create')}}" class="btn btncus btn_blue"><i
                                        class="notika-icon notika-draft"></i> Add New Language</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table  id="data-table-basic" class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Language</th>
                                    <th class="col-md-2">Local Code</th>
                                    <th class="col-md-2">Country Code</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($translations as $k=>$row)
                                    <tr id="{{ $row->id }}">
                                        <td>{{$k+1}}</td>
                                        <td>{{$row->language}}</td>
                                        <td>{{$row->code}}</td>
                                        <td>{{$row->locale_code}}</td>
                                        <td><a href="{{action('TranslationController@edit', $row->id)}}"
                                               class="btn btncus btn_blue"><i class="notika-icon notika-draft"></i>
                                                Edit
                                            </a>
                                            @if($row->id == '1')
                                                <a href="javascript:void(0);">
                                            <span class="btn btncus notika-btn-black disabled"> <i
                                                    class="notika-icon notika-trash"></i> Delete</span>
                                                    @else
                                                        <a href="javascript:void(0);" data-url="{{action('TranslationController@destroy', $row->id)}}" data-id="{{$row->id}}"
                                                           class="_delete_data">
                                                <span class="btn btncus notika-btn-black"> <i
                                                        class="notika-icon notika-trash"></i> Delete</span>
                                                            @endif
                                                        </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="col-md-1">ID</th>
                                    <th class="col-md-3">Language</th>
                                    <th class="col-md-2">Local Code</th>
                                    <th class="col-md-2">Country Code</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                    <!-- /.box-body -->


                </div>
                <!-- /.general form elements -->

                @if($translations->isEmpty())
                    <h6 class="alert alert-danger">@lang('admin.no_record').</h6>
                @endif

            </div>
            <!-- /.col -->

        </div>
    </div>
</div>
<!-- /.box -->

@endsection

@section('scripts')
    <script>
        $(document).ready(function () {
            $(document).on('click', '._delete_data', function () {
                var id = $(this).data("id");
                var url = $(this).data("url");
                // var id = $(this).attr('data-id');
                var token = $("meta[name='csrf-token']").attr("content");
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this language!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#DD6B55",
                    confirmButtonText: "Yes, delete it!",
                    closeOnConfirm: false
                }).then(isConfirmed => {
                    if (isConfirmed) {
                        $.ajax(
                            {
                                url: url,
                                type: 'DELETE',
                                data: {
                                    "id": id,
                                    "_token": token,
                                },
                                success: function (data) {
                                    if(data.status) {
                                        swal("Deleted!", data.message, "success");
                                        document.getElementById(id).remove();
                                    }else{
                                        swal("Delete!", data.message, "error");
                                    }
                                }
                            });
                    }
                });
            });


        });
    </script>
@endsection
