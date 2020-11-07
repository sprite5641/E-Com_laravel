<?php use App\Product; ?>
@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <div class="well well-small">
            <h4>สินค้าแนะนำ <small class="pull-right">จำนวน {{ $featuredItemsCount }} รายการ</small></h4>
            <div class="row-fluid">
                <div id="featured" @if($featuredItemsCount > 4) class="carousel slide" @endif>
                    <div class="carousel-inner">
                        @foreach ($featuredItemChunk as $key => $featuredItem)
                        <div class="item @if($key==1) active @endif">
                            <ul class="thumbnails">
                                @foreach ($featuredItem as $item)
                                <li class="span3">
                                    <div class="thumbnail">
                                        <i class="tag"></i>
                                        <a href="{{url('product/' .$item['id'])}}">
                                            <?php $product_image_path = 'images/product_images/small/' .
                                            $item['main_image']; ?>
                                            @if (!empty($item['main_image']) && file_exists($product_image_path))
                                                <img style="width: 100px;"
                                                    src="{{ asset($product_image_path) }}"
                                                    alt="">
                                            @else
                                                <img style="width: 100px;"
                                                    src="{{ asset('images/product_images/small/no-image.png') }}" alt="">
                                            @endif
                                            <div class="caption">
                                                <h5>{{ $item['product_name'] }}</h5>
                                                <?php $discounted_price = Product::getDiscountedPrice($item['id']); ?>
                                                <h4><a class="btn" href="{{url('product/' .$item['id'])}}">เพิ่มเติม</a> <span
                                                        class="pull-right" style="font-size: 12px;">
                                                        @if($discounted_price>0)
                                                        <del>ร{{ $item['product_price'] }}บ.</del>
                                                        <font color="red">ส่วนลดสินค้า: {{$discounted_price}}</font>
                                                        @else
                                                        ร{{ $item['product_price'] }}บ.
                                                        @endif
                                                    </span></h4>
                                            </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    @endforeach
                    @if ( $featuredItemsCount > 4)
                     <a class="left carousel-control" href="#featured" data-slide="prev">‹</a>
                     <a class="right carousel-control" href="#featured" data-slide="next">›</a> 
                @endif
                </div>
            </div>
        </div>
    </div>
    <h4>สินค้าล่าสุด </h4>
    <ul class="thumbnails">
        @foreach ($newProducts as $product)
            <li class="span3">
                <div class="thumbnail">
                    <a href="{{ url('product/' . $product['id']) }}">
                        <?php $product_image_path = 'images/product_images/small/' . $product['main_image'];
                        ?>
                        @if (!empty($product['main_image']) && file_exists($product_image_path))
                            <img style="width: 160px;"
                                src="{{ asset('images/product_images/small/' . $product['main_image']) }}" alt="">
                        @else
                            <img style="width: 160px;" src="{{ asset('images/product_images/small/no-image.png') }}" alt="">
                        @endif
                    </a>
                    <div class="caption">
                        <h5>{{ $product['product_name'] }}</h5>
                        <p>
                            {{ $product['product_code'] }} ({{ $product['product_color'] }})
                        </p>
                        <?php $discounted_price = Product::getDiscountedPrice($product['id']); ?>
                        <h4 style="text-align:center">
                            {{-- <a class="btn" href="{{ url('product/' . $product['id']) }}"> 
                                <i class="icon-zoom-in"></i></a> --}}
                            <a class="btn" href="#">Add to <i
                                    class="icon-shopping-cart"></i></a> <a class="btn btn-primary" href="#">
                                       @if($discounted_price>0)
                                        <del>ราคา {{ $product['product_price'] }} บ.</del>
                                        
                                        @else
                                        ราคา {{ $product['product_price'] }} บ.
                                        @endif
                                    </a></h4>
                                    @if($discounted_price>0)
                                  <h4><font color="red">ส่วนลดสินค้า: {{$discounted_price}}</font></h4>
                                    @endif
                    </div>
                </div>
            </li>
        @endforeach
    </ul>
    </div>
@endsection
