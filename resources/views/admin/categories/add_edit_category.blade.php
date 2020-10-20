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
                                        <label for="category_image">รูปสินค้า</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="category_image"
                                                    id="category_image">
                                                <label class="custom-file-label" for="category_image">เลือกไฟล์</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">อัพโหลด</span>
                                            </div>

                                        </div>
                                        @if (!empty($categorydata['category_image']))
                                            <div><img style="width:50px; margin-top:5px;"
                                                    src="{{ asset('images/category_images/' . $categorydata['category_image']) }}">
                                                &nbsp;
                                                 <a class="confirmDelete" href="javascript:void(0)" record="category-image" recordid="{{$categorydata['id']}}" <?php{{-- href="{{ url('admin/delete-category-image/' . $categorydata['id']) }}"--}}
                                                ?> > 
                                                    ลบรูปภาพ</a>
                                            </div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="category_discount">จำนวน</label>
                                        <input type="text" class="form-control" name="category_discount"
                                            id="category_discount" placeholder="ป้อนจำนวน" @if (!empty($categorydata['category_discount'])) 
                                            value="{{ $categorydata['category_discount'] }}" @else
                                        value="{{ old('category_discount') }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="url">url</label>
                                        <input type="text" class="form-control" name="url"
                                            id="url" placeholder="ป้อนจำนวน" @if (!empty($categorydata['url'])) 
                                            value="{{ $categorydata['url'] }}" @else
                                        value="{{ old('url') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
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
