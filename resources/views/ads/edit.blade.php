@extends('layouts.app')

@section('content')

@section('content_header','Edit Advertisement')

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
                            <a href="{{action('AdController@index')}}"><i class="notika-icon notika-edit"></i>
                                Advertisement Informations
                            </a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update AD</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Page Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" enctype="multipart/form-data"
                                  action="{{action('AdController@update', $id)}}">
                            @csrf @method('PUT')

                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>AD Location')</label>
                                        <input type="text" name="title" class="form-control"
                                               value="@lang('admin.'.$ad['title'])"
                                               placeholder="Ad Location" readonly/>
                                    </div>

                                    <div class="form-group">
                                        <label>Html Code</label>
                                        <textarea class="form-control" name="code" rows="10" cols="100"
                                                  placeholder="@lang('admin.html_code')">{{$ad->code}}</textarea>
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn_blue">Update Ad Code</button>
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
