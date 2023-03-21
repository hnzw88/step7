@extends('app')
   
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h2 style="font-size:1rem;">商品情報詳細画面</h2>
        </div>
        <div class="pull-right">
            <a class="btn btn-success" href="{{ url('/products') }}?page={{ $page_id }}">戻る</a>
        </div>
    </div>
</div>
 
<div style="text-align:left;">
<div class="row">
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【商品情報ID】</label> {{ $product -> id }}                
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【商品画像】</label>
        <img src="{{ asset('/storage/' . $product -> img_path) }}" class="img-fluid" alt="{{ $product -> img_path }}" width="200" height="200">            
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【商品名】</label>   {{ $product -> product_name }}                
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【メーカー名】</label> 
            @foreach ($companies as $company)
                @if($company -> id==$product -> company_id) {{ $company -> company_name }} @endif
            @endforeach         
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【価　格】</label>
            {{ $product -> price }}                
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【在庫数】</label>
            {{ $product -> stock }}                
        </div>
    </div>
    <div class="col-12 mb-2 mt-2">
        <div class="form-group">
        <label>【コメント】</label>
           {{ $product -> comment }}                
        </div>
    </div>

    <div class="text-right">
    <a class="btn btn-primary" href="{{ route('edit',$product -> id) }}">編集</a> 
    </div>
</div>
</div>
@endsection