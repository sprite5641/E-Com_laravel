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
                            <li class="breadcrumb-item active">Products</li>
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
                                <h3 class="card-title">Products</h3>
                                <a href="{{ url('admin/add-edit-product') }}" class="btn btn-success"
                                    style="float: right;">เพิ่มสินค้า</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="products" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ชื่อสินค้า</th>
                                            <th>โค้ดสินค้า</th>
                                            <th>สีสินค้า</th>
                                            <th>รูปสินค้า</th>
                                            <th>ประเภท</th>
                                            <th>เพศ</th>
                                            <th>สถานะ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td>{{ $product->id }}</td>
                                                <td>{{ $product->product_name }}</td>
                                                <td>{{ $product->product_code }}</td>
                                                <td>{{ $product->product_color }}</td>
                                                <td>
                                                    <?php $product_image_path = "images/product_images/small/".$product->main_image; ?>
                                                    @if (!empty($product->main_image) && file_exists($product_image_path))
                                                    <img style="width: 100px;"
                                                    src="{{ asset('images/product_images/small/' . $product->main_image) }}">
                                                    @else
                                                    <img style="width: 100px;"
                                                            src="{{ asset('images/product_images/small/no-image.png') }}">
                                                    @endif
                                                </td>
                                                <td>{{ $product->category->category_name }}</td>
                                                <td>{{ $product->section->name }}</td>
                                                <td class="text-center">
                                                    @if ($product->status == 1)
                                                        <a class="updateProductStatus" id="product-{{ $product->id }}"
                                                            product_id="{{ $product->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a class="updateProductStatus" id="product-{{ $product->id }}"
                                                            product_id="{{ $product->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a title="Add/Edit Attribues" href="{{ url('admin/add-attributes/'.$product->id) }}"><i class="fas fa-plus"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a title="Add/Edit Images" href="{{ url('admin/add-images/'.$product->id) }}"><i class="fas fa-plus-circle"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a title="Edit Product" href="{{ url('admin/add-edit-product/'.$product->id) }}"><i class="fas fa-edit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a title="Delete Product" href="javascript:void(0)" class="confirmDelete" record="product"
                                                        recordid="{{ $product->id }}"><i class="fas fa-trash-alt"></i></a> 
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
