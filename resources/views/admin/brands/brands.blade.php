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
                            <li class="breadcrumb-item active">Brands</li>
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
                                <h3 class="card-title">Brands</h3>
                                <a href="{{ url('admin/add-edit-brand') }}" class="btn btn-success"
                                    style="float: right;">เพิ่มยี่ห้อสินค้า</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="brands" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อ</th>
                                            <th>สถานะ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($brands as $brand)
                                            <tr>
                                                <td>{{ $brand->id }}</td>
                                                <td>{{ $brand->name }}</td>
                                                <td class="text-center">
                                                    @if ($brand->status == 1)
                                                        <a class="updateBrandStatus" id="brand-{{ $brand->id }}"
                                                            brand_id="{{ $brand->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-on text-success" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a class="updateBrandStatus" id="brand-{{ $brand->id }}"
                                                            brand_id="{{ $brand->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-off text-danger" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a class="btn btn-info btn-sm" title="Edit Brand" href="{{ url('admin/add-edit-brand/'.$brand->id) }}"><i class="fas fa-edit"></i> แก้ไข</a>
                                                    &nbsp;&nbsp;
                                                    <a title="Delete Brand" href="javascript:void(0)" class="confirmDelete btn btn-danger btn-sm" record="brand"
                                                        recordid="{{ $brand->id }}"><i class="fas fa-trash-alt"></i> ลบ</a>
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
