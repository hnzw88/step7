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
        $inputs = $request->all();
        $image = $request->file('image');
        
        // 画像がアップロードされていれば、storageに保存
        if($request->hasFile('image')){
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
        }else{
            $path = null;
        }
        $inputs['path'] = $path[1];

        $request->validate([
        'product_name'=>'required|max:200',
        'company_id'=>'required|integer',
        'price'=>'required|integer',
        'stock'=>'required|integer',
        ]);

        \DB::beginTransaction();
        try {
            // 商品を登録
            $product_model = new Product();
            $product_model->createProduct($inputs);

            \DB::commit();
        } catch (\Throwable $e) {
            \DB::rollback();
            abort(500);
        }

        return redirect() -> route('index')
        ->with('flash_message', config('const.message.create'));   
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
    public function update(Request $request, Product $product)
    {
        $inputs = $request->all();
        $image = $request->file('image');

        // 画像がアップロードされていれば、storageに保存
        if ($request->hasFile('image')) {
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
        } else {
            $path = null;
        }
        $inputs['path'] = $path[1];

        $request -> validate([
            'product_name' => 'required|max:200',
            'company_id' => 'required|integer',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            ]);
    

        //商品情報を更新
        $product_model = new Product();
        $product_model->updateProduct($inputs);

        DB::beginTransaction();
        try {
            // 商品を更新
            $product = Product::find($inputs['id']);
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollback();
            abort(500);
        }

        return redirect()->route('index')
        ->with('flash_message',config('const.message.update'));   
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('index')
        ->with('flash_message',config('const.message.destroy'));   
    }


    //検索機能
    public function search(Request $request) 
    {
        $company_model = new Company();
        $companies = $company_model->getAll();

        //入力される値nameの定義
        $keyword = $request->input('keyword'); //商品名
        $company_name = $request->input('company_name'); //メーカー名

        //queryビルダ
        $query = Product::query();

        //キーワード検索機能
        if (!empty($keyword)) {
            $query->where('product_name', 'LIKE', "%{$keyword}%");
        }

        //プルダウン検索機能
        if (isset($company_name)) {
            $query->where('company_id', $company_name);
        }

        $products = $query->get();

        return view('products.index', ['companies' => $companies], compact('products', 'keyword', 'company_name'),);
    }
}