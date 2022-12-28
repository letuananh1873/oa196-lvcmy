<?php
/**
 * Template Name: FPX Confirm
 */
?>
<!-- 
# These sample pages are provided for information purposes only. It does not imply any recommendation or endorsement by anyone.
  These sample pages are provided for FREE, and no additional support will be provided for these sample pages. 
  There is no warranty and no additional document. USE AT YOUR OWN RISK.
-->
<html>
<head>
<title>SAMPLE FPX MERCHANT PAGE - Your One Stop Online Computer Shopping</title>
<script type="text/JavaScript" language="JavaScript">
	
	window.name="seller";
	
</script>
<link rel="stylesheet" type="text/css" href="files/style.css">
</head>
<body bgcolor="#C0E7FE">
<center>
<?php

//Merchant will need to edit the below parameter to match their environment.
error_reporting(E_ALL);

/* Generating String to send to fpx */
/*For B2C, message.token = 01
 For B2B1, message.token = 02 */

$fpx_msgType="AR";
$fpx_msgToken="01";
$fpx_sellerExId="EX00014457";
$fpx_sellerExOrderNo=date('YmdHis');
$fpx_sellerTxnTime=date('YmdHis');
$fpx_sellerOrderNo=date('YmdHis');
$fpx_sellerId="SE00020661";
$fpx_sellerBankCode="01";
$fpx_txnCurrency="MYR";
$fpx_txnAmount= '100.00';
$fpx_buyerEmail="";
$fpx_checkSum="";
$fpx_buyerName="";
$fpx_buyerBankId="TEST0023";
$fpx_buyerBankBranch="";
$fpx_buyerAccNo="";
$fpx_buyerId="";
$fpx_makerName="";
$fpx_buyerIban="";
$fpx_productDesc="SampleProduct";
$fpx_version="6.0";

/* Generating signing String */
$data=$fpx_buyerAccNo."|".$fpx_buyerBankBranch."|".$fpx_buyerBankId."|".$fpx_buyerEmail."|".$fpx_buyerIban."|".$fpx_buyerId."|".$fpx_buyerName."|".$fpx_makerName."|".$fpx_msgToken."|".$fpx_msgType."|".$fpx_productDesc."|".$fpx_sellerBankCode."|".$fpx_sellerExId."|".$fpx_sellerExOrderNo."|".$fpx_sellerId."|".$fpx_sellerOrderNo."|".$fpx_sellerTxnTime."|".$fpx_txnAmount."|".$fpx_txnCurrency."|".$fpx_version;

/* Reading key */
$priv_key = file_get_contents( get_template_directory() . '/page-templates/cert/EX00014457.key' );
$pkeyid = openssl_get_privatekey($priv_key);
openssl_sign($data, $binary_signature, $pkeyid, OPENSSL_ALGO_SHA1);
$fpx_checkSum = strtoupper(bin2hex( $binary_signature ) );

