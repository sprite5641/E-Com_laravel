@extends('layouts.admin_layout.admin_layout')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>แคตตาล็อก</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard')}}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">Banners</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <!-- /.card -->
                        @if (Session::has('success_message'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert"
                            style="margin-top: 10px;">
                            {{ Session::get('success_message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Banners</h3>
                                <a href="{{ url('admin/add-edit-banner') }}" class="btn btn-success"
                                    style="float: right;">เพิ่มรูปแบนเนอร์</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="banners" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>รูปภาพ</th>
                                            <th>ลิ้ง</th>
                                            <th>หัวข้อ</th>
                                            <th>ข้อความอื่น</th>
                                            <th>สถานะ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($banners as $banner)
                                            <tr>
                                                <td>{{ $banner['id'] }}</td>
                                                <td>
                                                <img style="width: 100px" src="{{asset('images/banner_images/'.$banner['image']) }}" alt="">
                                                </td>
                                                <td>{{ $banner['link'] }}</td>
                                                <td>{{ $banner['title'] }}</td>
                                                <td>{{ $banner['alt'] }}</td>
                                                <td class="text-center">
                                                    @if ($banner['status'] == 1)
                                                        <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}"
                                                            banner_id="{{ $banner['id'] }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a class="updateBannerStatus" id="banner-{{ $banner['id'] }}"
                                                            banner_id="{{ $banner['id'] }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a title="Edit Banner" href="{{ url('admin/add-edit-banner/'.$banner['id']) }}"><i class="fas fa-edit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a title="Delete Banner" href="javascript:void(0)" class="confirmDelete" record="banner"
                                                        recordid="{{ $banner['id'] }}"><i class="fas fa-trash-alt"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection
