@extends('layouts.app')

@section('content')

@section('content_header', 'Account Settings')
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
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
            @endif

            <!-- general form elements -->
                <div class="box normal-table-list">
                    <ol class="breadcrumb breadcrumb-alt push">
                        <li class="breadcrumb-item">
                            <a href="{{action('AdminController@index')}}"><i class="notika-icon notika-house"></i>
                                Home</a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">Admin Configurations</li>
                    </ol>
                    <div class="row">
                        <div class="col-lg-3"><p class="text-muted">Update Admin Info<br><small class="text-muted">
                                    Admin settings page.
                                </small></p></div>
                        <!-- form -->
                        <div class="col-lg-9">
                            <!-- form -->
                            <form method="POST" action="{{ route('accountsettings') }}">
                            {{ csrf_field() }}

                            <!-- box-body -->
                                <div class="box-body">

                                    <div class="form-group">
                                        <label>E-mail</label>
                                        <input type="email" name="email" class="form-control"
                                               value="{{{ Auth::user()->email }}}"
                                               placeholder="E-mail"/>
                                    </div>

                                    <div class="form-group{{ $errors->has('current-password') ? ' has-error' : '' }}">
                                        <label>Current Password <span class="text-danger">*</span></label>
                                        <input id="current-password" type="password" class="form-control"
                                               name="current-password">

                                    </div>

                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label>New Password</label>
                                        <input id="new-password" type="password" class="form-control"
                                               name="new-password">
                                    </div>

                                    <div class="form-group{{ $errors->has('new-password') ? ' has-error' : '' }}">
                                        <label>Confirm New Password</label>
                                        <input id="new-password-confirm" type="password" class="form-control"
                                               name="new-password_confirmation">
                                    </div>

                                </div>
                                <!-- /.box-body -->

                                <div class="box-footer">
                                    <button type="submit" class="btn btn-primary">
                                        Update Admin
                                    </button>
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
