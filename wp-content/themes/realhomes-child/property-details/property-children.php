<?php
global $post;

$property_children_args = array(
    'post_type' => 'property',
    'posts_per_page' => -1,
    'post_parent' => $post->ID
);

$child_properties_query = new WP_Query( $property_children_args );

if ( $child_properties_query->have_posts() ) :
    ?>
	<div class="filter-grid child-properties">
		<h3>Filter properties (<?php echo $child_properties_query->post_count;?>)</h3>
		<div class="filter-form">
			
			
			<form action="" method="post">
				<div class="left-filter">
					<div class="field-container">
						<div class="label">Price : </div>
						<div class="price-con">
							<!-- <div id="priceslider"></div> -->
							<b><?php echo nice_number(1000)?></b> <input id="priceslider" type="text" class="span2" value="" data-slider-min="1000" data-slider-max="1500000" data-slider-step="5" data-slider-value="[1000,1500000]"/> <b> <?php echo nice_number(1500000)?></b>
						</div>
						<input type="hidden" id="slideText" value="1000" name="min_price" />
						<input type="hidden" id="slideText1" value="1500000" name="max_price" />
						<div class="clearfix"></div>
					</div>
				
					<!-- <div class="field-container cus-margin-top">
						<div class="label">Size in Sq.Ft. :</div>
						<div class="price-con">
							<div id="sizeslider"></div>
						</div>
						<!-- <input type="text" class="span2" id="test_slider" value="" data-slider-min="-20" data-slider-max="20" data-slider-step="1" data-slider-value="-14" data-slider-orientation="vertical" data-slider-selection="after"data-slider-tooltip="hide"> -->
						<!-- <div class="clearfix"></div>
						<input type="text" id="sizeText" name="min_size" value="5010" class="display_none" />
						<input type="text" id="sizeText1" name="max_size" value="15000" class="display_none" />
					</div> -->			
				
				</div>
				<div class="right-filter">
					<div class="field-container ">
						
						<div class="price-con">
							<input type="hidden" name="parent_id" id="parent_id" value="<?php echo $post->ID; ?>" />
							<select name="bedroom" id="bedroom" class="display_none">
								<option value="">--Select--</option>
								<?php for($i=1;$i<=5;$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; if($i == 1){ echo " Bedroom"; } else { echo " Bedrooms"; } ?> </option>
								<?php } ?>
							</select>
							<select name="bathrooms" id="bathrooms" class="display_none">
								<option value="">--Select--</option>
								<?php for($i=1;$i<=5;$i++){ ?>
								<option value="<?php echo $i; ?>"><?php echo $i; if($i == 1){ echo " Bathroom"; } else { echo " Bathrooms"; } ?> </option>
								<?php } ?>
							</select>
							<?php
							$taxonomies = array( 
								'property-type',
									);

							$args = array(
								'orderby'           => 'name', 
								'order'             => 'ASC',
								'hide_empty'        => true, 
								'exclude'           => array(), 
								'exclude_tree'      => array(), 
								'include'           => array(),
								'number'            => '', 
								'fields'            => 'all', 
								'slug'              => '',
								'parent'            => '',
								'hierarchical'      => true, 
								'child_of'          => 0, 
								'get'               => '', 
								'name__like'        => '',
								'description__like' => '',
								'pad_counts'        => false, 
								'offset'            => '', 
								'search'            => '', 
								'cache_domain'      => 'core'
							); 

							$terms = get_terms($taxonomies, $args);
							echo "<select name=\"property_type\" id=\"property_type\" class=\"display_none\"><option value=\"\">--Select--</option>";
								
							foreach($terms as $pro_type):
							?>
								<option value="<?php echo $pro_type->slug; ?>"><?php echo $pro_type->name; ?></option>
							<?php endforeach; 
							echo "</select>";
							?>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="bedroom_select" data-toggle="dropdown" aria-expanded="true">
									Bedrooms <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="bedroom_select">
									<?php for($i=1;$i<=5;$i++){ ?>
									<li role="presentation"><a role="menuitem" onclick="select_bedroom(<?php echo $i; ?>)" tabindex="-1" href="javascript:void(0);"><?php echo $i; if($i == 1){ echo " Bedroom"; } else { echo " Bedrooms"; } ?></a></li>
									<?php } ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="bathrooms_select" data-toggle="dropdown" aria-expanded="true">
									Bathrooms <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="bathrooms_select">
									<?php for($i=1;$i<=5;$i++){ ?>
									<li role="presentation"><a role="menuitem" onclick="select_bathrooms(<?php echo $i; ?>)" tabindex="-1" href="javascript:void(0);"><?php echo $i; if($i == 1){ echo " Bathroom"; } else { echo " Bathrooms"; } ?></a></li>
									<?php } ?>
								</ul>
							</div>
							<div class="dropdown">
								<button class="btn btn-default dropdown-toggle" type="button" id="property_type_select" data-toggle="dropdown" aria-expanded="true">
									Property type <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu" aria-labelledby="property_type_select">
									<?php foreach($terms as $pro_type): ?>
									<li role="presentation"><a role="menuitem" onclick="select_property_type('<?php echo $pro_type->slug; ?>')" tabindex="-1" href="javascript:void(0);"><?php echo $pro_type->name; ?></a></li>
									<?php endforeach; ?>
								</ul>
							</div>
							<div class="dropdown">
								<div class="loader">
									<input type="button" name="submit" id="filtersubmit" value="Search" class=" real-btn btn" />
									<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" id="filter-loader" alt="Loading...">
								</div>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
				</div>
			</form>
			
		</div>
		
	</div>
	<?php if(!isset($_POST['submit'])): ?>
    <div class="child-properties clearfix ">
    <?php
    $child_properties_title = get_option('theme_child_properties_title');
    if( !empty($child_properties_title) ){
        ?><h3><?php echo $child_properties_title; ?></h3><?php
    }
	?>
	<div class="child-properties-add">
	<?php
    while ( $child_properties_query->have_posts() ) :
        $child_properties_query->the_post();
        ?>
		
        <article class="property-item clearfix">

            <figure>
                <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>">
                    <?php
                    if(has_post_thumbnail($post->ID)) {
                        the_post_thumbnail('property-thumb-image');
                    } else {
                        inspiry_image_placeholder( 'property-thumb-image' );
                    }
                    ?>
                </a>
                <figcaption>
                    <?php
                    $status_terms = get_the_terms( $post->ID,"property-status" );
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
                    ?>
                </figcaption>
            </figure>


            <div class="summary">
                <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>
                <h5 class="price">
                    <?php
                    property_price();
                    $type_terms = get_the_terms( $post->ID,"property-type" );
                    if(!empty($type_terms)){
                        echo '<small> - ';
                        foreach($type_terms as $type_term){
                            echo $type_term->name;
                        }
                        echo '</small>';
                    }
                    ?>
                </h5>
                <p><?php framework_excerpt(20); ?></p>
                <a class="more-details" href="<?php the_permalink() ?>"><?php _e('More Details ','framework'); ?><i class="fa fa-caret-right"></i></a>
            </div>

            <div class="property-meta">
                <?php get_template_part('property-details/property-metas'); ?>
            </div>

        </article>
		
        <?php
    endwhile;
    wp_reset_query();
    ?></div></div>
	
	<?php
	endif;
	endif;
	?>