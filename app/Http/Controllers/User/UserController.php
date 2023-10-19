<?php

namespace App\Http\Controllers\User;

use Storage;
use Carbon\Carbon;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    // user home page
    public function home(){
        $pizza = Product::orderBy('created_at','desc')->get();
        $category = Category::get();
        $cart = Cart::where('user_id',Auth::user()->id)->get();
        $history = Order::where('user_id',Auth::user()->id)->get();
        return view('user.main.home',compact('pizza','category','cart','history'));
    }

     // direct user list page
    public function userList(){
        $users = User::when(request('key'),function($quary){
                $quary->orWhere('name','like','%'.request('key').'%')
                    ->orWhere('email','like','%'.request('key').'%')
                    ->orWhere('gender','like','%'.request('key').'%')
                    ->orWhere('phone','like','%'.request('key').'%')
                    ->orWhere('address','like','%'.request('key').'%');
        })
                 ->where('role','user')->paginate(3);
        return view('admin.user.list',compact('users'));
    }    

    // change user role
    public function userChangeRole(Request $request){
        $updateSource = [
            'role' => $request->role
        ];
        User::where('id',$request->userId)->update($updateSource);
    }

    // edit user account data form admin page
    public function userAccountEdit($id){
        $account = User::where('id',$id)->first();
        return view('admin.user.edit',compact('account'));
    }

    //update user account data from admin page
    public function userAccountUpdate($id,Request $request){
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
        return redirect()->route('admin#userList')->with(['updateSuccess'=>'Admin Account Updated...']);
        }

    // delete user account from admin page
    public function userAccountDelete($id){
        User::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'UserAccount Deleted']);
    }

    // direct Contact List Page
    public function contactList(){
        $contact = Contact::orderby('created_at','desc')->paginate(3);
        $contact->appends(request()->all());
        return view('admin.user.contactList',compact('contact'));
    }

    // delete Contact List
    public function contactDelete($id){
        Contact::where('id',$id)->delete();
        return back()->with(['deleteSuccess'=>'UserAccount Deleted']);
    }

    // direct Contact Message Page
    public function contactMessage($id){
        $message = Contact::where('id',$id)->select('name','email','phone','message')->get();
        // dd($message->toArray());
        return view('admin.user.contactMessage',compact('message'));
    }

    // change password page
    public function changePasswordPage(){
        return view('user.password.changePassword');
    }

    // change password
    public function changePassword(Request $request){
        $this->passwordValidationCheck($request);
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

    // user account changePage
        public function accountChangePage(){
            return view('user.profile.account');
        }

         // filter pizza
        public function filter($categoryId){
            
            $pizza = Product::where('category_id',$categoryId)->orderBy('created_at','desc')->get();
            $category = Category::get();
            $cart = Cart::where('user_id',Auth::user()->id)->get();
            $history = Order::where('user_id',Auth::user()->id)->get();
            return view('user.main.home',compact('pizza','category','cart','history'));
        }

    // user account change
        public function accountChange($id,Request $request){
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
        return back()->with(['updateSuccess'=>'Admin Account Updated...']);
        }

        // direct pizza details
        public function pizzaDetail($pizzaId){
            $pizza = Product::where('id',$pizzaId)->first();
            $pizzaList = Product::get();
            return view('user.main.detail',compact('pizza','pizzaList'));
        }

        // cart list
        public function cartList(){
            $cartList = Cart::select('carts.*','products.name as pizza_name','products.price as pizza_price','products.image as product_image')
                              ->leftJoin('products','products.id','carts.product_id')
                              ->where('user_id',Auth::user()->id)
                              ->get();
            $totalPrice = 0;

            foreach($cartList as $c){
                $totalPrice += $c->pizza_price*$c->qty;
            }
            return view('user.main.cart',compact('cartList','totalPrice'));
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

    //direct history page
    public function history(){
        $order = Order::where('user_id',Auth::user()->id)->orderBy('created_at','desc')->paginate('6');
        return view('user.main.history',compact('order'));

    }

    // account valadation check
    private function accountValidationCheck($request){
        Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required',
            'phone' => 'required',
            'image' => 'mimes:png,jpeg,jpg,webp|file',
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
