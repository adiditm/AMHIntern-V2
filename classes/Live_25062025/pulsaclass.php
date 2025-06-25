<?
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
	include_once("../classes/simple_html_dom.php");
	include_once("../classes/productclass.php");
	$regexViewstate = '/viewState\" value=\"(.*)\"/i';
	$regexEventVal  = '/__EVENTVALIDATION\" value=\"(.*)\"/i';


   class pulsa {

 		function get1stCook($pURL,$pCookie) {
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
				////curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 2);
				curl_setopt($curl, CURLOPT_HEADER, true);
				curl_setopt($curl, CURLOPT_POST, false);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_COOKIE,1);
				curl_setopt($curl, CURLOPT_COOKIEJAR,$pCookie);
				//curl_setopt($curl, CURLOPT_COOKIEFILE,$pCookie);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				$result = curl_exec($curl);
				curl_close($curl);
				return $result;
		}


		function getCaptchaImageHead($pURL,$pCookCapt) {

			$curl = curl_init();
			curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC ) ;
			//curl_setopt($curl, CURLOPT_SSLVERSION,3);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_HEADER, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

			curl_setopt($curl, CURLOPT_POST, false);

			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);

			curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookCapt);

			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
			curl_setopt($curl, CURLOPT_URL, $pURL);

			$resp= curl_exec($curl);

			list($headers, $response) = explode("\r\n\r\n", $resp, 2);
			$headers = explode("\n", $headers);
			foreach($headers as $header) {
				if (stripos($header, 'Content-length:') !== false) {
					$vHead= "$header";
				}
			}

			curl_close($curl);
			return $vHead;

		}


		function getCaptchaText($pUserDBC,$pPassDBC,$pURL) {
			$client = new DeathByCaptcha_SocketClient($pUserDBC, $pPassDBC);
			$client->is_verbose = false;
			//echo $pURL;
			//echo "Your balance is {$client->balance} US cents\n";

			 if ($captcha = $client->decode($pURL, 20)) {
				//echo "xsssssss".$captcha['text'];
				return $captcha['text'] ;
			 } 	else return "0";

		}

//Regex ViewState
		function regexExtract($text, $regex, $regs, $nthValue) {
			if (preg_match($regex, $text, $regs)) {
				$result = $regs[$nthValue];
			} else {
				$result = "";
			}
		    return $result;
		}


       //cURL
   function loginCurl($pURLLogin,$pFieldUser,$pFieldPass,$pUser,$pPass,$pCookie,$pCookieJar,$pCookieFileOnly) {
			
		//Preparing
		//===============Getting Login Page================//
				$ch = curl_init();

				curl_setopt($ch, CURLOPT_URL, $pURLLogin);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
				curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_COOKIEJAR,$pCookie);
				curl_setopt($ch, CURLOPT_COOKIESESSION,true);
				$data=curl_exec($ch);
	
				$viewstate = $this->getViewState($data);
				curl_close($ch);
		//===============End Getting LoginPage===============//

		//Executing CURL
			    $curl = curl_init();
				$params="$pFieldUser=$pUser&$pFieldPass=$pPass".'&ControlGroupLoginAgencyView$AgentLoginLoginAgencyView$ButtonLogIn='.rawurlencode('Log In');
				$params .= '&__EVENTTARGET=';
				
				$params .= '&viewState='.$vVal;
				
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_HEADER, false);

				curl_setopt($curl, CURLOPT_POST, TRUE);
				curl_setopt($curl, CURLOPT_POSTFIELDS,$params);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_COOKIE,1);
				//echo $referer;

				curl_setopt($curl, CURLOPT_COOKIEJAR,$pCookieJar);
				curl_setopt($curl, CURLOPT_COOKIEFILE,$pCookie);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				
				curl_setopt($curl, CURLOPT_URL, $pURLLogin);


				$result = curl_exec($curl);
				curl_close($curl);
				return $result;
		}


		function getBookPage($pURLBook,$pCookieFile,$pRefer,$pCookJarBook) {
			$curl = curl_init();
			//	echo $pCookieFile;

			//curl_setopt($curl, CURLOPT_SSLVERSION,3);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_HEADER, false);

			curl_setopt($curl, CURLOPT_POST, FALSE);
			curl_setopt($curl, CURLOPT_URL, $pURLBook);
			curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookieFile);
			curl_setopt($curl, CURLOPT_COOKIEJAR, $pCookJarBook);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION,TRUE);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_REFERER,$pRefer);
