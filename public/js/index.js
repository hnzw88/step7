//非同期検索処理
$(function() {
  console.log('読み込みOK')
    $('#search-btn').on('click',function(e){
        e.preventDefault();
        const form = $(this);
console.log('検索ボタン')
        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/search',
            method: 'GET',
            data: {
                keyword: $('#search_keyword').val(),
                company_id: $('#search_company').val(),
                max_price: $('#max_price').val(),
                min_price: $('#min_price').val(),
                max_stock: $('#max_stock').val(),
                min_stock: $('#min_stock').val(),
            },
dataType:'html',
            success: function(data) {
                let new_table = $(data).find('#product_table');
                $('#product_table').html(new_table);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('エラーが発生しました');
            }
        });
    });
});

//非同期削除処理
$(function() {
    $('.btn-danger').on('click',function(e) {
      e.preventDefault()
        var deleteConfirm = confirm('削除してよろしいでしょうか？');
        
          if (deleteConfirm == true) {
            var clickEle = $(this)
            var userID = clickEle.attr('data-delete_btn');

          $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: 'destroyproduct/'+userID,
            type: 'POST',
            data: {
                'id':userID,
            },
          })

          .done(function() {
            console.log('成功')
            // 通信が成功した場合、クリックした要素の親要素の <tr> を削除
            clickEle.parents('tr').remove();
          })
    
         .fail(function() {
            alert('エラー');
          });
    
        } else {
          (function(e) {
            e.preventDefault()
          });
        };
      });
    });