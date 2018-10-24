<?php
	session_start();

	global $wpdb;
	$myPath = '/home/field-jack/www/catspaw/wp-load.php';
	require_once( $myPath );

	$secret_id = $_GET['secret'];



	if(isset($_SESSION['secret'])){
		$secret_id = $_SESSION['secret'];
	}
	echo 'SESSION : ' .$_SESSION['secret'].'<br>';
	echo 'GET :' .$_GET['secret'].'<br>';
	echo 'secret_id :'.$secret_id.'<br>';

	/*------------QRコードの有効か無効化を判定----------*/
	if($secret_id!=NULL){
		$qr_query = "SELECT `available` FROM `cats_qr` WHERE `secret`='".$secret_id."';";
		$qr_available = $wpdb->get_var($qr_query);
		echo 'Available : ' .$qr_available.'<br>';
	}else{
		echo 'Available Error!<br>';
	}
	
	if($secret_id==NULL){
		echo '<h2>QRコードをもう一度読み直してください。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}else if($qr_available==1 && $secret_id!=NULL){
		if (is_user_logged_in()){
			echo 'Welcome!<br>';
			/*--------------投票時アーティスト表示部---------------*/
			$select_query = "SELECT * FROM `cats_usermeta` WHERE `meta_key` = 'artist_point' ORDER BY `cats_usermeta`.`artist_rank` ASC";
			$result = $wpdb->get_results($select_query);
			//デバッグ用
			//var_dump($result);

			// foreach文で配列の中身を一行ずつ出力
			foreach ($result as $row) {				 
				  // データベースのフィールド名で出力
				 	//デバッグ用
				 	//echo $row->artist_rank .'位'.'[ID : '.$row->user_id .']';
				$single = true; 
			 	$profile_id = $row->user_id;
			  	$profile_login = get_user_meta($profile_id , 'user_login' , $single);
			  	$avatar = get_avatar($profile_id,150);
			  	$status = get_user_meta($profile_id , 'account_status' , $single);
			  	$rank = '順位無し';

			  	if($status=='approved'){
			  		if($row->artist_rank==99999){
			  			$rank = '順位無し';
			  		}else{
			  			$rank = $row->artist_rank.'位';
			  		}
				  		
				 	echo '
				 	<div class="container">
						<div class="row">
							<div class="col-sm-6 col-xs-6 col-md-6">
							 	<span class="author-thumbanil">'.$avatar.'</span><br>
								<table>
									<tr><td>'.get_user_meta($profile_id , 'nickname' , $single).'</td></tr>
									<tr><td>'.get_user_meta($profile_id , 'artist_point' , $single).'P</td></tr>
								</table>
							</div> 
							<div class="col-sm-6 col-xs-6 col-md-6">
								<a href="http://field-jack.com/catspaw/vote/vote_check?id='.$profile_id.'&secret='.$secret_id.'"><button>投票する</button></a>
							</div>
					    </div>
					</div>
					<br><br>
					';
				}
			}
		}else{
			echo 'No user.<br>';
			echo '<div class="col-sm-4 col-xs-4">
					<a href="http://field-jack.com/catspaw/vote-login?secret='.$secret_id.'"><button>ログインへ進む</button></a>
				  </div>';
			echo '<div class="col-sm-4 col-xs-4">
					<button type="submit" name="vote_value" value="True">無記名投票</button>
				  </div>';
		}
	}else{
		echo '<h2>このQRコードは使用済です。</h2><br>';
		echo '<a href="http://field-jack.com/catspaw"><button>トップへ戻る</button></a>';
	}
    
	session_destroy();
?>