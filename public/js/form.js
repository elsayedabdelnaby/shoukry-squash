$(function () {
    //Validate forms by parsley
    $('.parsley-form').parsley().on('field:validated', function () {
            var ok = $('.parsley-error').length === 0;
            $('.bs-callout-info').toggleClass('hidden', !ok);
            $('.bs-callout-warning').toggleClass('hidden', ok);
        })
        .on('form:submit', function () {
            $('.parsley-form').find("button[type='submit']").prop('disabled', true).toggleClass('spinner');
            return true;
        });

    //Initialize Select2 Elements
    $(function () {
        $('.select2').select2();
    });
});
