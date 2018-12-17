(function($) {
    $('.get-related-post').on('click', function(event) {
        event.preventDefault();

        $('a.get-related-posts').remove();
        $('.ajax-loader').show();
        var json_url = postdata.json_url;
        var post_id = postdata.post_id;


        $.ajax({
            dataType: 'json',
            url: json_url
        })

        .done(function(response) {
            $('#related-posts').append('<h1 class="related-header">Related Posts:</h1>');

            $each(response, function(index, object){

                if (object.id == post_id) {
                    return;
                }

                var feat_img = '';
                if(object.featured_image !== 0) {
                    feat_img =  '<figure class="related-featured">' +
                                '<img src="'+ object.featured_image_src + '" alt="">' +
                                '</figure>'; 
                }

                var related_loop = '<aside class="related-post-clear>' +
                '<a href="' + object.link + '">' +
                '<h1 class="related-post-title">'+ object.title +'</h1>' +
                '<div class="related-author">by <em>' + object.author_name + '</em></div>' +
                '<div class="related-excerpt"' +
                feat_img +
                object.excerpt.rendered +
                'excerpt goes here' +
                '</div>' +
                '</a>' +
                '</aside>';

                $('.ajax-loader').remove();
                $('#related-posts').append(related_loop);
            });
        })

        .fail(function() {

        })

        .always(function() {

        });
    });
})(jQuery);