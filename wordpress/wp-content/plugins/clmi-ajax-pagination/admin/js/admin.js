jQuery(document).ready(function ($) {

    if (typeof wp === 'undefined' || !wp.media) {
        console.error('wp.media not available');
        return;
    }

    // Upload button
    $(document).on('click', '.clmi-upload-btn', function (e) {
        e.preventDefault();

        let button = $(this);
        let wrap = button.closest('.clmi-loader-wrap');

        let mediaUploader = wp.media({
            title: clmi_admin.title || 'Select Loader Image',
            button: { text: clmi_admin.button || 'Use this image' },
            multiple: false
        });

        mediaUploader.on('select', function () {

            let attachment = mediaUploader.state().get('selection').first().toJSON();

            if (!attachment || !attachment.url) return;

            wrap.find('#clmi_loader_image').val(attachment.url);

            let img = $('<img>', {
                src: attachment.url,
                css: { maxWidth: '60px' }
            });

            wrap.find('.clmi-preview').html(img);
            wrap.find('.clmi-remove-btn').show();
        });

        mediaUploader.open();
    });

    // Remove button
    $(document).on('click', '.clmi-remove-btn', function (e) {
        e.preventDefault();

        let wrap = $(this).closest('.clmi-loader-wrap');

        wrap.find('#clmi_loader_image').val('');
        wrap.find('.clmi-preview').empty();
        $(this).hide();
    });

});