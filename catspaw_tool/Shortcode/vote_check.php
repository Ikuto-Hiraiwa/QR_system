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

	echo '<br>Available : '.$qr_available;

	if($secret_id==NULL){
		echo '<h2>QRコードをもう一度読み直してください。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}else if($qr_available==1){
		$single = true; 
		$avatar = get_avatar($vote_id,150);
		echo '
			<div class="container">
					<div class="row">
						<div class="col-sm-12 col-xs-12 col-md-12" align="center">
						 	<span class="author-thumbanil">'.$avatar.'</span><br>
						</div>
						<div class="col-sm-12 col-xs-12 col-md-12">
							<table>
								<tr><td>'.get_user_meta($vote_id , 'nickname' , $single).'</td></tr>
								<tr><td>'.get_user_meta($vote_id , 'artist_point' , $single).'P</td></tr>
							</table>
						</div>
					</div>
			</div>
			<br>';
		echo '<h3>このアーティストに投票しますか？</h3><br>';
		echo '
			<div align="center">
				<a href="http://field-jack.com/catspaw/vote/vote_after?id='.$vote_id.'&secret='.$secret_id.'"><button>投票する</button>
			</div>';


	}else{
		echo '<h2>このQRコードは使用済です。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}

?>