function submit_short_link_form() {

    $('#errors').html("");

    var long_url = $('input[name="url"]').val();

    if (long_url.length === 0) {
        $('#errors').addClass("errors");
        $('#errors').html("Please, provide a valid url.");
        setTimeout(function(){
            $('#errors').html("");
            $('#errors').removeClass("errors");
        },5000);
        return false;
    }

    const URL_REGEXP = new RegExp("^(http|https|ftp)://", "i");

    if (!validURL(long_url)) {
        $('#errors').addClass("errors");
        $('#errors').html("Unable to shorten that link. It is not a valid url.");
        setTimeout(function(){
            $('#errors').html("");
            $('#errors').removeClass("errors");
        },5000);
        return false;
    }
    ;

    long_url = getUrl(long_url);
    console.log(long_url);

    $.ajax({
        type: "post",
        dataType: "json",
        url: myAjax.ajax_url,
        data: {
            action: 'short_link',
            long_url: long_url
        },
        // beforeSend: function(){
        // },
        success: function (response) {
            var short_link = response.data['urls']['short_url'];
            var long_link = response.data['urls']['long_url'];

            $('input[name="url"]').val(short_link);

            $('#idea_pro_short_link_submit').attr("name", "idea_pro_short_link_copy");
            $('#idea_pro_short_link_submit').attr("value", "Copy");
            $('#idea_pro_short_link_submit').attr("onclick", "copyToClipboard()");
            $('#idea_pro_short_link_submit').attr("id", "idea_pro_short_link_copy");

            var result_url = JSON.parse(localStorage.getItem('urls'));
            const add_url = {
                long_url: long_link,
                short_url: short_link,
            }
            result_url.unshift(add_url);
            console.log(result_url);

            var new_string = inner_table(result_url);

            add_to_local_storage(result_url);
            $('#here_table').html(new_string);


        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('The following error occured: ' + textStatus, errorThrown);
        }
    });
}

const URL_REGEXP = new RegExp("^(http|https|ftp)://", "i");

function getUrl(url) {
    let isProtocolOk = URL_REGEXP.test(url);
    return isProtocolOk ? url : ('http://' + url);
}

function validURL(str) {
    var pattern = new RegExp('^(https?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?(\\/[-a-z\\d%_.~+]*)*' + // port and path
        '(\\?[;&a-z\\d%_.~+=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return !!pattern.test(str);
}

function copyToClipboard() {
    /* Get the text field */
    var copyText = document.getElementById("url");

    /* Select the text field */
    copyText.select();
    copyText.setSelectionRange(0, 99999); /* For mobile devices */

    /* Copy the text inside the text field */
    document.execCommand("copy");

    $('#idea_pro_short_link_copy').attr("value", "Copied!");
    setTimeout(function () {
        $('#idea_pro_short_link_copy').attr("value", "Copy");
    }, 2000)
}

function return_submit_short_link() {
    $('#idea_pro_short_link_copy').attr("name", "idea_pro_short_link_submit");
    $('#idea_pro_short_link_copy').attr("value", "Shorten");
    $('#idea_pro_short_link_copy').attr("onclick", "submit_short_link_form()");
    $('#idea_pro_short_link_copy').attr("id", "idea_pro_short_link_submit");
}

$(document).ready(function () {
    const url = [];
    if (!("urls" in localStorage)) {
        localStorage.setItem('urls', JSON.stringify(url));
    }

    var result_url = JSON.parse(localStorage.getItem('urls'));

    if (result_url.length > 0) {
        var new_string = inner_table(result_url);
        $('#here_table').html(new_string);
    }

});

function add_to_local_storage(arr) {
    localStorage.setItem('urls', JSON.stringify(arr));
}

function inner_table(urls) {
    let string = '';
    for (let i = 0; i < urls.length; i++) {
        string += '<div class=\"td-pb-row\"> <div class=\"td-pb-span7 long_link\">'
            + urls[i]['long_url'] + '</div> <div id=\"short_url_'
            + i + '\" class=\"td-pb-span3 short_link\">' + urls[i]['short_url']
            + '</div> <div class=\"td-pb-span2 btn_copy\">' +
            '<input id=\"copy' + i + '\" type=\"button\" class=\"idea_pro_short_link_copy_detail\"' +
            ' onclick=\"copyDivToClipboard(' + i + ')\" value=\"Copy\"></div> </div>'
        if (i === 2) {
            break;
        }
    }
    return string;


}

function copyDivToClipboard(id) {
    console.log(id);
    var range = document.createRange();
    range.selectNode(document.getElementById('short_url_' + id));
    window.getSelection().removeAllRanges(); // clear current sel ection
    window.getSelection().addRange(range); // to select text
    document.execCommand("copy");
    $('#copy' + id).attr("value", "Copied!");
    setTimeout(function () {
        $('#copy' + id).attr("value", "Copy");
    }, 2000)
    window.getSelection().removeAllRanges();// to deselect
}