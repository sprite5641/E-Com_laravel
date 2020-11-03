<?php

namespace App\Http\Controllers\Front;

use App\Cart;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use App\Product;
use App\ProductsAttribute;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class ProductsController extends Controller
{
    public function listing(Request $request){
        Paginator::useBootstrap();
        if ($request->ajax()) {

            $data = $request->all();
            //echo "<pre>"; print_r($data); die;
            $url = $data['url'];
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1);

                //if fabric filter is select
                if (isset($data['fabric']) && !empty($data['fabric'])) {
                    $categoryProducts->whereIn('products.fabric', $data['fabric']);
                }

                if (isset($data['sleeve']) && !empty($data['sleeve'])) {
                    $categoryProducts->whereIn('products.sleeve', $data['sleeve']);
                }

                if (isset($data['pattern']) && !empty($data['pattern'])) {
                    $categoryProducts->whereIn('products.pattern', $data['pattern']);
                }

                if (isset($data['fit']) && !empty($data['fit'])) {
                    $categoryProducts->whereIn('products.fit', $data['fit']);
                }

                if (isset($data['occasion']) && !empty($data['occasion'])) {
                    $categoryProducts->whereIn('products.occasion', $data['occasion']);
                }

                //if sort option select by user
                if (isset($data['sort']) && !empty($data['sort'])) {
                    if ($data['sort'] == "product_latest") {
                        $categoryProducts->orderBy('id', 'Desc');
                    } else if ($data['sort'] == "product_name_a_z") {
                        $categoryProducts->orderBy('product_name', 'Asc');
                    } else if ($data['sort'] == "product_name_z_a") {
                        $categoryProducts->orderBy('product_name', 'Desc');
                    } else if ($data['sort'] == "price_lowest") {
                        $categoryProducts->orderBy('product_price', 'Asc');
                    } else if ($data['sort'] == "price_highest") {
                        $categoryProducts->orderBy('product_price', 'Desc');
                    }
                } else {
                    $categoryProducts->orderBy('id', 'Desc');
                }

                $categoryProducts = $categoryProducts->paginate(3);
                //echo "<pre>";print_r($categoryProducts); die;
                return view('front.products.ajax_product_listing')->with(compact(
                    'categoryDetails',
                    'categoryProducts',
                    'url'
                ));
            } else {
                abort(404);
            }
        } else {
            $url = Route::getFacadeRoot()->current()->uri();
            $categoryCount = Category::where(['url' => $url, 'status' => 1])->count();
            if ($categoryCount > 0) {
                $categoryDetails = Category::catDetails($url);
                $categoryProducts = Product::with('brand')->whereIn('category_id', $categoryDetails['catIds'])
                    ->where('status', 1);
                $categoryProducts = $categoryProducts->paginate(3);
                //echo "<pre>";print_r($categoryProducts); die;


                $productFilters = Product::productFilters();
                $fabricArray = $productFilters['fabricArray'];
                $sleeveArray = $productFilters['sleeveArray'];
                $patternArray = $productFilters['patternArray'];
                $fitArray = $productFilters['fitArray'];
                $occasionArray = $productFilters['occasionArray'];

                $page_name = "listing";
                return view('front.products.listing')->with(compact(
                    'categoryDetails',
                    'categoryProducts',
                    'url',
                    'fabricArray',
                    'sleeveArray',
                    'patternArray',
                    'fitArray',
                    'occasionArray',
                    'page_name'
                ));
            } else {
                abort(404);
            }
        }
    }

    public function detail($id){
        $productDetails = Product::with(['category', 'brand', 'attributes' => function ($query) {
            $query->where('status', 1);
        }, 'images' => function ($query) {
            $query->where('status', 1);
        }])->find($id)->toArray();
        // dd($productDetails);die;
        $total_stock = ProductsAttribute::where('product_id', $id)->where('status', 1)->sum('stock');
        $relatedProducts = Product::where('category_id', $productDetails['category']['id'])
            ->where('id', '!=', $id)->limit(3)->inRandomOrder()->get()->toArray();
        // dd($relatedProducts);die;
        return view('front.products.detail')->with(compact('productDetails', 'total_stock', 'relatedProducts'));
    }

    public function getProductPrice(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;
            $getDiscountesAttrPrice = Product::getDiscountesAttrPrice($data['product_id'],$data['size']);
            return $getDiscountesAttrPrice;
        }
    }

    public function addtocart(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data);die;

            //เช็คสินค้าในสต็อกว่าพอต่อการสั่งซื้อหรือไม่
            $getProductStock = ProductsAttribute::where([
                'product_id' => $data['product_id'],
                'size' => $data['size']
            ])->first()->toArray();

            if ($getProductStock['stock'] < $data['quantity']) {
                $message = "สินค้ามีไม่เพียงพอ!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            //สร้างsession id ถ้าไม่มี
            $session_id = Session::get('session_id');
            if (empty($session_id)) {
                $session_id = Session::getId();
                Session::put('session_id', $session_id);
            }

            //เช็คสินค้าซ้ำ
            if (Auth::check()) {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'user_id' => Auth::user()->id])->count();
            } else {
                $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size'], 'session_id' => Session::get('session_id')])->count();
            }

            $countProducts = Cart::where(['product_id' => $data['product_id'], 'size' => $data['size']])->count();

            if ($countProducts > 0) {
                $message = "มีสินค้าอยู่ในตะกร้าแล้ว!";
                session::flash('error_message', $message);
                return redirect()->back();
            }

            //บันทึกสินค้าลง Cart

            $cart = new Cart;
            $cart->session_id = $session_id;
            $cart->product_id = $data['product_id'];
            $cart->product_id = $data['product_id'];
            $cart->size = $data['size'];
            $cart->quantity = $data['quantity'];
            $cart->user_id = 0;
            $cart->save();

            $message = "เพิ่มสินค้าในตระกร้าเรียบร้อย!";
            session::flash('success_massage', $message);
            return redirect()->back();
        }
    }

    public function cart(){
        $userCartItems = Cart::userCartItems();
       // echo "<pre>"; print_r($userCartItems);die;
        return view('front.products.cart')->with(compact('userCartItems'));
    }
}
