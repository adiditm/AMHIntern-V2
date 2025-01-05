<?php
    error_reporting (E_ALL ^ E_NOTICE);
    session_start();
    include_once("../server/config.php");
	if ($_SESSION['LoggedIn']=="Yes") {
      if ($_SESSION['Priv']=='administrator')
	  header("Location: xsystem/manager/indexadmin.php");
	  else
	  header("Location: xsystem/memstock/index.php");
	}

   include_once($CLASS_DIR."memberclass.php");
   include_once($CLASS_DIR."dateclass.php");
   include_once($CLASS_DIR."networkclass.php");
   include_once($CLASS_DIR."ifaceclass.php");
   include_once($CLASS_DIR."ruleconfigclass.php");
   include_once($CLASS_DIR."komisiclass.php");
   include_once($CLASS_DIR."jualclass.php");
   include_once($CLASS_DIR."systemclass.php");
   include_once($CLASS_DIR."productclass.php");
   include_once($CLASS_DIR."texttoimageclass.php");
	
	?>
<!DOCTYPE html>
<html lang="en"><head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta charset="utf-8"><meta name="HandheldFriendly" content="true">
<meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Nexsukses - Registration Form</title>

<link href="../css/font-awesome.css" rel="stylesheet">
<link href="../css/bootstrap.css" rel="stylesheet" media="screen">
<link rel="stylesheet" href="../css/all_Jworld.css" media="all">
	<!--[if lt IE 9]><link rel="stylesheet" href="/css/ie.css" media="screen" /><![endif]-->
	<!--[if IE]><script type="text/javascript" src="/js/Jworld/ie.js"></script><![endif]-->
     <link rel="stylesheet" href="../css/stylereg.css">
        <link rel="stylesheet" href="../css/normalize.css">
  <script src='http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js'></script>
    
    <script type="text/javascript">

        var _gaq = _gaq || [];
        _gaq.push( ['_setAccount', 'UA-63189529-1'] );
        _gaq.push(['_setDomainName', 'jeunesseglobal.com']);
        _gaq.push(['_trackPageview']);

        (function () {
            var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
            ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
            var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
        })();

        </script>
<!-- <link href="regformfiles/WebResource.css" type="text/css" rel="stylesheet" class="Telerik_stylesheet"> -->

</head> 
<body class="color-scheme-01">
	<div id="wrapper">
		<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
			<div id="header" class="container">
				<div class="navbar-header" style="font-size:2em">
					<div id="layoutHeader_divNavBar">
                    Fill Your Data
					</div>
                    
				</div>
				<div class="navbar-collapse navigation">
					<span class="bg"></span>				
				</div>
			</div>
		</nav>
		<div id="main">
			<div class="container">

					
       		
<!--BEGIN PAGE CONTENTS HERE -->
  

<script type="text/javascript">

    function CheckBoxRequired_ClientValidate(sender, e) {
        e.IsValid = $(".cbTextingAcceptAdditionalCharges input:checkbox").is(':checked');
    }
    function CheckBoxRequired2_ClientValidate(sender, e) {
        e.IsValid = $(".cbTextingIsNotRequirment input:checkbox").is(':checked');
    }

    function isNumberKey(evt) {
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }

    function updateProdTotal(chkbox, qty, BV, price, BVTotal, ProdTotal, footerPrice, footerBV, prodname, country) {
        var chkboxctrl = $get(chkbox);
        var qtyctrl = $get(qty);
        var BVctrl = $get(BV);
        var pricectrl = $get(price);
        var BVTotalctrl = $get(BVTotal);
        var ProdTotalctrl = $get(ProdTotal);
        var TotalPackPrice = $get(footerPrice);
        var TotalPackBV = $get(footerBV);
        var prodname = $get(prodname);

        if (chkboxctrl.checked) {
            if (prodname.innerHTML.toString() == "AM &amp; PM Essentials™" && parseInt(qtyctrl.value) > 1 && country == "JP") {
                BVTotalctrl.value = parseInt(BVctrl.innerHTML) * 1;
                ProdTotalctrl.value = (Math.round((parseFloat(pricectrl.innerHTML) * 1 * 100)) / 100).toFixed(2);
                qtyctrl.value = 1;
            }
            else {
                BVTotalctrl.value = parseInt(BVctrl.innerHTML) * parseInt(qtyctrl.value);
                ProdTotalctrl.value = (Math.round((parseFloat(pricectrl.innerHTML) * parseInt(qtyctrl.value) * 100)) / 100).toFixed(2);
            }
        }
        else {
            BVTotalctrl.value = 0;
            ProdTotalctrl.value = 0;
        }
        updatePackTotal(footerPrice, footerBV);
    }
    function updatePackTotal(footerPrice, footerBV) {
        var TotalPackPrice = $get(footerPrice);
        var TotalPackBV = $get(footerBV);
        var grid = $find("rgCreatePack");
        var MasterTable = grid.get_masterTableView();
        var Rows = MasterTable.get_dataItems();
        var prodBV = 0;
        var prodPrice = 0.0;
        for (var i = 0; i < Rows.length; i++) {
            var row = Rows[i];
            prodBV = prodBV + parseInt(row.findElement("txtBV").value);
            prodPrice = prodPrice + parseFloat(row.findElement("txtPackSubtotal").value);
        }
        TotalPackBV.value = prodBV;
        TotalPackPrice.value = (Math.round(prodPrice * 100) / 100).toFixed(2);
    }

    function checkIfUrlAvail() {

        var url = "ajaxOperations.asp?operId=1&siteUrl=" + document.getElementById("txtSiteURL").value + "&nd = " + (new Date()).getTime() + "&l=" + document.getElementById("ddlLanguage").value;
        xmlHttp = GetXmlHttpObject(stateChanged);
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }

    function onLangChange(obj, url) {

        //var lngindex = document.getElementById("ddlLanguage").value; 
        var lngindex = obj.options[obj.selectedIndex].value;
        var link = url + "&lang=" + lngindex;
        document.form1.action = link;
        document.form1.submit();

    }
    function onChange(url) {


        var link = url;
        document.form1.action = link;
        document.form1.submit();

    }


    function stateChanged() {
        document.getElementById("UrlAvailStatus").innerHTML = '';

        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {

            document.getElementById("UrlAvailStatus").innerHTML = xmlHttp.responseText;

        }
    }

    function ValidateVeteranCode(returnURL)
{
        
       var url="ajaxOperations.asp?operId=VC&code=" + document.getElementById("txtVeteranCode").value  ;         
       xmlHttp=GetXmlHttpObject(stateChangedVC);
       xmlHttp.open("GET", url , false);
       xmlHttp.send(null);         
           
}

 function stateChangedVC() 
{ 
    document.getElementById("lblVeteranCodeValidate").innerHTML = '';    
     
    if (xmlHttp.readyState==4 || xmlHttp.readyState=="complete")
    {      
        document.getElementById("lblVeteranCodeValidate").innerHTML = xmlHttp.responseText;
    }
}
function DisplayVCPacksLink()
{
    str = document.getElementById("lblVeteranCodeValidate").innerHTML;    
    if (str.indexOf("Your code is Valid.") >= 0 ) 
    {
        document.getElementById("VeteranCodePackLink").style.display = "";
    }
    else 
    {
         document.getElementById("VeteranCodePackLink").style.display = "none";
    }
}

