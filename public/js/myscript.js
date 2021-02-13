// hide flash message after 5s 
$(function() {
    let message = $('.alert-success');
    if(message.length > 0) {
        setTimeout(function() {
            message.fadeOut();
        }, 5000);
    }
});

// order ********
$(function() {
    $( ".btn-position" ).on( "click", function(e) {
        e.preventDefault();
        let id = '#form-' + $(this).attr('data-url');
        let link = $(id).attr('action');
        alert(id);
        $.ajax({url: link, 
            method:"POST",
            url: link,
            data: $(id).serialize(), // our data object
        });
    });
});