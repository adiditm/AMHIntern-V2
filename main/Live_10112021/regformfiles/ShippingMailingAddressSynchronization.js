//require readonly.js

var as_AddressObjects = [];
var as_checkboxID = null;
var needToHandleChangeEvent = true;
var delaytimer = 100;
var as_DisablingIgnoreList = [];

function AddressSyncronization_CreateObject(nameID, lnameID, addressLineID, addressLine2ID, addressLine3ID, cityID, zipID, stateID, countryID, otherStateID) {
    var arr = [];
    arr.push(addressLineID);
    arr.push(addressLine2ID);
    if (addressLine3ID != undefined) {
        arr.push(addressLine3ID);
    }
    arr.push(cityID);
    arr.push(stateID);
    arr.push(countryID);
    arr.push(zipID);
    arr.push(nameID);
    arr.push(lnameID);
    if (otherStateID != undefined) {
        arr.push(otherStateID);
    }
    return arr;
}

//first address is mailing address, second one is shipping address
function AddressSyncronization_InitAddressObjects(checkboxID, MailingName, MailingLName, MailingAddress1, MailingAddress2, MailingAddress3, MailingCity, MailingZip, MailingState, MailingCountry, MailingOtherState, ShippingName, ShippingLName, ShippingAddress1, ShippingAddress2, ShippingAddress3, ShippingCity, ShippingZip, ShippingState, ShippingCountry, ShippingOtherState) {
    as_checkboxID = checkboxID;
    as_AddressObjects = [];
    as_AddressObjects.push(AddressSyncronization_CreateObject(MailingName, MailingLName, MailingAddress1, MailingAddress2, MailingAddress3, MailingCity, MailingZip, MailingState, MailingCountry, MailingOtherState));
    as_AddressObjects.push(AddressSyncronization_CreateObject(ShippingName, ShippingLName, ShippingAddress1, ShippingAddress2, ShippingAddress3, ShippingCity, ShippingZip, ShippingState, ShippingCountry, ShippingOtherState));

    AddressSyncronization_InitChangeEventHandler();
    AddressSyncronization_DisableAddress(document.getElementById(as_checkboxID).checked);
    //enable for correct saving
    $('#' + checkboxID).closest('form').submit(function () {
        AddressSyncronization_DisableAddress(false, true);
    })
}

function AddressSyncronization_OnAddressChange(e) {
    if (document.getElementById(as_checkboxID).checked && needToHandleChangeEvent) {
        if (!e) e = window.event;
        var currentItem = (e.target || e.srcElement || e);

        var sourceObjectIndex = AddressSyncronization_GetChangableObjectIndex(currentItem);
        var destObjectIndex = sourceObjectIndex == 0 ? 1 : 0;

        AddressSyncronization_SynchronizeObjects(as_AddressObjects[sourceObjectIndex], as_AddressObjects[destObjectIndex]);

        //init address validation
        AddressSyncronization_InitAddressValidation(destObjectIndex);

        AddressSyncronization_DisableAddress(document.getElementById(as_checkboxID).checked);
    }
}

function AddressSyncronization_OnCheckboxChange() {
    AddressSyncronization_SynchronizeObjects(as_AddressObjects[0], as_AddressObjects[1]);
    AddressSyncronization_InitAddressValidation(1);
    AddressSyncronization_DisableAddress(document.getElementById(as_checkboxID).checked);
}

function AddressSyncronization_GetChangableObjectIndex(field) {
    var objectIndex = -1;
    var currentIndex = -1;
    as_AddressObjects.forEach(function (currentArray) {
        var isFieldFound = false;
        currentIndex++;
        currentArray.forEach(function (currentObject) {
            if (document.getElementById(currentObject) == field) {
                isFieldFound = true;
            }
        });
        if (isFieldFound) {
            objectIndex = currentIndex;
        }
    });
    return objectIndex;
}

function AddressSyncronization_SynchronizeObjectsByIndexes(sourceObjectIndex, destObjectIndex) {
    AddressSyncronization_SynchronizeObjects(as_AddressObjects[sourceObjectIndex], as_AddressObjects[destObjectIndex]);
    if (document.getElementById(as_checkboxID) != null && document.getElementById(as_checkboxID) != undefined){
        AddressSyncronization_DisableAddress(document.getElementById(as_checkboxID).checked);
    }
}

function AddressSyncronization_SynchronizeObjects(sourceObject, destObject) {
    if (sourceObject != undefined && destObject != undefined) {
        var objctLength = sourceObject.length;
        if (document.getElementById(as_checkboxID).checked) {
            for (var i = 0; i < objctLength; i++) {
                var dstObj = document.getElementById(destObject[i]);
                var srcObj = document.getElementById(sourceObject[i]);
                if (srcObj != null && dstObj != null) {
                    var srcValue = document.getElementById(sourceObject[i]).value || document.getElementById(sourceObject[i]).innerHTML;
                    document.getElementById(destObject[i]).value = srcValue;
                }
            }
        }
    }
}

function AddressSyncronization_InitChangeEventHandler() {
    as_AddressObjects.forEach(function (currentArray) {
        currentArray.forEach(function (currentObject) {
            if ($('#' + currentObject + ':not(.AddressSyncronization_bound)').attr("disabled") == "disabled") {
                as_DisablingIgnoreList.push(currentObject);
            }
            $('#' + currentObject + ':not(.AddressSyncronization_bound)').addClass('AddressSyncronization_bound').bind('change', AddressSyncronization_OnAddressChange);
        });
    });
    $('#' + as_checkboxID).change(AddressSyncronization_OnCheckboxChange);

}

function AddressSyncronization_InitAddressValidation(destObjectIndex) {
    needToHandleChangeEvent = false;
    //0 - address line 1
    $('#' + as_AddressObjects[destObjectIndex][0]).change();
    needToHandleChangeEvent = true;
}

function AddressSyncronization_DisableAddress(needToDisable, addReadonly) {
    as_AddressObjects[1].forEach(function (currentObject) {
        if (as_DisablingIgnoreList.indexOf(currentObject) < 0) {
            if (needToDisable) {
                $('#' + currentObject).attr("disabled", "disabled");
            } else {
                $('#' + currentObject).removeAttr("disabled");
            }
            if (document.getElementById(as_checkboxID).checked && addReadonly != undefined && addReadonly) {
                $('#' + currentObject).attr("readonly", "readonly");
            }
        }
    });
}