function ValidatePassword() {
        if (document.getElementById("Password").value != document.getElementById("ConfirmPassword").value) {
            document.getElementById("DivConfirmPassword").innerHTML = "<font color=red>Passwords do not match</font>";
        }
        else {
            document.getElementById("DivConfirmPassword").innerHTML = "";
        }
    }

    function ValidateSSN(country) {
        var url = "ajaxOperations.asp?operId=5&c=" + country + "&ssn=" + document.getElementById("txtssn").value;
        xmlHttp = GetXmlHttpObject(stateChanged1);
        xmlHttp.open("GET", url, true);
        xmlHttp.send(null);
    }
    function stateChanged1() {
        document.getElementById("txtSSnValidate").innerHTML = '';

        if (xmlHttp.readyState == 4 || xmlHttp.readyState == "complete") {
            document.getElementById("txtSSnValidate").innerHTML = xmlHttp.responseText;
        }
    }
    function ValidateZip(country) {
        var zip = document.getElementById("zip").value;

        if (country == "US") {

            if (zip.length != 5 || isNaN(zip)) {
                document.getElementById("InvalidZip").innerHTML = "<font color=red>U.S.A Zipcode must be a 5 digit number.</font>";
            }
           
            else {
                document.getElementById("InvalidZip").innerHTML = "";
            }
        }
        //DBell, 2015-08-19, Task #12023. BR should have a maximum 8 digit numeric zipcode
        if (country == "BR") {

            if (zip.length > 8 || zip.length < 1 || isNaN(zip)) {
                document.getElementById("InvalidZip").innerHTML = "<font color=red>Brazil Postal Code must be a maximum of 8 numeric digits</font>";
            }
           
            else {
                document.getElementById("InvalidZip").innerHTML = "";
            }
        }
    }

    function ValidateShipZip(country) {

        var shipzip = document.getElementById("ShippingZip").value;
        if (document.getElementById("ddlShippingCountry").value == "US") {
            if (shipzip.length != 5 || isNaN(shipzip)) {
                document.getElementById("InvalidShippingZip").innerHTML = "<font color=red>U.S.A Zipcode must be a 5 digit number.</font>";
            }
            
            else {
                document.getElementById("InvalidShippingZip").innerHTML = "";
            }
        }
        //DBell, 2015-08-19, Task #12023. BR should have a maximum 8 digit numeric zipcode
        if (document.getElementById("ddlShippingCountry").value == "BR") {
            if (shipzip.length > 8 || shipzip.length < 1 || isNaN(shipzip)) {
                document.getElementById("InvalidShippingZip").innerHTML = "<font color=red>Brazil Shipping Postal Code must be a maximum of 8 numeric digits</font>";
            }
            
            else {
                document.getElementById("InvalidShippingZip").innerHTML = "";
            }
        }
    }

    function ValidateZip2() {
        var zip1 = document.getElementById("jpZip1").value;
        var zip2 = document.getElementById("jpZip2").value;

        if (zip1.length != 3 || isNaN(zip1) || zip2.length != 4 || isNaN(zip2)) {
            document.getElementById("InvalidZip2").innerHTML = "<font color=red>Japan Zipcode must be a 3 digit number and a 4 digit number.</font>";
        }
        else {
            document.getElementById("InvalidZip2").innerHTML = "";
        }
    }

    function ValidateShipZip2() {
        var zip1 = document.getElementById("jpShipZip1").value;
        var zip2 = document.getElementById("jpShipZip2").value;

        if (zip1.length != 3 || isNaN(zip1) || zip2.length != 4 || isNaN(zip2)) {
            document.getElementById("InvalidShippingZip2").innerHTML = "<font color=red>Japan Zipcode must be a 3 digit number and a 4 digit number.</font>";
        }
        else {
            document.getElementById("InvalidShippingZip2").innerHTML = "";
        }
    }

    function validateBRRG(country) {
        var country = document.getElementById("ddlCountry").value;
        var brrg = document.getElementById("txtBR_RG").value;
        if (country == "BR") {
            // 6 - 15 numeric digits
            if (brrg.length < 6 || brrg.length > 15 || isNaN(brrg)) {
                document.getElementById("InvalidBRRG").innerHTML = "<font color=red>Invalid RG number.  Must be 6 to 15 numeric digits.</font>";
            }
            else {
                document.getElementById("InvalidBRRG").innerHTML = "";
            }
        }
    }
    //#13010
    function validateNPWPnum(country) {
        var country = document.getElementById("ddlCountry").value;
        var strNPWPNum = document.getElementById("txtNPWPNum").value;
        if (country == "ID")  {
            // 15 digits
            if (strNPWPNum.length < 15) {
                document.getElementById("InvalidNPWPNum").innerHTML = "<font color=red>Invalid NPWP Number - must be 15 numeric digits</font>";
            }
            else {
                document.getElementById("InvalidNPWPNum").innerHTML = "";
            }
        }
        else {         
                document.getElementById("InvalidNPWPNum").innerHTML = "";
        }
    }
    function validateNPWPZip(country) {
        var zip = document.getElementById("txtNPWPZip").value;

        if (country == "ID") {

            if (zip.length != 5 || isNaN(zip)) {
                document.getElementById("InvalidNPWPZip").innerHTML = "<font color=red>NPWP Zipcode must be a 5 digit number.</font>";
            }
           
            else {
                document.getElementById("InvalidNPWPZip").innerHTML = "";
            }
        }
        else {
                document.getElementById("InvalidNPWPZip").innerHTML = "";
        }
        
    }

    function validatePhone(country) {
        var country = document.getElementById("ddlCountry").value;
        var strPhone = document.getElementById("txtPhone").value;
        if (country == "PL" || country == "KR") {
            // 9 - 15 digits
            if (strPhone.length < 9 || strPhone.length > 15) {
                document.getElementById("InvalidPhone").innerHTML = "<font color=red>Error (no dashes)</font>";
            }
            else {
                document.getElementById("InvalidPhone").innerHTML = "";
            }
        }
        else {
            if (country == "IT" ) //#12438
            {
                // 8-12 digits
                if (strPhone.length < 8 || strPhone.length > 12) {
                    document.getElementById("InvalidPhone").innerHTML = "<font color=red>Error (no dashes).</font>";
                }
                else {
                    document.getElementById("InvalidPhone").innerHTML = "";
                }
            }
            else {
            // 10 - 15 digits
            if (strPhone.length < 10 || strPhone.length > 15) {
                document.getElementById("InvalidPhone").innerHTML = "<font color=red>Error (no dashes)</font>";
            }
            else {
                document.getElementById("InvalidPhone").innerHTML = "";
            }
        }
    }
    }

    function validateSecondPhone(country) {
        var country = document.getElementById("ddlCountry").value;
        var strPhone = document.getElementById("SecondPhone").value;
        if (country == "PL" || country == "KR") {
            // 9 - 15 digits
            if (strPhone.length < 9 || strPhone.length > 15) {
                document.getElementById("InvalidSecondPhone").innerHTML = "<font color=red>Error (no dashes)</font>";
            }
            else {
                document.getElementById("InvalidSecondPhone").innerHTML = "";
            }
        }
        else {
            if (country == "IT" ) //#12438
            {
                // 8-12 digits
                if (strPhone.length < 8 || strPhone.length > 12) {
                    document.getElementById("InvalidPhone").innerHTML = "<font color=red>Error (no dashes).</font>";
                }
                else {
                    document.getElementById("InvalidPhone").innerHTML = "";
                }
            }
            else {
            // 10 - 15 digits
            if (strPhone.length < 10 || strPhone.length > 15) {
                document.getElementById("InvalidSecondPhone").innerHTML = "<font color=red>Error (no dashes)</font>";
            }
            else {
                document.getElementById("InvalidSecondPhone").innerHTML = "";
            }
        }
    }
    }
    function validateSMSPhone() {
        var country = document.getElementById("ddlCountry").value;
        var strPhone = document.getElementById("txtSMSNumber").value;
        if (country == "PL" || country == "KR") {
            // 9 - 15 digits
            if (strPhone.length < 9) {
                document.getElementById("divSMSNumberMsg").innerHTML = "<font color=red>number too short!</font>";
            }
            else if (strPhone.length > 15) {
                document.getElementById("divSMSNumberMsg").innerHTML = "<font color=red>number too long!</font>";
            }
            else {
                document.getElementById("divSMSNumberMsg").innerHTML = "";
            }
        }
        else {
            // 10 - 15 digits
            if (strPhone.length < 10) {
                document.getElementById("divSMSNumberMsg").innerHTML = "<font color=red>number too short!</font>";
            }
            else if (strPhone.length > 15) {
                document.getElementById("divSMSNumberMsg").innerHTML = "<font color=red>number too long!</font>";
            }
            else {
                document.getElementById("divSMSNumberMsg").innerHTML = "";
            }
        }
    }

    function validateABA_RoutingNumber() {
        var t = document.getElementById("txtRouting_number").value;
        // Run through each digit and calculate the total.
        n = 0;
        for (i = 0; i < t.length; i += 3) {
            n += parseInt(t.charAt(i),     10) * 3
              +  parseInt(t.charAt(i + 1), 10) * 7
              +  parseInt(t.charAt(i + 2), 10);
        }

        // the aba routing number is good.
        if (n != 0 && n % 10 == 0)
            document.getElementById("divABNRoutingNumberMsg").innerHTML = "";// good
        else
            document.getElementById("divABNRoutingNumberMsg").innerHTML = "<font color=red>Invalid Routing Number</font>";// bad
        
    }

    function validateBranchCode() {
        var country = document.getElementById("ddlCountry").value;
        var branchCode = document.getElementById("txtBankBranchCode").value;
        var bankCode = document.getElementById("txtBankNameCode").value;
        document.getElementById("divBankBranchMsg").innerHTML = ""; //default to good.
        if (country == "BR")
        {
            //do some checking in here. for control digit.
            if (bankCode == "237"){
                if (!controlDigitCheck(branchCode)){
                    document.getElementById("divBankBranchMsg").innerHTML = "<font color=red>Invalid Control Digit</font>";// bad
                }
            }
        }
    }

    function validateBankAccountNumber() {
        var country = document.getElementById("ddlCountry").value;
        var accountNum = document.getElementById("txtBankAccountNumber").value;
        var bankCode = document.getElementById("txtBankNameCode").value;
        document.getElementById("divBankAccountNumberMsg").innerHTML = ""; //default to good.
        if (country == "BR")
        {
            //do some checking in here. for control digit.
            if (bankCode == "237"){
                if (!controlDigitCheck(accountNum)){
                    document.getElementById("divBankAccountNumberMsg").innerHTML = "<font color=red>Invalid Control Digit</font>";// bad
                }
            }
        }
    }

    function validateCPF(sender, args) {
                 sender.innerText="Invalid CPF format";
                 args.IsValid = validarCPF(args.Value);
        }

    

    //Algorithm for bradesco control digits -- larger explanation in control_digit_check method in AddNew.aspx.cs
    function controlDigitCheck(checkNumberFull) {
        //Add this back in later
        //    if (!txtBankNameEntered.Text.ToLower().Contains("bradesco"))
        //{
        //        return true; //if we are not a bradesco bank, don't check the control digit.
        //}

        var enteredControlDigit = "";
        var checkValue = "  ";
        var splitString = checkNumberFull.split('-');  //???

        if (splitString.Length < 2)
        {
            return false;
        }

        checkValue = splitString[0];
        enteredControlDigit = splitString[1];

        var weight = 2;
        var sum = 0;
        for (var i = checkValue.length - 1; i >= 0; i--) {
            sum += checkValue.substr(i, 1) * weight;
            weight++;
            if (weight > 7) {
                weight = 2;
            }
        }
        var controlDigit = 11 - (sum % 11);

        if (controlDigit == 10) {
            if (enteredControlDigit.toLowerCase() == "p" || enteredControlDigit == "0" || enteredControlDigit == "00")
                return true; 
            else
                return false;
        } else if (controlDigit == 11) {
            if (enteredControlDigit == "0" || enteredControlDigit =="00") // I realize we could int32.parse this, but this avoids format exceptions, and isn't too onorous.
                return true;
            else
                return false;
        } else {
            if (parseInt(enteredControlDigit) == controlDigit)
                return true;
            else
                return false;
        }
    }

    function AutoFillNames() {
        var country = document.getElementById("ddlCountry").value;
        if (country == "KR" || country == "TH") {
            document.getElementById("txtCheckName").value = document.getElementById("txtFnameNonEng").value + ' ' + document.getElementById("txtLnameNonEng").value;
            document.getElementById("txtDisplayName").value = document.getElementById("txtFnameNonEng").value + ' ' + document.getElementById("txtLnameNonEng").value;
            document.getElementById("txtBillingFname").value = document.getElementById("txtFnameNonEng").value;
            document.getElementById("txtBillingLname").value = document.getElementById("txtLnameNonEng").value;
            document.getElementById("ShippingName").value = document.getElementById("txtFnameNonEng").value;
            document.getElementById("ShippingLName").value = document.getElementById("txtLnameNonEng").value;


        }
        else if (country == "US"){
            // LCK 2015-04-19 - change txtCheckName to match txtBankAccountName if set and lock txtCheckName
            if (document.getElementById("txtBankAccountName").value != ''){
                document.getElementById("txtCheckName").value = document.getElementById("txtBankAccountName").value;
                document.getElementById("txtCheckName").readOnly = true;
                if (document.getELementById("txtRouting_Number").value != ''){
                    ValidatorEnable(document.GetElmentById("cvalRoutingNumber"), true);
                    ValidatorDisable(document.GetElementById("CheckNameValidate"), true)
                }
            }
            else {
                document.getElementById("txtCheckName").value = document.getElementById("txtFNameEng").value + ' ' + document.getElementById("txtLNameEng").value;
            }            
            document.getElementById("txtDisplayName").value = document.getElementById("txtFNameEng").value + ' ' + document.getElementById("txtLNameEng").value;
        }
        else {

            document.getElementById("txtCheckName").value = document.getElementById("txtFNameEng").value + ' ' + document.getElementById("txtLNameEng").value;

            if (country == "CN" || country == "HK" || country == "MO") {
                document.getElementById("txtDisplayName").value = document.getElementById("company").value;
            }
            else {
                document.getElementById("txtDisplayName").value = document.getElementById("txtFNameEng").value + ' ' + document.getElementById("txtLNameEng").value;
            }
        }
    }

    function txtCityDisplay() {
        return true
    }
    function ddlCityDisplay() {
        return false
    }
    function displayDdlShippingCity2() {
        return false
    }
    function countItems_ddlCity() {
        return 0
    }
    function countItems_ddlShippingCity2() {
        return 0
    }
    function clear_ddlShippingCity2() {
        
    }


    var html;
    var htmlZipErrorMessage2;

    $(document).ready(function () {
		;
		});
    function ShipAddrAsBillingAddr() {
        var country = document.getElementById("ddlCountry").value;
        if (document.getElementById("chk_useBillingAddress").checked) {
            document.getElementById("ShippingName").value = document.getElementById("txtBillingFname").value;
            document.getElementById("ShippingLName").value = document.getElementById("txtBillingLname").value;
            document.getElementById("ShippingAddress1").value = document.getElementById("txtaddress1").value;
            document.getElementById("ShippingAddress2").value = document.getElementById("txtaddress2").value;
            if (country == "BR")
            {   document.getElementById("txtShipaddress3").value = document.getElementById("txtAddress3").value;}
            try { document.getElementById("ShippingZip").value = document.getElementById("zip").value; } catch (err) { }
            if (country == "CL")
            { document.getElementById("txtShipaddress3").value = document.getElementById("txtAddress3").value; }
            if (txtCityDisplay() == true && ddlCityDisplay() == false) {
                document.getElementById("ShippingCity").value = document.getElementById("txtCity").value;
            }
            else if (txtCityDisplay() == false && ddlCityDisplay() == true) {
                AjaxCall();
                if (document.getElementById("RequiredFieldValidator14") != null && document.getElementById("RequiredFieldValidator14").style.display != 'none') {
                    document.getElementById("RequiredFieldValidator14").style.display = 'none';
                }

                var dropd = document.getElementById("ddlCity");
                //var dropd2 = document.getElementById("ddlShippingCity2");
                if (dropd.options.length > 1 && document.getElementById("ddlCity").selectedIndex > 0) {
                    document.getElementById("HiddenCity").value = document.getElementById("ddlCity")[document.getElementById("ddlCity").selectedIndex].value;
                }
                else {
                    document.getElementById("HiddenCity").value = "";
                }
                var temp = document.getElementById("helpLabelDdlShippingCity2");
                var tempZipErrorMessage3 = document.getElementById("zipErrorMessage3");
                if (temp != null) {
                    document.getElementById("helpLabelDdlShippingCity2").style.display = 'none';
                }
                if (tempZipErrorMessage3 != null && dropd.options.length > 1) {
                    if (document.getElementById("zipErrorMessage3").style.display != 'none') {
                        document.getElementById("zipErrorMessage3").style.display = 'none';
                    }
                }
                else if (dropd.options.length <= 1) {
                    $("#labelZipErrorMessage3").html(htmlZipErrorMessage3);
                    $("#label").html(html);
                    document.getElementById("zipErrorMessage3").style.display = 'block';
                    document.getElementById("helpLabelDdlShippingCity2").style.display = 'block';
                }
                
                
                
                //document.getElementById("ddlShippingCity2").selectedIndex = document.getElementById("ddlCity").selectedIndex;
                //var mySelect = document.getElementById("ddlShippingCity2");
                //var options = ["1"];
                //for (var i = 0; i < options.length; i++)
                //{
                //    var opt = options[i];
                //    var el = document.createElement("option");
                //    el.textContent = opt;
                //    el.value = opt;
                //    mySelect.appendChild(el);
                //}

                //document.getElementById("ddlShippingCity2").style.display = 'none';
                //document.getElementById("HiddenCity").style.display = 'block';
            }
            try { document.getElementById("jpShipZip1").value = document.getElementById("jpZip1").value; document.getElementById("jpShipZip2").value = document.getElementById("jpZip2").value; } catch (err) { }
            document.getElementById("ddlShippingState").value = document.getElementById("ddlState")[document.getElementById("ddlState").selectedIndex].value;
            if (country == "RU")
            { document.getElementById("ddlShippingCity").value = document.getElementById("ddlShipCity")[document.getElementById("ddlShipCity").selectedIndex].value; }
            if (document.getElementById("ddlState").value == document.getElementById("ddlShippingState").value) document.getElementById("ddlShippingCountry").value = document.getElementById("ddlCountry")[document.getElementById("ddlCountry").selectedIndex].value;
            checkZip();
        }
        else {
            var displayHiddenCity = document.getElementById("HiddenCity").style.display;
            if (displayDdlShippingCity2() == true) {
                var displaySC2 = document.getElementById("ddlShippingCity2").style.display;
                if (displayHiddenCity == 'block') {
                    document.getElementById("HiddenCity").style.display = 'none';
                }
                //if (displaySC2 == 'none') {
                $("#ddlShippingCity2").empty();
                document.getElementById("ddlShippingCity2").selectedIndex = -1;
                    //document.getElementById("ddlShippingCity2").style.display = 'block';
                //}
                var long = $("#ddlShippingCity2 option").length;
                if (document.getElementById("ddlShippingCity2").selectedIndex < 1) {
                    $("#label").html(html);
                    $("#labelZipErrorMessage3").html(htmlZipErrorMessage3);
                    document.getElementById("helpLabelDdlShippingCity2").style.display = 'block';
                    document.getElementById("zipErrorMessage3").style.display = 'block';
                }
            }
            document.getElementById("ShippingName").value = "";
            document.getElementById("ShippingLName").value = "";
            document.getElementById("ShippingAddress1").value = "";
            document.getElementById("ShippingAddress2").value = "";
            if (country == "CL")
            { document.getElementById("txtShipaddress3").value = ""; }
            if (displayDdlShippingCity2() == false) {
                document.getElementById("ShippingCity").value = "";
            }
            try { document.getElementById("ShippingZip").value = ""; } catch (err) { }
            try { document.getElementById("jpShipZip1").value = ""; document.getElementById("jpShipZip2").value = ""; } catch (err) { }
            if (document.getElementById("ddlShippingCountry").disabled == false) document.getElementById("ddlShippingCountry").selectedIndex = -1;
            document.getElementById("ddlShippingState").selectedIndex = -1;
            checkZip();
        }
        //for shipping address validation
        //init address validation
        $("#ShippingAddress1").change();
    }

    function checkZip() {
        if (document.getElementById("ddlCountry").value == "JP") {
            //if (document.getElementById("ddlCountry").value == "CO") {
            //    document.getElementById("rwZip").style.display = "none";
            //    ValidatorEnable(document.getElementById("zipValidator"), false);
            //}
            if (document.getElementById("ddlCountry").value == "JP") {
                ValidatorEnable(document.getElementById("jpZipValidator1"), true);
                ValidatorEnable(document.getElementById("jpZipValidator2"), true);
                ValidatorEnable(document.getElementById("cval_jpZip"), true);
                document.getElementById("jpZipValidator1").style.visibility = "hidden";
                document.getElementById("jpZipValidator2").style.visibility = "hidden";
            }
        }
        else {
            //document.getElementById("rwZip").style.display = "";
            ValidatorEnable(document.getElementById("zipValidator"), true);
            document.getElementById("zipValidator").style.visibility = "hidden";
        }
        if (document.getElementById("ddlCountry").value == "JP") {
            //if (document.getElementById("ddlCountry").value == "CO") {
            //    document.getElementById("rwShipZip").style.display = "none";
            //    ValidatorEnable(document.getElementById("shipZipValidator"), false);
            //}
            if (document.getElementById("ddlCountry").value == "JP") {
                ValidatorEnable(document.getElementById("jpShipZipValidator1"), true);
                ValidatorEnable(document.getElementById("jpShipZipValidator2"), true);
                ValidatorEnable(document.getElementById("cval_JPShipZip"), true);
                document.getElementById("jpShipZipValidator1").style.visibility = "hidden";
                document.getElementById("jpShipZipValidator2").style.visibility = "hidden";
            }
        }
        else {
            //document.getElementById("rwShipZip").style.display = "";
            ValidatorEnable(document.getElementById("shipZipValidator"), true);
            document.getElementById("shipZipValidator").style.visibility = "hidden";
        }
    }

    /*function ShowAutoshipProduct()
    {
    if (document.getElementById("chk_SignupforAutoship").checked == true)
    {         
    document.getElementById("dgAutoshipProduct__ctl2_RowSelectorColumnSelector").disabled = false; 
    document.getElementById("dgAutoshipProduct__ctl2_RowSelectorColumnSelector").checked = true;
    }
    else
    {
    document.getElementById("dgAutoshipProduct__ctl2_RowSelectorColumnSelector").disabled = true;  
    document.getElementById("dgAutoshipProduct__ctl2_RowSelectorColumnSelector").checked = false ;
    }
    } */

    function UpdateOptIn(id) {
        var checkbox = document.getElementById(id);
        if (checkbox.checked) {
            // Show autoship multi item select
            document.getElementById("dgAutoshipMultiProduct").style.display = '';
            document.getElementById("dgAutoshipProduct").style.display = 'none';
            // Hide normal autoship conditionality and Club180 opt in
            document.getElementById("lblAutoshipType").style.display = 'none';
            document.getElementById("ddlAutoshipType").style.display = 'none';
        }
        else {
            // show autoship normal item select
            document.getElementById("dgAutoshipMultiProduct").style.display = 'none';
            document.getElementById("dgAutoshipProduct").style.display = '';
            // Show autoship conditionality  
            document.getElementById("lblAutoshipType").style.display = '';
            document.getElementById("ddlAutoshipType").style.display = '';
        }
    }

    function EnableBtns(id) {
        var chkSSN = document.getElementById(id);
        if (chkSSN.checked) {
            document.getElementById("btnContinueShopping").disabled = false;
            if (document.getElementById("btnAddDistributorInfo") != null)
            { document.getElementById("btnAddDistributorInfo").disabled = false; }
            if (document.getElementById("btnUpdateDistributorInfo") != null)
            { document.getElementById("btnUpdateDistributorInfo").disabled = false; }
        }
        else {
            document.getElementById("btnContinueShopping").disabled = true;
            if (document.getElementById("btnAddDistributorInfo") != null)
            { document.getElementById("btnAddDistributorInfo").disabled = true; }
            if (document.getElementById("btnUpdateDistributorInfo") != null)
            { document.getElementById("btnUpdateDistributorInfo").disabled = true; }
        }
    }
    //#13010 ID additional
    function EnableBtnsID(id) {
        var CheckIDNPWPagree = document.getElementById(id);
        if (CheckIDNPWPagree.checked) {
            document.getElementById("btnContinueShopping").disabled = false;
            if (document.getElementById("btnAddDistributorInfo") != null)
            { document.getElementById("btnAddDistributorInfo").disabled = false; }
            if (document.getElementById("btnUpdateDistributorInfo") != null)
            { document.getElementById("btnUpdateDistributorInfo").disabled = false; }
        }
        else {
            document.getElementById("btnContinueShopping").disabled = true;
            if (document.getElementById("btnAddDistributorInfo") != null)
            { document.getElementById("btnAddDistributorInfo").disabled = true; }
            if (document.getElementById("btnUpdateDistributorInfo") != null)
            { document.getElementById("btnUpdateDistributorInfo").disabled = true; }
        }
    }

    function ShowAutoshipOption(club180Products, pearlOrHigherProducts, selectedProductPK, CreateAPackPK, noPaycardOfferCountries) {
        if (CreateAPackPK == selectedProductPK) {
            document.getElementById("divCreatePack").style.display = '';
        }
        else {
            document.getElementById("divCreatePack").style.display = 'none';
        }

        // Set Selected productID to hidden field
        var productIDhiddenField = document.getElementById('hfSignupPacks');
        productIDhiddenField.value = selectedProductPK;
//        alert('hfSignupPacks value = ' + productIDhiddenField.value);

        // show/hide autoship and paycard options  
        //LCK 2011-12-1 - use same logic used by OfferPaycard function, which is used to determine if paycard selected is added to order
        // if OfferPaycard returns false (CompanyCountries.offerPaycard = false) then do not show paycard section
        var arrCountry = noPaycardOfferCountries.split(",");
        var isNoPaycardCountry = false;
        for (var i = 0; i < arrCountry.length; i++) {
            if (document.getElementById('ddlCountry').value == arrCountry[i]) // LCK 2014-07-14 Change from ddlLanguage (never used while commented below) to correct ddlCountry
                isNoPaycardCountry = true;
        }
        //if (document.getElementById("ddlCountry").value !="US" &&  document.getElementById("ddlCountry").value != "CA" && document.getElementById("ddlCountry").value != "JP"&& document.getElementById("ddlCountry").value != "PR")
        // LCK 2014-07-14 - uncomment below code to show paycard block - not sure why it was commented to begin with
        if (isNoPaycardCountry)
            document.getElementById("divPaycardOption").style.display = 'none';
        else
            document.getElementById("divPaycardOption").style.display = '';



        if (document.getElementById("ddlCountry").value == "FM" || document.getElementById("ddlCountry").value == "KR") {
            document.getElementById("divautoshipOption").style.display = '';
            //LCK 2011-12-1 comment out, set above - FM and KR will have CompanyCountries.offerPaycardOnSignup set to false
            //document.getElementById("divPaycardOption").style.display = 'none';   
            //EJA 2012-06-07 added hide multiproduct dg, only TH has club180
            document.getElementById("dgAutoshipMultiProduct").style.display = 'none';
        }
        /* EJA 2012-6-7 this shows autoship even if no product is selected, commented and moved after check if product chosen
        else
        {
        document.getElementById("divautoshipOption").style.display = '';  
        }*/

        // check if club180 product is selected - indexOf will not work here ProductPK 1 should not be found in 11
        // if club180 product - show multi autoship options   
        var arr = club180Products.split(",");
        var arr2 = pearlOrHigherProducts.split(",");
        var isClub180ProductChoosen = false;
        var isPearlOrHigherProductChoosen = false;
        var isProductChoosen = false;

        if (selectedProductPK.length > 0)
            isProductChoosen = true;

        for (var i = 0; i < arr.length; i++) {
            if (selectedProductPK == arr[i]) {
                isClub180ProductChoosen = true;
            }
        }

        for (var i = 0; i < arr2.length; i++) {
            if (selectedProductPK == arr2[i]) {
                isPearlOrHigherProductChoosen = true;
            }
        }

        if (document.getElementById("ddlCountry").value == "KR")
            isPearlOrHigherProductChoosen = false


        if (isProductChoosen) {
            // EJA 2012-06-07 moved from ELSE FM & KR check
            document.getElementById("divautoshipOption").style.display = '';
            if (isClub180ProductChoosen) {
                // Show autoship multi item select
                document.getElementById("dgAutoshipMultiProduct").style.display = '';
                document.getElementById("dgAutoshipProduct").style.display = 'none';
                // Hide normal autoship conditionality and Club180 opt in
                document.getElementById("lblAutoshipType").style.display = 'none';
                document.getElementById("ddlAutoshipType").style.display = 'none';
                document.getElementById("Club180Msg1").style.display = 'none';
                document.getElementById("Club180Msg2").style.display = 'none';
                document.getElementById("lblIAgree").style.display = 'none';
                document.getElementById("chkClub180").checked = false;
                document.getElementById("chkClub180").style.display = 'none';
            }
            else {
                // show autoship normal item select
                document.getElementById("dgAutoshipMultiProduct").style.display = 'none';
                document.getElementById("dgAutoshipProduct").style.display = '';
                // Show autoship conditionality  
                document.getElementById("lblAutoshipType").style.display = '';
                document.getElementById("ddlAutoshipType").style.display = '';
                // Club180 opt in for Pearl or higher
                // LCK 2011-06-01 hide for all except TH
                // LCK 2013-06-01 end club 180 - hide for all
                //if (document.getElementById("ddlCountry").value != "TH")
                isPearlOrHigherProductChoosen = false;

                if (isPearlOrHigherProductChoosen) {
                    document.getElementById("Club180Msg1").style.display = '';
                    document.getElementById("Club180Msg2").style.display = '';
                    document.getElementById("lblIAgree").style.display = '';
                    document.getElementById("chkClub180").style.display = '';
                }
                else {
                    document.getElementById("Club180Msg1").style.display = 'none';
                    document.getElementById("Club180Msg2").style.display = 'none';
                    document.getElementById("lblIAgree").style.display = 'none';
                    document.getElementById("chkClub180").checked = false;
                    document.getElementById("chkClub180").style.display = 'none';
                }
            }

            if (document.getElementById("chkClub180").checked == true && (isPearlOrHigherProductChoosen || isClub180ProductChoosen)) {
                document.getElementById("dgAutoshipMultiProduct").style.display = '';
                document.getElementById("dgAutoshipProduct").style.display = 'none';
            }
        }
    }
    function searchZip(po) {
        window.open('../KR/search_zipcode.asp?po=' + po, '', 'scrollbars=yes,width=600,height=600,left=400,top=400');
    }
    
     function searchZipJP(po) {
        window.open('../JP/search_Byzipcode.asp?po=' + po, '', 'scrollbars=yes,width=600,height=600,left=400,top=400');
    }
    //#12243
    function FR_VDIRegInstruction() {
        window.open('/documents/FR/VDI_Registration_Instructions_FR.pdf', '', 'scrollbars=yes,width=1200,height=1200,left=800,top=800');
    }
    function FR_VDIOnlineReg() {
        window.open('https://www.cfe.urssaf.fr/unsecure_index.jsp', '', 'scrollbars=yes,width=1200,height=1200,left=800,top=800');
    }
    function FR_Form() {
        window.open('/documents/FR/Jeunesse_French_VDI_RegistrationForm.pdf', '', 'scrollbars=yes,width=1200,height=1200,left=800,top=800');
    }
    //#13010
    function ID_Notification() {
        window.open('/documents/ID/DataNPWP.pdf', '', 'scrollbars=yes,width=1200,height=1200,left=800,top=800');
    }
    function onBankFieldChange() {
        var country = document.getElementById("ddlCountry").value;

        //For Brazil, if they enter ANY bank data, we want them to enter ALL the bank data.
        //  I notably left out the radio when toggling the requiredValidators because you 
        //  can't 'uncheck' a radio button very easily if you change your mind to not enter
        //  any bank data.
        if (country == "BR") {
        
            var bankName = $("#txtBankNameEntered").val();
            var bankCode = $("#txtBankNameCode").val();
            var branchCode = $("#txtBankBranchCode").val();
            var accountNum = $("#txtBankAccountNumber").val();
            var accountName = $("#txtBankAccountName").val();
            var accountType = $('#rblAccountType input:checked').val(); 
         
            var ValidatorToggleBool = false;

            if (bankName || bankCode || branchCode || accountNum || accountName){
                ValidatorToggleBool = true;
            } else {
                ValidatorToggleBool = false;
            }
     
            ValidatorEnable(document.getElementById("reqBankNameEntered"), ValidatorToggleBool);
            ValidatorEnable(document.getElementById("reqBankNameCode"), ValidatorToggleBool);
            ValidatorEnable(document.getElementById("reqBankBranchCode"), ValidatorToggleBool);
            ValidatorEnable(document.getElementById("reqBankAccountNumber"), ValidatorToggleBool);
            ValidatorEnable(document.getElementById("reqBankAccountName"), ValidatorToggleBool);
            ValidatorEnable(document.getElementById("reqAccountType"), ValidatorToggleBool);
        }
    }
    var canShowAddressCorrectBtn = true;
    var isAddressValid = false;
    var isMailingAddressValid = false;
    var shippingAlias = "shipping";
    var mailingAlias = "mailing";
    
    function validateAddressInit(needToCheckHiddenField) {
        var addressLineID = '#ShippingAddress1';
        var cityID = '#ShippingCity';
        var stateID = '#ddlShippingState';
        var countryID = '#ddlShippingCountry';
        var zipID = '#ShippingZip';

        if(needToCheckHiddenField == undefined || needToCheckHiddenField == true){
            if ($('#isShippingAddressValid').val() == "0" || $('#isShippingAddressValid').val() == "1")
           { 
               isAddressValid = true;
           }
       }

         $('#imgShippingAddressValidSign').hide();

       
     }

    function validateMailingAddressInit() {
        var addressLineID = '#txtaddress1';
        var cityID = '#txtCity';
        var stateID = '#ddlState';
        var countryID = '#ddlCountry';
        var zipID = '#zip';
       
        if ($('#isMailingAddressValid').val() == "0" || $('#isMailingAddressValid').val() == "1")
        {
            isMailingAddressValid = true;
        }

        $('#imgMailingAddressValidSign').hide();

       
        }

    function validationAddressPostBack(isPartialCallBack, needToSyncronize){
        isAddressValid = getAddressStatus(shippingAlias);
        $('#spnAddressValidationErrorMessage').toggle(!getAddressStatus(shippingAlias));
        $('#imgShippingAddressValidSign').toggle(getAddressStatus(shippingAlias) && wasAddressValidated(shippingAlias));
        $('#imgShippingAddressIncorrectSign').toggle(!getAddressStatus(shippingAlias) && wasAddressValidated(shippingAlias));

        if (isPartialCallBack == undefined || !isPartialCallBack) {
            if (getAddressStatus(shippingAlias)) {
                if (isAddressValidBtnWasPressed(shippingAlias)) {
                    $('#isShippingAddressValid').val('0');
                }
                else {
                    $('#isShippingAddressValid').val('1');
                }
                if (!wasAddressValidated(shippingAlias)) {
                    $('#isShippingAddressValid').val('-1');
                }
            }
            else {
                $('#isShippingAddressValid').val('-1');
            } 
            if((needToSyncronize == undefined || needToSyncronize) && document.getElementById("chk_useBillingAddress").checked){
                AddressVerification_SynchronizeStatuses();
                AddressSyncronization_SynchronizeObjectsByIndexes(1, 0);
                validationMailingAddressPostBack(isPartialCallBack, false);
            }
        }
    }

    function validationMailingAddressPostBack(isPartialCallBack, needToSyncronize){
        isMailingAddressValid = getAddressStatus(mailingAlias);
        $('#spnMailingAddressValidationErrorMessage').toggle(!getAddressStatus(mailingAlias));
        $('#imgMailingAddressValidSign').toggle(getAddressStatus(mailingAlias) && wasAddressValidated(mailingAlias));
        $('#imgMailingAddressIncorrectSign').toggle(!getAddressStatus(mailingAlias) && wasAddressValidated(mailingAlias));
        if (isPartialCallBack == undefined || !isPartialCallBack) {
            if (getAddressStatus(mailingAlias)) {
                if (isAddressValidBtnWasPressed(mailingAlias)) {
                    $('#isMailingAddressValid').val('0');
                }
                else {
                    $('#isMailingAddressValid').val('1');
                }
                if (!wasAddressValidated(mailingAlias)) {
                    $('#isMailingAddressValid').val('-1');
                }
            }
            else {
                $('#isMailingAddressValid').val('-1');
            }
        }
        if((needToSyncronize == undefined || needToSyncronize) && document.getElementById("chk_useBillingAddress").checked){
            AddressVerification_SynchronizeStatuses();
            AddressSyncronization_SynchronizeObjectsByIndexes(0, 1);
            validationAddressPostBack(isPartialCallBack, false);
        }
    }

    function valdatedPostBack(sender) {
        if (!getAddressStatus(mailingAlias, sender.name)) {
            ShowAddressValidationDialog('#dvMailingAddressValidationUpdateDialog', mailingAlias);
            return false;
        }
        if (!getAddressStatus(shippingAlias, sender.name)) {
            ShowAddressValidationDialog('#dvAddressValidationUpdateDialog', shippingAlias);
            return false;
        }
        return true;
    }


