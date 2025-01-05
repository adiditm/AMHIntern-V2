
/* Moved from out of the header control */
function popUp(URL, height, width, isScroll) {
    day = new Date();
    id = day.getTime();
    eval("page" + id + " = window.open(URL, '" + id + "', 'toolbar=0,scrollbars=" + isScroll + ",location=0,statusbar=0,menubar=0,resizable=0,width=" + width + ",height=" + height + ",left = 100,top = 100');");
}

/* used for main Menu */
/* Updated to just use display = 'block' instead of fadeIn() to spead up interface.  TSP 7/8/2014 */ 
function toggleSubMenu(e, elemRef) {
    var elem = document.getElementById(e);
    var childElem = $(elemRef).children('i').eq(0);

    if (elem.style.display == "none") {
        //$(elem).fadeIn();
        elem.style.display = 'block';
        $(childElem).removeClass('fa-caret-right');
        $(childElem).addClass('fa-caret-down');
    }
    else {
        $(elem).hide();
        $(childElem).removeClass('fa-caret-down');
        $(childElem).addClass('fa-caret-right');
    }
    return false;
}


function HasItemsInCart(strEncMainPK) {
    // grab elements off page
    var cartIcon = document.getElementById("spanShoppingCartIcon");
    var cartTotal = document.getElementById("CartHeaderStatus");

    var strURL = "/v2/WebService/ajaxService.aspx?op=HasExistingRetailOrder&a=" + strEncMainPK;

    var xmlHttp = new XMLHttpRequest();
    xmlHttp.open("GET", strURL, true);
    xmlHttp.send(null);
    xmlHttp.onreadystatechange = function () {
        if (xmlHttp.readyState == 4 && xmlHttp.status == 200) {
            var results = xmlHttp.responseText.split("|");
            if (results.length > 1) {
                // if Order exist AND has at least 1 item in cart, then...
                if (results[0] == 1 && results[1] > 0) {
                    cartTotal.innerHTML = results[1].toString();
                    $(cartIcon).fadeIn();
                    // calls function that only exist on /members/back_office.asp to show in Modal dialog popup.
                    if (typeof ShowExistingShoppingCartMsgInPopup === "function")
                        ShowExistingShoppingCartMsgInPopup(''+ results[1].toString());
                }
            }
        }
    }
}

function Set_Cookie(name, value, expires, path, domain, secure) {
    // set time, it's in milliseconds
    var today = new Date();
    today.setTime(today.getTime());

    /*
    if the expires variable is set, make the correct
    expires time, the current script below will set
    it for x number of days, to make it for hours,
    delete  24, for minutes, delete  60 * 24
    */
    if (expires) {
        expires = 1 * 1000 * 60 * 60 * 24; // 1 day
        //alert("expires = " + expires.toString());
    }
    var expires_date = new Date(today.getTime() + (expires));
    //alert("expires_date = " + expires_date.toString());

    var cookieStr = name + "=" + escape(value) +
((expires) ? ";expires=" + expires_date.toGMTString() : "") +
((path) ? ";path=" + path : "") +
((domain) ? ";domain=" + domain : "") +
((secure) ? ";secure" : "");
    document.cookie = cookieStr;

    //alert("Cookie set. cookieStr = " + cookieStr);
}

function Get_Cookie(check_name) {
    // first we'll split this cookie up into name/value pairs
    // note: document.cookie only returns name=value, not the other components
    var a_all_cookies = document.cookie.split(';');
    var a_temp_cookie = '';
    var cookie_name = '';
    var cookie_value = '';
    var b_cookie_found = false; // set boolean t/f default f

    for (i = 0; i < a_all_cookies.length; i++) {
        // now we'll split apart each name=value pair
        a_temp_cookie = a_all_cookies[i].split('=');


        // and trim left/right whitespace while we're at it
        cookie_name = a_temp_cookie[0].replace(/^\s+|\s+$/g, '');

        // if the extracted name matches passed check_name
        if (cookie_name == check_name) {
            b_cookie_found = true;
            // we need to handle case where cookie has no value but exists (no = sign, that is):
            if (a_temp_cookie.length > 1) {
                cookie_value = unescape(a_temp_cookie[1].replace(/^\s+|\s+$/g, ''));
            }
            // note that in cases where cookie is initialized but no value, null is returned
            //alert("Cookie Exists. cookie_value = " + cookie_value);
            return cookie_value;
            break;
        }
        a_temp_cookie = null;
        cookie_name = '';
    }
    if (!b_cookie_found) {
        return null;
    }
}
