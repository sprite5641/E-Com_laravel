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
                            <li class="breadcrumb-item active">Catagories</li>
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
                                <h3 class="card-title">Catagories</h3>
                                <a href="{{ url('admin/add-edit-category') }}" class="btn btn-success"
                                    style="float: right;">เพิ่มประเภทสินค้า</a>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table id="categories" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>ลำดับ</th>
                                            <th>ประเภท</th>
                                            <th>เพศ</th>
                                            <th>url</th>
                                            <th>สถานะ</th>
                                            <th>จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $category)
                                            @if (!@isset($category->parentcategory->category_name))
                                                <?php $parent_category = 'Root'; ?>
                                            @else
                                                <?php $parent_category =
                                                $category->parentcategory->category_name; ?>
                                            @endif
                                            <tr>
                                                <td>{{ $category->id }}</td>
                                                <td>{{ $category->category_name }}</td>
                                                <td>{{ $category->section->name }}</td>
                                                <td>{{ $category->url }}</td>
                                                <td class="text-center">
                                                    @if ($category->status == 1)
                                                        <a class="updateCategoryStatus" id="category-{{ $category->id }}"
                                                            category_id="{{ $category->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-on" aria-hidden="true" status="Active"></i></a>
                                                    @else
                                                        <a class="updateCategoryStatus" id="category-{{ $category->id }}"
                                                            category_id="{{ $category->id }}"
                                                            href="javascript:void(0)"><i class="fa fa-toggle-off" aria-hidden="true" status="Inactive"></i></a>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <a href="{{ url('admin/add-edit-category/'.$category->id) }}"><i class="fas fa-edit"></i></a>
                                                    &nbsp;&nbsp;
                                                    <a href="javascript:void(0)" class="confirmDelete" record="category" recordid="{{ $category->id }}"><i class="fas fa-trash-alt"></i></a> 
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
