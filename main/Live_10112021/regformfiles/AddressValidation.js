AddressValidationObjectList = [];
currentAddressValidationObject = null;
contentTextObject = undefined;
var allowedCountryCodes = [];

function AddressValidationObject(addressLineID, cityID, stateID, countryID, zipID, validationFinishCallBack, isAddressValid, useStrongValidation, ignoreList, dialogWindowID, dialogWindowContentID, alias) {
    //init fields
    this.addressLineID = addressLineID;
    this.cityID = cityID;
    this.stateID = stateID;
    this.countryID = countryID;
    this.zipID = zipID;
    this.validationFinishCallBack = validationFinishCallBack;
    this.isAddressValid = isAddressValid;
    this.useStrongValidation = useStrongValidation;
    this.isAddressValidBtnWasPressed = false;
    this.AddressWasNotValidated = false;
    this.ignoreList = ignoreList;
    this.dialogWindowID = dialogWindowID;
    this.dialogWindowContent = dialogWindowContentID;
    this.addressVerificationIsSetuping = false;
    this.alias = alias;
    this.tempDialogWindowContent = '';
    this.tempDialogWindowTitle = '';
    this.hideUpdateButton = false;
    
    this.openDialogAfterValidation = false;
    this.senderName = "";
    this.runningValidationIds = [];
}

function getContentTextObject(langID) {
    $.ajaxSetup({ async: false });
    $.post('/v2/WebService/ajaxService.aspx?op=ValidateAddress_GetTextContent&a=' + langID, function (data, status) {
        if (data != undefined) {
            contentTextObject = JSON.parse(data);
        }
        CheckContentTextObject(contentTextObject);
    });
    $.ajaxSetup({ async: true });
}

function getAllowedCountryCodes() {
    $.ajaxSetup({ async: false });
    $.post('/v2/WebService/ajaxService.aspx?op=ValidateAddress_GetAllowedCountryCodes&a=', function (data, status) {
        if (data != undefined) {
            allowedCountryCodes = JSON.parse(data);
        }
    });
    $.ajaxSetup({ async: true });
}

function CheckContentTextObject(contentTextObject) {
    contentTextObject.Ok = UpdatePropertyIfUndefined(contentTextObject.Ok, 'Ok');
    contentTextObject.Cancel = UpdatePropertyIfUndefined(contentTextObject.Cancel, 'Cancel');
    contentTextObject.AddressIsCorrect = UpdatePropertyIfUndefined(contentTextObject.AddressIsCorrect, 'Address is correct');
    contentTextObject.Update = UpdatePropertyIfUndefined(contentTextObject.Update, 'Update');
    contentTextObject.AddressIsCorrectConfirm = UpdatePropertyIfUndefined(contentTextObject.AddressIsCorrectConfirm, 'Please double check your shipping information carefully. If Jeunesse has to re-ship your product due to address errors, an additional shipping fee of $25 USD will be incurred');
    contentTextObject.AddressIsNotAccurate = UpdatePropertyIfUndefined(contentTextObject.AddressIsNotAccurate, 'Address is not accurate');
    contentTextObject.SelectSimilarVariants = UpdatePropertyIfUndefined(contentTextObject.SelectSimilarVariants, 'Address is not accurate. Please select one of the variants below.');
    contentTextObject.ConfirmationTitle = UpdatePropertyIfUndefined(contentTextObject.ConfirmationTitle, 'Confirmation');
    contentTextObject.ServiceIsNotWorking = UpdatePropertyIfUndefined(contentTextObject.ServiceIsNotWorking, 'We are sorry, but service which validates address is not working. Please confirm your address manually.');
}

function UpdatePropertyIfUndefined(property, defaultValue) {
    var result = (typeof property === 'undefined') ? defaultValue : property;
    //use default values in case no appropriate language
    if (result[0] == '@' && result[result.length - 1] == '@') {
        result = defaultValue;
    }
    return result;
}

