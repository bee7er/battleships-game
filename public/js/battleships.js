/**
 * Navigate to the requested page
 */
function gotoUrl(formId, url) {
    let f = $('#' + formId);
    f.attr("action", url);
    f.attr("method", "POST");
    f.submit();
}

/**
 * Post request to server side
 *
 * @param url
 * @param data
 * @param callBackFunction
 */
function ajaxCall(url, data, callBackFunction) {

    $.ajax({
        type: 'post',
        url: url,
        data: data,
        contentType: 'application/json',
        dataType: 'text',
        cache: false,
        processData: false
    }).success(function (response) {
        // Successful update
        let responseData = JSON.parse(response);
        if ('OK' == responseData.result) {
            if (null != callBackFunction) {
                // NB We must process any async returned data in a callback
                callBackFunction(responseData.returnedData);
            }

            return true;
        }

        alert(responseData.message);

    }).fail(function (jqXHR, textStatus, errorThrown) {

        alert("Error on Ajax call. Please report this issue to the administrator.");

        console.log(textStatus);
        console.log(errorThrown);
        console.log(jqXHR.getAllResponseHeaders());

        return false;
    });

}

/**
 * From vocal
 *
 * It wasn't necessary to run this function, as the pdf url was available locally
 * but this did in fact work
 * @param pdf
 */
    function experimental(pdf) {
        $.ajax({
            url: 'getTenseDetails',
            dataType: 'json',
            data: {'pdf': pdf},
            success: function (response) {
                let data = response.data;
                if (data != '') {
                    $('#embedId').attr('src', data);
                    $('#popup-modal').appendTo("body").modal('show');
                }
            }
        });
    };
