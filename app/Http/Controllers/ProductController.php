<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Product;
use App\Models\Company;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ProductRegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $company_model = new Company();
        $companies = $company_model->getAll();

        //商品情報一覧画面表示
        $products = Product::with('company')->get();
        
        return view('products.index', ['products' => $products, 'companies' => $companies,]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $company_model = new Company();
        $companies = $company_model->getAll();

        return view('products.create')
        ->with('companies',$companies);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $model = NEW product;
        DB::beginTransaction();
        try{
            $image = $request->file('image');
            if($image){
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $img_path = 'storage/images/'.$filename;
            }else{
                $img_path = null;
            }

            $companies = DB::table('companies')->get();

            $products = $model->createProduct($request, $img_path);

            DB::commit();
            return redirect() -> route('index')
            ->with('flash_message', config('const.message.create'));   
         }catch(Exception $e) {
            DB::rollBack();
         }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        $company_model = new Company();
        $companies = $company_model->getAll();

        return view('products.show', compact('product'))
        ->with('page_id', request()->page_id)
        ->with('companies', $companies);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $company_model = new Company();
        $companies = $company_model->getAll();

        return view('products.edit', compact('product'))
        -> with('companies', $companies);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id=$request->input('id');
        $model = New product;
        DB::beginTransaction();
        try{
            $image = $request->file('image');
            if($image){
                $filename = $image->getClientOriginalName();
                $image->storeAs('public/images', $filename);
                $img_path = 'storage/images/'.$filename;
                $model->updateProduct($request, $img_path, $id);
            }else{
                $model->updateProductNoImg($request, $id);
            }

            DB::commit();
            return redirect() -> route('index')
            ->with('flash_message', config('const.message.update'));   
         }catch(Exception $e) {
            DB::rollBack();
         }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    { 
        $product = Product::find($id);
        $product->delete();
        // $product::destroy($request->id);
        // return response()->json(['result'=> '成功']);
    }

    //検索機能
    public function search(Request $request) 
    {
            $company_model = new Company();
            $companies = $company_model->getAll();
        
            $keyword = $request->input('keyword');
            $company_name = $request->input('company_id');
            $max_price = $request->input('max_price');
            $min_price = $request->input('min_price');
            $max_stock = $request->input('max_stock');
            $min_stock = $request->input('min_stock');
        
            $query = Product::query();
        
            $product_model = new Product();
            $products = $product_model->searchProduct($keyword, $company_name, $max_price, $min_price, $max_stock, $min_stock);
            return view('products.index', compact('companies', 'products', 'keyword', 'company_name', 'max_price', 'min_price'));
        }
}