</script>
    
    
     
    

            <form name="form1" method="post" action="AddNew.aspx?c=AW&amp;siteurl=xiangli&amp;lang=1&amp;lpc=0&amp;lid=" onsubmit="javascript:return WebForm_OnSubmit();" id="form1">
<div>

</div>

<script type="text/javascript">
//<![CDATA[
var theForm = document.forms['form1'];
if (!theForm) {
    theForm = document.form1;
}
function __doPostBack(eventTarget, eventArgument) {
    if (!theForm.onsubmit || (theForm.onsubmit() != false)) {
        theForm.__EVENTTARGET.value = eventTarget;
        theForm.__EVENTARGUMENT.value = eventArgument;
        theForm.submit();
    }
}
//]]>
</script>


<script type="text/javascript">
//<![CDATA[
function WebForm_OnSubmit() {
if (typeof(ValidatorOnSubmit) == "function" && ValidatorOnSubmit() == false) return false;
return true;
}
//]]>
</script>

<div>

	<input name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="430D02A9" type="hidden">
</div>

 
<!-- 2009.2.701.20 --><div style="display: none;" id="RadAjaxManager1SU">
	<span id="RadAjaxManager1" style="display:none;"></span>
</div>

                <section id="MainSection" class="block">
					
			  <div class="row">
					    <div class="col-md-12">
							<div class="panel panel-primary" >
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><span id="LblLangtitle">Choose your language</span></h2>
								</div>
								<div class="panel-body">
									<div class="details">
										<fieldset>
    <div style="display: block;" id="UpdatePanel1">
	
											<div class="form-group">
												<div class="label-area" style="display: flex;">
													<label>
                                                        Language: 
													</label>
                                                    <div style="display:none">
                                                        
                                                    </div>
                                                    <select name="ddlLanguage" onchange="javascript:onLangChange(this, '/v2/NewSignup/AddNew.aspx?c=AW&amp;siteurl=xiangli&amp;lpc=0');setTimeout('__doPostBack(\'ddlLanguage\',\'\')', 0)" id="ddlLanguage" class="form-control">
		<option value="">--Please Select--</option>
		<option value="EN" <? if ($_SESSION['lmCountry']=='EN') echo 'selected';?>>English</option>
		<option value="ID" <? if ($_SESSION['lmCountry']=='ID') echo 'selected';?>>Indonesian</option>

		<option value="MY" <? if ($_SESSION['lmCountry']=='MY') echo 'selected';?>>Malay</option>
		

	</select>
												</div>
												<div class="row-holder"></div>
											</div>
        
