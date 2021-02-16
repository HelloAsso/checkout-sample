"use strict";

$(document).ready(function () {
    function makeJson(item){
        return { 
            label: item.properties.label,
            address : item.properties.name,
            zipcode : item.properties.postcode,
            city : item.properties.city
        }
    }

    function assignValues(item, index) {
        $('input[name="address' + index + '"]').val(item.address)
        $('input[name="zipcode' + index + '"]').val(item.zipcode)
        $('input[name="city' + index + '"]').val(item.city)
    }

    function manageAutocomplete(index) {
        return {
            source: function (request, response) {
                $.ajax({
                    url: "https://api-adresse.data.gouv.fr/search/",
                    data: { q: request.term, limit: 5 },
                    dataType: "json",
                    success: function (data) {
                        response($.map(data.features, function(item) { 
                            return makeJson(item) 
                        }))
                        
                        if(data.features.length > 0)
                            assignValues(makeJson(data.features[0]), index)
                    }
                })
            },
            select: function(_event, ui) {
                assignValues(ui.item, index)
            }
        }
    }
  
    $('input[name="address-auto"]').autocomplete(manageAutocomplete(''))
})