function InitAddressValidation(addressLineIDStr, cityIDStr, stateIDStr, countryIDStr, zipIDStr, validationFinishCallBackStr, isAddressValidStr, isCanShowAddressCorrectBtn, dialogWindowIDStr, dialogWindowContentIDStr, langID, useStrongValidationStr, useServerSideCallbackBindings, ignoreList, alias) {
    //set default text content if need
    getContentTextObject(langID);
  
    //get allowed countries
    getAllowedCountryCodes();

    //unbind old shipping fields
    if (typeof addressLineID != 'undefined') {
        UnbindAddressChangeCallBack();
    }

    // creation addressValidationObject
    addressValidationObject = new AddressValidationObject(addressLineIDStr, cityIDStr, stateIDStr, countryIDStr, zipIDStr, validationFinishCallBackStr, isAddressValidStr, useStrongValidationStr, ignoreList, dialogWindowIDStr, dialogWindowContentIDStr, alias);

    // verification existing addressValidation objects
    // to prevent adding objectx with same alias
    var addValidationObject = true;
    for (var i = 0; i < AddressValidationObjectList.length; i++) {
        if (AddressValidationObjectList[i].alias == addressValidationObject.alias) {
            addValidationObject = false;
        }
    }
    if (!addValidationObject)
        return;

    AddressValidationObjectList.push(addressValidationObject);
    AddressVariablesReinit(addressValidationObject);

    if (typeof useServerSideCallbackBindings == 'undefined' || !useServerSideCallbackBindings) {
        UnbindAddressChangeCallBack();
        InitAddressChangeCallBack();
    }

    initAddressValidationDialog();

    // remove 'Address is correct' btn
    if (!isCanShowAddressCorrectBtn) {
        $('.btnAddressValidationAddressCorrect', getCurrentDialogWindow()).remove();
    }
    document.getElementsByClassName('ui-dialog')[0].style.fontSize = '14px';
    $('.ui-dialog-content', getCurrentDialogWindow()).css('overflow', 'auto');

    //try to validate addreess by default
    validateAddress();

    //disable submit form on entering, address verification is not working correctly
    $(addressLineIDStr).closest('form').on('keyup keypress', function (e) {
        var keyCode = e.keyCode || e.which;
        if (keyCode === 13) {
            e.preventDefault();
            return false;
        }
    });
}

function initAddressValidationDialog() {
    $(currentAddressValidationObject.dialogWindowID).dialog({
        autoOpen: false,
        modal: true,
        close: function () {
            if (currentAddressValidationObject.tempDialogWindowContent != '') {
                revertDailogWindowToPrevioesView();
            }
        },
        buttons: {
            'Update': {
                text: contentTextObject.Update,
                class: 'btnAddressValidationUpdate btnAddressValidationAddress',
                click: function () {
                    var checkedRadioButton = $('.addressRadio:checked', getCurrentDialogWindow());
                    updateAddress($(checkedRadioButton).data('addressline'), $(checkedRadioButton).data('city'), $(checkedRadioButton).data('state'),
                        $(checkedRadioButton).data('country'), $(checkedRadioButton).data('zip'), $(checkedRadioButton).data('state-code'));
                    $(this).dialog('close');
                    currentAddressValidationObject.isAddressValid = true;
                    currentAddressValidationObject.senderName = "";
                    validationFinished();
                }
            },
            'Address is correct': {
                text: contentTextObject.AddressIsCorrect,
                class: 'btnAddressValidationAddressCorrect btnAddressValidationAddress',
                click: function () {
                    currentAddressValidationObject.senderName = "";
                    showAddressIsCorrectBeforeManualSettingConfirmation();
                }
            },

            'Cancel': {
                text: contentTextObject.Cancel,
                class: 'btnAddressValidationAddressCancel btnAddressValidationAddress',
                click: function () {
                    $(this).dialog('close');
                    currentAddressValidationObject.senderName = "";
                    validationFinished();
                }
            },

            'AddressCorrectConfirm_Ok': {
                text: contentTextObject.Ok,
                class: 'btnAddressCorrectConfirm_Ok btnAddressValidationAddress',
                click: function () {
                    $(this).dialog('close');
                    currentAddressValidationObject.isAddressValid = true;
                    currentAddressValidationObject.isAddressValidBtnWasPressed = true;
                    currentAddressValidationObject.senderName = "";
                    validationFinished();
                }
            },

            'AddressCorrectConfirm_Cancel': {
                text: contentTextObject.Cancel,
                class: 'btnAddressCorrectConfirm_Cancel btnAddressValidationAddress',
                click: function () {
                    currentAddressValidationObject.senderName = "";
                    revertDailogWindowToPrevioesView();
                }
            }
        },
        width: '50%',
        maxHeight: 420,
    });
}

