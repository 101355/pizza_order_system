<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Storage;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //change password page
    public function changePasswordPage(){
        return view('admin.account.changePassword');
    }

    //change password
    public function changePassword(Request $request){
        /*
         1.all field must be fill
         2.new password & confirm password length must be greater than 6
         3.new password & confirm password must same
         4.client old password must be same with db password
         5.change password
        */

        $this->passwordValidationCheck($request);

        // $currentUserId = Auth::user()->id;

        $user = User::select('password')->where('id', Auth::user()->id)->first();
        $dbHashPassword = $user->password; // hash value
        if(Hash::check($request->oldPassword, $dbHashPassword)){
            $data = ['password'=> Hash::make($request->newPassword)];
            User::where('id',Auth::user()->id)->update($data);

            // Auth::logout();
            return back()->with(['changeSuccess'=>'Password Change Success...']);
        }
        return back()->with(['notMatch'=>'The Old Password not Match.Try Again!']);
    }

    // direct admin details page
    public function details(){
        return view('admin.account.details');
    }

    // direct admin profile page
    public function editProfile(){
        return view('admin.account.editProfile');
    }

    // update account
    public function update($id,Request $request){
        $this->accountValidationCheck($request);
        $data = $this->getUserData($request);

        // for image
        if($request->hasFile('image')){
            // old image name | check => delete | store
            $dbImage = User::where('id',$id)->first();
            $dbImage = $dbImage->image;

            if($dbImage != null){
                Storage::delete('public/'.$dbImage);
            }

            $fileName = uniqid() . $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public',$fileName);
            $data['image'] = $fileName;
        }

        User::where('id',$id)->update($data);
        return redirect()->route('admin#details')->with(['updateSuccess'=>'Admin Account Updated...']);
    }

    // admin list
    public function list(){
        $admin = User::when(request('key'),function($quary){
            $quary->orWhere('name','like','%'.request('key').'%')
                  ->orWhere('email','like','%'.request('key').'%')
                  ->orWhere('gender','like','%'.request('key').'%')
                  ->orWhere('phone','like','%'.request('key').'%')
                  ->orWhere('address','like','%'.request('key').'%');
        })
         ->where('role','admin')
         ->paginate(3);
         $admin->appends(request()->all());
        return view('admin.account.list',compact('admin'));
    }

    // delete account
    public function delete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'Admin Account Deleted...']);
    }

    // change role
    public function changeRole($id){
        $account = User::where('id',$id)->first();
        return view('admin.account.changeRole',compact('account'));
    }

    // change
    public function change($id,Request $request){
        $data = $this->requestUserData($request);
        User::where('id',$id)->update($data);
        return redirect()->route('admin#list');
    }

    // request user data
    private function requestUserData($request){
        return [
            'role' => $request->role
        ];
    }

    // request user data
    private function getUserData($request){
        return [
        'name' => $request->name ,
        'email' => $request->email ,
        'gender' => $request->gender ,
        'phone' => $request->phone ,
        'address' => $request->address ,
        'updated_at' => Carbon::now() ,
        ];
    }

    // account valadation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpeg,jpg|file',
            'address' => 'required',
        ])->validate();
    }

    // password validation check
    private function passwordValidationCheck($request){
        Validator::make($request->all(),[
            'oldPassword' => 'required|min:6|max:10',
            'newPassword' => 'required|min:6|max:10',
            'comfirmPassword' => 'required|min:6|max:10|same:newPassword',
        ])->validate();
    }

}
