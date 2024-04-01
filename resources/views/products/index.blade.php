@extends('app')
  
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">

     <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js" integrity="sha256-2Pmvv0kuTBOenSvLm6bvfBSSHrUJ+3A7x6P5Ebd07/g=" crossorigin="anonymous"></script>
    <script src="{{ asset('/js/index.js') }}"></script>

    <!-- ソート機能 -->
    <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/js/jquery.tablesorter.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.0/css/theme.default.min.css">
    <style>
    #product_table th {
        background-color:pink;
    }
    .sorter-false {
        background-image: none;
    }
    </style>

    <script>
    $(document).ready(function() {
        $('#product_table').tablesorter({
            headers: {
               1: { sorter: false },
               6: { sorter: false },
               7: { sorter: false }
            }
            });
    });
    </script>

    <div class="row">
        <div class="col-lg-12">
            <div class="text-left">
                <h2 style="font-size:1rem;">商品情報一覧画面</h2>
            </div>
        </div>
    </div>

     <!-- フラッシュメッセージ -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
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
            <form method="GET" action="{{route('search')}}" id="search_form">
                <div class="form-group row">
                    <label class="col-sm-2 col-form-label">商品名</label>
                    <!--入力-->
                    <div class="col-sm-5">
                        <input type="text" class="form-control" name="keyword" value="{{ $keyword ?? '' }}" id="search_keyword">
                    </div>
                </div>
                <!--プルダウンカテゴリ選択-->
                <div class="form-group row">
                    <label class="col-sm-2">メーカー名</label>
                    <div class="col-sm-3">
                        <select name="company_name" class="form-control" value="" id="search_company">
                            <option value="" hidden selected>未選択</option>
                            @foreach($companies as $company)
                            <option value="{{ $company -> id }}">{{ $company -> company_name }}</option>
                            @endforeach
                        </select>

                        <input type="text" name="max_price" id="max_price" placeholder="価格の上限を入力">
                        <input type="text" name="min_price" id="min_price" placeholder="価格の下限を入力">
                        <input type="text" name="max_stock" id="max_stock" placeholder="在庫の上限を入力">
                        <input type="text" name="min_stock" id="min_stock" placeholder="在庫の下限を入力">
                        <div class="col-sm-auto">
                        <button type="submit" class="btn btn-primary" id="search-btn">検索</button>
                    </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="text-left">
       <a class="btn btn-success" onclick="location.href='/products/create'">新規登録</a>
    </div>
    
    <table class="table table-bordered" id="product_table">
      <thead>
        <tr>
            <th>id</th>
            <th>商品画像</th>
            <th>商品名</th>
            <th>価格</th>
            <th>在庫数</th>
            <th>メーカー名</th>
            <th></th>
            <th></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($products as $key=>$product)
        <tr>
            <td style="text-align:right">{{ $key+1 }}</td>
            <td style="text-align:left mr-2"><img src="{{ asset($product->img_path) }}" width="25%"></td>
            <td>{{ $product -> product_name }}</td>
            <td style="text-align:right">{{ $product -> price }}円</td>
            <td style="text-align:right">{{ $product -> stock }}</td>
            <td>{{ $product -> company -> company_name }}</td>
            <td style="text-align:center">
            <a class="btn btn-primary" href="{{ route('show',$product->id) }}">詳細</a>
            </td>
            <td style=”text-align:center”>
            <form  class="id">
            <input data-delete_btn="{{ $product-> id }}" type="submit" class="btn-danger btn-dell" value="削除">
            </form>
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
@endsection

<!--Storage::url($product -> img_path)-->