<?php
/**
 * File Name: property-market-information.php
 *
 * Send message function to filter form submission
 *
 */
/*add_action( 'wp_ajax_get_average_price', 'get_average_price' );
add_action( 'wp_ajax_nopriv_get_average_price', 'get_average_price' );

function get_average_price(){
	global $wpdb;
	$ID = $_POST['post_id'];
	$bed = $_POST['bedroom'];
	$for = $_POST['property_for'];*/
	global $post,$wpdb;
	$property_location = get_post_meta($post->ID,'REAL_HOMES_property_location',true);
	$url= 'http://api.nestoria.co.uk/api?pretty=1&encoding=json&action=metadata&centre_point='.$property_location;
	$json = @file_get_contents($url);
	$data=json_decode($json);
	$month = $data->response->most_recent_month;
	//echo "<pre>"; print_r($data->response); echo "</pre>";
	if($data->response->status_code == 200){
		foreach($data->response->metadata as $metadata)
		{
			if($metadata->num_beds == 'all' && $metadata->listing_type == 'buy'){
				$buy_avg = $metadata->data->$month->avg_price;
			}
			elseif($metadata->num_beds == 'all' && $metadata->listing_type == 'rent'){
				$rent_avg = $metadata->data->$month->avg_price;
			}
		}
		echo '<h3 class="title avg-price">Average House Price: '.round(nice_number($buy_avg)).'k</h3>';
		echo '<ul class="market-info">';
		foreach($data->response->metadata as $metadata)
		{
			if($metadata->num_beds == 1 && $metadata->listing_type == 'buy'){
				echo '<li><strong>1 Bed:</strong> '.round(nice_number($metadata->data->$month->avg_price)).'k</li>';
			}
			elseif($metadata->num_beds == 2 && $metadata->listing_type == 'buy'){
				echo '<li><strong>2 Beds:</strong> '.round(nice_number($metadata->data->$month->avg_price)).'k</li>';
			}
			elseif($metadata->num_beds == 3 && $metadata->listing_type == 'buy'){
				echo '<li><strong>3 Beds:</strong> '.round(nice_number($metadata->data->$month->avg_price)).'k</li>';
			}
			elseif($metadata->num_beds == 4 && $metadata->listing_type == 'buy'){
				echo '<li><strong>4 Beds:</strong> '.round(nice_number($metadata->data->$month->avg_price)).'k</li>';
			}
			elseif($metadata->num_beds == 5 && $metadata->listing_type == 'buy'){
				echo '<li><strong>5 Beds:</strong> '.round(nice_number($metadata->data->$month->avg_price)).'k</li>';
			}	
		}
		echo '</ul>';
		echo '<h3 class="title avg-rent">Average Rent Price: '.nice_number($rent_avg).' pcm</h3>';
		echo '<ul class="market-info">';
		foreach($data->response->metadata as $metadata)
		{
			if($metadata->num_beds == 1 && $metadata->listing_type == 'rent'){
				echo '<li><strong>1 Bed:</strong> '.$metadata->data->$month->avg_price.'</li>';
			}
			elseif($metadata->num_beds == 2 && $metadata->listing_type == 'rent'){
				echo '<li><strong>2 Beds:</strong> '.$metadata->data->$month->avg_price.'</li>';
			}
			elseif($metadata->num_beds == 3 && $metadata->listing_type == 'rent'){
				echo '<li><strong>3 Beds:</strong> '.$metadata->data->$month->avg_price.'</li>';
			}
			elseif($metadata->num_beds == 4 && $metadata->listing_type == 'rent'){
				echo '<li><strong>4 Beds:</strong> '.$metadata->data->$month->avg_price.'</li>';
			}
			elseif($metadata->num_beds == 5 && $metadata->listing_type == 'rent'){
				echo '<li><strong>5 Beds:</strong> '.$metadata->data->$month->avg_price.'</li>';
			}	
		}
		echo '</ul>';
	}
	/*die();
}	
*/