<?php use App\Cart; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">หน้าหลัก</a> <span class="divider">/</span></li>
            <li class="active"> ตะกร้าสินค้า</li>
        </ul>
        <h3> ตะกร้าสินค้า [ <small> มี {{ count($userCartItems) }} รายการ </small>]<a href="{{ url('/') }}"
                class="btn btn-large pull-right"><i class="icon-arrow-left"></i> เลือกสินค้าต่อ </a></h3>
        <hr class="soft" />
        <table class="table table-bordered">
            <tr>
                <th> 
                    ฉันลงทะเบียนแล้ว </th>
            </tr>
            <tr>
                <td>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputUsername">ชื่อผู้ใช้</label>
                            <div class="controls">
                                <input type="text" id="inputUsername" placeholder="Username">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPassword1">รหัสผ่าน</label>
                            <div class="controls">
                                <input type="password" id="inputPassword1" placeholder="Password">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">ล็อกอิน</button> หรือ <a href="register.html"
                                    class="btn">สมัครสมาชิก!</a>
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <a href="forgetpass.html" style="text-decoration:underline">ฉันลืมรหัสผ่าน ?</a>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th colspan="2">รายละเอียด</th>
                    <th>จำนวน/เพิ่มลบ</th>
                    <th>ราคา</th>
                    <th>ส่วนลด</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php $total_price = 0; ?>
                @foreach ($userCartItems as $item)
                    <?php $attrPrice = Cart::getProductAttrPrice($item['product_id'], $item['size']); ?>
                    <tr>
                        <td> <img width="60"
                                src="{{ asset('images/product_images/small/' . $item['product']['main_image']) }}" alt="" />
                        </td>
                        <td colspan="2">
                            {{ $item['product']['product_name'] }}
                            ({{ $item['product']['product_code'] }})<br />
                            สี : {{ $item['product']['product_color'] }}<br />
                            ไซส์ : {{ $item['size'] }}
                        </td>
                        <td>
                            <div class="input-append">
                                <input class="span1" style="max-width:34px" placeholder="{{ $item['quantity'] }}" id="appendedInputButtons"
                                    size="16" type="text">
                                <button class="btn" type="button">
                                    <i class="icon-minus"></i>
                                </button>
                                <button class="btn" type="button">
                                    <i class="icon-plus"></i>
                                </button>
                                <button class="btn btn-danger" type="button">
                                    <i class="icon-remove icon-white"></i>
                                </button>
                            </div>
                        </td>
                        <td>ราคา {{ $attrPrice }}</td>
                        <td></td>
                        <td>ราคา {{ $attrPrice * $item['quantity'] }}</td>
                    </tr>
                    <?php $total_price = $total_price + $attrPrice * $item['quantity']; ?>
                @endforeach


                <tr>
                    <td colspan="6" style="text-align:right">ราคารวม: </td>
                    <td>{{ $total_price }} บาท</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:right">ราคาหักส่วนลด: </td>
                    <td> 0.00 บาท</td>
                </tr>
                <tr>
                    <td colspan="6" style="text-align:right"><strong>รวม (ราคา {{ $total_price }} - ส่วนลด 0) =</strong></td>
                    <td class="label label-important" style="display:block"> <strong> {{ $total_price }} บาท</strong></td>
                </tr>
            </tbody>
        </table>


        <table class="table table-bordered">
            <tbody>
                <tr>
                    <td>
                        <form class="form-horizontal">
                            <div class="control-group">
                                <label class="control-label"><strong> โค้ดส่วนลด: </strong> </label>
                                <div class="controls">
                                    <input type="text" class="input-medium" placeholder="CODE">
                                    <button type="submit" class="btn"> เพิ่ม </button>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>

            </tbody>
        </table>

        <table class="table table-bordered">
            <tr>
                <th>ประมาณการระยะเวลา </th>
            </tr>
            <tr>
                <td>
                    <form class="form-horizontal">
                        <div class="control-group">
                            <label class="control-label" for="inputCountry">จังหวัด </label>
                            <div class="controls">
                                <input type="text" id="inputCountry" placeholder="Country">
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="inputPost">รหัสไปรษณีย์ </label>
                            <div class="controls">
                                <input type="text" id="inputPost" placeholder="Postcode">
                            </div>
                        </div>
                        <div class="control-group">
                            <div class="controls">
                                <button type="submit" class="btn">ประมาณการ </button>
                            </div>
                        </div>
                    </form>
                </td>
            </tr>
        </table>
        <a href="products.html" class="btn btn-large"><i class="icon-arrow-left"></i> เลือกสินค้าต่อ </a>
        <a href="login.html" class="btn btn-large pull-right">ไปต่อ <i class="icon-arrow-right"></i></a>

    </div>
@endsection
