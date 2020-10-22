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
                            <li class="breadcrumb-item active">Products Attributes</li>
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
                @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-top: 10px;">
                        {{ Session::get('error_message') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif

                <form name="addAttributeForm" id="addAttributeForm" method="POST"
                    action="{{ url('admin/add-attributes/' . $productdata['id']) }}">@csrf
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
                                        <label for="product_name">ชื่อสินค้า:</label>&nbsp;
                                        {{ $productdata['product_name'] }}
                                    </div>
                                    <div class="form-group">
                                        <label for="product_code">โค้ด:</label>&nbsp;
                                        {{ $productdata['product_code'] }}
                                    </div>
                                    <div class="form-group">
                                        <label for="product_color">สี:</label>&nbsp;
                                        {{ $productdata['product_color'] }}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <?php $product_image_path = 'images/product_images/small/' .
                                            $productdata['main_image']; ?>
                                            @if (!empty($productdata['main_image']) && file_exists($product_image_path))
                                                <img style="width: 100px;"
                                                    src="{{ asset('images/product_images/small/' . $productdata['main_image']) }}">
                                            @else
                                                <img style="width: 100px;"
                                                    src="{{ asset('images/product_images/small/no-image.png') }}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="field_wrapper">
                                    <div>
                                        <input style="width: 100px" id="size" name="size[]" type="text" value=""
                                            placeholder="ไซส์" required="" />
                                        <input style="width: 100px" id="sku" name="sku[]" type="text" value=""
                                            placeholder="โค้ดย่อย" required="" />
                                        <input style="width: 100px" id="price" name="price[]" type="number" value=""
                                            placeholder="ราคา" required="" />
                                        <input style="width: 100px" id="stock" name="stock[]" type="number" value=""
                                            placeholder="จำนวน" required="" />
                                        <a href="javascript:void(0);" class="add_button btn btn-info btn-sm"
                                            title="Add field">เพิ่ม</a>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">เพิ่มรายละเอียด</button>
                        </div>
                    </div>
                </form>

                <form name="editAttributeForm" id="editAttributeForm" method="post"
                    action="{{ url('admin/edit-attributes/' . $productdata['id']) }}">@csrf
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">แก้ไขรายละเอียดสินค้า</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="products" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>ไซส์</th>
                                        <th>โค้ดย่อย</th>
                                        <th>ราคา</th>
                                        <th>จำนวน</th>
                                        <th>สถานะ</th>
                                        <th>จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($productdata['attributes'] as $attribute)
                                        <input style="display: none;" type="text" name="attrId[]"
                                            value="{{ $attribute['id'] }}">
                                        <tr>
                                            <td>{{ $attribute['id'] }}</td>
                                            <td>{{ $attribute['size'] }}</td>
                                            <td>{{ $attribute['sku'] }}</td>
                                            <td>
                                                <input type="number" name="price[]" value="{{ $attribute['price'] }}"
                                                    required="">
                                            </td>
                                            <td>
                                                <input type="number" name="stock[]" value="{{ $attribute['stock'] }}"
                                                    required="">
                                            </td>
                                            <td class="text-center">

                                                @if ($attribute['status'] == 1)
                                                    <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}"
                                                        attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)"><i
                                                            class="fa fa-toggle-on text-success" aria-hidden="true"
                                                            status="Active"></i></a>
                                                @else
                                                    <a class="updateAttributeStatus" id="attribute-{{ $attribute['id'] }}"
                                                        attribute_id="{{ $attribute['id'] }}" href="javascript:void(0)"><i
                                                            class="fa fa-toggle-off text-danger" aria-hidden="true"
                                                            status="Inactive"></i></a>

                                                @endif
                                            </td>
                                            <td class="text-center">
                                                <a title="Delete Attribute" href="javascript:void(0)"
                                                    class="confirmDelete btn btn-danger btn-sm" record="attribute"
                                                    recordid="{{ $attribute['id'] }}"><i class="fas fa-trash-alt"></i>
                                                    ลบ</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">อัพเดตรายละเอียด</button>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
