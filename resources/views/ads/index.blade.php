@extends('layouts.app')

@section('content')

@section('content_header', ' Advertisement Informations')
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
                            <h2 class="panel-title pull-left" style="padding-top: 7.5px;">Advertisement Informations</h2>
                        </div>
                        <div class="table-responsive">
                            <table  id="data-table-basic" class="table table-striped">
                                <thead>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-9">Ad Location</th>
                                    <th class="col-md-2">Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($ads as $k=>$row)
                                    <tr id="{{ $row->id }}">
                                        <td>{{$k+1}}</td>
                                        <td>@lang('admin.'.$row->title)</td>
                                        <td><a href="{{action('AdController@edit', $row->id)}}"
                                               class="btn btncus btn_blue"><i class="notika-icon notika-draft"></i>
                                                Edit
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                <tr>
                                    <th class="col-md-1">#</th>
                                    <th class="col-md-9">Ad Location</th>
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
