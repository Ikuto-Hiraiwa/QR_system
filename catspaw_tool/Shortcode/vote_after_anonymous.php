<?php
	global $wpdb;
	$myPath = '/home/field-jack/www/catspaw/wp-load.php';
	require_once( $myPath );

	$vote_id = $_GET['id'];
	$secret_id = $_GET['secret'];

	//デバッグ

	echo 'ID : '.$vote_id;
	echo '<br>Secret : '.$secret_id.'<br>';
	

	/*-----------QRコード有効かチェック----------*/
	$qr_query = "SELECT `available` FROM `cats_qr` WHERE `secret`='".$secret_id."';";
	$qr_available = $wpdb->get_var($qr_query);

	//デバッグ
	//echo 'Available : '.$qr_available.'<br>';

	if($secret_id==NULL){
		echo '<h2>QRコードをもう一度読み直してください。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}else if($vote_id!=NULL && $secret_id!=NULL && $qr_available==1){
		$result = require_once('vote_system_anonymous.php');
		echo $result;
		if(is_user_logged_in()){
			$user = wp_get_current_user();
			$user_name = $user->nickname;
			echo '<br><div align="center"><a href="http://field-jack.com/catspaw/user/'.$user_name.'"><button>プロフィールへ</button></a></div>';
		}
	}else{
		echo '<div align="center"><h2>このQRコードは使用済です。</h2></div><br>';
		echo '<div align="center"><a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a></div>';
	}

?>