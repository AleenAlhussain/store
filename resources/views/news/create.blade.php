@extends('adminlte::page')

@section('content')

@section('content_header', __('admin.create_news'))

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
        <div class="box box-primary">

            <!-- form -->
            <form method="POST" enctype="multipart/form-data" action="{{url('/admin/news')}}">
            @csrf @method('POST')

            <!-- box-body -->
                <div class="box-body">

                    <div class="form-group">
                        <label>@lang('admin.page_title') <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control" placeholder="@lang('admin.page_title')"/>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.short_description') <span class="text-danger">*</span></label>
                        <textarea class="textarea-style textarea-h-100" name="description" placeholder="@lang('admin.short_description')"></textarea>
                    </div>

                    <div class="form-group">
                        <label>@lang('admin.article') <span class="text-danger">*</span></label>
                        <textarea class="textarea textarea-style" name="details" placeholder="@lang('admin.article')"></textarea>
                    </div>

                    <div class="form-group">
                            <label>@lang('admin.image') <span class="text-danger">*</span></label>
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
