// hide flash message after 5s 
$(function() {
    let message = $('.alert-success');
    if(message.length > 0) {
        setTimeout(function() {
            message.fadeOut();
        }, 5000);
    }
});

// order 
$(function() {

    $( ".js-like-article" ).on( "click", function(e) {

        e.preventDefault();

        var $link = $(e.currentTarget);

        $.ajax({method:"POST", url: $link.attr('href')}).done(function(data){
          $('.js-like-article-count').html(data.output);
        });
    });
});