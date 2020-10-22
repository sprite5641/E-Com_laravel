<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Product;
use App\ProductsAttribute;
use App\ProductsImage;
use App\Section;
use App\Brand;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ProductsController extends Controller
{
    public function products()
    {
        Session::put('page', 'products');
        $products = Product::with(['category' => function ($query) {
            $query->select('id', 'category_name');
        }, 'section' => function ($query) {
            $query->select('id', 'name');
        }])->get();
          $products = json_decode(json_encode($products));
         // echo "<pre>"; print_r($products); die;
        return view('admin.products.products')->with(compact('products'));
    }

    public function updateProductStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Product::where('id', $data['product_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'product_id' => $data['product_id']]);
        }
    }

    public function deleteProduct($id)
    {
        $productImage = Product::select('main_image')->where('id', $id)->first();
      
        Product::where('id', $id)->delete();
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';
        if (File::exists($small_image_path . $productImage->main_image)) {
            File::delete($small_image_path . $productImage->main_image);
        }
        if (File::exists($medium_image_path . $productImage->main_image)) {
            File::delete($medium_image_path . $productImage->main_image);
        }
        if (File::exists($large_image_path . $productImage->main_image)) {
            File::delete($large_image_path . $productImage->main_image);
        }
        $message = 'ลบสินค้าเรียบร้อย!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function addEditProduct(Request $request, $id = null)
    {
        if ($id == "") {
            $title = "เพิ่มสินค้า";
            $product = new Product;
            $productdata = array();
            $message = "เพิ่มสินค้าเรียบร้อย!";
        } else {
            $title = "แก้ไขสินค้า";
            $productdata = Product::find($id);
            $productdata = json_decode(json_encode($productdata), true);
            // echo "<pre>"; print_r($productdata); die;
            $product = Product::find($id);
            $message = "อัพเดตสินค้าเรียบร้อย!";
        }

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            // product validations
            $rules = [
                'category_id' => 'required',
                'brand_id' => 'required',
                'product_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'product_code' => 'required|regex:/^[\w-]*$/',
                'product_price' => 'required|numeric',
                'product_color' => 'required|regex:/^[\pL\s\-]+$/u',

            ];
            $customMessages = [
                'category_id.required' => 'กรุณาเลือกประเภทสินค้า',
                'brand_id.required' => 'กรุณาเลือกยี่ห้อสินค้า',
                'product_name.required' => 'กรุณากรอกชื่อสินค้า',
                'product_name.regex' => 'กรุณากรอกชื่อสินค้าเป็นตัวอักษร',
                'product_code.required' => 'กรุณากรอกโค้ดสินค้า',
                'product_code.regex' => 'รูปแบบโค้ดสินค้าผิด',
                'product_price.required' => 'กรุณากรอกราคาสินค้า',
                'product_price.numeric' => 'กรุณากรอกราคาสินค้าเป็นตัวเลข',
                'product_color.required' => 'กรุณากรอกสีสินค้า',
                'product_color.regex' => 'กรุณากรอกสีสินค้าเป็นตัวอักษร',
            ];
            $this->validate($request, $rules, $customMessages);

           /*if (empty($data['product_discount'])) {
                $product_discount = 0;
            } else {
                $product_discount = $data['product_discount'];
            }

            if (empty($data['product_weight'])) {
                $product_weight = 0;
            } else {
                $product_weight = $data['product_weight'];
            }

            if (empty($data['wash_care'])) {
                $wash_care = "";
            } else {
                $wash_care = $data['wash_care'];
            }

            if (empty($data['fabric'])) {
                $fabric = "";
            } else {
                $fabric = $data['fabric'];
            }

            if (empty($data['pattern'])) {
                $pattern = "";
            } else {
                $pattern = $data['pattern'];
            }

            if (empty($data['sleeve'])) {
                $sleeve = "";
            } else {
                $sleeve = $data['sleeve'];
            }

            if (empty($data['fit'])) {
                $fit = "";
            } else {
                $fit = $data['fit'];
            }

            if (empty($data['occasion'])) {
                $occasion = "";
            } else {
                $occasion = $data['occasion'];
            }

            if (empty($data['meta_title'])) {
                $meta_title = "";
            } else {
                $meta_title = $data['meta_title'];
            }

            if (empty($data['meta_keywords'])) {
                $meta_keywords = "";
            } else {
                $meta_keywords = $data['meta_keywords'];
            }

            if (empty($data['meta_description'])) {
                $meta_description = "";
            } else {
                $meta_description = $data['meta_description'];
            }

            if (empty($data['description'])) {
                $description = "";
            } else {
                $description = $data['description'];
            }*/

            

            //upload product image

            if ($request->hasFile('main_image')) {
                $image_tmp = $request->file('main_image');
                if ($image_tmp->isValid()) {
                    //  $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = 'Product' . '-' . rand(111, 99999) . '.' . $extension;
                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;
                    Image::make($image_tmp)->save($large_image_path);
                    Image::make($image_tmp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260, 300)->save($small_image_path);
                    $product->main_image = $imageName;
                }
            }

           

            // save Product details
            $categoryDetails = Category::find($data['category_id']);
            $product->section_id = $categoryDetails['section_id'];
            $product->category_id = $data['category_id'];
            $product->brand_id = $data['brand_id'];
            $product->product_name = $data['product_name'];
            $product->product_code = $data['product_code'];
            $product->product_color = $data['product_color'];
            $product->product_price = $data['product_price'];
            $product->product_discount = $data['product_discount'];
            $product->product_weight = $data['product_weight'];
            $product->description = $data['description'];
            $product->fabric = $data['fabric'];
            $product->pattern = $data['pattern'];
            $product->sleeve = $data['sleeve'];
            $product->fit = $data['fit'];
            $product->occasion = $data['occasion'];
            if (!empty($data['is_featured'])) {
                $product->is_featured = $data['is_featured'];
            }else{
                $product->is_featured = "No";
            }
            $product->status = 1;
            $product->save();

            session::flash('success_message', $message);
            return redirect('admin/products');
        }

        $productFilters = Product::productFilters();
        $fabricArray = $productFilters['fabricArray'];
        $sleeveArray = $productFilters['sleeveArray'];
        $patternArray = $productFilters['patternArray'];
        $fitArray = $productFilters['fitArray'];
        $occasionArray = $productFilters['occasionArray'];


        $categories = Section::with('categories')->get();
        $categories = json_decode(json_encode($categories),true);
        // echo "<pre>"; print_r($categories); die;

        //get all brand
        $brands = Brand::where('status',1)->get();
        $brands = json_decode(json_encode($brands),true);
        return view('admin.products.add_edit_product')->with(compact(
            'title',
            'fabricArray',
            'sleeveArray',
            'patternArray',
            'fitArray',
            'occasionArray',
            'categories',
            'productdata',
            'brands'
        ));
    }

    public function deteleProductImage($id)
    {
        $productImage = Product::select('main_image')->where('id', $id)->first();
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';
        if (File::exists($small_image_path . $productImage->main_image)) {
            File::delete($small_image_path . $productImage->main_image);
        }
        if (File::exists($medium_image_path . $productImage->main_image)) {
            File::delete($medium_image_path . $productImage->main_image);
        }
        if (File::exists($large_image_path . $productImage->main_image)) {
            File::delete($large_image_path . $productImage->main_image);
        }

        Product::where('id', $id)->update(['main_image' => '']);
        $message = 'ลบรูปภาพสินค้าเรียบร้อยแล้ว!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function addAttributes(Request $request, $id)
    {

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['sku'] as $key => $value) {
                if (!empty($value)) {

                    $attrCountSKU = ProductsAttribute::where('sku', $value)->count();
                    if ($attrCountSKU > 0) {

                        $message = 'รหัสสินค้าซ้ำ!';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attrCountSize = ProductsAttribute::where(['size' => $id, 'size' => $data['size'][$key]])->count();
                    if ($attrCountSKU > 0) {

                        $message = 'ไซส์สินค้าซ้ำ!';
                        session::flash('error_message', $message);
                        return redirect()->back();
                    }

                    $attribute = new ProductsAttribute;
                    $attribute->product_id = $id;
                    $attribute->sku = $value;
                    $attribute->size = $data['size'][$key];
                    $attribute->price = $data['price'][$key];
                    $attribute->stock = $data['stock'][$key];
                    $attribute->status = 1;
                    $attribute->save();
                }
            }
            $success_message = 'เพิ่มรายละเอียดสินค้าเรียบร้อย!';
            session::flash('success_message', $success_message);
            return redirect()->back();
        }



        $productdata = Product::select('id', 'product_name', 'product_code', 'product_color', 'main_image',)
            ->with('attributes')->find($id);
        $productdata = json_decode(json_encode($productdata), true);

        // echo "<pre>"; print_r($productdata); die;
        $title = "Product Attributes";
        return view('admin.products.add_attributes')->with(compact('productdata', 'title'));
    }

    public function editAttributes(Request $request, $id)
    {
        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            foreach ($data['attrId'] as $key => $attr) {
                if (!empty($attr)) {
                    ProductsAttribute::where(['id' => $data['attrId'][$key]])->update(['price' =>
                    $data['price'][$key], 'stock' => $data['stock'][$key]]);
                }
                $message = 'อัพเดตรายละเอียดสินค้าเรียบร้อย!';
                session::flash('success_message', $message);

                return redirect()->back();
            }
        }
    }

    public function updateAttributeStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsAttribute::where('id', $data['attribute_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'attribute_id' => $data['attribute_id']]);
        }
    }

    public function deleteAttribute($id)
    {
        ProductsAttribute::where('id', $id)->delete();

        $message = 'ลบรายละเอียดสินค้าเรียบร้อย!';
        session::flash('success_message', $message);

        return redirect()->back();
    }

    public function addImages(Request $request, $id)
    {
        if($request->isMethod('post')){
            if ($request->hasFile('images')) {
                $images = $request->file('images');
               // echo "<pre>"; print_r($images); die;
                foreach ($images as $key => $image) {
                    $productImage = new ProductsImage;
                    $image_tmp = Image::make($image);
                   // $originalName = $image->getClientOriginalName();die;
                    $extension = $image->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . time() . "." . $extension;

                    $large_image_path = 'images/product_images/large/' . $imageName;
                    $medium_image_path = 'images/product_images/medium/' . $imageName;
                    $small_image_path = 'images/product_images/small/' . $imageName;

                    Image::make($image_tmp)->save($large_image_path);

                    Image::make($image_tmp)->resize(520, 600)->save($medium_image_path);
                    Image::make($image_tmp)->resize(260, 300)->save($small_image_path);

                    $productImage->image = $imageName;
                    $productImage->product_id = $id;
                    $productImage->status = 1;
                    $productImage->save();
            }
            $message = 'เพิ่มรูปสินค้าเรียบร้อย!';
            session::flash('success_message', $message);
            return redirect()->back();
        }
        }

        $productdata = Product::with('images')->select('id','product_name','product_code','product_color','main_image')->find($id);
        $productdata = json_decode(json_encode($productdata),true);
        //echo "<pre>"; print_r($productdata);die;
        $title = "Product Images";
        return view('admin.products.add_images')->with(compact('productdata', 'title'));

    }

    public function updateImageStatus(Request $request)
    {
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            ProductsImage::where('id', $data['image_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'image_id' => $data['image_id']]);
        }
    }

    public function deleteImage($id)
    {
        $productImage = ProductsImage::select('image')->where('id', $id)->first();
        $small_image_path = 'images/product_images/small/';
        $medium_image_path = 'images/product_images/medium/';
        $large_image_path = 'images/product_images/large/';
        if (File::exists($small_image_path . $productImage->image)) {
            File::delete($small_image_path . $productImage->image);
        }
        if (File::exists($medium_image_path . $productImage->image)) {
            File::delete($medium_image_path . $productImage->image);
        }
        if (File::exists($large_image_path . $productImage->image)) {
            File::delete($large_image_path . $productImage->image);
        }

        ProductsImage::where('id', $id)->delete();
        $message = 'ลบรูปสินค้าเรียบร้อย!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
