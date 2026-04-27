@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.edit_news'))

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
        @endif @if(Session::has('success'))
            <div class="alert alert-success">
                <p>{{ Session::get('success') }}</p>
            </div>
    @endif

    <!-- general form elements -->
        <div class="box">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{action('NewsController@update', $id)}}">
            @csrf @method('PUT')

            <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" value="{{$news->title}}"
                               placeholder="@lang('admin.title')"/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.short_description') <span class="text-danger">*</span></label>
                        <textarea class="textarea-style textarea-h-100" name="description" placeholder="@lang('admin.short_description')">{{$news->description}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.article') <span class="text-danger">*</span></label>
                        <textarea class="textarea textarea-style" name="details" placeholder="@lang('admin.article')">{{$news->details}}</textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.image')</label>
                        <input type="file" name="image">
                    </div>

                </div>
                <!-- /.box-body -->

                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">@lang('admin.submit')</button>
                </div>

            </form>
            <!-- /.form -->

        </div>
        <!-- /.general form elements -->

    </div>
    <!-- /.col -->

</div>
<!-- /.box -->

@endsection
