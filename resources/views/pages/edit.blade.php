@extends('layouts.app')

@section('content')

@section('content_header', 'Edit Page')
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
                <div class="box normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('PageController@index')}}"><i class="notika-icon notika-windows"></i>
                                Pages</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Page</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{action('PageController@update', $id)}}">
                            @csrf @method('PUT')

                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>Title<span class="text-danger">*</span></label>
                                        <input type="text" name="title" class="form-control" value="{{$page->title}}"
                                               placeholder="Page Title"/>
                                    </div>

                                    <div class="form-group">
                                        <label>Content<span class="text-danger">*</span></label>
                                        <textarea class="form-control html-editor-cm" name="details"
                                                  placeholder="@lang('admin.page_content')">{{$page->details}}</textarea>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btncus btn_blue">Update Page</button>
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
