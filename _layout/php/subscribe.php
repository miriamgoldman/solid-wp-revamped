<?php
/*
 * 	E-mail subscribe via JSON
 */
	
	header('Content-type: text/json');

	require_once('../../../../../wp-config.php');
	require_once('../../../../../wp-includes/wp-db.php');
	require_once('../../../../../wp-includes/pluggable.php');
	require_once('../../functions.php');
	
	
	$mails = get_option(EWF_SETUP_THNAME."_newsletter_mails", '*');
	$exists = false;
	
	if (array_key_exists('subscribe',$_POST)){
	
		if ($mails=='*'){
			add_option(EWF_SETUP_THNAME."_newsletter_mails", $value = serialize(array(trim(strtolower($_POST['subscribe'])))), $description = __('the e-mail list for newsletter',EWF_SETUP_THEME_DOMAIN) , $autoload = 'no');
			
			echo json_encode(array('success'=>1,'message'=>__('thank you for your interest!',EWF_SETUP_THEME_DOMAIN)));
		}else{
			$new_mails = unserialize($mails);
			$current_mail = trim(strtolower($_POST['subscribe']));
			
			foreach($new_mails as $key=>$oldMail){
				if ($current_mail==$oldMail){
					$exists = true;
				}
			}
			
			if (!$exists){
				$new_mails[] = $current_mail;
				update_option(EWF_SETUP_THNAME."_newsletter_mails", $value = serialize($new_mails));
				
				echo json_encode(array('success'=>1,'message'=>__('thank you for your interest!',EWF_SETUP_THEME_DOMAIN)));
			}else{
				echo json_encode(array('success'=>0,'err'=>'101','message'=>__('this e-mail is already registered!',EWF_SETUP_THEME_DOMAIN)));
			}
		}
		
	}else{
		echo  json_encode(array('success'=>0,'err'=>'100','message'=>__('no data recived!', EWF_SETUP_THEME_DOMAIN)));
	}
	
?>