function InitAddressChangeCallBack() {
    if(NeedToBind(currentAddressValidationObject.ignoreList, currentAddressValidationObject.addressLineID)){
        $(currentAddressValidationObject.addressLineID).change(addressValidationFieldsOnChange);
    }
    if (NeedToBind(currentAddressValidationObject.ignoreList, currentAddressValidationObject.cityID)) {
        $(currentAddressValidationObject.cityID).change(addressValidationFieldsOnChange);
    }
    if (NeedToBind(currentAddressValidationObject.ignoreList, currentAddressValidationObject.stateID)) {
        $(currentAddressValidationObject.stateID).change(addressValidationFieldsOnChange);
    }
    if (NeedToBind(currentAddressValidationObject.ignoreList, currentAddressValidationObject.countryID)) {
        $(currentAddressValidationObject.countryID).change(addressValidationFieldsOnChange);
    }
    if (NeedToBind(currentAddressValidationObject.ignoreList, currentAddressValidationObject.zipID)) {
        $(currentAddressValidationObject.zipID).change(addressValidationFieldsOnChange);
    }
}

function NeedToBind(ignoreList, property) {
    if (ignoreList != '' && ignoreList != undefined) {
        if (ignoreList.indexOf(property) > -1) {
            return false;
        }
    }
    return true;
}

function UnbindAddressChangeCallBack() {
    $(currentAddressValidationObject.addressLineID).unbind('change', addressValidationFieldsOnChange);
    $(currentAddressValidationObject.cityID).unbind('change', addressValidationFieldsOnChange);
    $(currentAddressValidationObject.stateID).unbind('change', addressValidationFieldsOnChange);
    $(currentAddressValidationObject.countryID).unbind('change', addressValidationFieldsOnChange);
    $(currentAddressValidationObject.zipID).unbind('change', addressValidationFieldsOnChange);
}

//reinit global variables
function AddressVariablesReinit(addressObject) {
    currentAddressValidationObject = addressObject;
}

function IsFieldIsInAddressValidationObject(addressObject, field) {
    var addressLineID = addressObject.addressLineID;
    var cityID = addressObject.cityID;
    var stateID = addressObject.stateID;
    var countryID = addressObject.countryID;
    var zipID = addressObject.zipID;
    if ($(addressLineID)[0] == field || $(cityID)[0] == field || $(stateID)[0] == field || $(countryID)[0] == field || $(zipID)[0] == field) {
        return true;
    }
    return false;
}

function addressValidationFieldsOnChange(e) {
    if (!e) e = window.event;
    var currentItem = (e.target || e.srcElement);

    for (var i = 0; i < AddressValidationObjectList.length; ++i) {
        if (IsFieldIsInAddressValidationObject(AddressValidationObjectList[i], currentItem)) {

            AddressVariablesReinit(AddressValidationObjectList[i]);
            currentAddressValidationObject.isAddressValid = false;
            currentAddressValidationObject.isAddressValidBtnWasPressed = false;

            if ($("#hdnPreventClearZip") != undefined && !currentAddressValidationObject.addressVerificationIsSetuping)
                $("#hdnPreventClearZip").val('true');

            // check if Country change than we need to wait that states loaded/updated for correct address validation
            if (currentItem.id == $(currentAddressValidationObject.countryID).attr('id')) {
                setTimeout(function () {
                    validateAddress();
                }, 1000);
            }
            else {
                validateAddress();
            }
        }
    }
}

