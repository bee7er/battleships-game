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
 * Ajax change the current language - here for example only
 */
function ajaxChangeLanguage(languageCode)
{
    let url = "/changeLanguage";
    ajaxCall(url,
        JSON.stringify({'languageCode': languageCode})
    );
}

/**
 * Post request to server side
 *
 * @param url
 * @param data
 */
function ajaxCall(url, data) {

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

        console.log('Receiving: ' + response);

    }).fail(function (jqXHR, textStatus, errorThrown) {

        alert("Error on Ajax call");

        console.log(textStatus);
        console.log(errorThrown);
        console.log(jqXHR.getAllResponseHeaders());

        return false;
    });

    return true;
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
