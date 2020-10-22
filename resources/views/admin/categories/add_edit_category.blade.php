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
                            <li class="breadcrumb-item"><a href="{{ url('/admin/dashboard') }}">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active">Categories</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if ($errors->any())
                    <div class="alert alert-danger" style="margin-top: 10px;">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                        {{ Session::get('success_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
                <form name="CategoryForm" id="CategoryForm" @if (empty($categorydata['id']))
                    action="{{ url('admin/add-edit-category') }}"
                @else action="{{ url('admin/add-edit-category/' . $categorydata['id']) }}"
                    @endif
                    method="POST" enctype="multipart/form-data">@csrf
                    <div class="card card-default">
                        <div class="card-header">
                            <h3 class="card-title">{{ $title }}</h3>

                            <div class="card-tools">
                                <button type="button" class="btn btn-tool" data-card-widget="collapse"><i
                                        class="fas fa-minus"></i></button>
                                {{-- <button type="button" class="btn btn-tool"
                                    data-card-widget="remove"><i class="fas fa-times"></i></button>
                                --}}
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12 d-flex justify-content-center">
                                    <div class="col-md-2">
                                        <div class="form-group text-center">
                                            <label for="category_image">รูปภาพประเภทสินค้า</label>
                                            @if (!empty($categorydata['category_image']))
                                                <img style="width:75%;"
                                                    src="{{ asset('images/category_images/' . $categorydata['category_image']) }}"
                                                    id="output" class="img-fluid rounded ">
                                                <span title="Delete Category Image" href="javascript:void(0)"
                                                    class="confirmDelete btn btn-danger mt-2 " record="category-image"
                                                    recordid="{{ $categorydata['id'] }}">ลบรูป</span>
                                            @else
                                                <img style="width:75%;"
                                                    src="{{ asset('images/product_images/small/no-image.png') }}"
                                                    id="output" class="img-fluid rounded ">
                                            @endif
                                            <span class="btn btn-primary btn-file mt-2">
                                                เลือกไฟล์ <input type="file" name="category_image" id="category_image"
                                                    onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="category_name">ชื่อประเภท</label>
                                        <input type="text" class="form-control" name="category_name" id="category_name"
                                            placeholder="ป้อนชื่อประเภท" @if (!empty($categorydata['category_name']))
                                    value="{{ $categorydata['category_name'] }}" @else
                                        value="{{ old('category_name') }}" @endif>
                                    </div>
                                    <div id="appendCategoriesLevel">
                                        @include('admin.categories.append_categories_level')
                                    </div>
                                    <div class="form-group">
                                        <label for="url">url</label>
                                        <input type="text" class="form-control" name="url" id="url" placeholder="ป้อนURL"
                                            @if (!empty($categorydata['url']))
                                    value="{{ $categorydata['url'] }}" @else
                                        value="{{ old('url') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>เพศสินค้า</label>
                                        <select name="section_id" id="section_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($getSections as $section)
                                                <option value="{{ $section->id }}" @if (!empty($categorydata['section_id']) && $categorydata['section_id'] == $section->id)
                                                    selected=""
                                            @endif >{{ $section->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="category_discount">จำนวน</label>
                                        <input type="text" class="form-control" name="category_discount"
                                            id="category_discount" placeholder="ป้อนจำนวน" @if (!empty($categorydata['category_discount']))
                                    value="{{ $categorydata['category_discount'] }}" @else
                                        value="{{ old('category_discount') }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="description">รายละเอียด</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"
                                            placeholder="ป้อนรายละเอียด">@if (!empty($categorydata['description'])){{ $categorydata['description'] }}@else{{ old('description') }}@endif</textarea>
                                    </div>
                                </div>
                            </div>

                           
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ตกลง</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
