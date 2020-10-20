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
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="image">รูปแบนเนอร์</label>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" name="image" id="image">
                                                <label class="custom-file-label" for="image">เลือกไฟล์</label>
                                            </div>
                                            <div class="input-group-append">
                                                <span class="input-group-text" id="">อัพโหลด</span>
                                            </div>
                                        </div>
                                        (แนะนำเลือกรูปภาพขนาด:&nbsp;&nbsp;กว้าง:&nbsp;1170&nbsp;พิกเซล,&nbsp;&nbsp;สูง:&nbsp;480&nbsp;พิกเซล)
                                        @if (!empty($banner['image']))
                                            <div><img style="width:150px; margin-top:5px;"
                                                    src="{{ asset('images/banner_images/' . $banner['image']) }}">
                                                &nbsp;
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="link">ลิ้ง</label>
                                        <input type="text" class="form-control" name="link" id="link"
                                            placeholder="ป้อนจำนวนสินค้า" @if (!empty($banner['link']))
                                    value="{{ $banner['link'] }}" @else
                                        value="{{ old('link') }}" @endif>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-sm-6">

                                    <div class="form-group">
                                        <label for="title">หัวข้อแบนเนอร์</label>
                                        <input type="text" class="form-control" name="title" id="title"
                                            placeholder="ป้อนจำนวนสินค้า" @if (!empty($banner['title']))
                                    value="{{ $banner['title'] }}" @else
                                        value="{{ old('title') }}" @endif>
                                    </div>
                                    
                                </div>
                                <div class="col-12 col-sm-6">
                                    <div class="form-group">
                                        <label for="alt">ข้อความอื่น</label>
                                        <input type="text" class="form-control" name="alt" id="alt"
                                            placeholder="ป้อนจำนวนสินค้า" @if (!empty($banner['alt']))
                                    value="{{ $banner['alt'] }}" @else
                                        value="{{ old('alt') }}" @endif>
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