?>
<table border="0" cellpadding="0" cellspacing="0" height="96%" width="722">
    <tbody>
      <tr>
        <td colspan="3" align="left" height="50"><table style="background:#FDE6C4; border: 1px solid rgb(222, 217, 197);" cellpadding="0" cellspacing="0" height="50" width="722">
            <tbody>
              <tr>
                <td><table style="border: 1px solid rgb(255, 255, 255);" border="0" cellpadding="0" cellspacing="0" height="50" width="720">
                    <tbody>
                      <tr>
                        <td align="center"><strong>SAMPLE FPX MERCHANT PAGE</strong></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td colspan="3" align="left" height="21"><table style="border: 1px solid rgb(84, 141, 212);" class="menu" cellpadding="0" cellspacing="0" height="19" width="722">
            <tbody>
              <tr>
                <td align="center"></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td style="padding-left: 1px; padding-right: 1px;" align="left" valign="top" width="100%" colspan=2>
		<table bgcolor="#FDE6C4" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%">
            <tbody>
			
              <tr>
                <td align="left" height="27" width="722"><p style="color: rgb(0, 0, 0); font-family: Tahoma,sans-serif; font-size: 12px; padding-left: 5px;"><b>My Shopping Cart&nbsp;&nbsp;>&nbsp;&nbsp;Transaction Details&nbsp;&nbsp;>&nbsp;&nbsp;Order Confirmation</b></p></td>
              </tr>
              <tr>
                <td style="padding-top: 2px;" valign="top"><table class="infoBox" border="0" cellpadding="0" cellspacing="0" height="100%" width="100%">
                    <tbody>
                      <tr>
                        <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="5" bgcolor="#FDE6C4">
                            <tbody>
                              <tr>
                                <td><table class="infoBox" aborder="1" cellpadding="2" cellspacing="1" width="100%">
                                    <tbody>
                                      <tr class="infoBoxContents">
                                        <td valign="top" width="99%"><table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tbody>
											<!-- List of Products Chosen --> 
                                              <tr>
                                                <td><table border="0" cellpadding="10" cellspacing="0" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td class="main" ><b>Products</b> </td>
                                                        <td class="main" align="right"><b>Quantity</b></td>
                                                        <td class="main" align="right"><b>Total</b></td>
                                                      </tr>
                                                      <tr>
                                                        <td valign='top' class='main'>Kensington Pocketmouse </td>
                                                        <td class='main' align='right' valign='top'>
															<input class=productdata type="text" size='4' value='1' disabled></td>
                                                        <td class='main' align='right' valign='top'>MYR
                                                          	<input class=productdata type="text" size='10' value='25.00' disabled></td>
                                                      </tr>
                                                      <tr>
                                                        <td valign='top' class='main'>Apple Keyboard </td>
                                                        <td class='main' align='right' valign='top'>
															<input class=productdata type="text" size='4' value='1' disabled></td>
                                                        <td class='main' align='right' valign='top'>MYR
                                                          	<input class=productdata type="text" size='10' value='25.00' disabled></td>
                                                      </tr>
                                                      <tr>
                                                        <td class='main' valign='top'>Earphone with Remote and Mic </td>
                                                        <td class='main' align='right' valign='top'>
															<input class=productdata type="text" size='4' value='1' disabled></td>
                                                        <td class='main' align='right' valign='top'>MYR
                                                          	<input class=productdata type="text" size='10' value='50.00' disabled></td>
                                                      </tr>
													  <!-- End of List Products Chosen --> 
                                                    </tbody>
                                                  </table>
                                                  <table border="0" cellpadding="10" cellspacing="0" width="100%" height="100%">
                                                    <tr>
                                                      <td width="71%" align=center class="main">&nbsp;</td>
                                                    </tr>                                                   
													<tr>
                                                       <td width="71%" align='right' valign='top' class='main'><b>Total Amount</b></td>
                                                        <td width="29%" align='right' valign='top' class='main'>MYR
                                                      		<input type="text" name="TxnAmount" id="TxnAmount" size='10' value="<?php echo $_POST['TxnAmount'];?>" readonly></td>
                                                    </tr>
                                                  </table></td>
                                              </tr>
                                            </tbody>
                                          </table>
                                      </tr>
                                    </tbody>
                                  </table></td>
                              </tr>
							  <!-- Submit transaction via FPX -->
                              <tr>
                                <td><form name="form1" method="post" action="https://uat.mepsfpx.com.my/FPXMain/seller2DReceiver.jsp" >
                                  <table border="0" cellpadding="2" cellspacing="1" width="100%">
                                    <tbody>
                                      <tr class="infoBoxContents">
                                        <td valign="top" width="30%"><table border="0" cellpadding="2" cellspacing="0" width="100%">
                                            <tbody>                                              
                                              <tr>
                                                <td height="164" align="center" class="main"><b>Payment Method via FPX</b>
												<p>&nbsp;</p>
												<input type="submit" style="cursor:hand" value="Click to Pay"/>
												  <p>&nbsp;</p>
                                                  <p> <img src="image/FPXButton.PNG" border="2"/></p>
                                                  <p>&nbsp;</p>
												  <p class="main">&nbsp;</p>
                                                  <p class="main"><strong>* You must have Internet Banking Account in order to make transaction using FPX.</strong></p>
                                                  <p>&nbsp;</p>
                                                  <p class="main"><strong>* Please ensure that your browser's pop up blocker has been disabled to avoid any interruption during making transaction.</strong></p>
                                                  <p>&nbsp;</p>
                                                  <p class="main"><strong>* Do not close browser / refresh page until you receive response.</strong></p>
                                                <p>&nbsp;</p></td>
                                              </tr>
                                            </tbody>
                                          </table></td>
                                      </tr>
                                    </tbody>
                                  </table>                                  
                                 
                          </table></td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
            </tbody>
          </table></td>
      </tr>
      <tr>
        <td colspan="3" align="right" height="35" valign="top" width="722"><table border="0" cellpadding="0" cellspacing="0" width="722">
            <tbody>
              <tr> </tr>
              <tr>
                <td colspan="2"><table style="border: 1px solid rgb(84, 141, 212);" class="menu" cellpadding="0" cellspacing="0" height="19" width="722">
                    <tbody>
                      <tr>
                        <td align="center">&nbsp;&nbsp;Copyright � 2015 All rights reserved&nbsp;&nbsp; </td>
                      </tr>
                    </tbody>
                  </table></td>
              </tr>
              
            </tbody>
          </table></td>
      </tr>
    </tbody>
  </table>
  <hr>    
  <p>&nbsp;</p>
  <table width="100%" border="0" align="center" cellpadding="7" cellspacing="0" >
    <tr>
      <td colspan="100"></td>
    </tr> 	
	
	<label>

