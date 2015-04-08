<?php
/**
 * File Name: property_filter.php
 *
 * Send message function to filter form submission
 *
 */
add_action( 'wp_ajax_filter_property', 'filter_prop' );
add_action( 'wp_ajax_nopriv_filter_property', 'filter_prop' );

function filter_prop(){
	global $post,$wpdb;
	$min_price = trim($_POST['min_price']);
	$max_price = trim($_POST['max_price']);
	/*$min_size = trim($_POST['min_size']);
	$max_size = trim($_POST['max_size']);*/
	$bedroom = trim($_POST['bedroom']);
	$bathrooms = trim($_POST['bathrooms']);
	$parent_ID = trim($_POST['parent_ID']);
	$property_type = trim($_POST['property_type']);
	
	if($bedroom == '')
	{
		$bedroom = '1,2,3,4,5';
	}
	
	if($bathrooms == '')
	{
		$bathrooms = '1,2,3,4,5';
	}
	
	if($property_type != '')
	{
		$type = get_term_by('slug',$property_type,'property-type');
		$property_type = $type->term_id;
	}
	else
	{
		$property_type = '48,56,49,50,2,3,46';	
	}
	wp_reset_query(); 
	$child_properties_query = new WP_Query( array(
			'post_type' => 'property',
			'posts_per_page' => -1,
			'meta_key' => 'REAL_HOMES_property_price',
			'post_parent' => $parent_ID,
			'orderby' => 'ID',
			'order' => 'DESC',
			'tax_query' => array(
				array(
					'taxonomy' => 'property-type',
					'field'    => 'id',
					'terms'    => array( $property_type ),
					'operator' => 'IN',
				),
			),
			'meta_query' => array(
				array(
					'key'     => 'REAL_HOMES_property_price',
					'value'   => array( $min_price, $max_price ),
					'type'    => 'numeric',
					'compare' => 'BETWEEN',
				),
				array(
					'key'     => 'REAL_HOMES_property_bedrooms',
					'value'   => $bedroom,
					'type'    => 'numeric',
					'compare' => 'IN',
				),
				array(
					'key'     => 'REAL_HOMES_property_bathrooms',
					'value'   => $bathrooms,
					'type'    => 'numeric',
					'compare' => 'IN',
				)
			)
		)
	);
	/* echo "<pre>"; print_r($child_properties_query); echo "<pre>"; */
	
	if($child_properties_query->have_posts()){
		while ( $child_properties_query->have_posts() ) : $child_properties_query->the_post();
           $status_terms = get_the_terms( $post->ID,"property-status" );
		
		echo " <article class=\"property-item clearfix\">

            <figure>
                <a href=\"".get_the_permalink()."\" title=\"".get_the_title()."\">";
                    if(has_post_thumbnail($post->ID)){
                        the_post_thumbnail('property-thumb-image');}
					else {
						inspiry_image_placeholder( 'property-thumb-image' );
                    }
                echo "</a>
                <figcaption>
                  ";
                    if(!empty( $status_terms )){
                        $status_count = 0;
                        foreach( $status_terms as $term ){
                            if( $status_count > 0 ){
                                echo ', ';
                            }
                            echo $term->name;
                            $status_count++;
                        }
                    }
                    echo "
                </figcaption>
            </figure>


            <div class=\"summary\">
                <h4><a href=\"".get_the_permalink()."\"> ".get_the_title()."</a></h4>
                <h5 class=\"price\">";
                    
                    property_price();
                    
					$type_terms = get_the_terms( $post->ID,"property-type" );
                    if(!empty($type_terms)){
                        echo '<small> - ';
                        foreach($type_terms as $type_term){
                            echo $type_term->name;
                        }
                        echo '</small>';
                    }
                    echo "
                </h5>
                <p>";
				framework_excerpt(20);
				echo "</p>";
                echo"<a class=\"more-details\" href=\"".get_the_permalink()."\">More Details<i class=\"fa fa-caret-right\"></i></a>
            </div>

            <div class=\"property-meta\">";
               get_template_part('property-details/property-metas');
            echo"</div>

        </article>";
		
		
		endwhile;
	}
	else{
		echo "<div class=\"none-found\">Nothing found...!!</div>";
	}
	
	
	/*----------------If only price and size selected----------------------------------*/
	/*
	if($min_price != '' && $max_price != '' && $min_size != '' && $max_size != '' && $bedroom == '' && $bathrooms == '' & $property_type ==''  )
	{
		$sql2 = "select a.ID from wp_posts as a INNER JOIN wp_postmeta as b ON a.ID = b.post_id  AND b.meta_key = 'REAL_HOMES_property_size'  AND b.meta_value BETWEEN ".$min_size." AND ".$max_size." AND a.post_parent = '".$parent_ID."' AND post_type='property'";
		$sql3 = "select a.ID from wp_posts as a INNER JOIN wp_postmeta as b ON a.ID = b.post_id   AND  b.meta_key = 'REAL_HOMES_property_price'  AND b.meta_value BETWEEN ".$min_price." AND ".$max_price." AND a.post_parent = '".$parent_ID."' AND post_type='property'";
		$sql12 = $wpdb->get_results($sql2);
		$sql13 = $wpdb->get_results($sql3);
		// echo $wpdb->last_query;
		foreach($sql12 as $sql){
			foreach($sql13 as $sq){
			if(($sql->ID == $sq->ID)){
				$s[] = $sql->ID;
			}
			}
			
		}
		
		//echo "<pre>"; print_r($s); echo "</pre>";
		
		wp_reset_query();
		if(!empty($s)){
		 $child_properties_query = query_posts( array('post_type'=>'property','post__in' => $s, 'posts_per_page' => -1) );
		//echo "<pre>"; print_r($child_properties_query); echo "</pre>";
		if(have_posts()){
		while ( have_posts() ) :
        the_post();
           $status_terms = get_the_terms( $post->ID,"property-status" );
		
		echo " <article class=\"property-item clearfix\">

            <figure>
                <a href=\"".get_the_permalink()."\" title=\"".get_the_title()."\">";
                    if(has_post_thumbnail($post->ID)){
                        the_post_thumbnail('property-thumb-image');}
					else {
						inspiry_image_placeholder( 'property-thumb-image' );
                    }
                echo "</a>
                <figcaption>
                  ";
                    if(!empty( $status_terms )){
                        $status_count = 0;
                        foreach( $status_terms as $term ){
                            if( $status_count > 0 ){
                                echo ', ';
                            }
                            echo $term->name;
                            $status_count++;
                        }
                    }
                    echo "
                </figcaption>
            </figure>


            <div class=\"summary\">
                <h4><a href=\"".get_the_permalink()."\"> ".get_the_title()."</a></h4>
                <h5 class=\"price\">";
                    
                    property_price();
                    
					$type_terms = get_the_terms( $post->ID,"property-type" );
                    if(!empty($type_terms)){
                        echo '<small> - ';
                        foreach($type_terms as $type_term){
                            echo $type_term->name;
                        }
                        echo '</small>';
                    }
                    echo "
                </h5>
                <p>";
				framework_excerpt(20);
				echo "</p>";
                echo"<a class=\"more-details\" href=\"".get_the_permalink()."\">More Details<i class=\"fa fa-caret-right\"></i></a>
            </div>

            <div class=\"property-meta\">";
               get_template_part('property-details/property-metas');
            echo"</div>

        </article>";
		
		
		endwhile;
		}
		}
		else{
			echo "<div class=\"none-found\">Nothing found...!!</div>";
		}
		unset($s);
	}
	
	
	/*----------------If only price, size  and bedrooms selected----------------------------------*/
	/*if($min_price != '' && $max_price != '' && $min_size != '' && $max_size != '' && $bedroom != '' && $bathrooms == '' & $property_type ==''  )
	{
		 $sql2 = "select a.ID from wp_posts as a INNER JOIN wp_postmeta as b ON a.ID = b.post_id  AND b.meta_key = 'REAL_HOMES_property_size'  AND b.meta_value BETWEEN ".$min_size." AND ".$max_size." AND a.post_parent = '".$parent_ID."' AND post_type='property' ";
		 $sql3 = "select a.ID from wp_posts as a INNER JOIN wp_postmeta as b ON a.ID = b.post_id   AND  b.meta_key = 'REAL_HOMES_property_price'  AND b.meta_value BETWEEN ".$min_price." AND ".$max_price." AND a.post_parent = '".$parent_ID."' AND post_type='property'";
		 $sql4 = "select a.ID from wp_posts as a INNER JOIN wp_postmeta as b ON a.ID = b.post_id   AND  b.meta_key = 'REAL_HOMES_property_bedrooms'  AND b.meta_value ='".$bedroom."' AND a.post_parent = '".$parent_ID."' AND post_type='property'";
		 
		$sql12 = $wpdb->get_results($sql2);
		$sql13 = $wpdb->get_results($sql3);
		$sql14 = $wpdb->get_results($sql4);
		// echo $wpdb->last_query;
		foreach($sql12 as $sql){
			foreach($sql13 as $sq){
				foreach($sql14 as $bed){
				if(($sql->ID == $sq->ID)){
					if($sq->ID == $bed->ID){
						$s[] = $sql->ID;
					}
				}
				}
			}
			
		}
		
		
		//echo "<pre>"; print_r($s); echo "</pre>";
		
		wp_reset_query();
		if(!empty($s)){
		 $child_properties_query = query_posts( array('post_type'=>'property','post__in' => $s, 'posts_per_page' => -1) );
		//echo "<pre>"; print_r($child_properties_query); echo "</pre>";
		if(have_posts()){
		while ( have_posts() ) :
        the_post();
           $status_terms = get_the_terms( $post->ID,"property-status" );
		
		echo " <article class=\"property-item clearfix\">

            <figure>
                <a href=\"".get_the_permalink()."\" title=\"".get_the_title()."\">";
                    if(has_post_thumbnail($post->ID)){
                        the_post_thumbnail('property-thumb-image');}
					else {
						inspiry_image_placeholder( 'property-thumb-image' );
                    }
                echo "</a>
                <figcaption>
                  ";
                    if(!empty( $status_terms )){
                        $status_count = 0;
                        foreach( $status_terms as $term ){
                            if( $status_count > 0 ){
                                echo ', ';
                            }
                            echo $term->name;
                            $status_count++;
                        }
                    }
                    echo "
                </figcaption>
            </figure>


            <div class=\"summary\">
                <h4><a href=\"".get_the_permalink()."\"> ".get_the_title()."</a></h4>
                <h5 class=\"price\">";
                    
                    property_price();
                    
					$type_terms = get_the_terms( $post->ID,"property-type" );
                    if(!empty($type_terms)){
                        echo '<small> - ';
                        foreach($type_terms as $type_term){
                            echo $type_term->name;
                        }
                        echo '</small>';
                    }
                    echo "
                </h5>
                <p>";
				framework_excerpt(20);
				echo "</p>";
                echo"<a class=\"more-details\" href=\"".get_the_permalink()."\">More Details<i class=\"fa fa-caret-right\"></i></a>
            </div>

            <div class=\"property-meta\">";
               get_template_part('property-details/property-metas');
            echo"</div>

        </article>";
		
		
		endwhile;
		}
		}
		else{
			echo "<div class=\"none-found\">Nothing found...!!</div>";
		}
		unset($s);
	}
	*/

die();
}
	
