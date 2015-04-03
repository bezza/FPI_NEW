<?php
/**
 * File Name: contact_form_handler.php
 *
 * Send message function to process contact form submission
 *
 */

add_action( 'wp_ajax_nopriv_send_message', 'send_message' );
add_action( 'wp_ajax_send_message', 'send_message' );

if( !function_exists( 'send_message' ) ){
    function send_message()
    {
        if(isset($_POST['email'])):

            $nonce = $_POST['nonce'];

            if (!wp_verify_nonce($nonce, 'send_message_nonce')) {
                die (__('Unverified Nonce!', 'framework'));
            }

            $show_reCAPTCHA = get_option('theme_show_reCAPTCHA');
            $reCAPTCHA_public_key = get_option('theme_recaptcha_public_key');
            $reCAPTCHA_private_key = get_option('theme_recaptcha_private_key');

            if(!empty($reCAPTCHA_public_key) && !empty($reCAPTCHA_private_key) && $show_reCAPTCHA == 'true' ){
                /* Include recaptcha library */
                require_once( get_template_directory().'/recaptcha/recaptchalib.php' );
                $resp = recaptcha_check_answer ($reCAPTCHA_private_key,
                                                $_SERVER["REMOTE_ADDR"],
                                                $_POST["recaptcha_challenge_field"],
                                                $_POST["recaptcha_response_field"]);

                if (!$resp->is_valid){
                    /* What happens when the CAPTCHA was entered incorrectly */
                    die (__("The reCAPTCHA was not entered correctly. Please try it again.","framework"));
                }
            }

            /* Sanitize and Validate Target email address that will be configured from theme options */
            $to_email = sanitize_email( get_option('theme_contact_email') );
            $to_email = is_email($to_email);
            if (!$to_email) {
                die (__('Target Email address is not properly configured!', 'framework'));
            }

            /* Sanitize and Validate contact form input data */
            $from_name = sanitize_text_field($_POST['name']);
            $phone_number = sanitize_text_field($_POST['number']);
            $message = stripslashes( $_POST['message'] );
            $from_email = sanitize_email($_POST['email']);
            $from_email = is_email($from_email);
            if (!$from_email) {
                die (__('Provided Email address is invalid!', 'framework'));
            }

            $email_subject = __('New message sent by', 'framework') . ' ' . $from_name . ' ' . __('using contact form at', 'framework') . ' ' . get_bloginfo('name');

            $email_body = __("You have received a message from: ", 'framework') . $from_name . " <br/>";

            if (!empty($phone_number)) {
                $email_body .= __("Phone Number : ", 'framework') . $phone_number . " <br/>";
            }

            $email_body .= __("Their additional message is as follows.", 'framework') . " <br/>";
            $email_body .= wpautop( $message ) . " <br/>";
            $email_body .= __("You can contact ", 'framework') . $from_name . __(" via email, ", 'framework') . $from_email;

            $header = 'Content-type: text/html; charset=utf-8' . "\r\n";
            $header = apply_filters("inspiry_contact_mail_header", $header);
            $header .= 'From: ' . $from_name . " <" . $from_email . "> \r\n";

            if (wp_mail($to_email, $email_subject, $email_body, $header)) {
                _e("Message Sent Successfully!", 'framework');
            } else {
                _e("Server Error: WordPress mail method failed!", 'framework');
            }

        else:
            _e("Invalid Request !", 'framework');
        endif;

        die;

    }
}

add_action( 'wp_ajax_nopriv_send_message_to_agent', 'send_message_to_agent' );
add_action( 'wp_ajax_send_message_to_agent', 'send_message_to_agent' );

