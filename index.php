<?php
$url=array(
	'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=rss&topic=y&num=10',
	'http://news.google.com/news?hl=ja&ned=us&ie=UTF-8&oe=UTF-8&output=rss&topic=y&num=100'
	);
$flug=false;
$cnttitle='';
$status=0;
//index.phpに初回アクセスした時と検索キーワード入力してPOST送信した時にいろいろ変える仕組み
if(isset($_POST['words']) && $_POST['words']!=''){
	$words=h($_POST['words']);
	$flug=true;//これで状態を判定しています
	$rss=simplexml_load_file($url[1]);
	$cnttitle='社会ニュース検索結果';
}else{
	$flug=false;//これで状態を判定しています
	$rss=simplexml_load_file($url[0]);
	$cnttitle='最新のニュースから10件';
}

function h($v){
	return htmlspecialchars($v,ENT_QUOTES);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<link type="text/css" rel="stylesheet" href="css/style.css">
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="js/script.js"></script>
<title>ニュース検索</title>
</head>
<body>
<div class="container">
	<h1 class="gtitle"><img src="img/logo.png" width="400px"><br>から検索してみる</h1>
	<div class="search">
	<form action="" method="post">
		<input type="text" name="words" class="words" placeholder="キーワードを入力してください"><br>
		<input type="submit" value="社会ニュースタイトルから検索">
		<input type="button" value="最新のニュースに戻る" onClick="location.href='index.php'">
	</form>
		
	</div>
	<div class="newswrapp">
	<h2 id="sectitle1" class="sectitle"><?php echo $cnttitle;?></h2>
	<?php foreach($rss->channel->item as $item):
		//検索結果表示
		if($flug==true){
			
			$result=mb_strpos($item->title, $words,0,'UTF-8');
			if($result!==false){
				$cnttitle='わーーーー';
				echo "<div class='news'>";
				echo	"<a href='".$item->link."' target='blank'><h3>".$item->title."</h3></a>";
				echo    "<p class='date'>$item->pubDate</p>";
				echo	"<div class='details'>
							$item->description
						</div>";
				echo "</div>";
				$status++;				
			}
			
			

		}
		//初回アクセス時の表示
		if($flug==false){
			echo "<div class='news'>";
			echo	"<a href='".$item->link."' target='blank'><h3>".$item->title."</h3></a>";
			echo    "<p class='date'>$item->pubDate</p>";
			echo	"<div class='details'>
					$item->description
				</div>";
			echo "</div>";
			$status=1;
		}
		
	endforeach;
	if($status==0){
		echo '<p>検索にマッチする投稿はありません</p>';

	}
	?>
	</div>
</div>

</body>
</html>