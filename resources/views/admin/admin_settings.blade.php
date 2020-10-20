@extends('layouts.admin_layout.admin_layout')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">ตั้งค่าแอดมิน</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard')}}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">ตั้งค่าแอดมิน</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">เปลี่ยนรหัสผ่าน</h3>
                            </div>
                            <!-- /.card-header -->
                            @if (Session::has('error_message'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px;">
                                    {{ Session::get('error_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            
                            @if (Session::has('success_message'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert"
                                    style="margin-top: 10px;">
                                    {{ Session::get('success_message') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <!-- form start -->
                            <form role="form" method="post" action="{{ url('/admin/update-current-pwd') }}"
                                name="updatePasswordForm" id="updatePasswordForm">
                                @csrf
                                <div class="card-body">
                                    <?php
                                    /*
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Admin Name</label>
                                        <input class="form-control" value="{{ $adminDetails->name }}"
                                            placeholder="ป้อนชื่อแอดมิน" name="admin_name" id="admin_name">
                                    </div>*/
                                    ?>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">อีเมลล์</label>
                                        <input class="form-control" value="{{ $adminDetails->email }}" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">สถานะ</label>
                                        <input class="form-control" value="{{ $adminDetails->type }}" readonly="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">รหัสผ่านเดิม</label>
                                        <input type="password" class="form-control" placeholder="ป้อนรหัสผ่านเดิม"
                                            name="current_pwd" id="current_pwd" required="">
                                        <span id="chkCurrentPwd"></span>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">รหัสผ่านใหม่</label>
                                        <input type="password" class="form-control" placeholder="ป้อนรหัสผ่านใหม่"
                                            name="new_pwd" id="new_pwd" required="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputPassword1">ยืนยันรหัสผ่านใหม่</label>
                                        <input type="password" class="form-control" placeholder="ป้อนยืนยันรหัสผ่านใหม่"
                                            name="confirm_pwd" id="confirm_pwd" required="">
                                    </div>
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">ตกลง</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->

    </div>
    <!-- /.content-wrapper -->
   
@endsection
