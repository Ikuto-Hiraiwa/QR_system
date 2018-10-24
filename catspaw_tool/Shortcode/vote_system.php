<?php

	$vote_id = $_GET['id'];
	$secret_id = $_GET['secret'];
	echo 'ID : '.$vote_id;
	echo '<br>Secret : '.$secret_id.'<br>';

	$user = wp_get_current_user();
	echo 'User : '.$user->ID.'<br>';

	/*-----------QRコード有効かチェック----------*/
	$qr_query = "SELECT `available` FROM `cats_qr` WHERE `secret`='".$secret_id."';";
	$qr_available = $wpdb->get_var($qr_query);

	echo 'Available : '.$qr_available.'<br>';
	if($qr_available==1){
		/*--------------QRを無効に----------------*/
		$available_query = "UPDATE `cats_qr` SET `available`= 0 WHERE `secret`='".$secret_id."';";
		$wpdb->query($available_query);
		/*----------ポイント確認------------------^*/
		$point = $wpdb->get_var("SELECT `point` FROM `cats_qr` WHERE `secret`='".$secret_id ."';");
		
		/*----------アーティストにポイント等を追加---------*/
		$artist_point_query="UPDATE `cats_usermeta` SET `meta_value`= `meta_value`+".$point." WHERE `meta_key`='artist_point' AND `user_id`=".$vote_id.";";
		$artist_this_month_point_query="UPDATE `cats_usermeta` SET `meta_value`= `meta_value`+".$point." WHERE `meta_key`='this_month_point' AND `user_id`=".$vote_id.";";
		$wpdb->query($artist_point_query);
		$wpdb->query($artist_this_month_point_query);

		/*------------ファンにポイント追加----------*/
		$fan_point_query="UPDATE `cats_usermeta` SET `meta_value`= `meta_value`+".$point." WHERE `meta_key`='fan_point' AND `user_id`=".$user->ID.";";
		$fan_this_month_point_query="UPDATE `cats_usermeta` SET `meta_value`= `meta_value`+".$point." WHERE `meta_key`='this_month_point' AND `user_id`=".$user->ID.";";
		$wpdb->query($fan_point_query);	
		$wpdb->query($fan_this_month_point_query);	

		/*----------ショップにポイント追加*/
		$shop_number = $wpdb->get_var("SELECT `shop` FROM `cats_qr` WHERE `secret`='".$secret_id."';");
		$shop_poit_query="UPDATE `cats_usermeta` SET `meta_value`= `meta_value`+".$point." WHERE `meta_key`='activate_point' AND `user_id`=".$shop_number.";";
		$wpdb->query($shop_poit_query);


		/*-----------QRコードに情報格納-----------*/
		$modified_query = "UPDATE `cats_qr` SET `modified`=CURRENT_TIMESTAMP(6) WHERE `secret`='".$secret_id."';";
		$use_user_query = "UPDATE `cats_qr` SET `use_user`=".$user->ID." WHERE `secret`='".$secret_id."';";
		$use_artist_query = "UPDATE `cats_qr` SET `user_artist`=".$vote_id." WHERE `secret`='".$secret_id."';";
		$wpdb->query($modified_query);
		$wpdb->query($use_user_query);
		$wpdb->query($use_artist_query);



		return '<div align="center"><h2>投票完了しました!</h2></div><br><div align="center"><a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a></div>';
	}else{
		return '<h2>このQRは使用済みです。</h2><br><a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}
	

?>