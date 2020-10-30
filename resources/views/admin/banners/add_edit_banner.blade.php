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
                            <li class="breadcrumb-item active">Banners</li>
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
                <form name="bannerForm" id="bannerForm" @if (empty($banner['id']))
                    action="{{ url('admin/add-edit-banner') }}"
                @else action="{{ url('admin/add-edit-banner/' . $banner['id']) }}"
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
                                    <div class="col-md-2 text-center">
                                        <div class="form-group text-center">
                                            <label for="image">รูปภาพสินค้า</label>
                                            @if (!empty($banner['image']))
                                                <img 
                                                    src="{{  asset('images/banner_images/' . $banner['image']) }}"
                                                    id="output" class="img-fluid rounded ">
                                                <span title="Delete Banner Image" href="javascript:void(0)"
                                                    class="confirmDelete btn btn-danger mt-2 "
                                                    record="banner"
                                                    recordid="{{ $banner['id'] }}">ลบรูป</span>
                                            @else
                                                <img style="width:75%;" src="{{ asset('images/product_images/small/no-image.png') }}"
                                                    id="output" class="img-fluid rounded ">
                                            @endif
                                            <span class="btn btn-primary btn-file mt-2">
                                                เลือกไฟล์ <input type="file" name="image" id="image"
                                                    onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])">
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="title">หัวข้อแบนเนอร์</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="ป้อนหัวข้อ" @if (!empty($banner['title']))
                                    value="{{ $banner['title'] }}" @else
                                        value="{{ old('title') }}" @endif>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link">ลิงค์</label>
                                        <input type="text" class="form-control" name="link" id="link"
                                            placeholder="ป้อนลิงค์" @if (!empty($banner['link']))
                                    value="{{ $banner['link'] }}" @else
                                        value="{{ old('link') }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                               
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="alt">ข้อความ</label>
                                        <input type="text" class="form-control" name="alt" id="alt"
                                            placeholder="ป้อนข้อความ" @if (!empty($banner['alt']))
                                    value="{{ $banner['alt'] }}" @else
                                        value="{{ old('alt') }}" @endif>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">ตกลง</button>
                        </div>
                </form>
            </div>
        </section>
    </div>
@endsection
