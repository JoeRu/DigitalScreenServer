<?php
// Speed of each news can be adapted in Line 99 -- autoplaySpeed: 18000, # actual set to 18 seconds
header('Content-Type: text/html; charset=utf-8');

if (!ini_get('date.timezone')) {
	date_default_timezone_set('Europe/Berlin');
}

require_once 'src/Feed.php';
$my_feeds = array(
Feed::loadRss('https://www.usinger-anzeiger.de/rss/lokales/usingen'),
Feed::loadRss('https://www.faz.net/rss/aktuell/'),
Feed::loadRss('https://www.tagesschau.de/xml/rss2')
);

Feed::$cacheDir = '/tmp';
Feed::$cacheExpire = '30 minutes';

function console_log( $data ){
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function rem_mehr( $zeichenkette ){
	$zeichenkette = trim(preg_replace('/\s+/', ' ', $zeichenkette));
$suchmuster = '/(.*)\[mehr\].*/i';
$ersetzung = '$1';
return preg_replace($suchmuster, $ersetzung, $zeichenkette);
}

$News = array();
foreach ($my_feeds as $feed){
	foreach ($feed->item as $item){
		array_push($News, $item);
}}
// random News
shuffle($News);
// auf 7 begrenzen
//$News = array_slice($News, 0, 6);
/*
console_log($News)

 *
 * https://www.faz.net/rss/aktuell/
 https://www.tagesschau.de/xml/rss2
 * https://www.usinger-anzeiger.de/rss/lokales/neu-anspach
 * https://www.usinger-anzeiger.de/rss/lokales/wehrheim
 * https://www.usinger-anzeiger.de/rss/lokales/hochtaunus-und-region/landkreis-hochtaunus
 *
 * */
?>
<!doctype html>
<html class="no-js" lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News aus Usingen</title>

	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css"/>
    <link rel="stylesheet" type="text/css" href="css/app.css" >

  </head>
  <body onload="myload()">

    <!--  <div class="large-12 cell">
					  <h1><!--  <?php echo htmlspecialchars($rss->title) ?> </h1>
        </div> -->


<div class="joes1" id="joes1">
<?php
$first = true;
foreach ($News as $item){ ?>
	<div>
	<h2><?php echo strip_tags ($item->title) ?></h2>
<!--	<small><?php echo date('j.n.Y H:i', (int) $item->timestamp) ?></small> -->

	<?php if (isset($item->{'content:encoded'})): ?>
		<p><?php echo rem_mehr(strip_tags ($item->{'content:encoded'},'<img>')) ?></p>
	<?php else: ?>
		<p><?php echo rem_mehr(strip_tags ($item->description,'<img>')) ?></p>
	<?php endif ?>
</div>
<?php } ?>
</div>

<script type="text/javascript" src="//code.jquery.com/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>

<script type="text/javascript">
	function myload(){
		$('.joes1').slick({
			slidesToShow: 1,
		  slidesToScroll: 1,
		  autoplay: true,
		  autoplaySpeed: 18000,
			arrows: false,
			prevArrow: '',
			nextArrow: '',
		});
 		$('.joes1').css("display","block");
	}
</script>
  </body>
</html>
