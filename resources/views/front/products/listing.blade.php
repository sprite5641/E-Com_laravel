@extends('layouts.front_layout.front_layout')
@section('content')
    <div class="span9">
        <ul class="breadcrumb">
        <li><a href="{{ url('/')}}">หน้าหลัก</a> <span class="divider">/</span></li>
            <li class="active"><?php echo $categoryDetails['breadcrumbs'] ?></li>
        </ul>
        <h3> {{$categoryDetails['catDetails']['category_name']}} <small class="pull-right"> 
        {{count($categoryProducts) }} สินค้าในหน้านี้</small></h3>
        <hr class="soft" />
        <p>
            {{$categoryDetails['catDetails']['description']}} 
        </p>
        <hr class="soft" />
        <form name="sortProducts" id="sortProducts" class="form-horizontal span6">
        <input type="hidden" name="url" id="url" value="{{ $url}}">
            <div class="control-group">
                <label class="control-label alignL">Sort By </label>
                <select name="sort" id="sort">
                    <option disabled selected value>เลือก</option>
                    <option value="product_latest" @if(isset($_GET['sort']) && $_GET['sort']
                    =="product_latest") selected="" @endif>ล่าสุด</option>
                    <option value="product_name_a_z" @if(isset($_GET['sort']) && $_GET['sort']
                    =="product_name_a_z") selected="" @endif>ชื่อ A-Z</option>
                    <option value="product_name_z_a" @if(isset($_GET['sort']) && $_GET['sort']
                    =="product_name_z_a") selected="" @endif>ชื่อ Z - A</option>
                    <option value="price_lowest" @if(isset($_GET['sort']) && $_GET['sort']
                    =="price_lowest") selected="" @endif>ราคาจากน้อยสไปมาก</option>
                    <option value="price_highest" @if(isset($_GET['sort']) && $_GET['sort']
                    =="price_highest") selected="" @endif>ราคาจากมากไปน้อย</option>
                </select>
            </div>
        </form>

       
        <br class="clr" />
        <div class="tab-content filter_products">
            @include('front.products.ajax_product_listing')
        </div>
         <a href="compare.html" class="btn btn-large pull-right">Compair Product</a> 
        <div class="pagination">
         @if (isset($_GET['sort']) && !empty($_GET['soft']))
         {!! $categoryProducts->appends(['sort' => $_GET['sort']])->links() !!}          
         @else
         {!! $categoryProducts->links() !!}
         @endif   


        </div>
        <br class="clr" />
    </div>
@endsection
