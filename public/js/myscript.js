// add params 
$('#cours-parent').on('click', function() {
    sessionStorage.setItem('parent', true);
});
// scroll to lesson when come back to cours_edit page from lesson_edit
$(document).ready(function() {
    var data = sessionStorage.getItem('parent');
    if (data !== null) {
        // scroll to lessons
        let scrollTop = $('#table-test').offset().top;
        window.scrollTo(0, scrollTop - 100);
        // Supprimer des données de sessionStorage
        sessionStorage.removeItem('parent');
        // Supprimer toutes les données de sessionStorage
        sessionStorage.clear();
        return false;
    }
});
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
    $(document).on( "click", ".btn-position", function(e) {
        e.preventDefault();
        let id = '#form-' + $(this).attr('data-url');
        let link = $(id).attr('action');
        // submit form 
        $.ajax({url: link, 
            method:"POST",
            url: link,
            data: $(id).serialize(), 
        // load list 
        }).success(function(data) {
            $("#table-test").html();
            $("#table-test").load("/lesson/"+data[2]+"/load");
        });
    });
});