</div>               
										</fieldset>
										
										<p></p><div id="valSummary" style="color:Red;display:none;">

</div><p></p>
										<i><span id="lblError" style="color:Red;font-weight:normal;"></span></i>
									</div>
                                   
                                    

                                    
								</div>
							</div>
						</div>
					</div>
                    <div class="row">
                        <!-- Col 1 -->
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><span id="lblAddressSelection">User Name Selection</span></h2>
								</div>
                                <div class="panel-body">
                                    <div id="Div1" class="alert alert-danger">
							     <!-- <i class="fa fa fa-exclamation-triangle fa-lg"></i>--></div>
									<div class="details">
										<fieldset>
											
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblSponsorname">Sponsor Name</span>:</label>
												</div>
												<div class="row-holder"><span class="text"><span id="lblSpName"><?=$oMember->getMemberName($_SESSION['Ref'])?></span></span></div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblSponsorId">Sponsor ID</span>:</label>
												</div>
												<div class="row-holder"><span class="text"><span id="lblSpSiteurl"><?=$_SESSION['Ref']?></span></span></div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label>
													<span id="lblMainSiteURL">User Name:</span><br>
                                                    <span id="lblSiteURLNote"></span> 
													</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtSiteURL" maxlength="50" id="txtSiteURL" class="form-control" type="text">
                                                    <a href="javascript:void(0)" onclick="javascript:checkIfUrlAvail();"><span id="LabelChkifavailable">Check If available</span></a>
                                                    <span id="Siteurlvalidate" title="Site URL is required." style="color:Red;display:none;">Required</span> 
                                                    
                                                    <span id="RegExpValidatorSiteurl" title="Only Numbers,Letters and Underscores are valid" style="color:Red;display:none;">Error - Please enter a maximum of 30 characters, letters and numbers only.</span>
                                                    
                                                    <span id="SiteurlRejectedVal" style="color:Red;display:none;">Invalid SiteURL - Contains Invalid Characters, Foul Language or Blocked Names</span>        

                                                    <div id="UrlAvailStatus" title="Only letters and numbers. No more than 15 characters">        
                                                    </div>
                                                    
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><label for="Password" id="PasswordLabel">Password:</label>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="Password" maxlength="20" id="Password" class="form-control" value="" type="password">           

                                                    <span id="PasswordRequired" title="Password is required." style="color:Red;display:none;">Required</span>
                                                    <div id="divPassword">
                                                    </div>
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><label for="ConfirmPassword" id="ConfirmPasswordLabel">Confirm Password:</label>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="ConfirmPassword" maxlength="20" id="ConfirmPassword" class="form-control" onblur="ValidatePassword();" value="" type="password">            
                                                    <div style="display:none">
                                                        
                                                    </div>
                                                    <br>
                                                    <span id="ConfirmPasswordRequired" title="Confirm Password is required." style="color:Red;display:none;">Required</span>
                                                    <span id="PwdExpValidator" title="Only Numbers,Letters,*,! are valid" style="color:Red;display:none;">Error</span>
                                                    <div id="DivConfirmPassword">
                                                    </div>
                                                    <input name="txt_pass" id="txt_pass" style="display:none" type="text">
                                                </div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							
							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><strong><span id="lblDistributorInfo">Distributor Information</span></strong></h2>
								</div>
								<div class="panel-body">
									<div class="details">
										<fieldset>
										 
											
                                            

											        <div class="form-group">
												        <div class="label-area">
													       
                                                            <label>
                                                            <span id="lblCourtesyTitle">Courtesy Title</span>
                                                            
		                                                    
		                                                    
		                                                    
                                                            
													        </label>
												        </div>
												        <div class="row-holder"><select name="ddlCourtesyTitle" id="ddlCourtesyTitle" class="form-control long">
	<option selected="selected" value=""></option>
	<option value="Mr.">Mr.</option>
	<option value="Mrs.">Mrs.</option>
	<option value="Ms.">Ms.</option>
	<option value="Company">Company</option>

