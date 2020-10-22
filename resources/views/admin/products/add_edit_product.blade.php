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
                            <li class="breadcrumb-item active">Products</li>
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
                <form name="productForm" id="productForm" @if (empty($productdata['id']))
                    action="{{ url('admin/add-edit-product') }}"
                @else action="{{ url('admin/add-edit-product/' . $productdata['id']) }}"
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
                                            <label for="main_image">รูปภาพสินค้า</label>
                                            @if (!empty($productdata['main_image']))
                                                <img style="width:75%;"
                                                    src="{{  asset('images/product_images/small/' . $productdata['main_image']) }}"
                                                    id="output" class="img-fluid rounded ">
                                                <span title="Delete Product Image" href="javascript:void(0)"
                                                    class="confirmDelete btn btn-danger mt-2 "
                                                    record="product-image"
                                                    recordid="{{ $productdata['id'] }}">ลบรูป</span>
                                            @else
                                                <img style="width:75%;" src="{{ asset('images/product_images/small/no-image.png') }}"
                                                    id="output" class="img-fluid rounded ">
                                            @endif
                                            <span class="btn btn-primary btn-file mt-2">
                                                เลือกไฟล์ <input type="file" name="main_image" id="main_image"
                                                    onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>ประเภท</label>
                                        <select name="category_id" id="category_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($categories as $section)
                                                <optgroup label="{{ $section['name'] }}"></optgroup>
                                                @foreach ($section['categories'] as $category)
                                                    <option value="{{ $category['id'] }}" @if (!empty(@old('category_id')) && $category['id'] == @old('category_id'))
                                                        selected=""
                                                    @elseif(!empty($productdata['category_id']) &&
                                                        $productdata['category_id']==$category['id']) selected=""
                                                @endif
                                                >&nbsp;&nbsp;&nbsp;&nbsp;-&nbsp;{{ $category['category_name'] }}</option>
                                                @foreach ($category['subcategories'] as $subcategory)
                                                    <option value="{{ $subcategory['id'] }}" @if (!empty(@old('subcategory')) && $category['id'] == @old('category_id'))
                                                        selected=""
                                                    @elseif(!empty($productdata['category_id']) &&
                                                        $productdata['category_id']==$subcategory['id']) selected=""
                                                @endif
                                                >&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;--&nbsp;{{ $subcategory['category_name'] }}
                                                </option>
                                            @endforeach
                                            @endforeach
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>ยี่ห้อสินค้า</label>
                                        <select name="brand_id" id="brand_id" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand['id'] }}" @if (!empty(@old('brand_id')) && $brand['id'] == @old('brand_id'))
                                                    selected=""
                                                @elseif(!empty($productdata['brand_id']) && $productdata['brand_id'] ==
                                                    $brand['id'])
                                                    selected=""
                                            @endif>{{ $brand['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_name">ชื่อสินค้า</label>
                                        <input type="text" class="form-control" name="product_name" id="product_name"
                                            placeholder="ป้อนชื่อสินค้า" @if (!empty($productdata['product_name']))
                                    value="{{ $productdata['product_name'] }}" @else
                                        value="{{ old('product_name') }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">โค้ดสินค้า</label>
                                        <input type="text" class="form-control" name="product_code" id="product_code"
                                            placeholder="ป้อนโค้ดสินค้า" @if (!empty($productdata['product_code']))
                                    value="{{ $productdata['product_code'] }}" @else
                                        value="{{ old('product_code') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_color">สีสินค้า</label>
                                        <input type="text" class="form-control" name="product_color" id="product_color"
                                            placeholder="ป้อนสีสินค้า" @if (!empty($productdata['product_color']))
                                    value="{{ $productdata['product_color'] }}" @else
                                        value="{{ old('product_color') }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_price">ราคาสินค้า</label>
                                        <input type="text" class="form-control" name="product_price" id="product_price"
                                            placeholder="ป้อนราคาสินค้า" @if (!empty($productdata['product_price']))
                                    value="{{ $productdata['product_price'] }}" @else
                                        value="{{ old('product_price') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="product_weight">น้ำหนักสินค้า</label>
                                        <input type="text" class="form-control" name="product_weight" id="product_weight"
                                            placeholder="ป้อนน้ำหนักสินค้า" @if (!empty($productdata['product_weight']))
                                    value="{{ $productdata['product_weight'] }}" @else
                                        value="{{ old('product_weight') }}" @endif>
                                    </div>
                                    <div class="form-group">
                                        <label for="product_discount">จำนวนสินค้า</label>
                                        <input type="text" class="form-control" name="product_discount"
                                            id="product_discount" placeholder="ป้อนจำนวนสินค้า" @if (!empty($productdata['product_discount']))
                                    value="{{ $productdata['product_discount'] }}" @else
                                        value="{{ old('product_discount') }}" @endif>
                                    </div>
                                </div>
                                
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>เลือกแขนเสื้อ</label>
                                        <select name="sleeve" id="sleeve" class="form-control select2" style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($sleeveArray as $sleeve)
                                                <option value="{{ $sleeve }}" @if (!empty($productdata['sleeve']) && $productdata['sleeve'] == $sleeve)
                                                    selected=""
                                            @endif>{{ $sleeve }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>เลือกชนิดผ้าเสื้อ</label>
                                        <select name="fabric" id="fabric" class="form-control select2" style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($fabricArray as $fabric)
                                                <option value="{{ $fabric }}" @if (!empty($productdata['fabric']) && $productdata['fabric'] == $fabric)
                                                    selected=""
                                            @endif>{{ $fabric }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>เลือกรูปแบบเสื้อ</label>
                                        <select name="pattern" id="pattern" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($patternArray as $pattern)
                                                <option value="{{ $pattern }}" @if (!empty($productdata['pattern']) && $productdata['pattern'] == $pattern)
                                                    selected=""
                                            @endif>{{ $pattern }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>เลือกรูปแบบเสื้อ</label>
                                        <select name="fit" id="fit" class="form-control select2" style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($fitArray as $fit)
                                                <option value="{{ $fit }}" @if (!empty($productdata['fit']) && $productdata['fit'] == $fit)
                                                    selected=""
                                            @endif>{{ $fit }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label>เลือกระดับเสื้อ</label>
                                        <select name="occasion" id="occasion" class="form-control select2"
                                            style="width: 100%;">
                                            <option value="">เลือก</option>
                                            @foreach ($occasionArray as $occasion)
                                                <option value="{{ $occasion }}" @if (!empty($productdata['occasion']) && $productdata['occasion'] == $occasion)
                                                    selected=""
                                            @endif>{{ $occasion }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="is_featured">สินค้าแนะนำ</label>
                                        <input type="checkbox" name="is_featured" id="is_featured" value="Yes" @if (!empty($productdata['is_featured']) && $productdata['is_featured'] == 'Yes')
                                        checked=""@endif>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="description">รายละเอียดสินค้า</label>
                                        <textarea name="description" id="description" class="form-control" rows="3"
                                            placeholder="ป้อนรายละเอียดสินค้า">@if (!empty($productdata['description'])){{ $productdata['description'] }}@else{{ old('description') }}@endif</textarea>
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
