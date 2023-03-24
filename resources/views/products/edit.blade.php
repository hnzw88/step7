@extends('app')
   
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:1rem;">商品情報編集画面</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
        </div>
    </div>
</div>
 
<div style="text-align:right;">
 <form method="POST" action="{{ route('update'), $product -> id }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="id" value="{{ $product -> id }}">
        
    <div class="form-group">
        <div class="col-12 mb-2 mt-2">
        <div class="form-group" style="text-align:left">
            <label>【商品名】</label>              
            <input type="text" name="product_name" value="{{ $product -> product_name }}" class="form-control" placeholder = "商品名">
        </div>
        @error('product_name')
        <span style="color:red;">商品名を入力してください</span>
        @enderror
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group" style="text-align:left">
            <label>【メーカー名】</label>              
                <select name="company_id" class="form-select">
                    <option>メーカー名を選択してください</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company -> id }}"@if($company -> id==$product -> company_id) selected @endif>{{ $company -> company_name }}</option>
                    @endforeach
                </select>
            </div>
            @error('company_id')
            <span style="color:red;">メーカー名を選択してください</span>
            @enderror
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group" style="text-align:left">
            <label>【価　格】</label>              
                <input type="text" name="price" value="{{ $product -> price }}" class="form-control" placeholder="価格">
            </div>
            @error('price')
            <span style="color:red;">価格を入力してください</span>
            @enderror
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group" style="text-align:left">
            <label>【在庫数】</label>              
                <input type="text" name="stock" value="{{ $product -> stock }}" class="form-control" placeholder="在庫">
            </div>
            @error('stock')
            <span style="color:red;">在庫数を入力してください</span>
            @enderror
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group" style="text-align:left">
            <label>【コメント】</label>              
            <textarea class="form-control" style="height:100px" name="comment" placeholder="コメント">{{ $product -> comment }}</textarea>
            </div>
        </div>
        <div class="form-group" style="text-align:left" >
        <label>【商品画像】</label>
          <img src="{{ asset('/storage/' . $product -> img_path) }}" class="img-fluid" alt="{{ $product -> img_path }}" width="200" height="200">                          
          <input type="file" class="form-control-file" name='image' id="image">
        </div>

        <div class="col-12 mb-2 mt-2">
            <button type="submit" class="btn btn-primary w-100">更新</button>
        </div>
    </div>      
 </form>
</div>
@endsection