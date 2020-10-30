<?php

namespace App\Http\Controllers\Admin;

use App\Banner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
class BannersController extends Controller
{
    public function banners(){
        Session::put('page','banners');
        $banners = Banner::get()->toArray();
        //dd($banners);die;
        return view('admin.banners.banners')->with(compact('banners'));
    }
    
    public function addEditBanner($id=null,Request $request){
        if($id == ""){
            $banner = new Banner;
            $title = "เพิ่มรูปแบนเนอร์";
            $message = "เพิ่มรูปแบนเนอร์เรียบร้อย";
        }else{
            $banner = Banner::find($id);
            $title = "แก้ไขรูปแบนเนอร์";
            $message = "แก้ไขรูปแบนเนอร์เรียบร้อย";
        }
        if($request->isMethod('post')){
            $data = $request->all();
            $rules = [
                'image' => 'required',
                'title' => 'required',
            ];
            $customMessages = [
                'image.required' => 'กรุณาเพิ่มรูปแบนเนอร์',
                'title.required' => 'กรุณาเพิ่มหัวข้อแบนเนอร์',
            ];
            $this->validate($request, $rules, $customMessages);
            //echo "<pre>"; print_r($data); die;

            if (empty($data['link'])) {
                $link = "";
            } else {
                $link = $data['link'];
            }
            if (empty($data['alt'])) {
                $alt = "";
            } else {
                $alt = $data['alt'];
            }

            $banner->link = $link;
            $banner->title = $data['title'];
            $banner->alt = $alt;
            $banner->status = 1;
            if ($request->hasFile('image')) {
                $image_tmp = $request->file('image');
                if ($image_tmp->isValid()) {
                    //  $image_name = $image_tmp->getClientOriginalName();
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = 'Banner' . '-' . rand(111, 99999) . '.' . $extension;
                    $banner_image_path = 'images/banner_images/' . $imageName;
                    Image::make($image_tmp)->resize(1170,480)->save($banner_image_path);
                    
                    $banner->image = $imageName;
                }
               
            }
            $banner->save();
            session::flash('success_message',$message);
            return redirect('admin/banners');
        }

        return view('admin.banners.add_edit_banner')->with(compact('title','banner'));
    }

    public function updateBannerStatus(Request $request){
        if ($request->ajax()) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            if ($data['status'] == "Active") {
                $status = 0;
            } else {
                $status = 1;
            }
            Banner::where('id', $data['banner_id'])->update(['status' => $status]);
            return response()->json(['status' => $status, 'banner_id' => $data['banner_id']]);
        }
    }

    public function deleteBanner($id){
        $bannerImage = Banner::where('id', $id)->first();
        
        $banner_image_path = 'images/banner_images/';

        if (File::exists($banner_image_path . $bannerImage->image)) {
            File::delete($banner_image_path . $bannerImage->image);
        }
        Banner::where('id', $id)->delete();

        $message = 'ลบรูปแบนเนอร์เรียบร้อย!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
 