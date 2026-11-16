<script>
(function ($) {
    var $form = $('#formAnalisis');
    var $checkbox = $form.find('#is_industrial');
    if (!$checkbox.length) return;

    function updateIndustrialFields() {
        var industrial = $checkbox.is(':checked');
        $('[data-clinical-demographic], [data-clinical-age]').toggleClass('d-none', industrial);
        $form.find('input[name="edad"]').prop('disabled', industrial);
        $('#industrialFields').toggleClass('d-none', !industrial)
            .find('input').prop('disabled', !industrial);
        $form.find('[data-industrial-required]').prop('required', industrial);
        $('[data-client-label]').each(function () {
            $(this).text(industrial ? 'Cliente:' : $(this).attr('data-clinical-label'));
        });
    }

    $checkbox.on('change', updateIndustrialFields);
    updateIndustrialFields();

    // jQuery's programmatic submit does not run native constraint validation.
    // Register before the existing submit handlers so invalid forms stay editable.
    $form.on('submit.industrial', function (event) {
        if (!this.checkValidity()) {
            event.preventDefault();
            event.stopImmediatePropagation();
            if (this.reportValidity) this.reportValidity();
            return false;
        }
    });
})(jQuery);
</script>
