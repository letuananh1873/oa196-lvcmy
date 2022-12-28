<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:o="urn:schemas-microsoft-com:office:office">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<meta name="x-apple-disable-message-reformatting">
	<title></title>
</head>
<body>
    <?php
    $custom_logo_id = get_theme_mod( 'custom_logo' );
    $custom_logo_url = wp_get_attachment_image_url( $custom_logo_id , 'full' );
    ?>
    <table width="600" style="margin: auto;">
        <tbody>
            <tr style="text-align: center;">
                <td><img width="168" style="margin: 0 0 15px;" src="<?php echo $custom_logo_url; ?>" alt="Logo"></td>
            </tr>
        </tbody>
    </table>
    <table width="600" style="margin: auto;background-color: #ffffff;
    border: 1px solid #dedede;
    border-radius: 3px; border-collapse: collapse;">
        <tbody>
            <tr>
                <td style="dipslay: block; padding: 35px 45px; background: #9CD5BC;">
                    <h1 style="text-align: center; color: white;"><?php echo $product_name; ?></h1>
                </td>
            </tr>
            <tr style="">
                <td style="margin: 50px 0; display: block; padding: 0 50px;">
                    Dear <?php echo $recipient_name; ?><br>
                    We heard that <?php echo $your_name; ?> is eyeing for <a style="font-weight: bold;" href="<?php echo $customiser_url;?>"><?php echo $product_name; ?></a>
                </td>
            </tr>
            <tr style="">
                <td>
                    <p style="padding: 0 50px; font-family:arial; margin-top:15px; margin-left:auto; text-align:center; margin-right:auto; margin-bottom:5px">
                        <a href="<?php echo $customiser_url; ?>" style="border:1px solid #000; text-decoration:none!important; text-align:center; color:#808080; margin-top:10px; text-transform:uppercase; color:#000; padding:7px 30px 6px 30px">Shop Now</a>
                    </p>
                </td>
            </tr>
            <tr style="">
                <td style="padding: 0 50px; margin-bottom: 50px; display: block;">
                    <p>With Love, <br>Your friends at <a href="<?php echo home_url(); ?>">Love & Co.</a></p>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>