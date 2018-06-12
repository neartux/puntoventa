/**
 * Metodo para mostrar una notificacion
 * @param title El titulo de la notificacion
 * @param message El mensaje
 * @param type Puden ser: success, info, warning, error
 */
function showNotification(title, message, type){
    toastr.clear();
    toastr[type](message, title);
    toastr.options = {
        "closeButton": true,
        "debug": false,
        "newestOnTop": true,
        "progressBar": true,
        "positionClass": "toast-top-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "300",
        "hideDuration": "1000",
        "timeOut": "2000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "slideDown",
        "hideMethod": "fadeOut",
        "escapeHtml": true,
        "closeHtml": "<button><i class=\"icon-close\"></i></button>"
    };
}


function startLoading(message) {
    var options = {
        theme:"sk-circle",
        message:message
    };

    HoldOn.open(options);
}

function stopLoading() {
    HoldOn.close();
}