<input type=hidden value="<?php print $fpx_msgType; ?>" name="fpx_msgType">
<input type=hidden value="<?php print $fpx_msgToken; ?>" name="fpx_msgToken">
<input type=hidden value="<?php print $fpx_sellerExId; ?>" name="fpx_sellerExId">
<input type=hidden value="<?php print $fpx_sellerExOrderNo; ?>" name="fpx_sellerExOrderNo">
<input type=hidden value="<?php print $fpx_sellerTxnTime; ?>" name="fpx_sellerTxnTime">
<input type=hidden value="<?php print $fpx_sellerOrderNo; ?>" name="fpx_sellerOrderNo">
<input type=hidden value="<?php print $fpx_sellerId; ?>" name="fpx_sellerId">
<input type=hidden value="<?php print $fpx_sellerBankCode; ?>" name="fpx_sellerBankCode">
<input type=hidden value="<?php print $fpx_txnCurrency; ?>" name="fpx_txnCurrency">
<input type=hidden value="<?php print $fpx_txnAmount; ?>" name="fpx_txnAmount">
<input type=hidden value="<?php print $fpx_buyerEmail; ?>" name="fpx_buyerEmail">
<input type=hidden value="<?php print $fpx_checkSum; ?>" name="fpx_checkSum">
<input type=hidden value="<?php print $fpx_buyerName; ?>" name="fpx_buyerName">
<input type=hidden value="<?php print $fpx_buyerBankId; ?>" name="fpx_buyerBankId">
<input type=hidden value="<?php print $fpx_buyerBankBranch; ?>" name="fpx_buyerBankBranch">
<input type=hidden value="<?php print $fpx_buyerAccNo; ?>" name="fpx_buyerAccNo">
<input type=hidden value="<?php print $fpx_buyerId; ?>" name="fpx_buyerId">
<input type=hidden value="<?php print $fpx_makerName; ?>" name="fpx_makerName">
<input type=hidden value="<?php print $fpx_buyerIban; ?>" name="fpx_buyerIban">
<input type=hidden value="<?php print $fpx_version; ?>" name="fpx_version">
<input type=hidden value="<?php print $fpx_productDesc; ?>" name="fpx_productDesc">	
	</label>
  </table>
  </form>
</center>
<br>
</body>
</html>