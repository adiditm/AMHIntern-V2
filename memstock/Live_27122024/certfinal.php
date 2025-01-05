<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Welcome Letter</title>


<style type="text/css">

.divtr {
	margin-top:10px;
	
	}
.divtrsmall {
	margin-top:-10px;
	
}

}
.bold {
	font-weight:bold;
	
}

@media (max-width: 600px) {
  .divtr {
	margin-top:0px;
	
	}

.divtrsmall {
	margin-top:-15px;
	
}

  } 



.container {
    position: relative;
    text-align: center;
    color: white;
}

/* Bottom left text */
.bottom-left {
    position: absolute;
    bottom: 8px;
    left: 16px;
}

/* Top left text */
.top-left {
    position: absolute;
    top: 8px;
    left: 16px;
}

/* Top right text */
.top-right {
    position: absolute;
    top: 8px;
    right: 16px;
}

/* Bottom right text */
.bottom-right {
    position: absolute;
    bottom: 8px;
    right: 16px;
}

/* Centered text */
.centered {
    position: absolute;
    top: 57%;
    left: 50%;
    transform: translate(-50%, -50%);
	
}

/* Centered text */
.centered2 {
    position: absolute;
    top: 61%;
    left: 50%;
    transform: translate(-50%, -50%);
	
}


.centered3 {
    position: absolute;
    top: 65%;
    left: 16%;
  /*  transform: translate(-50%, -50%);*/
	text-align:justify;
	width:74%;
}


.centered4 {
    position: absolute;
    top: 46%;
    left: 35%;
  /*  transform: translate(-50%, -50%);*/
	text-align:justify;
	width:74%;
}

@font-face {
    font-family: myScript;
    src: url(parisienne-regular.woff);
}
	</style>
</head>

<body onload="//window.print()">
<?=$_POST['hContent']?>
</body>
</html>
