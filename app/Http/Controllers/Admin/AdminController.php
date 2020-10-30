<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use \App\Admin;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;
class AdminController extends Controller
{
    public function dashboard(){
        Session::put('page', 'dashboard');
        return view('admin.admin_dashboard');
    }

    public function settings(){
        Session::put('page', 'settings');
        $adminDetails = Admin::where('email', Auth::guard('admin')->user()->email)->first();
        return view('admin.admin_settings')->with(compact('adminDetails'));
    }

    public function login(Request $request){

        if ($request->isMethod('post')) {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;
            $rules = [
                'email' => 'required|email|max:255',
                'password' => 'required',
            ];
            $customMessages = [
                'email.required' => 'กรุณากรอกอีเมลล์',
                'email.email' => 'กรอกอีเมลล์ผิด',
                'password.required' => 'กรุณากรอกรหัสผ่าน',
            ];
            $this->validate($request, $rules, $customMessages);

             if (Auth::guard('admin')->attempt(['email' => $data['email'], 'password' => $data['password']])) {
                 return redirect('admin/dashboard');
             } else {
                 Session::flash('error_message','อีเมลล์หรือรหัสผ่านผิด');
                 return redirect()->back();
             }
        }
        return view('admin.admin_login');
    }

    public function logout(){
        Auth::logout();
        return redirect('/admin');
    }
    
    public function chkCurrentPassword(Request $request){
        $data = $request->all();
        // echo"<pre>"; print_r($data); die;
        if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
            return true;
        } else {
            return false; 
        }
    }

    public function updateCurrentPassword(Request $request){
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>"; print_r($data); die;
            if (Hash::check($data['current_pwd'], Auth::guard('admin')->user()->password)) {
                if ($data['new_pwd'] == $data['confirm_pwd']) {
                    Admin::where('id', Auth::guard('admin')->user()->id)->update(['password' => bcrypt($data['new_pwd'])]);
                    Session::flash('success_message', 'เปลี่ยนรหัสผ่านใหม่เรียบร้อย!');
                } else {
                    Session::flash('error_message', 'คุณกรอกรหัสผ่านใหม่ไม่ตรงกัน!');
                }
            } else {
                Session::flash('error_message', 'คุณกรอกรหัสผ่านเดิมผิด!');
            }
            return redirect()->back();
        }
    }

    public function updateAdminDetails(Request $request){
        Session::put('page', 'update-admin-details');
        if ($request->isMethod('post')) {
            $data = $request->all();
            //  echo "<pre>";
            // print_r($data);
            //  die;
            $rules = [
                'admin_name' => 'required|regex:/^[\pL\s\-]+$/u',
                'admin_phone' => 'required|numeric',
                'admin_image' => 'required|image',
            ];
            $customMessages = [
                'admin_name.required' => 'กรุณากรอกชื่อแอดมิน',
                'admin_name.regex' => 'กรุณากรอกชื่อแอดมินเป็นตัวอักษร',
                'admin_phone.required' => 'กรุณากรอกเบอร์โทร',
                'admin_phone.numeric' => 'กรุณากรอกเบอร์โทรเป็นตัวเลข',
                'admin_image.required' => 'กรุณาใส่รูปแอดมิน',
                'admin_image.image' => 'ไม่รองรับรูปแบบภาพ',
            ];
            $this->validate($request, $rules, $customMessages);

            if ($request->hasFile('admin_image')) {
                $image_tmp = $request->file('admin_image');
                if ($image_tmp->isValid()) {
                    $extension = $image_tmp->getClientOriginalExtension();
                    $imageName = rand(111, 99999) . '.' . $extension;
                    $imagePath = 'images/admin_images/admin_photos/' . $imageName;
                    Image::make($image_tmp)->resize(300, 400)->save($imagePath);
                } else if (!empty($data['current_admin_image'])) {
                    $imageName = $data['current_admin_image'];
                } else {
                    $imageName = "";
                }
            }

            Admin::where('email', Auth::guard('admin')->user()->email)
                ->update(['name' => $data['admin_name'], 'phone' => $data['admin_phone'], 'image' => $imageName]);
            Session::flash('success_message', 'อัพเดตรายละเอียดแอดมินเรียบร้อย!');
            return redirect()->back();
        }
        return view('admin.update_admin_details');
    }

    public function deleteAdminImage($id){
        $adminImage = Admin::select('image')->where('id', Auth::guard('admin')->user()->id)->first();
        $admin_image_path = 'images/admin_images/admin_photos/';

        if (File::exists($admin_image_path . $adminImage->image)) {
            File::delete($admin_image_path . $adminImage->image);
        }

        Admin::where('id',$id) ->update(['image' => '']);
        
        $message = 'ลบภาพสินค้าเรียบร้อย!';
        session::flash('success_message', $message);

        return redirect()->back();
    }
}
