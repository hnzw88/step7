@extends('app')
   
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:1rem;">商品新規登録画面</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ url('/products') }}">戻る</a>
        </div>
    </div>
</div>
 
<div style="text-align:right;">
<form method="POST" action="{{ route('store') }}" enctype="multipart/form-data">
    @csrf
     
     <div class="row">
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="product_name" class="form-control" placeholder="商品名">
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <select name="company_id" class="form-select">
                    <option>メーカー名をを選択してください</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company -> id }}">{{ $company -> company_name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="price" class="form-control" placeholder="価格">
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
                <input type="text" name="stock" class="form-control" placeholder="在庫数">
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <textarea class="form-control" style="height:100px" name="comment" placeholder="コメント"></textarea>
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <div class="form-group">
            <input type="file" class="form-control-file" name='image' id="image">
            </div>
        </div>
        <div class="col-12 mb-2 mt-2">
            <button type="submit" class="btn btn-primary w-100">登録</button>
        </div>
    </div>      
</form>
</div>
@endsection