function AddAddressValidationClassForAllFields() {
    addAddressValidationClass(currentAddressValidationObject.addressLineID);
    addAddressValidationClass(currentAddressValidationObject.cityID);
    addAddressValidationClass(currentAddressValidationObject.countryID);
    addAddressValidationClass(currentAddressValidationObject.stateID);
    addAddressValidationClass(currentAddressValidationObject.zipID);
}

function getAddressStatus(alias, senderName) {
    reinitAddressVariablesByAlias(alias);
    currentAddressValidationObject.senderName = senderName;
    return currentAddressValidationObject.isAddressValid;
}

function isAddressValidBtnWasPressed(alias) {
    reinitAddressVariablesByAlias(alias);
    return currentAddressValidationObject.isAddressValidBtnWasPressed;
}

function wasAddressValidated(alias) {
    reinitAddressVariablesByAlias(alias);
    return !currentAddressValidationObject.AddressWasNotValidated;
}

function ShowAllDialogButtons() {
    var p = $('.btnAddressValidationAddress', getCurrentDialogWindow());
    $('.btnAddressValidationAddress', getCurrentDialogWindow()).show();
    $('.btnAddressCorrectConfirm_Cancel, .btnAddressCorrectConfirm_Ok', getCurrentDialogWindow()).hide();
}

function HideAllDialogButtons() {
    $('.btnAddressValidationAddress', getCurrentDialogWindow()).hide();
}

function UpdateDialogWindowSelectSimilarAdresses() {
    $('.ui-dialog-title', getCurrentDialogWindow()).html(contentTextObject.SelectSimilarVariants);
    ShowAllDialogButtons();
}

function UpdateDialogWindowAddressIncorrect() {
    $('.ui-dialog-title', getCurrentDialogWindow()).html(contentTextObject.AddressIsNotAccurate);
    ShowAllDialogButtons();
    $('.btnAddressValidationUpdate', getCurrentDialogWindow()).hide();
}

function UpdateDialogWindowServiceIsNotWorking(inputAddress) {
    $('.ui-dialog-title', getCurrentDialogWindow()).html(contentTextObject.ConfirmationTitle);
    $(currentAddressValidationObject.dialogWindowContent).html(contentTextObject.ServiceIsNotWorking);

    var currentAddressObject = inputAddress.split(",,");
    var addressLine = currentAddressObject.length > 0 ? currentAddressObject[0] : "";
    var city = currentAddressObject.length > 1 ? currentAddressObject[1] : "";
    var state = currentAddressObject.length > 2 ? currentAddressObject[2] : "";
    var country = currentAddressObject.length > 3 ? currentAddressObject[3] : "";
    var zip = currentAddressObject.length > 4 ? currentAddressObject[4] : "";
    var stateCode = $('option:selected', currentAddressValidationObject.stateID).val() || "";

    var address = '<div style="display: block;margin-top: 5px;"><input name="addressRadio" type="radio" class="addressRadio"'
        + 'data-city="' + city + '"'
        + 'data-country="' + country + '"'
        + 'data-zip="' + zip + '"'
        + 'data-state="' + state + '"'
        + 'data-state-code="' + stateCode + '"'
        + 'data-addressLine="' + addressLine + '"'
        + '/>'
        + '<span style="font-weight: bold;margin-bottom: 5px;margin-top: 5px;">' + addressLine + ', ' + city + ', ' + state + ', ' + country + ', ' + zip + '</span></div>';
    $(currentAddressValidationObject.dialogWindowContent).append(address);
    $('.addressRadio', getCurrentDialogWindow()).first().prop('checked', true);
    ShowAllDialogButtons();
    $('.btnAddressValidationUpdate', getCurrentDialogWindow()).hide();
}

function replaceAll(str, find, replace) {
    return str.replace(new RegExp(find, 'g'), replace);
}

function UpdateDialogWindowAddressValid() {
    $('.ui-dialog-title', getCurrentDialogWindow()).html('Address is valid');
    HideAllDialogButtons();
}

