<?php
global $wpdb;
$myPath = '/home/field-jack/www/catspaw/wp-load.php';
require_once( $myPath );

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
  	$avatar = get_avatar($profile_id,300);


 
 	echo '
 	<div class="container">
	<div class="row">
		<div class="col-sm-12 col-xs-8">
			<span><h2>'.$row->artist_rank.
			'位</h2></span>
		</div>
		<div class="col-sm-4 col-xs-4">
			<span class="author-thumbanil"><a href="http://field-jack.com/catspaw/user/'. $profile_login . '">'.$avatar.'</a></span>
		</div>
		<div class="col-sm-4 col-xs-12">
                            <table border="1">
                                <tr>
                                    <td colspan="2"><span >放送枠！</span></td>
                                </tr>

                                <tr>
                                    <td width="30%">バンド名</td>
                                    <td><span><a href="http://field-jack.com/catspaw/user/'. $profile_login . '">'.get_user_meta($profile_id , 'nickname' , $single).'</a></span></td>
                                </tr>
                                <tr>
                                    <td>ポイント</td>
                                    <td><span>'.get_user_meta($profile_id , 'artist_point' , $single).'P</span></td>
                                </tr>
                                <tr>
                                    <td>地域</td>
                                    <td><span>'.get_user_meta($profile_id , 'address' , $single).'</span></td>
                                </tr>
                                <tr>
                                    <td>コメント</td>
                                    <td><span>'.get_user_meta($profile_id , 'description' , $single).'</span></td>
                                </tr>
                            </table>
        </div>
    </div>
</div>
<br><br>
';
}

?>
