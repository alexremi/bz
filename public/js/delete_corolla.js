function corollaDelete(id) {
    $.ajax({
        url: '/corolla/delete/' + id,
        type: 'POST',
        success: function () {
            $('#corolla_' + id).remove();
        }
    })
}