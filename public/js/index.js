//非同期検索処理
$(function() {
    $('#seach_form').on('submit',function(e){
        e.preventDefault();
        const form = $(this);

        $.ajax({
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            url: '/search',
            method: 'GET',
            data: {
                keyword: $('#search_keyword').val(),
                company_id: $('#company_id').val(),
                max_price: $('#max_price').val(),
                min_price: $('#min_price').val(),
                max_stock: $('#max_stock').val(),
                min_stock: $('#min_stock').val(),
            },

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
