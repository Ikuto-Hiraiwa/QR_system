<?php

global $wpdb;
$myPath = '/home/field-jack/www/catspaw/wp-load.php';
require_once( $myPath );

$single = true;
$qeury = "DELETE FROM `cats_qr` ORDER BY `id` DESC LIMIT 44;";
$result = $wpdb->query($qeury);

if($result!=NULL){
	echo '<br><br><h2>'.$result.'件のデータを消去しました。</h2>';
}else{
	echo '<br><br><h2>データの消去に失敗しました。</h2>';
}

echo '<a href="http://field-jack.com/catspaw/qr"><button>QR情報へ戻る</button></a>';



?>