</select></div>
											        </div>

                                            
                                           
										    
											<div class="form-group">
												<div class="label-area">
													<label>
													    
													    <span id="lblFnameEnglish">First Name(English) </span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtFNameEng" maxlength="50" id="txtFNameEng" class="form-control" type="text">
                <span id="reqFieldValidator" style="color:Red;display:none;">Required</span>         
              
                <span id="regExp1" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblLnameEnglish">Last Name(English) </span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtLNameEng" maxlength="50" id="txtLNameEng" class="form-control" onblur="AutoFillNames();" type="text">
                    <span id="RequiredFieldValidator1" style="color:Red;display:none;">Required</span>
               
                    <span id="regExp2" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>
											
											
											
											
											

                                            
                                            

											
                                <div id="divCompanyName">
											    <div class="form-group" style="border:solid 0px red">
												<div class="label-area">
													    <label><span id="lblCompany">Company</span>:</label>
												</div>
                                                <div class="row-holder">
                                                        <input name="company" maxlength="100" id="company" size="30" class="form-control" type="text">
                                                </div>
											</div>
                                </div>
											<div class="form-group" style="border:solid 0px red">
												<div class="label-area">
													<label><span id="lblDisplayName">Display Name</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtDisplayName" maxlength="100" id="txtDisplayName" size="30" class="form-control" type="text">
                                                    <span id="DisplayNameValidator" title="Display Name Required" style="color:Red;display:none;">Required</span>
                                                </div>
											</div>
                                            <div id="DivCheckName" style="border:solid 0px red;">
											<div class="form-group" style="border:solid 0px red">
												<div class="label-area">
													<label><span id="lblCheckName">Check Name</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtCheckName" maxlength="100" id="txtCheckName" size="30" class="form-control" type="text">
        <span id="CheckNameValidate" style="color:Red;display:none;">Required</span>
                  
        
                                                </div>
											</div></div>
											
											
											<div class="form-group" style="border:solid 0px red">
												<div class="label-area">
													<label><span id="lblDOB">Date of Birth</span>:</label>
												</div>
                                                <div class="row-holder">
        <span class="short HebFloatRight" style="float: left; text-align: center;"><select name="ddlMOB" id="ddlMOB" class="short form-control">
	<option selected="selected" value="Select Month">Select Month</option>
	<option value="01-Jan">01-Jan</option>
	<option value="02-Feb">02-Feb</option>
	<option value="03-Mar">03-Mar</option>
	<option value="04-Apr">04-Apr</option>
	<option value="05-May">05-May</option>
	<option value="06-Jun">06-Jun</option>
	<option value="07-Jul">07-Jul</option>
	<option value="08-Aug">08-Aug</option>
	<option value="09-Sept">09-Sept</option>
	<option value="10-Oct">10-Oct</option>
	<option value="11-Nov">11-Nov</option>
	<option value="12-Dec">12-Dec</option>