if( !function_exists( 'send_message_to_agent' ) ){
    function send_message_to_agent(){
        if(isset($_POST['email'])):

            $nonce = $_POST['nonce'];

            if (!wp_verify_nonce($nonce, 'agent_message_nonce')) {
                die (__('Unverified Nonce!', 'framework'));
            }

            $show_reCAPTCHA = get_option('theme_show_reCAPTCHA');
            $reCAPTCHA_public_key = get_option('theme_recaptcha_public_key');
            $reCAPTCHA_private_key = get_option('theme_recaptcha_private_key');

            if(!empty($reCAPTCHA_public_key) && !empty($reCAPTCHA_private_key) && $show_reCAPTCHA == 'true' ){
                /* Include recaptcha library */
                require_once( get_template_directory().'/recaptcha/recaptchalib.php' );
                $resp = recaptcha_check_answer ($reCAPTCHA_private_key,
                                                $_SERVER["REMOTE_ADDR"],
                                                $_POST["recaptcha_challenge_field"],
                                                $_POST["recaptcha_response_field"]);

                if (!$resp->is_valid){
                    /* What happens when the CAPTCHA was entered incorrectly */
                    die (__("The reCAPTCHA was not entered correctly. Please try it again.","framework"));
                }
            }

            /* Sanitize and Validate Target email address that is coming from agent form */
            //$to_email = sanitize_email( $_POST['target'] );
            $to_email = sanitize_email( 'berian.reed@gmail.com' );
            $to_email = is_email($to_email);
            if (!$to_email) {
                die (__('Agent email address is not properly configured!', 'framework'));
            }


            /* Sanitize and Validate contact form input data */
            $from_name = sanitize_text_field($_POST['name']);
            $from_country = sanitize_text_field($_POST['country']);
            $from_phone = sanitize_text_field($_POST['phone']);
            $message = stripslashes( $_POST['message'] );
            $property_title = sanitize_text_field( $_POST['property_title'] );
            $property_permalink = esc_url( $_POST['property_permalink'] );
			$img_url =  $_POST['img_url'];
            $from_email = sanitize_email($_POST['email']);
            $from_email = is_email($from_email);
			$contact_method = $_POST['con-method'];
			$country = $_POST['country'];
			//ob_start();
			
			// set the cookies
			setcookie("name",$from_name, time()+3600,'/' );
			setcookie("email",$from_email, time()+3600,'/' );
			setcookie("phone",$from_phone, time()+3600,'/' );
			$_COOKIE['name'] = $from_name;
			//ob_clean();
	
            if (!$from_email) {
                die (__('Provided Email address is invalid!', 'framework'));
            }
			
            $email_subject = __('New lead from ', 'framework') . ' ' . $from_name . ' ' . __('- FirstPropInvest.com ', 'framework') . ' ' . get_bloginfo('name');
		
			$email_body .= "
			<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//ENhttp://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd><html xmlns=http://www.w3.org/1999/xhtml><head>
    <title></title>
    <meta http-equiv=Content-Type content=text/html; charset=utf-8 />
			<style type=\"text/css\">
body {
  margin: 0;
  mso-line-height-rule: exactly;
  padding: 0;
  min-width: 100%;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
td {
  padding: 0;
  vertical-align: top;
}
.spacer,
.border {
  font-size: 1px;
  line-height: 1px;
}
.spacer {
  width: 100%;
}
img {
  border: 0;
  -ms-interpolation-mode: bicubic;
}
.image {
  font-size: 12px;
  Margin-bottom: 24px;
  mso-line-height-rule: at-least;
}
.image img {
  display: block;
}
.logo {
  mso-line-height-rule: at-least;
}
.logo img {
  display: block;
}
strong {
  font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
  Margin-top: 0;
}
ol,
ul,
li {
  padding-left: 0;
}
blockquote {
  Margin-top: 0;
  Margin-right: 0;
  Margin-bottom: 0;
  padding-right: 0;
}
.column-top {
  font-size: 32px;
  line-height: 32px;
}
.column-bottom {
  font-size: 8px;
  line-height: 8px;
}
.column {
  text-align: left;
}
.contents {
  table-layout: fixed;
  width: 100%;
}
.padded {
  padding-left: 32px;
  padding-right: 32px;
  word-break: break-word;
  word-wrap: break-word;
}
.wrapper {
  display: table;
  table-layout: fixed;
  width: 100%;
  min-width: 620px;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
}
table.wrapper {
  table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
  Margin-left: auto;
  Margin-right: auto;
  width: 600px;
}
.centered {
  Margin-left: auto;
  Margin-right: auto;
}
.two-col .image {
  Margin-bottom: 23px;
}
.two-col .column-bottom {
  font-size: 9px;
  line-height: 9px;
}
.two-col .column {
  width: 300px;
}
.three-col .image {
  Margin-bottom: 21px;
}
.three-col .column-bottom {
  font-size: 11px;
  line-height: 11px;
}
.three-col .column {
  width: 200px;
}
.three-col .first .padded {
  padding-left: 32px;
  padding-right: 16px;
}
.three-col .second .padded {
  padding-left: 24px;
  padding-right: 24px;
}
.three-col .third .padded {
  padding-left: 16px;
  padding-right: 32px;
}
@media only screen and (min-width: 0) {
  .wrapper {
    text-rendering: optimizeLegibility;
  }
}
@media only screen and (max-width: 620px) {
  [class=wrapper] {
    min-width: 318px !important;
    width: 100% !important;
  }
  [class=wrapper] .one-col,
  [class=wrapper] .two-col,
  [class=wrapper] .three-col {
    width: 318px !important;
  }
  [class=wrapper] .column,
  [class=wrapper] .gutter {
    display: block;
    float: left;
    width: 318px !important;
  }
  [class=wrapper] .padded {
    padding-left: 32px !important;
    padding-right: 32px !important;
  }
  [class=wrapper] .block {
    display: block !important;
  }
  [class=wrapper] .hide {
    display: none !important;
  }
  [class=wrapper] .image {
    margin-bottom: 24px !important;
  }
  [class=wrapper] .image img {
    height: auto !important;
    width: 100% !important;
  }
}
.wrapper h1 {
  font-weight: 700;
}
.wrapper h2 {
  font-style: italic;
  font-weight: normal;
}
.wrapper h3 {
  font-weight: normal;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
  font-style: italic;
}
.one-col-feature h1 {
  font-weight: normal;
}
.one-col-feature h2 {
  font-style: normal;
  font-weight: bold;
}
.one-col-feature h3 {
  font-style: italic;
}
td.border {
  width: 1px;
}
tr.border {
  background-color: #e9e9e9;
  height: 1px;
}
tr.border td {
  line-height: 1px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature {
  background-color: #ffffff;
  font-size: 14px;
  table-layout: fixed;
}
.one-col,
.two-col,
.three-col,
.one-col-feature,
.preheader,
.header,
.footer {
  Margin-left: auto;
  Margin-right: auto;
}
.preheader table {
  width: 602px;
}
.preheader .title,
.preheader .webversion {
  padding-top: 10px;
  padding-bottom: 12px;
  font-size: 12px;
  line-height: 21px;
}
.preheader .title {
  text-align: left;
}
.preheader .webversion {
  text-align: right;
  width: 300px;
}
.header {
  width: 602px;
}
.header .logo {
  padding: 32px 0;
}
.header .logo div {
  font-size: 26px;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 32px;
}
.header .logo div a {
  text-decoration: none;
}
.header .logo div.logo-center {
  text-align: center;
}
.header .logo div.logo-center img {
  Margin-left: auto;
  Margin-right: auto;
}
.gmail {
  width: 650px;
  min-width: 650px;
}
.gmail td {
  font-size: 1px;
  line-height: 1px;
}
.wrapper a {
  text-decoration: underline;
  transition: all .2s;
}
.wrapper h1 {
  font-size: 36px;
  Margin-bottom: 18px;
}
.wrapper h2 {
  font-size: 26px;
  line-height: 32px;
  Margin-bottom: 20px;
}
.wrapper h3 {
  font-size: 18px;
  line-height: 22px;
  Margin-bottom: 16px;
}
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a {
  text-decoration: none;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
  font-size: 14px;
  border-left: 2px solid #e9e9e9;
  Margin-left: 0;
  padding-left: 16px;
}
table.divider {
  width: 100%;
}
.divider .inner {
  padding-bottom: 24px;
}
.divider table {
  background-color: #e9e9e9;
  font-size: 2px;
  line-height: 2px;
  width: 60px;
}
.wrapper .gray {
  background-color: #f7f7f7;
}
.wrapper .gray blockquote {
  border-left-color: #dddddd;
}
.wrapper .gray .divider table {
  background-color: #dddddd;
}
.padded .image {
  font-size: 0;
}
.image-frame {
  padding: 8px;
}
.image-background {
  display: inline-block;
  font-size: 12px;
}
.btn {
  Margin-bottom: 24px;
  padding: 2px;
}
.btn a {
  border: 1px solid #ffffff;
  display: inline-block;
  font-size: 13px;
  font-weight: bold;
  line-height: 15px;
  outline-style: solid;
  outline-width: 2px;
  padding: 10px 30px;
  text-align: center;
  text-decoration: none !important;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 24px;
}
.one-col p,
.one-col ol,
.one-col ul {
  font-size: 16px;
  line-height: 24px;
}
.one-col ol,
.one-col ul {
  Margin-left: 18px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 23px;
}
.two-col .image-frame {
  padding: 6px;
}
.two-col h1 {
  font-size: 26px;
  line-height: 32px;
  Margin-bottom: 16px;
}
.two-col h2 {
  font-size: 20px;
  line-height: 26px;
  Margin-bottom: 18px;
}
.two-col h3 {
  font-size: 16px;
  line-height: 20px;
  Margin-bottom: 14px;
}
.two-col p,
.two-col ol,
.two-col ul {
  font-size: 14px;
  line-height: 23px;
}
.two-col ol,
.two-col ul {
  Margin-left: 16px;
}
.two-col li {
  padding-left: 5px;
}
.two-col .divider .inner {
  padding-bottom: 23px;
}
.two-col .btn {
  Margin-bottom: 23px;
}
.two-col blockquote {
  padding-left: 16px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 21px;
}
.three-col .image-frame {
  padding: 4px;
}
.three-col h1 {
  font-size: 20px;
  line-height: 26px;
  Margin-bottom: 12px;
}
.three-col h2 {
  font-size: 16px;
  line-height: 22px;
  Margin-bottom: 14px;
}
.three-col h3 {
  font-size: 14px;
  line-height: 18px;
  Margin-bottom: 10px;
}
.three-col p,
.three-col ol,
.three-col ul {
  font-size: 12px;
  line-height: 21px;
}
.three-col ol,
.three-col ul {
  Margin-left: 14px;
}
.three-col li {
  padding-left: 6px;
}
.three-col .divider .inner {
  padding-bottom: 21px;
}
.three-col .btn {
  Margin-bottom: 21px;
}
.three-col .btn a {
  font-size: 12px;
  line-height: 14px;
  padding: 8px 19px;
}
.three-col blockquote {
  padding-left: 16px;
}
.one-col-feature .column-top {
  font-size: 36px;
  line-height: 36px;
}
.one-col-feature .column-bottom {
  font-size: 4px;
  line-height: 4px;
}
.one-col-feature .column {
  text-align: center;
  width: 600px;
}
.one-col-feature .image {
  Margin-bottom: 32px;
}
.one-col-feature .column table:nth-last-child(2) td h1:last-child,
.one-col-feature .column table:nth-last-child(2) td h2:last-child,
.one-col-feature .column table:nth-last-child(2) td h3:last-child,
.one-col-feature .column table:nth-last-child(2) td p:last-child,
.one-col-feature .column table:nth-last-child(2) td ol:last-child,
.one-col-feature .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 32px;
}
.one-col-feature h1,
.one-col-feature h2,
.one-col-feature h3 {
  text-align: center;
}
.one-col-feature h1 {
  font-size: 52px;
  Margin-bottom: 22px;
}
.one-col-feature h2 {
  font-size: 42px;
  Margin-bottom: 20px;
}
.one-col-feature h3 {
  font-size: 32px;
  line-height: 42px;
  Margin-bottom: 20px;
}
.one-col-feature p,
.one-col-feature ol,
.one-col-feature ul {
  font-size: 21px;
  line-height: 32px;
  Margin-bottom: 32px;
}
.one-col-feature p a,
.one-col-feature ol a,
.one-col-feature ul a {
  text-decoration: none;
}
.one-col-feature p {
  text-align: center;
}
.one-col-feature ol,
.one-col-feature ul {
  Margin-left: 40px;
  text-align: left;
}
.one-col-feature li {
  padding-left: 3px;
}
.one-col-feature .btn {
  Margin-bottom: 32px;
  text-align: center;
}
.one-col-feature .divider .inner {
  padding-bottom: 32px;
}
.one-col-feature blockquote {
  border-bottom: 2px solid #e9e9e9;
  border-left-color: #ffffff;
  border-left-width: 0;
  border-left-style: none;
  border-top: 2px solid #e9e9e9;
  Margin-bottom: 32px;
  Margin-left: 0;
  padding-bottom: 42px;
  padding-left: 0;
  padding-top: 42px;
  position: relative;
}
.one-col-feature blockquote:before,
.one-col-feature blockquote:after {
  background: -moz-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -webkit-gradient(linear, left top, right top, color-stop(25%, #ffffff), color-stop(25%, #e9e9e9), color-stop(75%, #e9e9e9), color-stop(75%, #ffffff));
  background: -webkit-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -o-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -ms-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: linear-gradient(to right, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  content: '';
  display: block;
  height: 2px;
  left: 0;
  outline: 1px solid #ffffff;
  position: absolute;
  right: 0;
}
.one-col-feature blockquote:before {
  top: -2px;
}
.one-col-feature blockquote:after {
  bottom: -2px;
}
.one-col-feature blockquote p,
.one-col-feature blockquote ol,
.one-col-feature blockquote ul {
  font-size: 42px;
  line-height: 48px;
  Margin-bottom: 48px;
}
.one-col-feature blockquote p:last-child,
.one-col-feature blockquote ol:last-child,
.one-col-feature blockquote ul:last-child {
  Margin-bottom: 0 !important;
}
.footer {
  width: 602px;
}
.footer .padded {
  font-size: 12px;
  line-height: 20px;
}
.social {
  padding-top: 32px;
  padding-bottom: 22px;
}
.social img {
  display: block;
}
.social .divider {
  font-family: sans-serif;
  font-size: 10px;
  line-height: 21px;
  text-align: center;
  padding-left: 14px;
  padding-right: 14px;
}
.social .social-text {
  height: 21px;
  vertical-align: middle !important;
  font-size: 10px;
  font-weight: bold;
  text-decoration: none;
  text-transform: uppercase;
}
.social .social-text a {
  text-decoration: none;
}
.address {
  width: 250px;
}
.address .padded {
  text-align: left;
  padding-left: 0;
  padding-right: 10px;
}
.subscription {
  width: 350px;
}
.subscription .padded {
  text-align: right;
  padding-right: 0;
  padding-left: 10px;
}
.address,
.subscription {
  padding-top: 32px;
  padding-bottom: 64px;
}
.address a,
.subscription a {
  font-weight: bold;
  text-decoration: none;
}
.address table,
.subscription table {
  width: 100%;
}
@media only screen and (max-width: 651px) {
  .gmail {
    display: none !important;
  }
}
@media only screen and (max-width: 620px) {
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ul:last-child {
    Margin-bottom: 24px !important;
  }
  [class=wrapper] .address,
  [class=wrapper] .subscription {
    display: block;
    float: left;
    width: 318px !important;
    text-align: center !important;
  }
  [class=wrapper] .address {
    padding-bottom: 0 !important;
  }
  [class=wrapper] .subscription {
    padding-top: 0 !important;
  }
  [class=wrapper] h1 {
    font-size: 36px !important;
    line-height: 42px !important;
    Margin-bottom: 18px !important;
  }
  [class=wrapper] h2 {
    font-size: 26px !important;
    line-height: 32px !important;
    Margin-bottom: 20px !important;
  }
  [class=wrapper] h3 {
    font-size: 18px !important;
    line-height: 22px !important;
    Margin-bottom: 16px !important;
  }
  [class=wrapper] p,
  [class=wrapper] ol,
  [class=wrapper] ul {
    font-size: 16px !important;
    line-height: 24px !important;
    Margin-bottom: 24px !important;
  }
  [class=wrapper] ol,
  [class=wrapper] ul {
    Margin-left: 18px !important;
  }
  [class=wrapper] li {
    padding-left: 2px !important;
  }
  [class=wrapper] blockquote {
    padding-left: 16px !important;
  }
  [class=wrapper] .two-col .column:nth-child(n + 3) {
    border-top: 1px solid #e9e9e9;
  }
  [class=wrapper] .btn {
    margin-bottom: 24px !important;
  }
  [class=wrapper] .btn a {
    display: block !important;
    font-size: 13px !important;
    font-weight: bold !important;
    line-height: 15px !important;
    padding: 10px 30px !important;
  }
  [class=wrapper] .column-bottom {
    font-size: 8px !important;
    line-height: 8px !important;
  }
  [class=wrapper] .first .column-bottom,
  [class=wrapper] .three-col .second .column-bottom {
    display: none;
  }
  [class=wrapper] .second .column-top,
  [class=wrapper] .third .column-top {
    display: none;
  }
  [class=wrapper] .image-frame {
    padding: 4px !important;
  }
  [class=wrapper] .header .logo {
    padding-left: 10px !important;
    padding-right: 10px !important;
  }
  [class=wrapper] .header .logo div {
    font-size: 26px !important;
    line-height: 32px !important;
  }
  [class=wrapper] .header .logo div img {
    display: inline-block !important;
    max-width: 280px !important;
    height: auto !important;
  }
  [class=wrapper] table.border,
  [class=wrapper] .header,
  [class=wrapper] .webversion,
  [class=wrapper] .footer {
    width: 320px !important;
  }
  [class=wrapper] .preheader .webversion,
  [class=wrapper] .header .logo a {
    text-align: center !important;
  }
  [class=wrapper] .preheader table,
  [class=wrapper] .border td {
    width: 318px !important;
  }
  [class=wrapper] .border td.border {
    width: 1px !important;
  }
  [class=wrapper] .image .border td {
    width: auto !important;
  }
  [class=wrapper] .title {
    display: none;
  }
  [class=wrapper] .footer .padded {
    text-align: center !important;
  }
  [class=wrapper] .footer .subscription .padded {
    padding-top: 20px !important;
  }
  [class=wrapper] .footer .social-link {
    display: block !important;
  }
  [class=wrapper] .footer .social-link table {
    margin: 0 auto 10px !important;
  }
  [class=wrapper] .footer .divider {
    display: none !important;
  }
  [class=wrapper] .one-col-feature .btn {
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature .image {
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature .divider .inner {
    padding-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature h1 {
    font-size: 42px !important;
    line-height: 48px !important;
    margin-bottom: 20px !important;
  }
  [class=wrapper] .one-col-feature h2 {
    font-size: 32px !important;
    line-height: 36px !important;
    margin-bottom: 18px !important;
  }
  [class=wrapper] .one-col-feature h3 {
    font-size: 26px !important;
    line-height: 32px !important;
    margin-bottom: 20px !important;
  }
  [class=wrapper] .one-col-feature p,
  [class=wrapper] .one-col-feature ol,
  [class=wrapper] .one-col-feature ul {
    font-size: 20px !important;
    line-height: 28px !important;
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature blockquote {
    font-size: 18px !important;
    line-height: 26px !important;
    margin-bottom: 28px !important;
    padding-bottom: 26px !important;
    padding-left: 0 !important;
    padding-top: 26px !important;
  }
  [class=wrapper] .one-col-feature blockquote p,
  [class=wrapper] .one-col-feature blockquote ol,
  [class=wrapper] .one-col-feature blockquote ul {
    font-size: 26px !important;
    line-height: 32px !important;
  }
  [class=wrapper] .one-col-feature blockquote p:last-child,
  [class=wrapper] .one-col-feature blockquote ol:last-child,
  [class=wrapper] .one-col-feature blockquote ul:last-child {
    margin-bottom: 0 !important;
  }
  [class=wrapper] .one-col-feature .column table:last-of-type h1:last-child,
  [class=wrapper] .one-col-feature .column table:last-of-type h2:last-child,
  [class=wrapper] .one-col-feature .column table:last-of-type h3:last-child {
    margin-bottom: 28px !important;
  }
}
@media only screen and (max-width: 320px) {
  [class=wrapper] td.border {
    display: none;
  }
  [class=wrapper] table.border,
  [class=wrapper] .header,
  [class=wrapper] .webversion,
  [class=wrapper] .footer {
    width: 318px !important;
  }
}</style>
    <!--[if gte mso 9]>
    <style>
      .column-top {
        mso-line-height-rule: exactly !important;
      }
    </style>
    <![endif]-->
  <meta name=\"robots\" content=\"noindex,nofollow\" />
<meta property=\"og:title\" content=\"My First Campaign\" />
</head>
  <body style=\"margin: 0;mso-line-height-rule: exactly;padding: 0;min-width: 100%;background-color: #fbfbfb\";><style type=\"text/css\">
body,.wrapper,.emb-editor-canvas{background-color:#fbfbfb}.border{background-color:#e9e9e9}h1{color:#565656}.wrapper h1{}.wrapper h1{font-family:sans-serif}@media only screen and (min-width: 0){.wrapper h1{font-family:Avenir,sans-serif !important}}h1{}.one-col h1{line-height:42px}.two-col h1{line-height:32px}.three-col h1{line-height:26px}.wrapper .one-col-feature h1{line-height:58px}@media only screen and (max-width: 620px){h1{line-height:42px !important}}h2{color:#555}.wrapper h2{}.wrapper h2{font-family:Georgia,serif}h2{}.one-col h2{line-height:32px}.two-col h2{line-height:26px}.three-col h2{line-height:22px}.wrapper .one-col-feature h2{line-height:52px}@media only screen and (max-width: 620px){h2{line-height:32px !important}}h3{color:#555}.wrapper h3{}.wrapper h3{font-family:Georgia,serif}h3{}.one-col h3{line-height:26px}.two-col h3{line-height:22px}.three-col 
h3{line-height:20px}.wrapper .one-col-feature h3{line-height:42px}@media only screen and (max-width: 620px){h3{line-height:26px !important}}p,ol,ul{color:#565656}.wrapper p,.wrapper ol,.wrapper ul{}.wrapper p,.wrapper ol,.wrapper ul{font-family:Georgia,serif}p,ol,ul{}.one-col p,.one-col ol,.one-col ul{line-height:25px;Margin-bottom:25px}.two-col p,.two-col ol,.two-col ul{line-height:23px;Margin-bottom:23px}.three-col p,.three-col ol,.three-col ul{line-height:21px;Margin-bottom:21px}.wrapper .one-col-feature p,.wrapper .one-col-feature ol,.wrapper .one-col-feature ul{line-height:32px}.one-col-feature blockquote p,.one-col-feature blockquote ol,.one-col-feature blockquote ul{line-height:50px}@media only screen and (max-width: 620px){p,ol,ul{line-height:25px !important;Margin-bottom:25px !important}}.image{color:#565656}.image{font-family:Georgia,serif}.wrapper a{color:#41637e}.wrapper 
a:hover{color:#30495c !important}.wrapper .logo div{color:#41637e}.wrapper .logo div{font-family:sans-serif}@media only screen and (min-width: 0){.wrapper .logo div{font-family:Avenir,sans-serif !important}}.wrapper .logo div a{color:#41637e}.wrapper .logo div a:hover{color:#41637e !important}.wrapper .one-col-feature p a,.wrapper .one-col-feature ol a,.wrapper .one-col-feature ul a{border-bottom:1px solid #41637e}.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature ol a:hover,.wrapper .one-col-feature ul a:hover{color:#30495c !important;border-bottom:1px solid #30495c !important}.btn a{}.wrapper .btn a{}.wrapper .btn a{font-family:Georgia,serif}.wrapper .btn a{background-color:#41637e;color:#fff !important;outline-color:#41637e;text-shadow:0 1px 0 #3b5971}.wrapper .btn a:hover{background-color:#3b5971 !important;color:#fff !important;outline-color:#3b5971 !important}.preheader 
.title,.preheader .webversion,.footer .padded{color:#999}.preheader .title,.preheader .webversion,.footer .padded{font-family:Georgia,serif}.preheader .title a,.preheader .webversion a,.footer .padded a{color:#999}.preheader .title a:hover,.preheader .webversion a:hover,.footer .padded a:hover{color:#737373 !important}.footer .social .divider{color:#e9e9e9}.footer .social .social-text,.footer .social a{color:#999}.wrapper .footer .social .social-text,.wrapper .footer .social a{}.wrapper .footer .social .social-text,.wrapper .footer .social a{font-family:Georgia,serif}.footer .social .social-text,.footer .social a{}.footer .social .social-text,.footer .social a{letter-spacing:0.05em}.footer .social .social-text:hover,.footer .social a:hover{color:#737373 !important}.image .border{background-color:#c8c8c8}.image-frame{background-color:#dadada}.image-background{background-color:#f7f7f7}
</style>
    <center class=\"wrapper\" style=\"display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #fbfbfb;\">
    	<table class=\"gmail\" style=\"border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px><tbody><tr><td style=padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;\">&nbsp;</td></tr></tbody></table>
      <table class=\"preheader centered\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;\">
        <tbody><tr>
          <td style=\"padding: 0;vertical-align: top;\">
            <table style=\"border-collapse: collapse;border-spacing: 0;width: 602px;\">
              <tbody><tr>
                
                <td class=\"webversion\" style=\"padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: right;width: 300px;color: #999;font-family: Georgia,serif\">
                <webversion style=\"font-weight:bold;text-decoration:none;\"></webversion>
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
      <table class=\"header centered\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px;\">
        <tbody><tr><td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px;\">&nbsp;</td></tr>
        <tr><td class=\"logo\" style=\"padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least\"><div class=\"logo-center\" style=\"font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center\" align=\"center\" id=\"emb-email-header\"><a style=\"text-decoration: none;transition: all .2s;color: #41637e\" href=\"http://www.firstpropinvest.com\"><img style=\"border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 240px;\" src='".get_template_directory_uri()."/images/FPIlogojpeg.jpg' alt=\"FPI\" width=\"160\" height=\"160\" /></a></div></td></tr>
      </tbody></table>
      
          <table class=\"border\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto\" width=\"602\">
            <tbody><tr><td style=\"padding: 0;vertical-align: top\">&#8203;</td></tr>
          </tbody></table>
        
          <table class=centered style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto\">
            <tbody><tr>
              <td class=border style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
              <td style=\"padding: 0;vertical-align: top\">
                <table class=\"one-col\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px;table-layout: fixed\">
                  <tbody><tr>
                    <td class=\"column\" style=\"padding: 0;vertical-align: top;text-align: left\">
                      <div><div class=\"column-top\" style=\"font-size: 32px;line-height: 32px\">&nbsp;</div></div>
                        <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                          <tbody><tr>
                            <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word\">
                              
            <h1 style=\"Margin-top: 0;color: #565656;font-weight: 700;font-size: 36px;Margin-bottom: 18px;font-family: sans-serif;line-height: 42px\">You have received a new lead</h1><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px\"><br />
Property Name: ".$_POST['property_title']."<br />
Property ID: ".$_POST['property_id']."<br />
Name: ".$from_name."<br />
Email: ".$from_email."<br />
Number:&nbsp; ".$from_phone."<br />
Country: ".$country."<br />
Preferred Contact Method: ".$contact_method."
</p><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px\">".$property_permalink."</p><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px\">Please consider the time difference when contacting investors based overseas.</p><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px\">Good luck with the lead!</p><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px\"><br />
FirstPropInvest.com team.</p>
          
                            </td>
                          </tr>
                        </tbody></table>
                      
                      <div class=\"column-bottom\" style=\"font-size: 8px;line-height: 8px\">&nbsp;</div>
                    </td>
                  </tr>
                </tbody></table>
              </td>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
            </tr>
          </tbody></table>
        
          <table class=\"border\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto\" width=\"602\">
            <tbody><tr class=\"border\" style=\"font-size: 1px;line-height: 1px;background-color: #e9e9e9;height: 1px\">
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
              <td style=\"padding: 0;vertical-align: top;line-height: 1px\">&#8203;</td>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
            </tr>
          </tbody></table>
        
          <table class=\"centered\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto\">
            <tbody><tr>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
              <td style=\"padding: 0;vertical-align: top\">
                <table class=\"one-col gray\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 600px;background-color: #f7f7f7;font-size: 14px;table-layout: fixed\">
                  <tbody><tr>
                    <td class=\"column\" style=\"padding: 0;vertical-align: top;text-align: left\">
                      <div><div class=\"column-top style=font-size: 32px;line-height: 32px\">&nbsp;</div></div>
					  <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                          <tbody><tr>
                            <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word\">
                              
            <p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 24px\">".$property_title."</p>
          
                            </td>
                          </tr>
                        </tbody></table>
                        <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                          <tbody><tr>
                            <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word\">
                              
              <table class=\"image\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 0;Margin-bottom: 24px;mso-line-height-rule: at-least;color: #565656;font-family: Georgia,serif align=center;margin-left:auto;margin-right:auto;\">
                <tbody><tr>
                  <td class=\"image-frame\" style=\"padding: 8px;vertical-align: top;background-color: #dadada\">
                    <span class=\"image-background\" style=\"display: inline-block;font-size: 12px;background-color: #f7f7f7\"><a href=\"".$property_permalink."\"><img style=\"border: 0;-ms-interpolation-mode: bicubic;display: block;max-width: 900px\" src=".$img_url." alt= width=\"520\" height=\"268\" /></a></span>
					 </td>
                </tr>
                <tr><td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #c8c8c8;width: 1px\">&nbsp;</td></tr>
              </tbody></table>
			  <p style=\"color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;margin-bottom: 24px;margin-top: 0;\">Price : ".$_POST['property_price']."</p>
					<p style=\"color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;margin-bottom: 24px;margin-top: 0;\">Property ID : property_id_".$_POST['property_id']."</p>
              <!--[if mso]><br clear=all style=mso-special-character:line-break;font-size:1px;>
<![endif]-->
            
                            </td>
                          </tr>
                        </tbody></table>
                      
                        
                      
                      <div class=\"column-bottom\" style=\"font-size: 8px;line-height: 8px\">&nbsp;</div>
                    </td>
                  </tr>
                </tbody></table>
              </td>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
            </tr>
          </tbody></table>
        
          <table class=\"border\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto\" width=\"602\">
            <tbody><tr><td style=\"padding: 0;vertical-align: top\">&#8203;</td></tr>
          </tbody></table>
        
      <div class=\"spacer\" style=\"font-size: 1px;line-height: 32px;width: 100%\">&nbsp;</div>
      <table class=\"footer\" centered style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px\">
        <tbody><tr>
          <td class=\"social\" style=\"padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px\" align=\"center\">
            <table style=\"border-collapse: collapse;border-spacing: 0\">
              <tbody><tr>
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
                
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
                
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
        <tr><td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&nbsp;</td></tr>
        <tr>
          <td style=\"padding: 0;vertical-align: top\">
            <table style=\"border-collapse: collapse;border-spacing: 0\">
              <tbody><tr>
                <td class=\"address\" style=\"padding: 0;vertical-align: top;width: 100%;text-align:center;padding-top: 32px;padding-bottom: 64px\">
                  <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                    <tbody><tr>
                      <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 0;padding-right: 10px;word-break: break-word;word-wrap: break-word;text-align: center;font-size: 12px;line-height: 20px;color: #999;font-family: Georgia,serif\">
                        <div><a href=\"www.firstpropinvest.com\">FirstPropInvest.com</a></div>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
                <td class=\"subscription\" style=\"padding: 0;vertical-align: top;width: 350px;padding-top: 32px;padding-bottom: 64px\">
                  
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
    </center>
	  
</body></html>
  ";
            $header = 'Content-type: text/html; charset=utf-8' . "\r\n";
            $header = apply_filters("inspiry_agent_mail_header", $header);
            $header .= 'From: ' . $from_name . " <" . $from_email . "> \r\n";

            /* Send copy of message to admin if configured */
            $theme_send_message_copy = get_option('theme_send_message_copy');
            if( $theme_send_message_copy == 'true' ){
                $cc_email = get_option( 'theme_message_copy_email' );
                $cc_email = explode( ',', $cc_email );
                if( !empty( $cc_email ) ){
                    foreach( $cc_email as $ind_email ){
                        $ind_email = sanitize_email( $ind_email );
                        $ind_email = is_email( $ind_email );
                        if ( $ind_email ) {
                            $header .= 'Cc: ' . $ind_email . " \r\n";
                        }
                    }
                }

            }

            if ( wp_mail( $to_email, $email_subject, $email_body, $header ) ) {
               echo "
				<div class=\"form-left ful-width-btn\">
					<span class=\"property-address1\">Thank you, a representative from ".$_POST['author_name']." will be in touch within 24 hrs.</span>
					<p class=\"sub-form-heading\">In the meantime before you go</p>
					<form id=\"mail_chimp_form\" action=\"\" method=\"\">
						<label>
							
							<span class=\"label-input\"><input type=\"checkbox\" name=\"mail_chimp\" value=\"true\" checked=\"checked\" /> </span><br />
							<span class=\"label-text\">Sign up to our mailing list Receive the latest properties direct to your inbox</span>
						</label>
					</form>
					<p class=\"sub-form-heading\">We can also help with the following service tick as appropriate</p>
					<form action=\"".site_url()."/wp-admin/admin-ajax.php\" method=\"post\" id=\"advice-form\">
					<input type=\"hidden\" name=\"return_name\" value=".$from_name." id=\"ret-name\" />
					<input type=\"hidden\" name=\"return_email\" value=".$from_email." id=\"ret-email\"  />
					<input type=\"hidden\" name=\"return_phone\" value=".$from_phone." id=\"ret-phone\"  />
					<input type=\"hidden\" name=\"return_country\" value=".$country." id=\"ret-country\" />
					<input type=\"hidden\" name=\"return_con_method\" value".$contact_method." id=\"return_con_method\" />
					<input type=\"hidden\" name=\"return_property_id\" value=".$_POST['property_id']." id=\"return_property_id\" />
					<input type=\"hidden\" name=\"return_property_title\" value=".$_POST['property_title']." id=\"return_property_title\" />
					<input type=\"hidden\" name=\"return_property_permalink\" value=".$_POST['property_permalink']." id=\"return_property_permalink\" />
					<input type=\"hidden\" name=\"return_property_price\" value=".$_POST['property_price']." id=\"return_property_price\" />
					<input type=\"hidden\" name=\"return_img_url\" value=".$_POST['img_url']." id=\"return_img_url\" />
					
					<input type=\"hidden\" name=\"to_email\" value=\"berian.reed@gmail.com\" />
					<label>
							<span class=\"label-input\"><input type=\"checkbox\" name=\"check-1\" id=\"check-1\" value=\"Mortgage advice\" /> </span>&nbsp;&nbsp;<span class=\"label-text\">Mortgage advice</span>
					</label>
					<label>
							<span class=\"label-input\"><input type=\"checkbox\" name=\"check-2\" id=\"check-2\"  value=\"Financial advice\" /> </span>&nbsp;&nbsp;<span class=\"label-text\">Financial advice</span>
					</label>
					<label>
							<span class=\"label-input\"><input type=\"checkbox\" name=\"check-3\" id=\"check-3\"  value=\"Legal advice\" /> </span>&nbsp;&nbsp;<span class=\"label-text\">Legal advice</span>
					</label>
					<div class=\"gap-seperator\"></div>

					<input type=\"button\" value=\"Sign up\"  name=\"submit\" class=\"real-btn\" id=\"sub-btn\" >
					</form>
					
					
				</div>
				
				<div class=\"clearfix\"> </div>
				
				";} else {
               _e("Server Error: WordPress mail method failed!", 'framework');
			 
			
				
            }

        else:
            _e("Invalid Request !", 'framework');
        endif;
        die;
    }
}


add_action( 'wp_ajax_nopriv_advice_form', 'advice_form' );
add_action( 'wp_ajax_advice_form', 'advice_form' );
if( !function_exists( 'advice_form' ) ){
    function advice_form(){
		$name = $_POST['fname'];
		$email = $_POST['email'];
		$phone = $_POST['phone'];
		$check_1 = $_POST['check_1'];
		$check_2 = $_POST['check_2'];
		$check_3 = $_POST['check_3'];
		//$to_email = 'varunsrivastava89@gmail.com';
		$to_email = 'berian.reed@gmail.com';
		
		$email_body .= "
			<!DOCTYPE html PUBLIC -//W3C//DTD XHTML 1.0 Transitional//ENhttp://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd><html xmlns=http://www.w3.org/1999/xhtml><head>
    <title></title>
    <meta http-equiv=Content-Type content=text/html; charset=utf-8 />
			<style type=\"text/css\">
body {
  margin: 0;
  mso-line-height-rule: exactly;
  padding: 0;
  min-width: 100%;
}
table {
  border-collapse: collapse;
  border-spacing: 0;
}
td {
  padding: 0;
  vertical-align: top;
}
.spacer,
.border {
  font-size: 1px;
  line-height: 1px;
}
.spacer {
  width: 100%;
}
img {
  border: 0;
  -ms-interpolation-mode: bicubic;
}
.image {
  font-size: 12px;
  Margin-bottom: 24px;
  mso-line-height-rule: at-least;
}
.image img {
  display: block;
}
.logo {
  mso-line-height-rule: at-least;
}
.logo img {
  display: block;
}
strong {
  font-weight: bold;
}
h1,
h2,
h3,
p,
ol,
ul,
li {
  Margin-top: 0;
}
ol,
ul,
li {
  padding-left: 0;
}
blockquote {
  Margin-top: 0;
  Margin-right: 0;
  Margin-bottom: 0;
  padding-right: 0;
}
.column-top {
  font-size: 32px;
  line-height: 32px;
}
.column-bottom {
  font-size: 8px;
  line-height: 8px;
}
.column {
  text-align: left;
}
.contents {
  table-layout: fixed;
  width: 100%;
}
.padded {
  padding-left: 32px;
  padding-right: 32px;
  word-break: break-word;
  word-wrap: break-word;
}
.wrapper {
  display: table;
  table-layout: fixed;
  width: 100%;
  min-width: 620px;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
}
table.wrapper {
  table-layout: fixed;
}
.one-col,
.two-col,
.three-col {
  Margin-left: auto;
  Margin-right: auto;
  width: 600px;
}
.centered {
  Margin-left: auto;
  Margin-right: auto;
}
.two-col .image {
  Margin-bottom: 23px;
}
.two-col .column-bottom {
  font-size: 9px;
  line-height: 9px;
}
.two-col .column {
  width: 300px;
}
.three-col .image {
  Margin-bottom: 21px;
}
.three-col .column-bottom {
  font-size: 11px;
  line-height: 11px;
}
.three-col .column {
  width: 200px;
}
.three-col .first .padded {
  padding-left: 32px;
  padding-right: 16px;
}
.three-col .second .padded {
  padding-left: 24px;
  padding-right: 24px;
}
.three-col .third .padded {
  padding-left: 16px;
  padding-right: 32px;
}
@media only screen and (min-width: 0) {
  .wrapper {
    text-rendering: optimizeLegibility;
  }
}
@media only screen and (max-width: 620px) {
  [class=wrapper] {
    min-width: 318px !important;
    width: 100% !important;
  }
  [class=wrapper] .one-col,
  [class=wrapper] .two-col,
  [class=wrapper] .three-col {
    width: 318px !important;
  }
  [class=wrapper] .column,
  [class=wrapper] .gutter {
    display: block;
    float: left;
    width: 318px !important;
  }
  [class=wrapper] .padded {
    padding-left: 32px !important;
    padding-right: 32px !important;
  }
  [class=wrapper] .block {
    display: block !important;
  }
  [class=wrapper] .hide {
    display: none !important;
  }
  [class=wrapper] .image {
    margin-bottom: 24px !important;
  }
  [class=wrapper] .image img {
    height: auto !important;
    width: 100% !important;
  }
}
.wrapper h1 {
  font-weight: 700;
}
.wrapper h2 {
  font-style: italic;
  font-weight: normal;
}
.wrapper h3 {
  font-weight: normal;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
  font-style: italic;
}
.one-col-feature h1 {
  font-weight: normal;
}
.one-col-feature h2 {
  font-style: normal;
  font-weight: bold;
}
.one-col-feature h3 {
  font-style: italic;
}
td.border {
  width: 1px;
}
tr.border {
  background-color: #e9e9e9;
  height: 1px;
}
tr.border td {
  line-height: 1px;
}
.one-col,
.two-col,
.three-col,
.one-col-feature {
  background-color: #ffffff;
  font-size: 14px;
  table-layout: fixed;
}
.one-col,
.two-col,
.three-col,
.one-col-feature,
.preheader,
.header,
.footer {
  Margin-left: auto;
  Margin-right: auto;
}
.preheader table {
  width: 602px;
}
.preheader .title,
.preheader .webversion {
  padding-top: 10px;
  padding-bottom: 12px;
  font-size: 12px;
  line-height: 21px;
}
.preheader .title {
  text-align: left;
}
.preheader .webversion {
  text-align: right;
  width: 300px;
}
.header {
  width: 602px;
}
.header .logo {
  padding: 32px 0;
}
.header .logo div {
  font-size: 26px;
  font-weight: 700;
  letter-spacing: -0.02em;
  line-height: 32px;
}
.header .logo div a {
  text-decoration: none;
}
.header .logo div.logo-center {
  text-align: center;
}
.header .logo div.logo-center img {
  Margin-left: auto;
  Margin-right: auto;
}
.gmail {
  width: 650px;
  min-width: 650px;
}
.gmail td {
  font-size: 1px;
  line-height: 1px;
}
.wrapper a {
  text-decoration: underline;
  transition: all .2s;
}
.wrapper h1 {
  font-size: 36px;
  Margin-bottom: 18px;
}
.wrapper h2 {
  font-size: 26px;
  line-height: 32px;
  Margin-bottom: 20px;
}
.wrapper h3 {
  font-size: 18px;
  line-height: 22px;
  Margin-bottom: 16px;
}
.wrapper h1 a,
.wrapper h2 a,
.wrapper h3 a {
  text-decoration: none;
}
.one-col blockquote,
.two-col blockquote,
.three-col blockquote {
  font-size: 14px;
  border-left: 2px solid #e9e9e9;
  Margin-left: 0;
  padding-left: 16px;
}
table.divider {
  width: 100%;
}
.divider .inner {
  padding-bottom: 24px;
}
.divider table {
  background-color: #e9e9e9;
  font-size: 2px;
  line-height: 2px;
  width: 60px;
}
.wrapper .gray {
  background-color: #f7f7f7;
}
.wrapper .gray blockquote {
  border-left-color: #dddddd;
}
.wrapper .gray .divider table {
  background-color: #dddddd;
}
.padded .image {
  font-size: 0;
}
.image-frame {
  padding: 8px;
}
.image-background {
  display: inline-block;
  font-size: 12px;
}
.btn {
  Margin-bottom: 24px;
  padding: 2px;
}
.btn a {
  border: 1px solid #ffffff;
  display: inline-block;
  font-size: 13px;
  font-weight: bold;
  line-height: 15px;
  outline-style: solid;
  outline-width: 2px;
  padding: 10px 30px;
  text-align: center;
  text-decoration: none !important;
}
.one-col .column table:nth-last-child(2) td h1:last-child,
.one-col .column table:nth-last-child(2) td h2:last-child,
.one-col .column table:nth-last-child(2) td h3:last-child,
.one-col .column table:nth-last-child(2) td p:last-child,
.one-col .column table:nth-last-child(2) td ol:last-child,
.one-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 24px;
}
.one-col p,
.one-col ol,
.one-col ul {
  font-size: 16px;
  line-height: 24px;
}
.one-col ol,
.one-col ul {
  Margin-left: 18px;
}
.two-col .column table:nth-last-child(2) td h1:last-child,
.two-col .column table:nth-last-child(2) td h2:last-child,
.two-col .column table:nth-last-child(2) td h3:last-child,
.two-col .column table:nth-last-child(2) td p:last-child,
.two-col .column table:nth-last-child(2) td ol:last-child,
.two-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 23px;
}
.two-col .image-frame {
  padding: 6px;
}
.two-col h1 {
  font-size: 26px;
  line-height: 32px;
  Margin-bottom: 16px;
}
.two-col h2 {
  font-size: 20px;
  line-height: 26px;
  Margin-bottom: 18px;
}
.two-col h3 {
  font-size: 16px;
  line-height: 20px;
  Margin-bottom: 14px;
}
.two-col p,
.two-col ol,
.two-col ul {
  font-size: 14px;
  line-height: 23px;
}
.two-col ol,
.two-col ul {
  Margin-left: 16px;
}
.two-col li {
  padding-left: 5px;
}
.two-col .divider .inner {
  padding-bottom: 23px;
}
.two-col .btn {
  Margin-bottom: 23px;
}
.two-col blockquote {
  padding-left: 16px;
}
.three-col .column table:nth-last-child(2) td h1:last-child,
.three-col .column table:nth-last-child(2) td h2:last-child,
.three-col .column table:nth-last-child(2) td h3:last-child,
.three-col .column table:nth-last-child(2) td p:last-child,
.three-col .column table:nth-last-child(2) td ol:last-child,
.three-col .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 21px;
}
.three-col .image-frame {
  padding: 4px;
}
.three-col h1 {
  font-size: 20px;
  line-height: 26px;
  Margin-bottom: 12px;
}
.three-col h2 {
  font-size: 16px;
  line-height: 22px;
  Margin-bottom: 14px;
}
.three-col h3 {
  font-size: 14px;
  line-height: 18px;
  Margin-bottom: 10px;
}
.three-col p,
.three-col ol,
.three-col ul {
  font-size: 12px;
  line-height: 21px;
}
.three-col ol,
.three-col ul {
  Margin-left: 14px;
}
.three-col li {
  padding-left: 6px;
}
.three-col .divider .inner {
  padding-bottom: 21px;
}
.three-col .btn {
  Margin-bottom: 21px;
}
.three-col .btn a {
  font-size: 12px;
  line-height: 14px;
  padding: 8px 19px;
}
.three-col blockquote {
  padding-left: 16px;
}
.one-col-feature .column-top {
  font-size: 36px;
  line-height: 36px;
}
.one-col-feature .column-bottom {
  font-size: 4px;
  line-height: 4px;
}
.one-col-feature .column {
  text-align: center;
  width: 600px;
}
.one-col-feature .image {
  Margin-bottom: 32px;
}
.one-col-feature .column table:nth-last-child(2) td h1:last-child,
.one-col-feature .column table:nth-last-child(2) td h2:last-child,
.one-col-feature .column table:nth-last-child(2) td h3:last-child,
.one-col-feature .column table:nth-last-child(2) td p:last-child,
.one-col-feature .column table:nth-last-child(2) td ol:last-child,
.one-col-feature .column table:nth-last-child(2) td ul:last-child {
  Margin-bottom: 32px;
}
.one-col-feature h1,
.one-col-feature h2,
.one-col-feature h3 {
  text-align: center;
}
.one-col-feature h1 {
  font-size: 52px;
  Margin-bottom: 22px;
}
.one-col-feature h2 {
  font-size: 42px;
  Margin-bottom: 20px;
}
.one-col-feature h3 {
  font-size: 32px;
  line-height: 42px;
  Margin-bottom: 20px;
}
.one-col-feature p,
.one-col-feature ol,
.one-col-feature ul {
  font-size: 21px;
  line-height: 32px;
  Margin-bottom: 32px;
}
.one-col-feature p a,
.one-col-feature ol a,
.one-col-feature ul a {
  text-decoration: none;
}
.one-col-feature p {
  text-align: center;
}
.one-col-feature ol,
.one-col-feature ul {
  Margin-left: 40px;
  text-align: left;
}
.one-col-feature li {
  padding-left: 3px;
}
.one-col-feature .btn {
  Margin-bottom: 32px;
  text-align: center;
}
.one-col-feature .divider .inner {
  padding-bottom: 32px;
}
.one-col-feature blockquote {
  border-bottom: 2px solid #e9e9e9;
  border-left-color: #ffffff;
  border-left-width: 0;
  border-left-style: none;
  border-top: 2px solid #e9e9e9;
  Margin-bottom: 32px;
  Margin-left: 0;
  padding-bottom: 42px;
  padding-left: 0;
  padding-top: 42px;
  position: relative;
}
.one-col-feature blockquote:before,
.one-col-feature blockquote:after {
  background: -moz-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -webkit-gradient(linear, left top, right top, color-stop(25%, #ffffff), color-stop(25%, #e9e9e9), color-stop(75%, #e9e9e9), color-stop(75%, #ffffff));
  background: -webkit-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -o-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: -ms-linear-gradient(left, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  background: linear-gradient(to right, #ffffff 25%, #e9e9e9 25%, #e9e9e9 75%, #ffffff 75%);
  content: '';
  display: block;
  height: 2px;
  left: 0;
  outline: 1px solid #ffffff;
  position: absolute;
  right: 0;
}
.one-col-feature blockquote:before {
  top: -2px;
}
.one-col-feature blockquote:after {
  bottom: -2px;
}
.one-col-feature blockquote p,
.one-col-feature blockquote ol,
.one-col-feature blockquote ul {
  font-size: 42px;
  line-height: 48px;
  Margin-bottom: 48px;
}
.one-col-feature blockquote p:last-child,
.one-col-feature blockquote ol:last-child,
.one-col-feature blockquote ul:last-child {
  Margin-bottom: 0 !important;
}
.footer {
  width: 602px;
}
.footer .padded {
  font-size: 12px;
  line-height: 20px;
}
.social {
  padding-top: 32px;
  padding-bottom: 22px;
}
.social img {
  display: block;
}
.social .divider {
  font-family: sans-serif;
  font-size: 10px;
  line-height: 21px;
  text-align: center;
  padding-left: 14px;
  padding-right: 14px;
}
.social .social-text {
  height: 21px;
  vertical-align: middle !important;
  font-size: 10px;
  font-weight: bold;
  text-decoration: none;
  text-transform: uppercase;
}
.social .social-text a {
  text-decoration: none;
}
.address {
  width: 250px;
}
.address .padded {
  text-align: left;
  padding-left: 0;
  padding-right: 10px;
}
.subscription {
  width: 350px;
}
.subscription .padded {
  text-align: right;
  padding-right: 0;
  padding-left: 10px;
}
.address,
.subscription {
  padding-top: 32px;
  padding-bottom: 64px;
}
.address a,
.subscription a {
  font-weight: bold;
  text-decoration: none;
}
.address table,
.subscription table {
  width: 100%;
}
@media only screen and (max-width: 651px) {
  .gmail {
    display: none !important;
  }
}
@media only screen and (max-width: 620px) {
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h1:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h2:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td h3:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td p:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ol:last-child,
  [class=wrapper] .one-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .two-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .three-col .column:last-child table:nth-last-child(2) td ul:last-child,
  [class=wrapper] .one-col-feature .column:last-child table:nth-last-child(2) td ul:last-child {
    Margin-bottom: 24px !important;
  }
  [class=wrapper] .address,
  [class=wrapper] .subscription {
    display: block;
    float: left;
    width: 318px !important;
    text-align: center !important;
  }
  [class=wrapper] .address {
    padding-bottom: 0 !important;
  }
  [class=wrapper] .subscription {
    padding-top: 0 !important;
  }
  [class=wrapper] h1 {
    font-size: 36px !important;
    line-height: 42px !important;
    Margin-bottom: 18px !important;
  }
  [class=wrapper] h2 {
    font-size: 26px !important;
    line-height: 32px !important;
    Margin-bottom: 20px !important;
  }
  [class=wrapper] h3 {
    font-size: 18px !important;
    line-height: 22px !important;
    Margin-bottom: 16px !important;
  }
  [class=wrapper] p,
  [class=wrapper] ol,
  [class=wrapper] ul {
    font-size: 16px !important;
    line-height: 24px !important;
    Margin-bottom: 24px !important;
  }
  [class=wrapper] ol,
  [class=wrapper] ul {
    Margin-left: 18px !important;
  }
  [class=wrapper] li {
    padding-left: 2px !important;
  }
  [class=wrapper] blockquote {
    padding-left: 16px !important;
  }
  [class=wrapper] .two-col .column:nth-child(n + 3) {
    border-top: 1px solid #e9e9e9;
  }
  [class=wrapper] .btn {
    margin-bottom: 24px !important;
  }
  [class=wrapper] .btn a {
    display: block !important;
    font-size: 13px !important;
    font-weight: bold !important;
    line-height: 15px !important;
    padding: 10px 30px !important;
  }
  [class=wrapper] .column-bottom {
    font-size: 8px !important;
    line-height: 8px !important;
  }
  [class=wrapper] .first .column-bottom,
  [class=wrapper] .three-col .second .column-bottom {
    display: none;
  }
  [class=wrapper] .second .column-top,
  [class=wrapper] .third .column-top {
    display: none;
  }
  [class=wrapper] .image-frame {
    padding: 4px !important;
  }
  [class=wrapper] .header .logo {
    padding-left: 10px !important;
    padding-right: 10px !important;
  }
  [class=wrapper] .header .logo div {
    font-size: 26px !important;
    line-height: 32px !important;
  }
  [class=wrapper] .header .logo div img {
    display: inline-block !important;
    max-width: 280px !important;
    height: auto !important;
  }
  [class=wrapper] table.border,
  [class=wrapper] .header,
  [class=wrapper] .webversion,
  [class=wrapper] .footer {
    width: 320px !important;
  }
  [class=wrapper] .preheader .webversion,
  [class=wrapper] .header .logo a {
    text-align: center !important;
  }
  [class=wrapper] .preheader table,
  [class=wrapper] .border td {
    width: 318px !important;
  }
  [class=wrapper] .border td.border {
    width: 1px !important;
  }
  [class=wrapper] .image .border td {
    width: auto !important;
  }
  [class=wrapper] .title {
    display: none;
  }
  [class=wrapper] .footer .padded {
    text-align: center !important;
  }
  [class=wrapper] .footer .subscription .padded {
    padding-top: 20px !important;
  }
  [class=wrapper] .footer .social-link {
    display: block !important;
  }
  [class=wrapper] .footer .social-link table {
    margin: 0 auto 10px !important;
  }
  [class=wrapper] .footer .divider {
    display: none !important;
  }
  [class=wrapper] .one-col-feature .btn {
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature .image {
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature .divider .inner {
    padding-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature h1 {
    font-size: 42px !important;
    line-height: 48px !important;
    margin-bottom: 20px !important;
  }
  [class=wrapper] .one-col-feature h2 {
    font-size: 32px !important;
    line-height: 36px !important;
    margin-bottom: 18px !important;
  }
  [class=wrapper] .one-col-feature h3 {
    font-size: 26px !important;
    line-height: 32px !important;
    margin-bottom: 20px !important;
  }
  [class=wrapper] .one-col-feature p,
  [class=wrapper] .one-col-feature ol,
  [class=wrapper] .one-col-feature ul {
    font-size: 20px !important;
    line-height: 28px !important;
    margin-bottom: 28px !important;
  }
  [class=wrapper] .one-col-feature blockquote {
    font-size: 18px !important;
    line-height: 26px !important;
    margin-bottom: 28px !important;
    padding-bottom: 26px !important;
    padding-left: 0 !important;
    padding-top: 26px !important;
  }
  [class=wrapper] .one-col-feature blockquote p,
  [class=wrapper] .one-col-feature blockquote ol,
  [class=wrapper] .one-col-feature blockquote ul {
    font-size: 26px !important;
    line-height: 32px !important;
  }
  [class=wrapper] .one-col-feature blockquote p:last-child,
  [class=wrapper] .one-col-feature blockquote ol:last-child,
  [class=wrapper] .one-col-feature blockquote ul:last-child {
    margin-bottom: 0 !important;
  }
  [class=wrapper] .one-col-feature .column table:last-of-type h1:last-child,
  [class=wrapper] .one-col-feature .column table:last-of-type h2:last-child,
  [class=wrapper] .one-col-feature .column table:last-of-type h3:last-child {
    margin-bottom: 28px !important;
  }
}
@media only screen and (max-width: 320px) {
  [class=wrapper] td.border {
    display: none;
  }
  [class=wrapper] table.border,
  [class=wrapper] .header,
  [class=wrapper] .webversion,
  [class=wrapper] .footer {
    width: 318px !important;
  }
}</style>
    <!--[if gte mso 9]>
    <style>
      .column-top {
        mso-line-height-rule: exactly !important;
      }
    </style>
    <![endif]-->
  <meta name=\"robots\" content=\"noindex,nofollow\" />
<meta property=\"og:title\" content=\"My First Campaign\" />
</head>
  <body style=\"margin: 0;mso-line-height-rule: exactly;padding: 0;min-width: 100%;background-color: #fbfbfb\";><style type=\"text/css\">
body,.wrapper,.emb-editor-canvas{background-color:#fbfbfb}.border{background-color:#e9e9e9}h1{color:#565656}.wrapper h1{}.wrapper h1{font-family:sans-serif}@media only screen and (min-width: 0){.wrapper h1{font-family:Avenir,sans-serif !important}}h1{}.one-col h1{line-height:42px}.two-col h1{line-height:32px}.three-col h1{line-height:26px}.wrapper .one-col-feature h1{line-height:58px}@media only screen and (max-width: 620px){h1{line-height:42px !important}}h2{color:#555}.wrapper h2{}.wrapper h2{font-family:Georgia,serif}h2{}.one-col h2{line-height:32px}.two-col h2{line-height:26px}.three-col h2{line-height:22px}.wrapper .one-col-feature h2{line-height:52px}@media only screen and (max-width: 620px){h2{line-height:32px !important}}h3{color:#555}.wrapper h3{}.wrapper h3{font-family:Georgia,serif}h3{}.one-col h3{line-height:26px}.two-col h3{line-height:22px}.three-col 
h3{line-height:20px}.wrapper .one-col-feature h3{line-height:42px}@media only screen and (max-width: 620px){h3{line-height:26px !important}}p,ol,ul{color:#565656}.wrapper p,.wrapper ol,.wrapper ul{}.wrapper p,.wrapper ol,.wrapper ul{font-family:Georgia,serif}p,ol,ul{}.one-col p,.one-col ol,.one-col ul{line-height:25px;Margin-bottom:25px}.two-col p,.two-col ol,.two-col ul{line-height:23px;Margin-bottom:23px}.three-col p,.three-col ol,.three-col ul{line-height:21px;Margin-bottom:21px}.wrapper .one-col-feature p,.wrapper .one-col-feature ol,.wrapper .one-col-feature ul{line-height:32px}.one-col-feature blockquote p,.one-col-feature blockquote ol,.one-col-feature blockquote ul{line-height:50px}@media only screen and (max-width: 620px){p,ol,ul{line-height:25px !important;Margin-bottom:25px !important}}.image{color:#565656}.image{font-family:Georgia,serif}.wrapper a{color:#41637e}.wrapper 
a:hover{color:#30495c !important}.wrapper .logo div{color:#41637e}.wrapper .logo div{font-family:sans-serif}@media only screen and (min-width: 0){.wrapper .logo div{font-family:Avenir,sans-serif !important}}.wrapper .logo div a{color:#41637e}.wrapper .logo div a:hover{color:#41637e !important}.wrapper .one-col-feature p a,.wrapper .one-col-feature ol a,.wrapper .one-col-feature ul a{border-bottom:1px solid #41637e}.wrapper .one-col-feature p a:hover,.wrapper .one-col-feature ol a:hover,.wrapper .one-col-feature ul a:hover{color:#30495c !important;border-bottom:1px solid #30495c !important}.btn a{}.wrapper .btn a{}.wrapper .btn a{font-family:Georgia,serif}.wrapper .btn a{background-color:#41637e;color:#fff !important;outline-color:#41637e;text-shadow:0 1px 0 #3b5971}.wrapper .btn a:hover{background-color:#3b5971 !important;color:#fff !important;outline-color:#3b5971 !important}.preheader 
.title,.preheader .webversion,.footer .padded{color:#999}.preheader .title,.preheader .webversion,.footer .padded{font-family:Georgia,serif}.preheader .title a,.preheader .webversion a,.footer .padded a{color:#999}.preheader .title a:hover,.preheader .webversion a:hover,.footer .padded a:hover{color:#737373 !important}.footer .social .divider{color:#e9e9e9}.footer .social .social-text,.footer .social a{color:#999}.wrapper .footer .social .social-text,.wrapper .footer .social a{}.wrapper .footer .social .social-text,.wrapper .footer .social a{font-family:Georgia,serif}.footer .social .social-text,.footer .social a{}.footer .social .social-text,.footer .social a{letter-spacing:0.05em}.footer .social .social-text:hover,.footer .social a:hover{color:#737373 !important}.image .border{background-color:#c8c8c8}.image-frame{background-color:#dadada}.image-background{background-color:#f7f7f7}
</style>
    <center class=\"wrapper\" style=\"display: table;table-layout: fixed;width: 100%;min-width: 620px;-webkit-text-size-adjust: 100%;-ms-text-size-adjust: 100%;background-color: #fbfbfb;\">
    	<table class=\"gmail\" style=\"border-collapse: collapse;border-spacing: 0;width: 650px;min-width: 650px><tbody><tr><td style=padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;\">&nbsp;</td></tr></tbody></table>
      <table class=\"preheader centered\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;\">
        <tbody><tr>
          <td style=\"padding: 0;vertical-align: top;\">
            <table style=\"border-collapse: collapse;border-spacing: 0;width: 602px;\">
              <tbody><tr>
                
                <td class=\"webversion\" style=\"padding: 0;vertical-align: top;padding-top: 10px;padding-bottom: 12px;font-size: 12px;line-height: 21px;text-align: right;width: 300px;color: #999;font-family: Georgia,serif\">
                <webversion style=\"font-weight:bold;text-decoration:none;\"></webversion>
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
      <table class=\"header centered\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px;\">
        <tbody><tr><td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px;\">&nbsp;</td></tr>
        <tr><td class=\"logo\" style=\"padding: 32px 0;vertical-align: top;mso-line-height-rule: at-least\"><div class=\"logo-center\" style=\"font-size: 26px;font-weight: 700;letter-spacing: -0.02em;line-height: 32px;color: #41637e;font-family: sans-serif;text-align: center\" align=\"center\" id=\"emb-email-header\"><a style=\"text-decoration: none;transition: all .2s;color: #41637e\" href=\"http://www.firstpropinvest.com\"><img style=\"border: 0;-ms-interpolation-mode: bicubic;display: block;Margin-left: auto;Margin-right: auto;max-width: 240px;\" src='".get_template_directory_uri()."/images/FPIlogojpeg.jpg' alt=\"FPI\" width=\"160\" height=\"160\" /></a></div></td></tr>
      </tbody></table>
      
          <table class=\"border\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto\" width=\"602\">
            <tbody><tr><td style=\"padding: 0;vertical-align: top\">&#8203;</td></tr>
          </tbody></table>
        
          <table class=centered style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto\">
            <tbody><tr>
              <td class=border style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
              <td style=\"padding: 0;vertical-align: top\">
                <table class=\"one-col\" style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 600px;background-color: #ffffff;font-size: 14px;table-layout: fixed\">
                  <tbody><tr>
                    <td class=\"column\" style=\"padding: 0;vertical-align: top;text-align: left\">
                      <div><div class=\"column-top\" style=\"font-size: 32px;line-height: 32px\">&nbsp;</div></div>
                        <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                          <tbody><tr>
                            <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 32px;padding-right: 32px;word-break: break-word;word-wrap: break-word\">
                              
            <h1 style=\"Margin-top: 0;color: #565656;font-weight: 700;font-size: 36px;Margin-bottom: 18px;font-family: sans-serif;line-height: 42px\">You have received a new request for a 3rd party service</h1><p style=\"Margin-top: 0;color: #565656;font-family: Georgia,serif;font-size: 16px;line-height: 25px;Margin-bottom: 25px\"><br />
Name: ".$name."<br />
Email: ".$email."<br />
Number:&nbsp; ".$phone."<br />
Country: ".$_POST['return_country']."<br />
Preferred Contact Method: ".$_POST['return_con_method']."<br />
Services requested: <br />-".$_POST['check_1']."<br />-
".$_POST['check_2']."<br />-
".$_POST['check_3']."<br />
</p>
          
                            </td>
                          </tr>
                        </tbody></table>
                      
                      <div class=\"column-bottom\" style=\"font-size: 8px;line-height: 8px\">&nbsp;</div>
                    </td>
                  </tr>
                </tbody></table>
              </td>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
            </tr>
          </tbody></table>
        
          
        
          
                      
                        
                      
                      <div class=\"column-bottom\" style=\"font-size: 8px;line-height: 8px\">&nbsp;</div>
                    </td>
                  </tr>
                </tbody></table>
              </td>
              <td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&#8203;</td>
            </tr>
          </tbody></table>
        
          <table class=\"border\" style=\"border-collapse: collapse;border-spacing: 0;font-size: 1px;line-height: 1px;background-color: #e9e9e9;Margin-left: auto;Margin-right: auto\" width=\"602\">
            <tbody><tr><td style=\"padding: 0;vertical-align: top\">&#8203;</td></tr>
          </tbody></table>
        
      <div class=\"spacer\" style=\"font-size: 1px;line-height: 32px;width: 100%\">&nbsp;</div>
      <table class=\"footer\" centered style=\"border-collapse: collapse;border-spacing: 0;Margin-left: auto;Margin-right: auto;width: 602px\">
        <tbody><tr>
          <td class=\"social\" style=\"padding: 0;vertical-align: top;padding-top: 32px;padding-bottom: 22px\" align=\"center\">
            <table style=\"border-collapse: collapse;border-spacing: 0\">
              <tbody><tr>
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
                
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
                
                <td class=\"social-link\" style=\"padding: 0;vertical-align: top\">
                  
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
        <tr><td class=\"border\" style=\"padding: 0;vertical-align: top;font-size: 1px;line-height: 1px;background-color: #e9e9e9;width: 1px\">&nbsp;</td></tr>
        <tr>
          <td style=\"padding: 0;vertical-align: top\">
            <table style=\"border-collapse: collapse;border-spacing: 0\">
              <tbody><tr>
                <td class=\"address\" style=\"padding: 0;vertical-align: top;width: 100%;text-align:center;padding-top: 32px;padding-bottom: 64px\">
                  <table class=\"contents\" style=\"border-collapse: collapse;border-spacing: 0;table-layout: fixed;width: 100%\">
                    <tbody><tr>
                      <td class=\"padded\" style=\"padding: 0;vertical-align: top;padding-left: 0;padding-right: 10px;word-break: break-word;word-wrap: break-word;text-align: center;font-size: 12px;line-height: 20px;color: #999;font-family: Georgia,serif\">
                        <div><a href=\"www.firstpropinvest.com\">FirstPropInvest.com</a></div>
                      </td>
                    </tr>
                  </tbody></table>
                </td>
                <td class=\"subscription\" style=\"padding: 0;vertical-align: top;width: 350px;padding-top: 32px;padding-bottom: 64px\">
                  
                </td>
              </tr>
            </tbody></table>
          </td>
        </tr>
      </tbody></table>
    </center>
	  
</body></html>
  ";
		
		
		 $header = 'Content-type: text/html; charset=utf-8' . "\r\n";
         $header = apply_filters("inspiry_agent_mail_header", $header);
         $header .= 'From: ' . $name . " <" . $email . "> \r\n";
		 $email_subject = __('3rd Party Service Request ', 'framework');
		  if ( wp_mail( $to_email, $email_subject, $email_body, $header ) ) {
			echo "Thanks for your subscription";
		  
		  }
		  

		
	die;
	}
}	
?>