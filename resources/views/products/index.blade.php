@extends('app')
  
@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">商品情報一覧画面</h2>
            </div>
        </div>
    </div>

     <!-- フラッシュメッセージ -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

     <script>
            @if (session('flash_message'))
                $(function () {
                        toastr.success('{{ session('flash_message') }}');
                });
            @endif
    </script>    

    <div class="row">
        <!-- 検索バー -->
        <div class="col-sm">
            <form method="GET" action="{{route('search')}}">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">商品名</label>
                    <!--入力-->
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="keyword" value="{{ $keyword ?? '' }}" id="search_keyword">
                    </div>
                    <div class="col-sm-auto">
                        <button type="submit" class="btn btn-primary">検索</button>
                    </div>
                </div>
                <!--プルダウンカテゴリ選択-->
                <div class="form-group row">
                    <label class="col-sm-2">メーカー名</label>
                    <div class="col-sm-3">
                        <select name="company_name" class="form-control" value="">
                            <option value="">未選択</option>

                            @foreach($companies as $company)
                            <option value="{{ $company -> id }}">{{ $company -> company_name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-left">
       <a class="btn btn-success" onclick="location.href='/products/create'">新規登録</a>
    </div>

    <table class="table table-bordered">
        <tr>
            <th>id</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>

        </tr>
        @foreach ($products as $product)
        <tr>
            <td style="text-align:right">{{ $product -> id }}</td>
            <td style="text-align:left mr-2"><img src="{{ Storage::url($product -> img_path) }}" width="25%"></td>
            <td>{{ $product -> product_name }}</td>
            <td style="text-align:right">{{ $product -> price }}円</td>
            <td style="text-align:right">{{ $product -> stock }}</td>
            <td>{{ $product -> company -> company_name }}</td>
            <td style="text-align:center">
            <a class="btn btn-primary" href="{{ route('show',$product->id) }}">詳細</a>
            </td>
            <td style=”text-align:center”>
            <form action="{{ route('destroy',$product->id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-sm btn-danger" onclick='return confirm("削除しますか？");'>削除</button>
            </form>
            </td>
        </tr>
        @endforeach
    </table>
 
@endsection