</select><br>
        <div class="label-area">
            <label><span id="lblDateMM">mm</span>:</label>
        </div>
        </span>
        <span class="short HebFloatRight" style="float: left; text-align: center;"><select name="ddlDOB" id="ddlDOB" class="short form-control">
	<option selected="selected" value="Select Day">Select Day</option>
	<option value="1">1</option>
	<option value="2">2</option>
	<option value="3">3</option>
	<option value="4">4</option>
	<option value="5">5</option>
	<option value="6">6</option>
	<option value="7">7</option>
	<option value="8">8</option>
	<option value="9">9</option>
	<option value="10">10</option>
	<option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>

</select><br><div class="label-area">
            <label><span id="lblDateDD">dd</span>:</label>
        </div></span>
        <span class="short HebFloatRight" style="float: left; text-align: center;"><select name="ddlYOB" id="ddlYOB" class="short form-control">
	<option selected="selected" value="Select Year">Select Year</option>
	<option value="1900">1900</option>
	<option value="1901">1901</option>
	<option value="1902">1902</option>
	<option value="1903">1903</option>
	<option value="1904">1904</option>
	<option value="1905">1905</option>
	<option value="1906">1906</option>
	<option value="1907">1907</option>
	<option value="1908">1908</option>
	<option value="1909">1909</option>
	<option value="1910">1910</option>
	<option value="1911">1911</option>
	<option value="1912">1912</option>
	<option value="1913">1913</option>
	<option value="1914">1914</option>
	<option value="1915">1915</option>
	<option value="1916">1916</option>
	<option value="1917">1917</option>
	<option value="1918">1918</option>
	<option value="1919">1919</option>
	<option value="1920">1920</option>
	<option value="1921">1921</option>
	<option value="1922">1922</option>
	<option value="1923">1923</option>
	<option value="1924">1924</option>
	<option value="1925">1925</option>
	<option value="1926">1926</option>
	<option value="1927">1927</option>
	<option value="1928">1928</option>
	<option value="1929">1929</option>
	<option value="1930">1930</option>
	<option value="1931">1931</option>
	<option value="1932">1932</option>
	<option value="1933">1933</option>
	<option value="1934">1934</option>
	<option value="1935">1935</option>
	<option value="1936">1936</option>
	<option value="1937">1937</option>
	<option value="1938">1938</option>
	<option value="1939">1939</option>
	<option value="1940">1940</option>
	<option value="1941">1941</option>
	<option value="1942">1942</option>
	<option value="1943">1943</option>
	<option value="1944">1944</option>
	<option value="1945">1945</option>
	<option value="1946">1946</option>
	<option value="1947">1947</option>
	<option value="1948">1948</option>
	<option value="1949">1949</option>
	<option value="1950">1950</option>
	<option value="1951">1951</option>
	<option value="1952">1952</option>
	<option value="1953">1953</option>
	<option value="1954">1954</option>
	<option value="1955">1955</option>
	<option value="1956">1956</option>
	<option value="1957">1957</option>
	<option value="1958">1958</option>
	<option value="1959">1959</option>
	<option value="1960">1960</option>
	<option value="1961">1961</option>
	<option value="1962">1962</option>
	<option value="1963">1963</option>
	<option value="1964">1964</option>
	<option value="1965">1965</option>
	<option value="1966">1966</option>
	<option value="1967">1967</option>
	<option value="1968">1968</option>
	<option value="1969">1969</option>
	<option value="1970">1970</option>
	<option value="1971">1971</option>
	<option value="1972">1972</option>
	<option value="1973">1973</option>
	<option value="1974">1974</option>
	<option value="1975">1975</option>
	<option value="1976">1976</option>
	<option value="1977">1977</option>
	<option value="1978">1978</option>
	<option value="1979">1979</option>
	<option value="1980">1980</option>
	<option value="1981">1981</option>
	<option value="1982">1982</option>
	<option value="1983">1983</option>
	<option value="1984">1984</option>
	<option value="1985">1985</option>
	<option value="1986">1986</option>
	<option value="1987">1987</option>
	<option value="1988">1988</option>
	<option value="1989">1989</option>
	<option value="1990">1990</option>
	<option value="1991">1991</option>
	<option value="1992">1992</option>
	<option value="1993">1993</option>
	<option value="1994">1994</option>
	<option value="1995">1995</option>
	<option value="1996">1996</option>
	<option value="1997">1997</option>
	<option value="1998">1998</option>
	<option value="1999">1999</option>
	<option value="2000">2000</option>
	<option value="2001">2001</option>
	<option value="2002">2002</option>
	<option value="2003">2003</option>
	<option value="2004">2004</option>
	<option value="2005">2005</option>
	<option value="2006">2006</option>
	<option value="2007">2007</option>
	<option value="2008">2008</option>
	<option value="2009">2009</option>
	<option value="2010">2010</option>
	<option value="2011">2011</option>
	<option value="2012">2012</option>
	<option value="2013">2013</option>
	<option value="2014">2014</option>
	<option value="2015">2015</option>
	<option value="2016">2016</option>

</select><br><div class="label-area">
            <label><span id="lblDateYY">yy</span>:</label>
        </div></span>
        <br>
                                                </div>
                                                 
                                                <span id="rfvYOB" style="color:Red;visibility:hidden;">Date of Birth Required!</span>
											</div>

                                            
                                            
                                            
                                
                                            

                                            
                                             
                                            
                                           

									        
										       
									        
											
										
                                            
                                            
                                             

											
                                            <div id="divIDType">
											    <div class="form-group" style="border:solid 0px red">
												    <div class="label-area">
													    <label><span id="lblID">IdentificationType</span>:</label>
												    </div>
                                                    <div class="row-holder">
                                                        <select name="ddlIdentificationtype" onchange="javascript:setTimeout('__doPostBack(\'ddlIdentificationtype\',\'\')', 0)" id="ddlIdentificationtype" class="form-control">
	<option selected="selected" value="6">SSN</option>

