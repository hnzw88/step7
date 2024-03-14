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
            // $product_model->searchProduct($keyword, $query);
            // $product_model->searchCompany($company_name, $query);

            if (!empty($keyword)) {
                $query->where('product_name', 'LIKE', "%{$keyword}%");
            }    

            if (isset($company_name)) {
                $query->where('company_id', $company_name);
            }    
        
            // 上限価格の条件追加
            if ($max_price) {
                $query->where('price', '<=', $max_price);
            }
        
            // 下限価格の条件追加
            if ($min_price) {
                $query->where('price', '>=', $min_price);
            }
        
            if($max_stock){
                $query->where('stock','<=',$max_stock);
            }
        
            if($min_stock){
                $query->where('stock','>=',$min_stock);
            }
        
            $products = $query->get();
        
            return view('products.index', compact('companies', 'products', 'keyword', 'company_name', 'max_price', 'min_price'));
        }
}