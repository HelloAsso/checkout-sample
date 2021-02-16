"use strict";

$(document).ready(function () {
    $('[name="iscompany"]').on('change', function () {
        if($(this).is(":checked")) {
            $('#companyContainer').show()
            $('[name="company"]').attr('required', true)
        } else {
            $('#companyContainer').hide()
            $('[name="company"]').attr('required', false)
        }
    })

    function computeTotal() {
        var subtotal = $('[name="tree-count"] option:selected').val() * 50 + 
        $('[name="chocolate-count"] option:selected').val() * 20 + 
        $('[name="beer-count"] option:selected').val() * 10

        var fee = subtotal * 0.02
        var total = subtotal + fee

        var formater = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' })

        $('[data-item="amount"]').html(formater.format(subtotal))
        $('[data-item="fee"]').html(formater.format(fee))
        $('[data-item="total"]').html(formater.format(total))
        $('[name="amount"]').val(total)
        
        $('[type="submit"]').prop("disabled", total == 0)
    }

    $('select').on('change', function () {
        computeTotal()
    })

    $('[data-action="reset"]').on('click', function (e) {
        $(e.currentTarget).parent().parent().find('select').val(0)
        computeTotal()
    })

    computeTotal()
})