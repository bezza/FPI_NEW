<?php
get_header();

        // Banner Image
        $banner_image_path = "";
        $banner_image_id = get_post_meta( $post->ID, 'REAL_HOMES_page_banner_image', true );
        if( $banner_image_id ){
            $banner_image_path = wp_get_attachment_url($banner_image_id);
        }else{
            $banner_image_path = get_default_banner();
        }
        ?>
        <div class="page-head" style="background-repeat: no-repeat;background-position: center top;background-image: none; background-size: cover; margin-bottom:10px; padding-top:10px;">
            <?php if(!('true' == get_option('theme_banner_titles'))): ?>
            <div class="container">
                <div class="wrap clearfix">
                    <h1 class="page-title"><span><?php _e('Property Details', 'framework'); ?></span></h1>
                    <p><?php
                        the_title();

                        if( !function_exists('display_parent_locations') ){
                            function display_parent_locations($ct_trm){
                                if( !empty($ct_trm->parent) ){
                                    $parent_location = get_term( $ct_trm->parent, 'property-city' );
                                    echo ' - '. $parent_location->name;
                                    display_parent_locations($parent_location); // recursive call
                                }
                            }
                        }

                        /* Property City */
                        $city_terms = get_the_terms( $post->ID,"property-city" );
                        if(!empty($city_terms)){
                            foreach($city_terms as $ct_trm){
                                echo ' - '. $ct_trm->name;
                                display_parent_locations($ct_trm);
                                break;
                            }
                        }
                        ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div><!-- End Page Head -->
		
		
		
        <!-- Content -->
        <div class="container contents detail">
            <div class="row">
                <div class="span9 main-wrap">

                    <!-- Main Content -->
                    <div class="main">
                        <div id="overview">
                         <?php
                         if ( have_posts() ) :
                             while ( have_posts() ) :
                                the_post();
