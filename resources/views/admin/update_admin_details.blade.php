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
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">รายละเอียดแอดมิน</li>
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
                    <div class="col-md-12">
                        <!-- general form elements -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">จัดการรายละเอียดแอดมิน</h3>
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
                            @if ($errors->any())
                                <div class="alert alert-danger" style="margin-top: 10px;">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <!-- form start -->
                            <form role="form" method="post" action="{{ url('/admin/update-admin-details') }}"
                                name="updateAdminDetails" id="updateAdminDetails" enctype="multipart/form-data">
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
                                    <div class="row">
                                        <div class="col-md-2">
                                            <div class="form-group text-center">
                                                <label for="admin_image">ภาพแอดมิน</label>
                                                @if (!empty(Auth::guard('admin')->user()->image))
                                                    <img src="{{ asset('images/admin_images/admin_photos/' . Auth::guard('admin')->user()->image) }}"
                                                        id="output" class="img-fluid rounded ">
                                                        <span title="Delete Admin Image" href="javascript:void(0)"
                                                    class="confirmDeleteAdminImage btn btn-danger mt-2 " record="admin-image"
                                                    recordid="{{ Auth::guard('admin')->user()->id }}">ลบไฟล์</span>
                                                @else
                                                    <img src="{{ asset('images/admin_images/admin_photos/no_avatar.jpg') }}"
                                                        id="output" class="img-fluid rounded ">
                                                @endif
                                                <span class="btn btn-primary btn-file mt-2">
                                                    เลือกไฟล์ <input type="file" name="admin_image" id="admin_image"
                                                        onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="email">อีเมลล์</label>
                                                <input class="form-control"
                                                    value="{{ Auth::guard('admin')->user()->email }}" readonly="">
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_type">สถานะ</label>
                                                <input class="form-control" value="{{ Auth::guard('admin')->user()->type }}"
                                                    readonly="">
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_name">ชื่อ</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Auth::guard('admin')->user()->name }}" placeholder="ป้อนชื่อ"
                                                    name="admin_name" id="admin_name" required="">
                                                <span id="chkCurrentPwd"></span>
                                            </div>
                                            <div class="form-group">
                                                <label for="admin_phone">เบอร์โทร</label>
                                                <input type="text" class="form-control"
                                                    value="{{ Auth::guard('admin')->user()->phone }}"
                                                    placeholder="ป้อนเบอร์โทร" name="admin_phone" id="admin_phone"
                                                    required="">
                                            </div>
                                        </div>
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