function showAddressIsCorrectBeforeManualSettingConfirmation() {
    currentAddressValidationObject.tempDialogWindowTitle = $('.ui-dialog-title', getCurrentDialogWindow()).html();
    $('.ui-dialog-title', getCurrentDialogWindow()).html(contentTextObject.ConfirmationTitle);

    currentAddressValidationObject.tempDialogWindowContent = $(currentAddressValidationObject.dialogWindowContent).html();
    $(currentAddressValidationObject.dialogWindowContent).html(contentTextObject.AddressIsCorrectConfirm);

    HideAllDialogButtons();
    $('.btnAddressCorrectConfirm_Cancel, .btnAddressCorrectConfirm_Ok', getCurrentDialogWindow()).show();
}

function revertDailogWindowToPrevioesView() {
    $('.ui-dialog-title', getCurrentDialogWindow()).html(currentAddressValidationObject.tempDialogWindowTitle);
    $(currentAddressValidationObject.dialogWindowContent).html(currentAddressValidationObject.tempDialogWindowContent);
    ShowAllDialogButtons();
    if (currentAddressValidationObject.hideUpdateButton) {
        $('.btnAddressValidationUpdate', getCurrentDialogWindow()).hide();
    }
    
    $('.addressRadio', getCurrentDialogWindow()).first().prop('checked', true);
    //clear temp data
    currentAddressValidationObject.tempDialogWindowContent = '';
    currentAddressValidationObject.tempDialogWindowTitle = '';
}

function UpdateDialogWindowAddressIsNotValid() {
    $('.ui-dialog-title', getCurrentDialogWindow()).html(contentTextObject.AddressIsNotAccurate);
    ShowAllDialogButtons();
    $('.btnAddressValidationUpdate', getCurrentDialogWindow()).hide();
}

function addAddressValidationClass(element) {
    if (!$(element).hasClass('addressValidationFields')) {
        $(element).addClass('addressValidationFields')
    }
}

