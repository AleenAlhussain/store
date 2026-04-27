@extends('layouts.app')

@section('content')

@section('content_header', 'Sliders')
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
                            <h2 class="panel-title pull-left" style="padding-top: 7.5px;">Sliders<br><span
                                    class="bread-ntd" style="font-size: 14px;font-weight: normal"> Click on and drag title to a new spot within the list to sort.</span>
                            </h2>
                            <div class="btn-group pull-right">
                                <a href="{{action('SliderController@create')}}" class="btn btncus btn_blue"><i
                                        class="notika-icon notika-draft"></i> Add New Slider</a>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="col-md-2">Image</th>
                                    <th class="col-md-4">Title</th>
                                    <th class="col-md-2">link</th>
                                    <th class="col-md-3">Action</th>
                                </tr>
                                </thead>
                                <tbody class="sortable-posts" id="pages">
                                @foreach($sliders as $k=>$row)
                                    <tr id="{{ $row->id }}">
                                        <td><img src="{{ asset('public/images/sliders') }}/{{$row->image}}"
                                                 alt="Product" style="height: 100px;width: auto;"
                                                 class="img-fluid"></td>
                                        <td>{{$row->title}}</td>
                                        <td>{{$row->link}}</td>
                                        <td><a href="{{action('SliderController@edit', $row->id)}}"
                                               class="btn btncus btn_blue"><i class="notika-icon notika-draft"></i>
                                                Edit
                                            </a>

                                            <a href="javascript:void(0);"
                                               data-url="{{action('SliderController@destroy', $row->id)}}"
                                               data-id="{{$row->id}}"
                                               class="_delete_data">
                                                <span class="btn btncus notika-btn-black"> <i
                                                        class="notika-icon notika-trash"></i> Delete</span>

                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
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
            $(".sortable-posts").sortable({
                stop: function () {
                    var sort_type = $(this).attr('id');
                    $.map($(this).find('tr'), function (el) {
                        var id = el.id;
                        var sort = $(el).index();
                        $.ajax({
                            url: '{{action('SliderController@order')}}',
                            type: 'GET',
                            data: {
                                id: id,
                                sort: sort
                            },
                            success: function (response) {
                                if (response.status == "success") {
                                    console.log(response);
                                } else {
                                    console.log(response);
                                }
                            }
                        });
                        $(".sortable-posts").disableSelection();
                    });
                }
            });
            $(document).on('click', '._delete_data', function () {
                var id = $(this).data("id");
                var url = $(this).data("url");
                // var id = $(this).attr('data-id');
                var token = $("meta[name='csrf-token']").attr("content");
                swal({
                    title: "Are you sure?",
                    text: "You will not be able to recover this page!",
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
                                    if (data.status) {
                                        swal("Deleted!", data.message, "success");
                                        document.getElementById(id).remove();
                                    } else {
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
