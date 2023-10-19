<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    // get product list
    public function productList(){
        $products = Product::get();
        return response()->json($products, 200);
    }

    // get category list
    public function categoryList(){
        $category = Category::get();
        return response()->json($category, 200);
    }

    // create category
    public function categoryCreate(Request $request){
        $data = [
            'name' => $request->name,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
        $response = Category::create($data);
        return response()->json($response,200);
    }
    
    // create contact
    public function createContact(Request $request){
        $data = $this->getContactData($request);        
        Contact::create($data);
        $contact = Contact::get($data);
        return response()->json($contact, 200);
    }

    private function getContactData($request){
        return  [
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->description,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }

    // delete category
    public function deleteCategory($id){
        $data = Category::where('id',$id)->first();
        if(isset($data)){
            Category::where('id',$id)->delete();
            return response()->json(['status' => true ,'message' => 'delete success','deleteData' => $data], 200);
        }
        return response()->json(['status' => false , 'message' => 'there is no category...'], 200);
    }

    // category detail
    public function categoryDetail($id){
        $data = Category::where('id',$id)->first();
        if(isset($data)){
            
            return response()->json(['status' => true ,'category' => $data], 200);
        }
        return response()->json(['status' => false , 'category' => 'there is no category...'], 500);
    }

    // category update
    public function categoryUpdate(Request $request){
        $categoryId = $request->category_id;
        $dbSource = Category::where('id',$categoryId)->first();

        if(isset($dbSource)){
            $data = $this->getCategoryData($request);
            Category::where('id',$categoryId)->update($data);
            $response = Category::where('id',$categoryId)->first();
            return response()->json(['status' => true, 'message' => 'category update success...','category' => $response]);    
        }
        return response()->json(['status' => false , 'message' => 'there is no category for update...'], 500);
        
        
    }

    // get category data
    private function getCategoryData($request){
        return [
            'name' => $request->category_name,                        
            'updated_at' => Carbon::now()
        ];
    }
}
