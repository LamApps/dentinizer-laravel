var _showLoader = function(id_element) {
    $('#'+id_element).html('<i class="fas fa-spinner fa-spin"></i>');
}
var _hideLoader = function(id_element) {
    $('#'+id_element).html('');
}
var _showResponseMessage = function(type,msgText) {
    swal.fire({
        html: msgText,
        icon: type,
        customClass: {
            confirmButton: 'btn btn-primary',
            cancelButton: 'btn btn-outline-danger ml-1'
        },
        buttonsStyling: false,
        timer: 1500
    }).then(function() {});
}