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
    $(document).on( "click", ".btn-position", function(e) {
        e.preventDefault();
        let id = '#form-' + $(this).attr('data-url');
        let link = $(id).attr('action');
        $.ajax({url: link, 
            method:"POST",
            url: link,
            data: $(id).serialize(), // our data object
        }).success(function(data) {
            $("#table-test").html();
            $("#table-test").load("/lesson/"+data[2]+"/load");
        });
    });
});