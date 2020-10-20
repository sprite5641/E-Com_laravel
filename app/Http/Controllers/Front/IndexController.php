<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;

class IndexController extends Controller
{
    public function Index(){
        // get featured item
        $featuredItemsCount = Product::where('is_featured','Yes')->where('status',1)->count();
        $featuredItems = Product::where('is_featured','Yes')->where('status',1)->get()->toArray();
        $featuredItemChunk = array_chunk($featuredItems,4);

        //get new product
        $newProducts = Product::orderBy('id','Desc')->where('status',1)->limit(6)->get()->toArray();
        //echo "<pre>"; print_r($newProducts);die;
        $page_name = "Index";
        return view('front.index')->with(compact('page_name','featuredItemChunk','featuredItemsCount','newProducts'));
    }
}