</select> 
                                                    </div>
											    </div>
                                            </div>
											
											
											
                                            <div id="divSSNGroup">
											    <div class="form-group" style="border:solid 0px red">
												    <div class="label-area">
													    <label><span id="lblSSN">Identification No</span>:</label>
												    </div>
                                                    <div class="row-holder">
                                                        <div id="divSSN">  
                                                            <input name="txtssn" maxlength="9" id="txtssn" class="form-control" type="text">
                                            </div>    
                                            
                                                
                                                             
                                            
                                                        
                                                        
                                                        
                                                            
                                                        
                                                            
                                                        <div id="txtSSnValidate" title="Invalid Format">
                                                        </div>
                                                    </div>
											    </div>
                                            </div>
                                            <!--DBell, 2015-08-19, Task 12185.  show/hide message that says SSN not required for non-US countries. -->
                                            <div id="divSSNNotReqd">
                                                <div class="form-group" style="border:solid 0px red">
												    <div class="label-area">
													    <label><span id="lblSSNNotReqd" style="color:Red;">SSN Identification No. is not required for NON-US markets and can be left blank.</span></label>
												    </div>
                                                </div>
                                            </div>
											
                                            
                                             
                                            
                                            
                                
                                
                                
                                            
                                            
                                             
                                            
                                            
                                            
                                            
                                            
                                            
                                            

											
                                             <div id="divCoApp">
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblcoapName">Co-Applicant Name</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="coappname" maxlength="100" id="coappname" size="30" class="form-control" type="text">
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblCoApPresidentID">Co-App Identification No</span> :</label>
												</div>
                                                <div class="row-holder">
    <div id="divCoappResident">
        <input name="coappresidentid" id="coappresidentid" size="30" class="form-control" type="text">
    </div>
    
                                                </div>
											</div></div>
											
											
											



										</fieldset>
									</div>
								</div>
							</div>
						</div>
                        <!-- Col 2 -->
						<div class="col-md-6">
							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><span id="lblContactInfo">Contact Information</span></h2>
								</div>
								<div class="panel-body">
									<div class="details">
										<fieldset>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblEmail">Email</span>:</label>
												</div>
												<div class="row-holder">
												    <input name="txtEmail" maxlength="50" id="txtEmail" size="40%" class="form-control" type="text">
                                                    <span id="RequiredFieldValidator6" title="Email required" style="color:Red;display:none;">Required</span>
                                                    <span id="regexprEmail" title="Max length is 50 with valid characters" style="color:Red;display:none;">Error</span>
												</div>
											</div>
											<div class="form-group" style="display:none;">
												<div class="label-area">
													<label><span id="lblTwitterName">Twitter (ex. @Name)</span>:</label>
												</div>
												<div class="row-holder">
                                                    <input name="txtTwitterHandle" maxlength="100" id="txtTwitterHandle" class="form-control" size="30" type="text">
                                                    <span id="RegularExpressionValidator2" title="Number should be atleast 10 digits and Max 20 digits" style="color:Red;display:none;"></span>
												</div>
											</div>
											<div class="form-group" style="display:none;">
												<div class="label-area">
													<label><span id="lblFacebookName">Facebook Page/URL</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtFacebookHomePageURL" maxlength="100" id="txtFacebookHomePageURL" class="form-control" size="30" type="text">
                                                    <span id="RegularExpressionValidator3" title="Number should be atleast 10 digits and Max 20 digits" style="color:Red;display:none;"></span>
                                                </div>
											</div>
											<div class="form-group" style="display:none;">
												<div class="label-area">
													<label><span id="lblSkypePhone">Skype ID</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtSkypePhone" maxlength="100" id="txtSkypePhone" class="form-control" size="30" type="text">
                                                    <span id="RegularExpressionValidator1" title="Number should be atleast 10 digits and Max 15 digits and No Dashes" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblPhone">Phone(No dashes)</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtPhone" maxlength="20" id="txtPhone" class="form-control" size="30" onkeypress="return isNumberKey(event)" type="text">
                                                    <span id="RequiredFieldValidator5" title="Phone required" style="color:Red;display:none;">Required</span>
                                                    <span id="cvalPhone" title="Number should be atleast 10 digits and Max 15 digits and No Dashes" style="color:Red;display:none;">Error</span>
                                                    <div id="InvalidPhone"></div>
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblSecondPhone">Cell Phone</span>:</label>
												</div>
                                                <div class="row-holder">
                                        <input name="SecondPhone" maxlength="20" id="SecondPhone" class="form-control" size="30" onkeypress="return isNumberKey(event)" onblur="CopyValues('SecondPhone', 'txtSMSNumber')" type="text">
                                        
                                        <span id="cvalSecondPhone" title="Number should be atleast 10 digits and Max 15 digits and No Dashes" style="color:Red;display:none;">Phone(No dashes)</span>
                                                    <div id="InvalidSecondPhone"></div>
                                                </div>
											</div>
											<div class="form-group" style="display:none;">
												<div class="label-area">
													<label><span id="lblFax">Fax</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="Fax" maxlength="20" id="Fax" class="form-control" size="30" type="text">
                                                </div>
											</div>
            <div style="display: block;" id="UpdatePanel3">
	
											<div class="form-group" style="display:none;">
												<div class="label-area">
													<label><span id="lblReceiveTextMessages">Do you want to receive text messages?</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <table id="rblDoYouWantTextMsg" class="rblFix" border="0">
		<tbody><tr>
			<td><input id="rblDoYouWantTextMsg_0" name="rblDoYouWantTextMsg" value="1" onclick="javascript:setTimeout('__doPostBack(\'rblDoYouWantTextMsg$0\',\'\')', 0)" type="radio"><label for="rblDoYouWantTextMsg_0">Yes</label></td>
		</tr><tr>
			<td><input id="rblDoYouWantTextMsg_1" name="rblDoYouWantTextMsg" value="0" checked="checked" type="radio"><label for="rblDoYouWantTextMsg_1">No</label></td>
		</tr>
	</tbody></table>
                                                </div>
											</div>
                                        
                
</div>
										</fieldset>
									</div>
								</div>
							</div>

							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><span id="lblbillingAddress">Mailing Address</span>
                                        <img style="padding-bottom: 15px; display: none;" id="imgMailingAddressValidSign" src="regformfiles/AddressValidSign.png" hidden="hidden">
                                        <img id="imgMailingAddressIncorrectSign" style="cursor: pointer; display: none;" src="regformfiles/AddressIncorrectSign.png" hidden="hidden">
									</h2>
								</div>
                                <input value="-1" name="isMailingAddressValid" id="isMailingAddressValid" style="visibility:hidden;" type="text">
								<div class="panel-body">
								    <div class="alert alert-danger">
                                        <span id="divnoteEnglishonlyspacer" style="display:inline-block;color:Maroon;font-weight:bold;height:10px;"></span>    								
								    </div>
									<div class="details">
										<fieldset>
                                            <span style="color: red; display: none;" id="spnMailingAddressValidationErrorMessage" hidden="hidden">Mailing Address is not valid. <a style="cursor:pointer;text-decoration: underline;" id="MailingAddressIsNotValidDialogFire">(Click here for more details)</a></span>
											<div class="form-group">
												<div class="label-area">
													<label><span id="Label2">Mailing Name</span>:</label>
												</div>
                                                <div class="row-holder">
                            <span class="short"><input name="txtBillingFname" maxlength="50" id="txtBillingFname" size="10" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event);" type="text"></span>
                            <span class="middle inlineTextBoxes"><input name="txtBillingLname" maxlength="50" id="txtBillingLname" size="20" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event);" type="text"></span>
                            <span id="RequiredFieldValidator4" title="Name Required" style="color:Red;display:none;">Required</span>
                            <span id="RexBillingFname" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                            <span id="RequiredFieldValidator7" title="Name Required" style="color:Red;display:none;">Required</span>
                            <span id="RexBillingLname" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>
											

                                            <div style="display: block;" id="UpdatePanelZip">
	
                                            <div class="form-group">
												<div class="label-area">
													<label><span id="lblAddress1">Address Line 1</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtaddress1" maxlength="250" id="txtaddress1" class="form-control AddressSyncronization_bound" size="30" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" type="text">&nbsp;
                                                    <span id="RequiredFieldValidator8" title="Address Required" style="color:Red;display:none;">Required</span>
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblAddress2">Address Line 2</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="txtaddress2" maxlength="50" id="txtaddress2" class="form-control AddressSyncronization_bound" size="30" onchange="AddressSyncronization_OnAddressChange(event);" type="text">
                                                </div>
											</div>
                                            
                                             
                                             
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblCity">City</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    
                                                    
                                                    <input name="txtCity" maxlength="50" id="txtCity" class="form-control AddressSyncronization_bound" size="30" alt="If you select OTHER please fill in the box to the right" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" type="text">
                                                    <span id="RequiredFieldValidator9" title="City Required" style="color:Red;display:none;">Required</span>
                                                    
                                                    
                                                    <label style="font-size:x-small;"></label>
                                                    
                                                    
                                                <triggers>
                                                        <asp:asyncpostbacktrigger controlid="ddlShipCity" eventname="SelectedIndexChanged">
                                                </asp:asyncpostbacktrigger></triggers>
                                                

                                                </div>
											</div>
                                            
                                            
</div>
                            <div style="display: block;" id="UpdatePanelState">
		
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblState">State</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <select name="ddlState" id="ddlState" title="Select State" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" style="font-size:X-Small;">
		<option selected="selected" value=""></option>
		<option value="AW">ARUBA </option>

	</select>
                                                    <span id="RequiredFieldValidator16" title="State required" style="color:Red;display:none;">Required</span>
                                                </div>
											</div>
                                            
                                            <div class="form-group">
												<div class="label-area">
													<label><span id="lblZip">Postal Code</span>:</label>
												</div>
                                                <div id="regZip" class="row-holder">
                                                    <input name="zip" maxlength="20" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);setTimeout('__doPostBack(\'zip\',\'\')', 0)" onkeypress="if (WebForm_TextBoxKeyHandler(event) == false) return false;" id="zip" class="form-control AddressSyncronization_bound" size="10" onblur="ValidateZip('AW');" type="text">
                                                        
                                                    <span id="zipValidator" title="Zip/Postal code required" style="color:Red;display:none;">Required</span>
                                                    <!--DBell, 2015-08-19, Task 12023.  ToolTip and ErrorMessage are now being set dynamcially in .cs file. -->
                                                    <span id="cval_Zip" style="color:Red;display:none;"></span>
                                                    <!--Error Message Field-->
                                                    
                                                    <div id="InvalidZip"></div>
                                                </div>
                                                
											</div>
                                           
											
                                
