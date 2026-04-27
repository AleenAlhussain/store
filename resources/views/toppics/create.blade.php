@extends('layouts.app')

@section('content')

@section('content_header','Create Page')
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
                @if(Session::has('success'))
                    <div class="alert alert-success">
                        <p>{{ Session::get('success') }}</p>
                    </div>
            @endif

            <!-- general form elements -->
                <div class="box box-primary normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('ToppicsController@index')}}"><i class="notika-icon notika-windows"></i>
                                Toppics</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Create Toppics</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/toppics')}}">
                            @csrf @method('POST')

                            <!-- box-body -->
                                <div class="box-body">
                                    <div class="form-group">
                                        <label>Title <span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" placeholder="Title"/>
                                    </div>
                                    <div class="form-group">
                                        <label>@lang('admin.image') <span class="text-danger">*</span></label>
                                        <input type="file" name="images">
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="fm-checkbox">
                                                <label><input type="checkbox" name="home" class="i-checks"> <i></i> Show
                                                    Home Page</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Status</label>
                                        <select name="status" class="form-control">
                                            <option value="0">In Active</option>
                                            <option selected value="1">Active</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Content <span class="text-danger">*</span></label>
                                        <textarea class="form-control" name="details"
                                                  placeholder="Content"></textarea>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btncus btn_blue">Create New</button>
                                </div>

                            </form>
                            <!-- /.form -->
                        </div>
                    </div>
                </div>
                <!-- /.general form elements -->

            </div>
            <!-- /.col -->

        </div>
    </div>
</div>
<!-- /.box -->

@endsection