function validateAddress() {
    var validationId = guid();
    currentAddressValidationObject.runningValidationIds.push(validationId);

    var error = isAddressCompleted(currentAddressValidationObject.addressLineID, currentAddressValidationObject.cityID, currentAddressValidationObject.stateID, currentAddressValidationObject.countryID, currentAddressValidationObject.zipID);

    if (!isAddressValidationAllowed(currentAddressValidationObject.countryID)) {
        AddressValidationIsNotAllowedCallBack(validationId);
        return;
    }

    if (error != '') {
        $(currentAddressValidationObject.dialogWindowContent).html('');
        $(currentAddressValidationObject.dialogWindowContent).append('<span style="color:Red;">For address validation these fields: ' + error + ' are required.</span>');
        HideAllDialogButtons();
        AddressValidationIsNotAllowedCallBack(validationId);
        return;
    }

    if (currentAddressValidationObject.isAddressValid && error == '') {
        validationFinished(true, validationId);
    }
    else {
        
        $(currentAddressValidationObject.dialogWindowContent).html('');
        var useStrongValidationUrl = '';
        if (currentAddressValidationObject.useStrongValidation != undefined) {
            useStrongValidationUrl = '[param=]' + currentAddressValidationObject.useStrongValidation;
        }

        if (error == '') {
            //prevent double verification
            if (currentAddressValidationObject.addressVerificationIsSetuping) {
                removeValidationId(validationId);
                return;
            }
            currentAddressValidationObject.addressVerificationIsSetuping = true;
            var inputAddress = buildAddress(currentAddressValidationObject.addressLineID, currentAddressValidationObject.cityID, currentAddressValidationObject.stateID, currentAddressValidationObject.countryID, currentAddressValidationObject.zipID);
            //validate address
            currentAddressValidationObject.hideUpdateButton = false;
            var saveCurrentAddressObject = currentAddressValidationObject;
            $.post('/v2/WebService/ajaxService.aspx?op=ValidateAddresses&a=' + inputAddress + useStrongValidationUrl, function (data, status) {
                var code;
                AddressVariablesReinit(saveCurrentAddressObject);
                var serviceIsNotWorking = true;
                if (data != undefined) {
                    try {
                        data = JSON.parse(data)
                        code = data.Status;
                        currentAddressValidationObject.AddressWasNotValidated = false;

                        // 0 - address validated successfully
                        // 1 - address is not very accurate, couple similar variants are found
                        // 2 - address is not accurate, no alternative variants
                        // 3 - error during validation
                        // 4 - not authorized
                        //-1 - address was not validated
                        if (code == -1) {
                            AddressValidationIsNotAllowedCallBack(validationId);
                            serviceIsNotWorking = false;
                        }
                        if (code == 0) {
                            currentAddressValidationObject.isAddressValid = true;
                            serviceIsNotWorking = false;
                            validationFinished(null, validationId);
                        }
                        if (code == 1) {
                            //get similar addresses
                            $(currentAddressValidationObject.dialogWindowContent).html('');
                            if (data.SimilarAddresses != undefined) {
                                var array = data.SimilarAddresses;
                                for (var i = 0; i < array.length; ++i) {
                                    var element = array[i];
                                    var city = element.City || '';
                                    var country = element.Country || '';
                                    var zip = element.Zip || '';
                                    var state = element.State || '';
                                    var stateCode = element.StateCode || '';
                                    var addressLine = element.AddressLine || '';
                                    var address = '<div style="display: block;margin-bottom: 5px;"><input name="addressRadio" type="radio" class="addressRadio"'
                                        + 'data-city="' + city + '"'
                                        + 'data-country="' + country + '"'
                                        + 'data-zip="' + zip + '"'
                                        + 'data-state="' + state + '"'
                                        + 'data-state-code="' + stateCode + '"'
                                        + 'data-addressLine="' + addressLine + '"'
                                        + '/>'
                                        + '<span style="font-weight: bold;margin-bottom: 5px;margin-top: 5px;">' + addressLine + ', ' + city + ', ' + state + ', ' + country + ', ' + zip + '</span></div>';
                                    $(currentAddressValidationObject.dialogWindowContent).append(address);
                                }
                                $('.addressRadio', getCurrentDialogWindow()).first().prop('checked', true);
                                UpdateDialogWindowSelectSimilarAdresses();
                                //disable update button for correct server code updating
                                var updateButton = $('.btnAddressValidationUpdate', getCurrentDialogWindow());
                                $(updateButton).attr("disabled", "disabled");
                                setTimeout(function () {
                                    $(updateButton).removeAttr('disabled');
                                }, 2500);

                                //showDialog();
                                serviceIsNotWorking = false;
                                validationFinished(null, validationId);
                            }
                        }
                        if (code == 2) {
                            $(currentAddressValidationObject.dialogWindowContent).html('');
                            $(currentAddressValidationObject.dialogWindowContent).append('<span style="color:Red;">Address is not valid.</span>');
                            UpdateDialogWindowAddressIncorrect();
                            
                            //showDialog();
                            serviceIsNotWorking = false;
                            currentAddressValidationObject.hideUpdateButton = true;
                            validationFinished(null, validationId);
                        }
                    }
                    catch(err) {
                        serviceIsNotWorking = true;
                    }

                    if (serviceIsNotWorking) {
                        currentAddressValidationObject.hideUpdateButton = true;
                        UpdateDialogWindowServiceIsNotWorking(inputAddress);

                        //showDialog();
                        validationFinished(null, validationId);
                    }
                }

                currentAddressValidationObject.addressVerificationIsSetuping = false;
                removeValidationId(validationId);
            });
        }
    }
}

function AddressValidationIsNotAllowedCallBack(validationId) {
    currentAddressValidationObject.isAddressValid = true;
    currentAddressValidationObject.AddressWasNotValidated = true;
    validationFinished(null, validationId);
}

function showDialog() {
    $(currentAddressValidationObject.dialogWindowID).dialog('open');
}

function buildAddress(addressLineID, cityID, stateID, countryID, zipID) {
    var addressLine = $(addressLineID).val();
    var city = $(cityID).val();
    var state = $('option:selected', stateID).text();
    var country = $('option:selected', countryID).text();
    if (country == "") {
        country = $(countryID).val();
    }
    var zip = $(zipID).val();
    var separator = ",,";
    var address = addressLine + separator + city + separator + state + separator + country + separator + zip;
    return address;
}

