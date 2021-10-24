function showToastMessage() {
    var source = $('input[name="toast"]');

    var toast_msg = source.val();
    var toast_type = parseInt(source.data('type'));

    if (toast_msg) {
        if (toast_type == 1) {
            toastr.success(toast_msg);
        } else if (toast_type == 2) {
            toastr.warning(toast_msg);
        } else {
            toastr.error(toast_msg);
        }
    }
}

$(function () {
    $('[data-real]').each(function (i) {
        $(this).val($(this).data('real'));
    });

    $('#nv-profile').click(function () {
        $(this).parent().toggleClass('open');
    });

    showToastMessage();

    var hasServerLabel = $('#server_tag').length
    if (hasServerLabel) {
        $.get('/api/running-server', function(data) {
            const label = $('#server_tag').first()
            const style = data.state === 'normal' ? 'tw-p-4 tw-bg-green-500' : 'tw-p-4 tw-bg-red-500'
            label.addClass(style).text(data.label)
        })
        
    }
});