// echo $data."xxxxxxxxxxxxxxxxxxxxxxx";
			return $data = curl_exec($curl);
			curl_close($curl);

		}

       //cURL
		function searchTicket($pURLGet,$pCookie,$pParamTicket,$pJarFlight) {

				$curl = curl_init();
				//echo $pURLGet;
				//echo $pCookie;
				//echo $pParamTicket."<br><br>mm";
				//$params='__EVENTTARGET=&__EVENTARGUMENT=&__VIEWSTATE=%2FwEPDwUBMGQYAQUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFgMFWkNvbnRyb2xHcm91cEJvb2tpbmdMaXN0VHJhdmVsQWdlbnRWaWV3JEJvb2tpbmdMaXN0Qm9va2luZ0xpc3RUcmF2ZWxBZ2VudFZpZXckUmFkaW9Gb3JBZ2VudAVbQ29udHJvbEdyb3VwQm9va2luZ0xpc3RUcmF2ZWxBZ2VudFZpZXckQm9va2luZ0xpc3RCb29raW5nTGlzdFRyYXZlbEFnZW50VmlldyRSYWRpb0ZvckFnZW5jeQVbQ29udHJvbEdyb3VwQm9va2luZ0xpc3RUcmF2ZWxBZ2VudFZpZXckQm9va2luZ0xpc3RCb29raW5nTGlzdFRyYXZlbEFnZW50VmlldyRSYWRpb0ZvckFnZW5jeTXhy2ltZry%2FVwOL4DGYiD%2Br%2FS9H&pageToken=&AvailabilitySearchInputBookingListTravelAgentVieworiginStation1=SUB&AvailabilitySearchInputBookingListTravelAgentView%24TextBoxMarketOrigin1=SUB&AvailabilitySearchInputBookingListTravelAgentViewdestinationStation1=CGK&AvailabilitySearchInputBookingListTravelAgentView%24TextBoxMarketDestination1=CGK&AvailabilitySearchInputBookingListTravelAgentVieworiginStation2=&AvailabilitySearchInputBookingListTravelAgentView%24TextBoxMarketOrigin2=&AvailabilitySearchInputBookingListTravelAgentViewdestinationStation2=&AvailabilitySearchInputBookingListTravelAgentView%24TextBoxMarketDestination2=&AvailabilitySearchInputBookingListTravelAgentView%24RadioButtonMarketStructure=OneWay&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListMarketDay1=21&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListMarketMonth1=2014-03&date_picker=2014-03-21&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListMarketDay2=27&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListMarketMonth2=2014-03&date_picker=2014-03-27&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListPassengerType_ADT=1&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListPassengerType_CHD=0&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListPassengerType_INFANT=0&AvailabilitySearchInputBookingListTravelAgentView%24DropDownListSearchBy=columnView&AvailabilitySearchInputBookingListTravelAgentView%24ButtonSubmit=Find+Flights&ControlGroupBookingListTravelAgentView%24BookingListBookingListTravelAgentView%24Search=ForAgent&ControlGroupBookingListTravelAgentView%24BookingListBookingListTravelAgentView%24DropDownListTypeOfSearch=0&ControlGroupBookingListTravelAgentView%24BookingListBookingListTravelAgentView%24TextBoxKeyword=';
				//echo $pParamTicket=$params;
				//echo str_replace("&","&<br>",$pParamTicket);
			//	$pRefer='https://book.citilink.co.id/ScheduleSelect.aspx';
				curl_setopt($curl, CURLOPT_URL, $pURLGet);
				
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParamTicket);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				curl_setopt($curl, CURLOPT_COOKIEJAR,$pJarFlight);
				curl_setopt($curl, CURLOPT_REFERER,$pRefer);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");



		 	    $rescurl = curl_exec($curl);
				$result[1]=$rescurl;
				
				if (preg_match("/Session/i",$rescurl)) 
				    $result[0]="Err2";

				curl_close($curl);
				return $result ;
				
		}

	function checkSession($pURLGet,$pCookie) {
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, true);
				curl_setopt($curl, CURLOPT_POST, false);

				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURLGet);


				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Expect:'));
				$response = curl_exec($curl);
				list($header, $body) = explode("\r\n\r\n", $response, 2);
				return $body;

	}

	function checkFare($pURLGet,$pCookie) {
		//echo $pURLGet;
				$curl = curl_init();
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, false);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_URL, $pURLGet);
				$response = curl_exec($curl);
				return $response;
	}



	function setPrePax($pURL,$pCookie,$pParam) {
				//echo $pCookie;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIEJAR, $pCookieJar);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				$response = curl_exec($curl);
				//echo "xxxx".$response;
				return $response;


	}

	function setPax($pURL,$pCookie,$pParam) {
				//echo $pParam;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				curl_setopt($curl, CURLOPT_COOKIEJAR, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


			    $response = curl_exec($curl);
				return $response;


	}


	function getGoto($pURL,$pCookie) {
				//echo $pParam;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, false);
				//curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				if ($pCookie !='')
				   curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				$response = curl_exec($curl);
				return $response;


	}


	function getGotoRef($pURL,$pCookie,$pRefer) {
				//echo $pParam;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, false);
				//curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);
				curl_setopt($curl, CURLOPT_REFERER,$pRefer);


				$response = curl_exec($curl);
				return $response;


	}
	
	function genPost($pURL,$pParam,$pCookie) {
				//echo $pParam;
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
			//	curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				//curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				$response = curl_exec($curl);
				curl_close ($curl);
				return $response;


	}


	function doBook($pURL,$pCookie,$pParam) {
				$curl = curl_init();
				//curl_setopt($curl, CURLOPT_SSLVERSION,3);
				curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
				curl_setopt($curl, CURLOPT_HEADER, false);
				curl_setopt($curl, CURLOPT_POST, true);
				curl_setopt($curl, CURLOPT_POSTFIELDS, $pParam);
				curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
				curl_setopt($curl, CURLOPT_COOKIEFILE, $pCookie);
				//curl_setopt($curl, CURLOPT_COOKIESESSION,1);
				curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				curl_setopt($curl, CURLOPT_USERAGENT, "Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)");
				curl_setopt($curl, CURLOPT_URL, $pURL);


				$response = curl_exec($curl);
				return $response;

	}

	function getBookStatus($pPage, $pFromTo) {
			//echo $pPage;
			global $oProduct;
			$html = new simple_html_dom();
			$html = str_get_html($pPage);
			if (trim($pPage) != '') {
			if ($html) 
			foreach($html->find('div[id=itineraryBody]') as $element) {
					
					$vitr=0;
					foreach($element->find('tr') as $dl) {
						$itd=0;
						
						foreach($dl->find('td') as $td) {
						   $vTt[]= $td->plaintext;
						}


				    }
					foreach($element->find('p') as $thep) {
						   $vByr[]= $thep->plaintext;
					}
					
			}

			//print_r($vByr);
			
			$vBayarBahan=$vByr[1];
			$vBayar=explode("Jumlah yang harus dibayar",$vBayarBahan);
			$vExpBahan=$vByr[0];
			$vExpBahan=explode("Ticketing time limit",$vExpBahan);
			$vExp=trim($vExpBahan[1]);
			$vExp=explode("&nbsp;",$vExp);
			$vExp=explode(",",$vExp[0]);
			$vTahun=$vExp[4];
			$vTgl=explode(" ",$vExp[1]);
			
			$vTime=explode(" ",$vExp[2]);
			//$vTime=substr(trim($vTime[0]),
			//
			$vExp=strtoupper(trim($vTgl[1]).trim($vTgl[2])." ".substr(trim($vTahun),0,4)." ".trim($vTime[29])." WIB");
			//Summary Status Booking
			$vResult="";
			 if ($vTt[5] !='') {
			    $vResult[0]=$vTt[5];//Kode Book
				$vResult[1]=$vExp;//Expired
				//$vResult[2]=$vTahun; //Tahun Limit
				$vResult[4]=substr($vBayar[1],1,20);//Fare Total
				$vResult[3]=$vFlight;//Flight
				$vResult[5]=$vTt[7];//Kode Referensi

			 } else {
				$vResult[0]='failed';
			 }
			//==========================NTA======================//
			//Route
			$vRoute="";
			foreach($html->find('table[id=itinerarySeatAssignmentsTable]') as $table) {
					$vTRFlight=0;
					foreach($table->find('tr') as $tr) {
						$vTDFlight=0;
						foreach($tr->find('td') as $td) {
							//if ($vTRFlight > 0) {
							   $vRoute['TR'.$vTRFlight][$vTDFlight]=$td->plaintext;
							   $vTDFlight++;
							//}
						}
						
						$vTRFlight++;
						// $vCountFlight+=count($vRoute['TB'.$vTableFlight]);
						
					}
					 $vTableFlight++;					 
			}
			
			  
			
			   $vResult[6]= $vTRFlight-1; //Jumlah Route, harus dibagi jumlah penumpang
			   $vBF=$_SESSION['citifare']['basic'];
			   $vNT=$_SESSION['citifare']['total'];
			   $vMaska='QG';
			   
			   $vRumus= trim($oProduct->getCredMask($vMaska,"frumus"));
			   $vRumusX= trim($oProduct->getCredMask($vMaska,"frumus"));
				 if ($vRumus!='') {
				   $vRumus=str_replace("{BF}",$vBF,$vRumus);
				   $vRumus=str_replace("{NT}",$vNT,$vRumus);
				  
				   $vRumusX=str_replace("{BF}","Basic Fare",$vRumusX);
				   $vRumusX=str_replace("{NT}","Nilai Total",$vRumusX);
				   $vRumusX=str_replace("/100","%",$vRumusX);
				   $vRumusX=str_replace("*"," x ",$vRumusX);
				   $vRumusX=str_replace("-"," - ",$vRumusX);
				
					   
				   @eval('$result = ' . $vRumus . ';');
				   $vResult[7]=$result;
				} 
	//===========================End NTA=========================//
	
	
	//=========================== Detail penerbangan =========================//
	
			$vRoute="";		//Clear Route
			foreach($html->find('div[id=flightDisplayBody]') as $element) {

				$vTableFlight=0;$vCountFlight=0;
				foreach($element->find('table') as $table) {
					$vTRFlight=0;
					
					foreach($table->find('tr') as $tr) {
						$vTDFlight=0;
						
						$vRoute['TB'.$vTableFlight]['TR'.$vTRFlight]=$tr->plaintext;
						
						$vTRFlight++;
						
						
					}
					  $vTableFlight++;					 
				}

				
			}

//Route Detail
			$vFrom=substr($pFromTo,0,3);
			$vTo=substr($pFromTo,4,3);
			foreach($html->find('td[class=onwardh6]') as $element) {

				$vTDFlight=0;$vCountFlight=0;
				foreach($element->find('div[class=sectionHeader]') as $div) {
					
					$vArah=$div->plaintext;
					if ($vArah=='Berangkat:') {
					   $vMatched=explode("QG",$element->plaintext);
					   $v1stPos = strpos($element->plaintext,"($vFrom)") + 5;
					   $vNextText=substr($element->plaintext,$v1stPos,strlen($element->plaintext));

					   $vJamBrkt=explode("($vFrom)",$vNextText);
					 //  print_r($vJamBrkt);
					   $vJamBrkt=explode("Jam",$vJamBrkt[1]);
					   $vJamBrkt=trim(substr($vJamBrkt[1],0,10));
					   $vResult['hDep']=$vJamBrkt;
					   
					   $v1stPos = strpos($element->plaintext,"($vTo)") + 5;
					   $vNextText=substr($element->plaintext,$v1stPos,strlen($element->plaintext));
					   
					   $vJamDtg=explode("($vTo)",$vNextText);
					  // print_r($vJamDtg);
					   $vJamDtg=explode("Jam",$vJamDtg[1]);
					   $vJamDtg=trim(substr($vJamDtg[1],0,10));
					   $vResult['hArr']=$vJamDtg;
					}
					       
					if ($vArah=='Kembali:') {
					   $vMatchedR=explode("QG",$element->plaintext);
					   $v1stPos = strpos($element->plaintext,"($vTo)") + 5;
					   $vNextText=substr($element->plaintext,$v1stPos,strlen($element->plaintext));

					   $vJamBrkt=explode("($vTo)",$vNextText);
					   //print_r($vJamBrkt);
					   $vJamBrkt=explode("Jam",$vJamBrkt[1]);
					   $vJamBrktR=trim(substr($vJamBrkt[1],0,10));
					   $vResult['hDepR']=$vJamBrktR;
					   
					   $v1stPos = strpos($element->plaintext,"($vFrom)") + 5;
					   $vNextText=substr($element->plaintext,$v1stPos,strlen($element->plaintext));
					   
					   $vJamDtg=explode("($vFrom)",$vNextText);
					   //print_r($vJamDtg);
					   $vJamDtg=explode("Jam",$vJamDtg[1]);
					   $vJamDtgR=trim(substr($vJamDtg[1],0,10));					   
					   $vResult['hArrR']=$vJamDtgR;
					}
					
						
				}
				
				

				
			}
			
			$vResult['Flight'][2]='0';
			$vFlight1=explode("PK-",$vMatched[1]);
			$vFlight1="QG".trim(str_replace("&nbsp;","",$vFlight1[0]));
			$vFlight2=explode("PK-",$vMatched[2]);
			$vFlight2="QG".trim(str_replace("&nbsp;","",$vFlight2[0]));
			$vFlightDep=$vFlight1; 
			if (trim($vFlight2) !='QG') $vFlightDep.="-".$vFlight2;
			$vResult['Flight'][0]=$vFlightDep;

			if (is_array($vMatchedR)) {
				$vFlight1=explode("PK-",$vMatchedR[1]);
				$vFlight1="QG".trim(str_replace("&nbsp;","",$vFlight1[0]));
				$vFlight2=explode("PK-",$vMatchedR[2]);
				$vFlight2="QG".trim(str_replace("&nbsp;","",$vFlight2[0]));
				$vFlightRet=$vFlight1;
				if (trim($vFlight2) !='QG') $vFlightRet.="-".$vFlight2;
				$vResult['Flight'][1]=$vFlightRet;
				$vResult['Flight'][2]='1';
			}
			
			
			
			
			
	//============End Detail Penerbangan================//
	

			 return $vResult;
			} else echo "Booking Failed!<br />";

	}



		
	function saveBooking($fkdbook,$fmaskapai,$fpenumpang,$flisttumpang,$fjmlroute,$fsold,$fnta,$fdepart,$freturn,$frek,$fholder,$ftrans,$flastuser,$fket,$froute,$ftime,$faircode,$fdetinfo,$fmaster,$fcurr,$fpassbday,$fphone='',$fhp='',$femail='') {
		 global $oDB;
		 
		 $vSQL="insert into tb_issued(ftanggal,fkdbook,fmaskapai,fpenumpang,flisttumpang,fjmlroute,fsold,fnta,fdepart,freturn,frek,fholder,ftrans,flastuser,fket,froute,ftime,faircode,fdetinfo,fmaster, fcurr,fpassbday,fphone,fhp,femail) ";
		 $vSQL.="values(now(),'$fkdbook','$fmaskapai',$fpenumpang,'$flisttumpang',$fjmlroute,0,$fnta,'$fdepart','$freturn','$frek','$fholder',$ftrans,'$flastuser','$fket','$froute','$ftime','$faircode','$fdetinfo','$fmaster','$fcurr','$fpassbday','$fphone','$fhp','$femail') ";
		   
		  $vSQLCheck="select fkdbook from tb_issued where fkdbook='$fkdbook' and faircode='$faircode' and date(ftanggal)=date(now());";
		 $oDB->query($vSQLCheck);
		 while ($oDB->next_record()) {
			$vKd=$oDB->f('fkdbook');
		 }
	
		
		 if ($vKd=='') {
			 if ($oDB->query($vSQL)) 
				return true;
			else
				return false; 
		 } else return false; 
		 
		 return true;
			
	}
	
	
	
	function saveBookingDet($fkdbook,$fflightnum,$fdepret,$ffrom,$fto,$fdepdate,$fdeptime,$farrdate,$farrtime,$fclassflight,$ffarebasic,$ffarfetax,$ffaretot) {
		 global $oDB;
		 
		 $vSQL="INSERT INTO   `tb_issued_det`(  `fkdbook`, `fflightnum`,`fdepret`,`ffrom`,`fto`,`fdepdate`,`fdeptime`,`farrdate`,`farrtime`, `fclassflight`,`ffarebasic`,`ffarfetax`,`ffaretot`) 
	  ";
		  $vSQL.=" VALUES ('$fkdbook','$fflightnum','$fdepret','$ffrom','$fto','$fdepdate','$fdeptime','$farrdate','$farrtime','$fclassflight',$ffarebasic,$ffarfetax,$ffaretot);";
		   
		
		 if ($oDB->query($vSQL)) 
				return true;
		 else
				return false; 
		
	}	

	function getViewState($pHtml) {
		$dom = new DOMDocument;
		@$dom->loadHTML($pHtml);
		$vValidState= $dom->saveHTML();
		$html = str_get_html($vValidState);

		foreach($html->find('form') as $element) {
			foreach($element->find('input[type=hidden]') as $hidden) {
				$vID= $hidden->getAttribute('id');
				if ($vID=='viewState')
					$vVal=$hidden->getAttribute('value');
				
			}
		}

		return $vVal;
	}






}//Class

   $oPulsa=new pulsa;

?>
