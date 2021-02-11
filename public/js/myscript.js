// hide flash message after 5s 
$(function() {
    let message = $('.alert-success');
    if(message.length > 0) {
        setTimeout(function() {
            message.fadeOut();
        }, 5000);
    }
});

    
