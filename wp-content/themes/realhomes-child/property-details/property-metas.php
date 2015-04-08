<?php
        $post_meta_data = get_post_custom($post->ID);		
		if( !empty($post_meta_data['REAL_HOMES_property_yield'][0]) ) {                $prop_yield = $post_meta_data['REAL_HOMES_property_yield'][0];                echo '<span><i class="icon-graph"></i>';                echo $prop_yield.'% '.__('Yield','framework' );                echo '</span>';        }		
        if( !empty($post_meta_data['REAL_HOMES_property_size'][0]) ) {
                $prop_size = $post_meta_data['REAL_HOMES_property_size'][0];
                echo '<span><i class="icon-area"></i>';
                echo $prop_size;
                if( !empty($post_meta_data['REAL_HOMES_property_size_postfix'][0]) ){
                    $prop_size_postfix = $post_meta_data['REAL_HOMES_property_size_postfix'][0];
                    echo '&nbsp;'.$prop_size_postfix;
                }
                echo '</span>';
        }

        if( !empty($post_meta_data['REAL_HOMES_property_bedrooms'][0]) ) {
                $prop_bedrooms = floatval($post_meta_data['REAL_HOMES_property_bedrooms'][0]);
                $bedrooms_label = ($prop_bedrooms > 1)? __('Beds','framework' ): __('Bed','framework');
                echo '<span><i class="icon-bed"></i>'. $prop_bedrooms .'&nbsp;'.$bedrooms_label.'</span>';
        }

        if( !empty($post_meta_data['REAL_HOMES_property_bathrooms'][0]) ) {
                $prop_bathrooms = floatval($post_meta_data['REAL_HOMES_property_bathrooms'][0]);
                $bathrooms_label = ($prop_bathrooms > 1)?__('Baths','framework' ): __('Bath','framework');
                echo '<span><i class="icon-bath"></i>'. $prop_bathrooms .'&nbsp;'.$bathrooms_label.'</span>';
        }

        if( !empty($post_meta_data['REAL_HOMES_property_garage'][0]) ) {
                $prop_garage = floatval($post_meta_data['REAL_HOMES_property_garage'][0]);
                $garage_label = ($prop_garage > 1)?__('Garages','framework' ): __('Garage','framework');
                echo '<span><i class="icon-garage"></i>'. $prop_garage .'&nbsp;'.$garage_label.'</span>';
        }

  ?>