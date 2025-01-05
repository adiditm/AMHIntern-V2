function GetXmlHttpObject(handler)
{ 
    var objXmlHttp=null;

    if (navigator.userAgent.indexOf("MSIE")>=0)
    { 
        //LCK 2014-02-24 IIS upgrade
        var strName="Msxml2.ServerXMLHTTP.6.0";
        //if (navigator.appVersion.indexOf("MSIE 5.5")>=0)
        //{
            //strName="Microsoft.XMLHTTP";
        //} 
        try
        { 
            objXmlHttp=new ActiveXObject(strName);
            objXmlHttp.onreadystatechange=handler;
            return objXmlHttp;
        } 
        catch(e)
        { 
            //alert("Error. Scripting for ActiveX might be disabled");
            return;
        }
    } 

    if (navigator.userAgent.indexOf("Mozilla")>=0)
    {
        objXmlHttp=new XMLHttpRequest();
        objXmlHttp.onload=handler;
        objXmlHttp.onerror=handler;
        return objXmlHttp;
    }
} 