function isAddressCompleted(addressLineID, cityID, stateID, countryID, zipID) {
    var addressLine = $(addressLineID).val();
    var city = $(cityID).val();
    var state = $(stateID).val();
    var country = $(countryID).val();
    var zip = $(zipID).val();
    var error = '';
    error = validateAddressPart(error, addressLine, 'Address Line 1');
    error = validateAddressPart(error, city, 'City');
    error = validateAddressPart(error, state, 'State');
    error = validateAddressPart(error, country, 'Country');
    error = validateAddressPart(error, zip, 'Zip');
    return error;
}

function validateAddressPart(error, value, strValue) {
    if (value != undefined && (value == '' || value.trim() == '')) {
        if (error != '') {
            error += ', ';
        }
        error += strValue;
    }
    return error;
}

function updateAddress(addressLine, city, state, country, zip, stateCode) {
    if ($("#hdnPreventClearZip") != undefined)
        $("#hdnPreventClearZip").val('false');

    $(currentAddressValidationObject.addressLineID).val(addressLine);
    $(currentAddressValidationObject.cityID).val(city);

    country = country.toUpperCase().trim();
    var countryCode = GetCountryCodeByCountryName(country);
    if ($(currentAddressValidationObject.countryID).val().toUpperCase().trim() != countryCode) {
        $('option', currentAddressValidationObject.countryID).each(function () {
            if ($(this).text().toUpperCase().trim() == country || (countryCode != '' && $(this).val() == countryCode)) {
                if (!$(this).prop('selected')) {
                    $(this).prop('selected', true);
                    //stop address validation
                    currentAddressValidationObject.addressVerificationIsSetuping = true;
                    //init event for loading states
                    $(currentAddressValidationObject.countryID).change();
                    //enable address validation
                    currentAddressValidationObject.addressVerificationIsSetuping = false;
                }
            }
        });
    }

    //wait while state will be loaded via ajax
    state = state.toUpperCase().trim();
    stateCode = stateCode.toUpperCase().trim();
    var delay = 500;
    var maxAttempt = 4;
    var stateUpdated = false;
    updateState(currentAddressValidationObject, state, stateCode, delay, 1, maxAttempt, stateUpdated);

    $(currentAddressValidationObject.zipID).val(zip);
}

function updateState(addressValidationObject, stateVal, stateCode, delay, attempt, maxAttempt, stateUpdated) {
    if (stateUpdated || attempt >= maxAttempt) {
        tryToSynchronizeAddresses();
        return;
    }
    //try to update state
    $('option', addressValidationObject.stateID).each(function () {
        if (stateCode != '' && stateCode != undefined) {
            if ($(this).val().toUpperCase().trim() == stateCode && $(addressValidationObject.stateID).val().toUpperCase().trim() != stateCode) {
                if (!$(this).prop('selected')) {
                    addressValidationObject.addressVerificationIsSetuping = true;
                    $(this).prop('selected', true);
                    addressValidationObject.addressVerificationIsSetuping = false;
                    stateUpdated = true;
                }
            }
        }
        else {
            if ($(this).text().toUpperCase().trim() == stateVal && $(addressValidationObject.stateID).text().toUpperCase().trim() != stateVal) {
                if (!$(this).prop('selected')) {
                    addressValidationObject.addressVerificationIsSetuping = true;
                    $(this).prop('selected', true);
                    addressValidationObject.addressVerificationIsSetuping = false;
                    stateUpdated = true;
                }
            }
        }
    });
    //wait and try again
    setTimeout(function () {
        updateState(addressValidationObject, stateVal, stateCode, delay, attempt + 1, maxAttempt, stateUpdated);
    }, delay);
}

function tryToSynchronizeAddresses() {
    //init synchronization
    if (typeof AddressSyncronization_SynchronizeObjectsByIndexes == 'function') {
        AddressSyncronization_SynchronizeObjectsByIndexes(1, 0);
    }
}

