@extends('layouts.app')

@section('content')

@section('content_header','edit translation')
<div class="contact-area">
    <div class="container">
        <!-- box -->
        <div class="row">
            <!-- col -->
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
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
            <!-- general form elements frontend -->
                <div class="box normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('TranslationController@index')}}"><i class="notika-icon notika-edit"></i>
                                Language</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Update Language</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Translation Information</p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <form method="POST" id="form_2" enctype="multipart/form-data"
                                  action="{{action('TranslationController@update', $id)}}">
                                @csrf @method('PUT')

                                <input name="translation_type" type="hidden" value="2">

                                <!-- box-body -->
                                <div class="box-body">

                                    @foreach($translation_frontend_org as $key => $item)
                                        <div class="form-group">
                                            <label>{{$item}}</label>
                                            <input type="text" name="{{$key}}" class="form-control"
                                                   value="{{$translation_frontend_target[$key]}}"
                                                   placeholder="{{$translation_frontend_target[$key]}}"/>
                                        </div>
                                    @endforeach

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <a href="{{action('TranslationController@index')}}"
                                       class="btn btn-dark mr-1"><i
                                            class="fa fa-arrow-left"></i> Back</a>
                                    <button type="submit" class="btn btn_blue">Update</button>
                                </div>

                            </form>
                            <!-- /.form -->

                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col -->

        </div>
    </div>
</div>
<!-- /.box -->

@endsection