?>								
							
								<div id="tabs" class="property-details">
											
										  <ul class="tab">
											<li><a href="#tabs-0" class="photos">Photos</a></li>
											<li><a href="#tabs-1" class="floor">Floor Plans</a></li>
											<?php 
											$key_1_value = get_post_meta( $post->ID, 'REAL_HOMES_video_id', true );
											if($key_1_value != ''):
											?>
											<li><a href="#tabs-2" class="video">Video</a></li>
											<?php endif; ?>
											<li><a href="#tabs-3" class="map">map</a></li>
											<li><a href="#tabs-4" class="transport">Transport and Schools</a></li>
										  </ul>
										
  
								  <div id="tabs-0">
									<div id="photo-slider">
										<?php
											
											/*
																* 1. Property Images Slider
																*/
																 $gallery_slider_type = get_post_meta($post->ID, 'REAL_HOMES_gallery_slider_type', true);
																 /* For demo purpose only */
																 if(isset($_GET['slider-type'])){
																	 $gallery_slider_type = $_GET['slider-type'];
																 }
																 if( $gallery_slider_type == 'thumb-on-bottom' ){
																	 get_template_part('property-details/property-slider-two');
																 }else{
																	 get_template_part('property-details/property-slider');
																 }
										?>
									</div>
								  
								  </div>
								  <div id="tabs-1">
									<div id="floor-plan">
										<?php 
											get_template_part('property-details/property-floor-plan');
										?>
									</div>	
								  </div>
								  <?php 
								  if($key_1_value != ''):
								  ?>
								  <div id="tabs-2">
									
									<iframe title="YouTube video player" class="youtube-player" type="text/html" 
									width="100%" height="450" src="http://www.youtube.com/embed/<?php echo $key_1_value; ?>"
									frameborder="0" allowFullScreen></iframe>
								  </div>
								  <?php endif; ?>
								  <div id="tabs-3" >
									<?php
											$display_google_map = get_option('theme_display_google_map');
											$display_social_share = get_option('theme_display_social_share');
											global $post;
											$property_location = get_post_meta($post->ID,'REAL_HOMES_property_location',true);
											$property_address = get_post_meta($post->ID,'REAL_HOMES_property_address',true);

											if( $property_address && !empty($property_location) && $display_google_map == 'true')
											{

												$lat_lng = explode(',',$property_location);

												/* Property Map Icon Based on Property Type */
												$property_type_slug = 'single-family-home'; // Default Icon Slug
												$property_marker_icon = '';

												$type_terms = get_the_terms( $post->ID,"property-type" );
												if(!empty($type_terms)){
													foreach($type_terms as $typ_trm){
														$property_type_slug = $typ_trm->slug;
														break;
													}
												}

												if( file_exists( get_template_directory().'/images/map/'.$property_type_slug.'-map-icon.png' ) ){
													$property_marker_icon = get_template_directory_uri().'/images/map/'.$property_type_slug.'-map-icon.png';
												}else{
													$property_marker_icon = get_template_directory_uri().'/images/map/single-family-home-map-icon.png';
												}

												$property_map_title = get_option('theme_property_map_title');
												if( !empty($property_map_title) ){
													?><!--<span class="map-label"><?php //echo $property_map_title; ?></span>--><?php
												}
												?>
												<div id="property_map" ></div>
												<script>
													var propertyMap,propertyLocation;
													/* Property Detail Page - Google Map for Property Location */
													function initialize_property_map(){
														propertyLocation = new google.maps.LatLng(<?php echo $lat_lng[0]; ?>,<?php echo $lat_lng[1]; ?>);
														var propertyMapOptions = {
															center: propertyLocation,
															zoom: 15,
															mapTypeId: google.maps.MapTypeId.ROADMAP,
															scrollwheel: false
														};
														 propertyMap = new google.maps.Map(document.getElementById("property_map"), propertyMapOptions);
														 
														var propertyMarker = new google.maps.Marker({
															position: propertyLocation,
															map: propertyMap,
															icon: "<?php echo $property_marker_icon; ?>"
														});
														
														 setTimeout(function()
																	   {
															var center = propertyMap.getCenter();
															google.maps.event.trigger(propertyMap, "resize");
															propertyMap.setCenter(center);
																	   },50);
														
														
													}
													jQuery('a[href="#tabs-3"]').on('click',function(event){
													initialize_property_map();
													
													});
													
													
													
													
												</script>

												<?php
											}
										 ?>
								  </div>
								   <div id="tabs-4">
									<!--<span rel-val="airport">Airport</span>
									<span rel-val="subway_station">Tube</span>
									<span rel-val="school">School</span>
									<span rel-val="university">University</span>-->
								   
									
									 <script>
										var map;
										var infowindow;
										var near_place = '';
										jQuery("#tabs-4 span").click(function(){
											if(jQuery(this).hasClass('active-span')){
												jQuery(this).removeClass('active-span');
												//initialize();
												
											}
											else{
												jQuery('#tabs-4 span').removeClass('active-span');
												jQuery(this).addClass('active-span');
												var val = jQuery(this).attr('rel-val');
												//initialize1(val);
												//console.log(val);
											}
										});

										function initialize1() {
										  var pyrmont = new google.maps.LatLng(<?php echo $lat_lng[0]; ?>,<?php echo $lat_lng[1]; ?>);
										var propertyMapOptions = {
															center: pyrmont,
															zoom: 15,
															mapTypeId: google.maps.MapTypeId.ROADMAP,
															scrollwheel: false
														};
										  map = new google.maps.Map(document.getElementById('map-canvas'), {
											center: pyrmont,
											zoom: 15
										  },propertyMapOptions);
										  var propertyMarker = new google.maps.Marker({
															position: pyrmont,
															map: map,
															icon: "<?php echo $property_marker_icon; ?>"
														});

										  var request = {
											location: pyrmont,
											radius: 2000,
											types: ["airport","subway_station","school","university"]
										  };
										  infowindow = new google.maps.InfoWindow();
										  var service = new google.maps.places.PlacesService(map);
										  service.nearbySearch(request, callback);
										  
											function callback(results, status) {
											  if (status == google.maps.places.PlacesServiceStatus.OK) {
												for (var i = 0; i < results.length; i++) {
												  createMarker(results[i]);
												}
											  }
											}
										  
										  setTimeout(function()
												   {
										var center = map.getCenter();
										google.maps.event.trigger(map, "resize");
										map.setCenter(center);
												   },50);
										  
										}
										function initialize() {
										  var pyrmont = new google.maps.LatLng(<?php echo $lat_lng[0]; ?>,<?php echo $lat_lng[1]; ?>);
										var propertyMapOptions = {
															center: pyrmont,
															zoom: 15,
															mapTypeId: google.maps.MapTypeId.ROADMAP,
															scrollwheel: false
														};
										  map = new google.maps.Map(document.getElementById('map-canvas'), {
											center: pyrmont,
											zoom: 15
										  },propertyMapOptions);
										  var propertyMarker = new google.maps.Marker({
															position: pyrmont,
															map: map,
															icon: "<?php echo $property_marker_icon; ?>"
														});

										 
										  infowindow = new google.maps.InfoWindow();
										  var service = new google.maps.places.PlacesService(map);
										  
										  
										  setTimeout(function()
												   {
										var center = map.getCenter();
										google.maps.event.trigger(map, "resize");
										map.setCenter(center);
												   },50);
										  
										}


										function createMarker(place) {
										  var placeLoc = place.geometry.location;
										  var marker = new google.maps.Marker({
											map: map,
											position: place.geometry.location
										  });

										  google.maps.event.addListener(marker, 'click', function() {
											
											infowindow.setContent(place.name);
											
											infowindow.open(map, this);
										  });
										}

										//google.maps.event.addDomListener(window, 'load', initialize);
										jQuery('a[href="#tabs-4"]').on('click',function(event){
													initialize1();
													
													});
																				
											</script>
											
										<div id="map-canvas"></div>	
									
								  </div>
								</div>
								<?php
                                /*
                                * 1. Property Images Slider
                                */
                                // $gallery_slider_type = get_post_meta($post->ID, 'REAL_HOMES_gallery_slider_type', true);
                                 /* For demo purpose only */
                                // if(isset($_GET['slider-type'])){
                                //     $gallery_slider_type = $_GET['slider-type'];
                                // }
                                // if( $gallery_slider_type == 'thumb-on-bottom' ){
                                //     get_template_part('property-details/property-slider-two');
                                // }else{
                                    // get_template_part('property-details/property-slider');
                                // }


                                /*
                                * 2. Property Information Bar, Icons Bar, Text Contents and Features
                                */
                                get_template_part('property-details/property-contents');

                                /*
                                * 3. Property Video
                                */
                                //get_template_part('property-details/property-video');

                                 /*
                                 * 4. Property Map
                                 */
                                 //get_template_part('property-details/property-map');

                                 /*
                                 * 5. Property Attachments
                                 */
                                 get_template_part('property-details/property-attachments');

                                 /*
                                 * 6. Child Properties
                                 */
                                 get_template_part('property-details/property-children');

                                 /*
                                 * 7. Property Agent
                                 */
                                 $theme_property_detail_variation = get_option('theme_property_detail_variation');
                                 /* For demo purpose only */
                                 if(isset($_GET['variation'])){
                                     $theme_property_detail_variation = $_GET['variation'];
                                 }
                                 if( $theme_property_detail_variation != "agent-in-sidebar" ){
                                    get_template_part('property-details/property-agent');
                                 }

                             endwhile;
                         endif;
                         ?>
                        </div>

                    </div><!-- End Main Content -->

                    <?php
                    /*
                     * 8. Similar Properties
                     */
                    get_template_part('property-details/similar-properties');
                    ?>

                </div> <!-- End span9 -->

                <?php
                if( $theme_property_detail_variation == "agent-in-sidebar" ) {
                    ?>
                    <div class="span3 sidebar-wrap">
						<!-- <div class="near-locations">
							<section class="widget">
								<h3 class="title locations">Nearest Transports</h3>
								<div class="location-grid">
									<?php //get_template_part('property-details/property-near-station'); ?>
								</div>
							</section>
						</div>
						<div class="near-locations">
							<section class="widget">
								<h3 class="title locations">Market Information</h3>
								<div class="location-grid">
									<!-- <form action="" method="post" class="market-info-form">
										<div class="field-container-sidebar">
											<div class="label-sidebar">Property Type : </div>
											<div class="price-con-sidebar">
												<select id="property_for" name="property_for">
													<option value="buy">Buy </option>
													<option value="rent">Rent </option>
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										<div class="field-container-sidebar">
											<div class="label-sidebar">Bedroom : </div>
											<div class="price-con-sidebar">
												<select id="beds" name="beds">
													<option value="all">All</option>
													<option value="1">1 Bedroom </option>
													<option value="2">2 Bedrooms </option>
													<option value="3">3 Bedrooms </option>
													<option value="4">4 Bedrooms </option>
													<option value="5">5 Bedrooms </option>
												</select>
											</div>
											<div class="clearfix"></div>
										</div>
										
										<input type="button" data-id="<?php echo get_the_ID();?>" class="real-btn btn" value="Search" id="get_average_price" name="get_average_price">
										<img alt="Loading..." id="average-price-loader" src="<?php echo get_template_directory_uri()?>/images/loading.gif" style="display:none;" />
									</form>
									<div class="average_price_container"></div> --><!--
									<?php //get_template_part('property-details/property-market-information'); ?>
								</div>
							</section>
						</div> -->
                        <!-- Sidebar -->
                        <aside class="sidebar">
                            <?php get_template_part('property-details/property-agent-for-sidebar'); ?>
                            <?php
                            if ( ! dynamic_sidebar( 'property-sidebar' ) ) :
                            endif;
                            ?>
                        </aside>
                        <!-- End Sidebar -->
						
						
                    </div>
                    <?php
                }else{
                    get_sidebar('property');
                }
                ?>
				
            </div><!-- End contents row -->
        </div><!-- End Content -->

<?php get_footer(); ?>