function getCurrentDialogWindow() {
    return $(currentAddressValidationObject.dialogWindowID).closest('.ui-dialog');
}

function ShowAddressValidationDialog(dialogID, alias) {
    if (isValidationInProgress())
        currentAddressValidationObject.openDialogAfterValidation = true;
    else {
        reinitAddressVariablesByAlias(alias);
        var chb = $('.addressRadio', dialogID).first();
        if (chb != undefined) {
            $(chb).prop('checked', true);
        }
        $(dialogID).dialog('open');
    }
}

function removeValidationId(validationId) {
    if (validationId != '' && validationId != undefined) {
        var indexOfElement = currentAddressValidationObject.runningValidationIds.indexOf(validationId);
        if (indexOfElement > -1) {
            if (indexOfElement == 0)
                currentAddressValidationObject.runningValidationIds.shift();
            else
                currentAddressValidationObject.runningValidationIds.splice(indexOfElement, 1);
        }
    }
}

function validationFinished(isPartialCallBack, validationId) {
    removeValidationId(validationId);

    if (!isValidationInProgress()) {
        if (currentAddressValidationObject.openDialogAfterValidation && !currentAddressValidationObject.isAddressValid &&
            $(currentAddressValidationObject.dialogWindowContent).html() != "") {
            ShowAddressValidationDialog(currentAddressValidationObject.dialogWindowID, currentAddressValidationObject.alias);
            currentAddressValidationObject.openDialogAfterValidation = false;
        }
        else if (currentAddressValidationObject.senderName != undefined && currentAddressValidationObject.senderName != "") {
            __doPostBack(currentAddressValidationObject.senderName, "");
        }

        currentAddressValidationObject.validationFinishCallBack(isPartialCallBack);
    }
}

function isValidationInProgress() {
    return currentAddressValidationObject.runningValidationIds.length > 0;
}

function reinitAddressVariablesByAlias(alias) {
    if (alias != undefined && alias != '') {
        for (var i = 0; i < AddressValidationObjectList.length; ++i) {
            if (AddressValidationObjectList[i].alias == alias) {
                AddressVariablesReinit(AddressValidationObjectList[i]);
            }
        }
    }
}

function AddressVerification_SynchronizeStatuses() {
    for (var i = 0; i < AddressValidationObjectList.length; ++i) {
        AddressValidationObjectList[i].isAddressValid = currentAddressValidationObject.isAddressValid;
        AddressValidationObjectList[i].isAddressValidBtnWasPressed = currentAddressValidationObject.isAddressValidBtnWasPressed;
        AddressValidationObjectList[i].AddressWasNotValidated = currentAddressValidationObject.AddressWasNotValidated;
        AddressValidationObjectList[i].addressVerificationIsSetuping = false;
        AddressValidationObjectList[i].hideUpdateButton = currentAddressValidationObject.hideUpdateButton;
        AddressValidationObjectList[i].openDialogAfterValidation = currentAddressValidationObject.openDialogAfterValidation;
        AddressValidationObjectList[i].runningValidationIds = currentAddressValidationObject.runningValidationIds;
    }
}

function GetCountryCodeByCountryName(name) {
    var code = "";
    switch (name) {
        case "UNITED STATES":
            code = "US";
            break;
        case "CANADA":
            code = "CA";
            break;
    }
    return code;
}

function isAddressValidationAllowed(countryID) {
    return true;
    var country = $(countryID).val();

    if (country == undefined || country == '') {
        return false;
    }

    //replace all whitespaces
    country = replaceAll(country, ' ', '');

    if (allowedCountryCodes.Length == 0) {
        return false;
    }
    if (allowedCountryCodes.indexOf(country) >= 0) {
        return true;
    }

    return false;
}

function guid() {
    return s4() + s4() + '-' + s4() + '-' + s4() + '-' +
      s4() + '-' + s4() + s4() + s4();
}

function s4() {
    return Math.floor((1 + Math.random()) * 0x10000)
      .toString(16)
      .substring(1);
}