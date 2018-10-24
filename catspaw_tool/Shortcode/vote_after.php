<?php
	global $wpdb;
	$myPath = '/home/field-jack/www/catspaw/wp-load.php';
	require_once( $myPath );

	$vote_id = $_GET['id'];
	$secret_id = $_GET['secret'];
	echo 'ID : '.$vote_id;
	echo '<br>Secret : '.$secret_id.'<br>';

	/*-----------QRコード有効かチェック----------*/
	$qr_query = "SELECT `available` FROM `cats_qr` WHERE `secret`='".$secret_id."';";
	$qr_available = $wpdb->get_var($qr_query);

	echo 'Available : '.$qr_available.'<br>';

	if($secret_id==NULL){
		echo '<h2>QRコードをもう一度読み直してください。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}else if($vote_id!=NULL && $secret_id!=NULL && $qr_available==1){
		$result = require_once('vote_system.php');
		echo $result;
	}else{
		echo '<div align="center"><h2>このQRコードは使用済です。</h2></div><br>';
		echo '<div align="center"><a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a></div>';
	}

?>