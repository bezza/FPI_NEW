<?php
global $post;
$property_location = get_post_meta($post->ID,'REAL_HOMES_property_location',true);
$lat_lng = explode(',',$property_location);
$tube_distance = get_post_meta( $post->ID, 'tube_distance', true );
$bus_distance = get_post_meta( $post->ID, 'bus_distance', true );
$train_distance = get_post_meta( $post->ID, 'train_distance', true );

if($tube_distance == '' && $bus_distance == '' && $train_distance == ''){
?>

<?php 
//------------------------------tube station
$url = "http://transportapi.com/v3/uk/tube/stations/near.json?api_key=92d473a8c088f97c1c3521f1282de202&app_id=96e591e5&lat=".  $lat_lng[0]."&lon=". $lat_lng[1]."&page=&rpp=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
// This is what solved the issue (Accepting gzip encoding)
curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
$response = curl_exec($ch);
curl_close($ch);
$con = json_decode($response);
foreach($con->stations as $con2){
	add_post_meta( $post->ID, 'tube_distance',$con2->distance , true );
	add_post_meta( $post->ID, 'tube_name',$con2->name , true );
?>
	<div class="near-transport border-btm">
		<div class="transport-icon">
			<img src="<?php echo get_template_directory_uri(); ?>/images/tube.png" />
		</div>
		<div class="transport-details">
			<p class="transport-name"><?php echo $con2->name; ?></p>
			<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
			<?php echo round(($con2->distance/1000),2)." Km."; ?></p>
			<?php
				$dis_per = ($con2->distance/1000)*100;
			?>
			<div class="distance-mark">
				<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
			</div>
		</div>
			<div class="clearfix"></div>
	</div>
<?php

}
//----------------------------bus stop
$url = "http://transportapi.com/v3/uk/bus/stops/near.json?api_key=92d473a8c088f97c1c3521f1282de202&app_id=96e591e5&lat=".  $lat_lng[0]."&lon=". $lat_lng[1]."&page=&rpp=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
// This is what solved the issue (Accepting gzip encoding)
curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
$response = curl_exec($ch);
curl_close($ch);
$con = json_decode($response);
foreach($con->stops as $con2){
	add_post_meta( $post->ID, 'bus_distance',$con2->distance , true );
	add_post_meta( $post->ID, 'bus_name',$con2->name , true );
?>
	<div class="near-transport border-btm">
		<div class="transport-icon">
			<img src="<?php echo get_template_directory_uri(); ?>/images/bus.png" />
		</div>
		<div class="transport-details">
			<p class="transport-name"><?php echo $con2->name; ?></p>
			<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
			<?php echo round(($con2->distance/1000),2)." Km."; ?></p>
			<?php
				$dis_per = ($con2->distance/1000)*100;
			?>
			<div class="distance-mark">
				<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
			</div>
		</div>
			<div class="clearfix"></div>
	</div>
<?php	
}
//----------------------------train stop
$url = "http://transportapi.com/v3/uk/train/stations/near.json?api_key=92d473a8c088f97c1c3521f1282de202&app_id=96e591e5&lat=".  $lat_lng[0]."&lon=". $lat_lng[1]."&page=&rpp=1";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
// This is what solved the issue (Accepting gzip encoding)
curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
$response = curl_exec($ch);
curl_close($ch);
$con = json_decode($response);
foreach($con->stations as $con2){
	add_post_meta( $post->ID, 'train_distance',$con2->distance , true );
	add_post_meta( $post->ID, 'train_name',$con2->name , true );
?>
	<div class="near-transport border-btm">
		<div class="transport-icon">
			<img src="<?php echo get_template_directory_uri(); ?>/images/train.png" />
		</div>
		<div class="transport-details">
			<p class="transport-name"><?php echo $con2->name; ?></p>
			<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
			<?php echo round(($con2->distance/1000),2)." Km."; ?></p>
			<?php
				$dis_per = ($con2->distance/1000)*100;
			?>
			<div class="distance-mark">
				<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
			</div>
		</div>
			<div class="clearfix"></div>
	</div>
<?php	
}
} else {
	?>
		<div class="near-transport border-btm">
			<div class="transport-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/tube.png" />
			</div>
			<div class="transport-details">
				<p class="transport-name"><?php echo get_post_meta( $post->ID, 'tube_name', true ); ?></p>
				<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
				<?php echo round((get_post_meta( $post->ID, 'tube_distance', true )/1000),2)." Km."; ?></p>
				<?php
					$dis_per = (get_post_meta( $post->ID, 'tube_distance', true )/1000)*100;
				?>
				<div class="distance-mark">
					<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
				</div>
			</div>
				<div class="clearfix"></div>
		</div>
		
		<div class="near-transport border-btm">
			<div class="transport-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/bus.png" />
			</div>
			<div class="transport-details">
				<p class="transport-name"><?php echo get_post_meta( $post->ID, 'bus_name', true ); ?></p>
				<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
				<?php echo round((get_post_meta( $post->ID, 'bus_distance', true )/1000),2)." Km."; ?></p>
				<?php
					$dis_per = (get_post_meta( $post->ID, 'bus_distance', true )/1000)*100;
				?>
				<div class="distance-mark">
					<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
				</div>
			</div>
				<div class="clearfix"></div>
		</div>
		
		<div class="near-transport border-btm">
			<div class="transport-icon">
				<img src="<?php echo get_template_directory_uri(); ?>/images/train.png" />
			</div>
			<div class="transport-details">
				<p class="transport-name"><?php echo get_post_meta( $post->ID, 'train_name', true ); ?></p>
				<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
				<?php echo round((get_post_meta( $post->ID, 'train_distance', true )/1000),2)." Km."; ?></p>
				<?php
					$dis_per = (get_post_meta( $post->ID, 'train_distance', true )/1000)*100;
				?>
				<div class="distance-mark">
					<div class="distance-bar" style="width:<?php echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
				</div>
			</div>
				<div class="clearfix"></div>
		</div>
	
	

<?php } ?>

	<div class="near-transport border-btm">
		<div class="transport-icon">
			<img src="<?php echo get_template_directory_uri(); ?>/images/airport.png" />
		</div>
		<div class="transport-details">
			<p class="transport-name">Heathrow Airport</p>
			<p class="transport-dis"><img src="<?php echo get_template_directory_uri(); ?>/images/men.png" />
			<span class="dis"></span></p>
			
			<div class="distance-mark">
				<div class="distance-bar" style="width:<?php //echo $dis_per; ?>%;background:#e8b91b;height:6px;"></div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>		


<script>
	
var p1 = new google.maps.LatLng(51.466844, -0.452952);
var p2 = new google.maps.LatLng(<?php echo $lat_lng[0]; ?>,<?php echo $lat_lng[1]; ?>);

var distance = calcDistance(p1, p2);
jQuery('.dis').text(distance+" Km.");
//calculates distance between two points in km's
function calcDistance(p1, p2){
  return (google.maps.geometry.spherical.computeDistanceBetween(p1, p2) / 1000).toFixed(2);
}
</script>


