<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use App\Section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
class CategoryController extends Controller
{
    public function categories(){
        Session::put('page','categories');
        $categories = Category::with(['section','parentcategory'])->get();
        // $categories = json_decode(json_encode($categories));
        // echo "<pre>"; print_r($categories); die;
        return view('admin.categories.categories')->with(compact('categories'));
    }

    public function updateCategoryStatus(Request $request){
        if($request->ajax()){
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if($data['status']=="Active"){
                $status = 0;
            }else{
                $status = 1;
            }
            Category::where('id',$data['category_id'])->update(['status'=>$status]);
            return response()->json(['status'=>$status,'category_id'=>$data['category_id']]);
        }
    }

    public function addEditCategory(Request $request, $id=null){
        if($id==""){
            $title = "Add Category";
            $category = new Category;
            $categorydata = array();
            $getCategories = array();
            $message = "เพิ่มชนิดสินค้าเรียบร้อยแล้ว!";
        }else{
            $title = "Edit Category";
            $categorydata = Category::where('id',$id)->first();
            $categorydata = json_decode(json_encode($categorydata),true);
            // echo "<pre>"; print_r($categorydata); die;
            $getCategories = Category::with('subcategories')->where(['parent_id'=>0,'section_id'=>$categorydata['section_id']])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            //  echo "<pre>"; print_r($getCategories); die;
            $category = Category::find($id);
            $message = "Category updated successfully!";
        }
        if($request->isMethod('post')){
            $data = $request->all();
           // echo "<pre>"; print_r($data); die;
            $rules = [
                'category_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'section_id' => 'required',
                'category_image' => 'image',
                'url' => 'required',
            ];
            $customMessages = [
                'category_name.required' => 'กรุณากรอกชื่อประเภทสินค้า',
                'category_name.regex' => 'กรุณากรอกชื่อประเภทสินค้าเป็นตัวอักษร',
                'section_id.required' => 'กรุณาเลือกเพศของประเภทสินค้า',
                'category_image.image' => 'คุณใส่รูปผิดประเภท',
                'url.required' => 'กรุณากรอกURLของสินค้า',
            ];
            $this->validate($request, $rules, $customMessages);
            
            if ($request->hasFile('category_image')) {
                $image_tmp = $request->file('category_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/category_images/' . $imageName;
                    Image::make($image_tmp)->save($imagePath);
                    $category->category_image = $imageName;
                }
            }
           
            if(empty($data['category_discount'])){
                $data['category_discount']="0";
            }
            if(empty($data['description'])){
                $data['description']="";
            }
            if(empty($data['url'])){
                $data['url']="";
            }

            
          //   echo "<pre>"; print_r($data); die;
          $category->parent_id = $data['parent_id'];
          $category->section_id = $data['section_id'];
          $category->category_name = $data['category_name'];
          $category->category_discount = $data['category_discount'];
          $category->url = $data['url'];
          $category->description = $data['description'];
          $category->status = 1;
          $category->save();

          session::flash('success_message',$message);
          return redirect('admin/categories');
        }
        $getSections = Section::get();
        return view('admin.categories.add_edit_category')->with(compact('title','getSections','categorydata','getCategories'));
    }

    public function appendCategoryLevel(Request $request){
        if($request->ajax()){
            $data = $request->all();
           // echo "<pre>"; print_r($data); die;
            $getCategories = Category::with('subcategories')->where(['section_id'=>$data['section_id'],'parent_id'=>0,
            'status'=>1])->get();
            $getCategories = json_decode(json_encode($getCategories),true);
            return view('admin.categories.append_categories_level')->with(compact('getCategories'));
        }
    }

    public function deteleCategoryImage($id){
        $categoryImage = Category::select('category_image')->where('id',$id)->first();
        $category_image_path = 'images/category_images/';
        if(file_exists($category_image_path.$categoryImage->category_image)){
            unlink($category_image_path.$categoryImage->category_image);
        }

        Category::where('id',$id)->update(['category_image'=>'']);
        $message ='ลบรูปประเภทสินค้าเรียบร้อย!';
        session::flash('success_message',$message);
        
        return redirect()->back();
    }

    public function deteleCategory($id){
        Category::where('id',$id)->delete();

        $message ='ลบประเภทสินค้าเรียบร้อย!';
        session::flash('success_message',$message);
        
        return redirect()->back();
    }
}
