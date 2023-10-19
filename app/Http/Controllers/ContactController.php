<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    // direct contact page
    public function contactPage(){
        return view('user.contact.contact');
    }
    public function contactCreate(Request $request){
        $this->contactValidationCheck($request,'contactCreate');
        $data = $this->requestContactData($request);
        Contact::create($data);
        return redirect()->route('user#home');
    }
    

    // request product info
    private function requestContactData($request){
        return [
            'name' => $request->name ,
            'email' => $request->email ,
            'phone' => $request->phone ,
            'message' => $request->message,
        ];
    }

    // product validation check
    private function contactValidationCheck($request,$action){
        $validationRule = [
            'name' => 'required' ,
            'email' => 'required' ,
            'phone' => 'required' ,
            'message' => 'required'
        ];
        Validator::make($request->all(),$validationRule)->validate();
    }
}