</div>

											




											<div class="form-group">
												<div class="label-area">
													<label><span id="lblCountry">Country</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <select class="AddressSyncronization_bound" name="ddlCountry" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);setTimeout('__doPostBack(\'ddlCountry\',\'\')', 0)" id="ddlCountry" disabled="disabled" style="font-size:X-Small;">
	  <option value="ID" <? if ($_SESSION['lmCountry']=='ID') echo 'selected';?>>INDONESIA </option>
            
 
            
                    <option value="MY" <? if ($_SESSION['lmCountry']=='MY') echo 'selected';?>>MALAYSIA</option>
            
 
            
                    <option value="SG" <? if ($_SESSION['lmCountry']=='SG') echo 'selected';?>>SINGAPORE</option>

</select>
                                                </div>
											</div>
										</fieldset>
									</div>
								</div>
							</div>
							<div class="panel panel-primary">
								<div class="panel-heading" style="background-color:#6acbde">
									<h2><span id="lblShippingAdd">Shipping Address</span>
                                        <span><img style="padding-bottom: 15px; display: none;" id="imgShippingAddressValidSign" src="regformfiles/AddressValidSign.png" hidden="hidden"></span>
                                        <img id="imgShippingAddressIncorrectSign" style="cursor: pointer; display: none;" src="regformfiles/AddressIncorrectSign.png" hidden="hidden">
									</h2>
								</div>
                                <input value="-1" name="isShippingAddressValid" id="isShippingAddressValid" style="visibility:hidden;" type="text">
								<div class="panel-body">
								    <div class="alert alert-danger">
								        <span id="divnoteEnglishonly" style="color:Maroon;font-weight:bold;">Only alphanumeric characters and numbers are allowed (English Only)</span> 
								        <br>
                                        <span onchange="AddressSyncronization_OnCheckboxChange();"><input id="chk_useBillingAddress" name="chk_useBillingAddress" type="checkbox"></span>
                                        <span id="lblUseBillingAdd" style="font-size:Smaller;">Shipping same as Mailing</span>
                                        <div style="display:none">
                                            
                                        </div>
								    </div>
                                    <span style="color: red; display: none;" id="spnAddressValidationErrorMessage" hidden="hidden">Shipping Address is not valid. <a style="cursor:pointer;text-decoration: underline;" id="ShippingAddressIsNotValidDialogFire">(Click here for more details)</a></span>
                                <div style="display: block;" id="UpdatePanelShippingZip">
	
									<div class="details">
										<fieldset>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblShipName">Shipping Name</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <span class="short"><input name="ShippingName" maxlength="50" id="ShippingName" class="form-control AddressSyncronization_bound" size="10" onchange="AddressSyncronization_OnAddressChange(event);" type="text"></span>
                                                    <span class="middle inlineTextBoxes"><input name="ShippingLName" maxlength="50" id="ShippingLName" class="form-control AddressSyncronization_bound" size="20" onchange="AddressSyncronization_OnAddressChange(event);" type="text"></span>
                                                    <span id="RequiredFieldValidator11" title="Name Required" style="color:Red;display:none;">Required</span>
                                                    <span id="RexShippingNameValidator" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                    <span id="RexShippingNameValidatorEU" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                    <span id="RequiredFieldValidator12" style="color:Red;display:none;">Required</span>
                                                    <span id="RexShippingLNameValidator" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                    <span id="RexShippingLNameValidatorEU" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>

											
											
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblShipAddr1">Address Line 1</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="ShippingAddress1" maxlength="150" id="ShippingAddress1" size="30" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" type="text">&nbsp;        
                                                    <span id="ReqShipAddressValidator" title="Address Required" style="color:Red;display:none;">Required</span>  
                                                    <span id="RexShipAddressValidator" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span> 
                                                </div>
											</div>
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblShipAddr2">Address Line 2</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <input name="ShippingAddress2" maxlength="50" id="ShippingAddress2" size="30" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event);" type="text">
                                                    <span id="RexShipAddress2Validator" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                </div>
											</div>
                                             
                                             
                                            
                                           
											<div class="form-group">
												<div class="label-area">
													<label><span id="lblShipCity">City</span>:</label>
												</div>
                                                  <div class="row-holder">
                                                    
                                                    
                                                    <input name="ShippingCity" maxlength="50" id="ShippingCity" size="30" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" type="text">
                                                    <span id="RequiredFieldValidator19" title="City Required" style="color:Red;display:none;">Required</span>
                                                    <span id="RexShipCityValidator2" title="Only characters [A-Z],[a-z],[0-9],dash and underscore allowed" style="color:Red;display:none;">Error</span>
                                                    <input name="HiddenCity" maxlength="50" id="HiddenCity" size="30" class="form-control" disabled="disabled" style="display:none;" type="text">
                                                    
                                                    
                                                    
                                                    <label id="label" style="font-size:x-small;"></label>
                                               
                                                    
                                                
                                                

                                                </div>
											</div>

                                            
                                         
                                         
											<div class="form-group">
												<div class="label-area">
												    <label><span id="lblShipState">State</span>:</label>
												</div>
                                                <div class="row-holder">


                                                    <select name="ddlShippingState" id="ddlShippingState" class="form-control AddressSyncronization_bound" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);" style="font-size:X-Small;">
		<option selected="selected" value=""></option>
		<option value="AW">ARUBA </option>

	</select> 
                                                    <span id="RequiredFieldValidator17" title="State required" style="color:Red;display:none;">Required</span>


                                                </div>
											</div>

                                            <div class="form-group">
			                                    <div class="label-area">
				                                    <label><span id="ShipZip">Postal Code</span>:</label>
				                                </div>
                                                <div id="regShipZip" class="row-holder">
                                                <input name="ShippingZip" maxlength="20" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);setTimeout('__doPostBack(\'ShippingZip\',\'\')', 0)" onkeypress="if (WebForm_TextBoxKeyHandler(event) == false) return false;" id="ShippingZip" size="10" class="form-control AddressSyncronization_bound" onblur="ValidateShipZip('AW');" type="text">
                                                <span id="shipZipValidator" title="Zip/Postal code required" style="color:Red;display:none;">Required</span>
                                                    <!--DBell, 2015-08-19, Task 12023.  ToolTip and ErrorMessage are now being set dynamcially in .cs file. -->
                                                    <span id="cval_ShipZip" style="color:Red;display:none;"></span>
                                                    <!--Error Message Field-->
                                                    
                                                    <div id="InvalidShippingZip"></div>
                                                </div>
                                                
		                                </div>
                                        <div class="form-group">
												<div class="label-area">
													<label><span id="lblShipCountry">Country</span>:</label>
												</div>
                                                <div class="row-holder">
                                                    <select name="ddlShippingCountry" onchange="AddressSyncronization_OnAddressChange(event); addressValidationFieldsOnChange(event);setTimeout('__doPostBack(\'ddlShippingCountry\',\'\')', 0)" id="ddlShippingCountry" class="form-control AddressSyncronization_bound" style="font-size:X-Small;">
	  <option value="ID" <? if ($_SESSION['lmCountry']=='ID') echo 'selected';?>>INDONESIA </option>
            
 
            
                    <option value="MY" <? if ($_SESSION['lmCountry']=='MY') echo 'selected';?>>MALAYSIA</option>
            
 
            
                    <option value="SG" <? if ($_SESSION['lmCountry']=='SG') echo 'selected';?>>SINGAPORE</option>

	</select>
                                                </div>
										</div>
			
											
											 
										    
											
										</fieldset>

							</div>
                                
</div>
						</div>
					</div>
                    </div>
			    </div>

					
					
					
	        
				  

					
					
			        
                    <div id="divShowSignup" class="row minimalSpacing">
						<div class="col-md-12"></div>
					</div>

			
			        
                    
			
        
        
        

					
					<!-- Old Packages GridViews -->
				    

					
				    


					
					
				    


					
				    


					<!-- Auto Ship Products -->
				    


					<!-- Final acceptance of terms & buttons -->
				    <div class="row">
						<div class="col-md-12">
<div id="divFinalSSNagreementCheckBox">
    <input id="chkSSN" name="chkSSN" checked="checked" onclick="javascript:EnableBtns('chkSSN');" type="checkbox">
    <label for="chkSSN">Agreement</label>
    </div>

<div id="divIDNPWPagreementCheckBox">
    
</div>

<p>&nbsp;</p>

<div id="submitButtonsArea" align="center">
  <input name="btnAddDistributorInfo" value="Complete Signup" onclick="" type="submit" class="btn btn-success">
    
    <input name="Reset" value="Reset" id="Reset" class="btn btn-danger" type="reset">
    <input name="btnCancel" value="Cancel" id="btnCancel" class="btn btn-default" type="button" onClick="document.location.href='../../'">
    
</div>


						</div>
					</div>





				</section>

                <div id="vnCustomsWarningModal" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 id="lblVNCustomsWarningHeader" class="modal-title">Warning</h4>
                            </div>
                            <div class="modal-body">
                                <p id="lblVNCustomsWarning" class="text-danger" style="font-size: 14px;">Each
 order will be subject to import duties and it is the responsibility of 
the purchaser to pay the duties and clear their order in Customs. By 
submitting your application, you are accepting this condition.  
Additionally, you release Jeunesse from any responsibility for clearing 
the products through Customs and waive your right to a refund of the 
purchase price if you fail to pay the duties and clear the product.</p>
                                <input name="vnCustomsWarningModalShown" id="vnCustomsWarningModalShown" value="0" type="hidden">
                            </div>
                            <div class="modal-footer">
                                <input name="btnVNIAgree" value="I Agree" onclick='return valdatedPostBack(this);WebForm_DoPostBackWithOptions(new WebForm_PostBackOptions("btnVNIAgree", "", true, "", "", false, false))' id="btnVNIAgree" class="btn btn-primary btn-update" type="submit">
                            </div>
                        </div>
                    </div>
                </div>

<!--<div class="modal fade" id="newsInfoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">Shipping Address Verification</h4>
      </div>
      <div class="modal-body HeDirLTR">
            <ul id="myList" class="news" style="list-style-type: none;margin: 9px 0;padding: 10px;">
            </ul>   
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Use this address</button>
      </div>
    </div>
  </div>
</div>
-->

            






</form>
            




			</div>
		</div>
		
		
        <footer id="footer" class="container">
   
		</footer>
	</div>
  

</body></html>