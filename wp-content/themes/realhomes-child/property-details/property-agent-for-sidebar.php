<?php
$agent_display_option = get_post_meta($post->ID, 'REAL_HOMES_agent_display_option',true);

if( $agent_display_option != "none" ){
    $property_title = get_the_title($post->ID);
    $property_permalink = get_permalink($post->ID);

    $display_author = false; // flag to display author info instead of agent info
    $hide_info_box = true;

    $agent_id = null;
    $profile_image_id = null;
    $agent_mobile = null;
    $agent_office_phone = null;
    $agent_office_fax = null;
    $agent_email = null;
    $agent_title_text = null;
    $agent_description = null;

    if($agent_display_option == "my_profile_info"){

        $display_author = true;
        $hide_info_box = false;

        $profile_image_id = intval( get_the_author_meta('profile_image_id') );
        $agent_mobile = get_the_author_meta('mobile_number');
        $agent_office_phone = get_the_author_meta('office_number');
        $agent_office_fax = get_the_author_meta('fax_number');
        $agent_email = get_the_author_meta('user_email');
        $agent_name = get_the_author_meta('display_name');
		
        $agent_title_text = __('Submitted by','framework')." ".get_the_author_meta('display_name');

    }else{
        $property_agent = get_post_meta($post->ID, 'REAL_HOMES_agents',true);
        if( ( !empty($property_agent) ) && ( intval($property_agent) > 0 ) ){
            $hide_info_box = false;

            $agent_id = intval($property_agent);
            $post = get_post($agent_id);
            setup_postdata($post);

            $agent_mobile = get_post_meta($agent_id, 'REAL_HOMES_mobile_number',true);
            $agent_office_phone = get_post_meta($agent_id, 'REAL_HOMES_office_number',true);
            $agent_office_fax = get_post_meta($agent_id, 'REAL_HOMES_fax_number',true);
            $agent_email = get_post_meta($agent_id, 'REAL_HOMES_agent_email',true);
            $agent_email2 = get_post_meta($agent_id, 'REAL_HOMES_agent_email_2',true);
            $agent_email3 = get_post_meta($agent_id, 'REAL_HOMES_agent_email_3',true);
			$agent_name = get_the_title($agent_id);
            $agent_title_text = get_the_title($agent_id);
            $agent_description = get_framework_excerpt(20);

            wp_reset_postdata();
        }
    }


    if( !$hide_info_box ){
        ?>
				
            <section class="widget sticky-sidebar">
					
                <h3 class="title"><?php echo $agent_title_text ?></h3>
                <div class="agent-info">
                    <?php
                    if($display_author){

                        if ( $profile_image_id ) {
                            ?><?php echo wp_get_attachment_image( $profile_image_id, 'agent-image' ); ?><?php
                        } else if(function_exists('get_avatar')) {
                            ?><?php echo get_avatar( $agent_email, '210' ); ?><?php
                        }

                    }else{

                        if(has_post_thumbnail($agent_id)){
                            ?><a href="<?php echo get_permalink($agent_id); ?>"><?php echo get_the_post_thumbnail( $agent_id, 'agent-image'); ?></a><?php
                        }

                    }
                    ?>
                    <ul class="contacts-list">
                        <?php
                        if(!empty($agent_office_phone)){
                            ?><li class="office"><?php _e('Office', 'framework'); ?> : <?php echo $agent_office_phone; ?></li><?php
                        }
                        if(!empty($agent_mobile)){
                            ?><li class="mobile"><?php _e('Mobile', 'framework'); ?> : <?php echo $agent_mobile; ?></li><?php
                        }
                        if(!empty($agent_office_fax)){
                            ?><li class="fax"><?php _e('Fax', 'framework'); ?>  : <?php echo $agent_office_fax; ?></li><?php
                        }
                        ?>
                    </ul>
                    <p>
                        <?php
                        if ( $display_author ) {
                            the_author_meta('description');
                            ?><br/><br/>
						
							<!--<a class="real-btn" href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php _e('Know More','framework'); ?></a>-->
							<button type="button" class="btn btn-primary btn-lg con-developer-btn real-btn" data-toggle="modal" data-target="#myModal">
							  Enquire about this property
							</button>
							<div class="mobile-enq">
								<button type="button" class="btn btn-primary btn-lg con-developer-btn real-btn" data-toggle="modal" data-target="#myModal">
							  Enquire about this property
							</button>
							</div>
							<?php
                        } else {
                            echo $agent_description;
                            ?>
								<!-- Button for mobile version -->
						<div class="mobile-enq">
								<button type="button" class="btn btn-primary btn-lg con-developer-btn real-btn" data-toggle="modal" data-target="#myModal">
							  Enquire about this property
							</button>
						</div>
							<!-- Button trigger modal -->
						<button type="button" class="btn btn-primary btn-lg con-developer-btn real-btn" data-toggle="modal" data-target="#myModal">
						  Enquire about this property
						</button>
							<br/><br/><!--<a class="real-btn" href="<?php echo get_permalink( $agent_id ); ?>"><?php _e('Know More','framework'); ?></a>--><?php
                        }
                        ?>	
                    </p>
                </div>
            </section>
		
			<div style="display:none;" class="mail-chimp">
			<?php get_template_part('property-details/mail-chimp-form'); ?>
			</div>
            <?php
            if(!empty($agent_email)){
                ?>
                <!--<section class="widget enquiry-form">

                    <h3 class="title"><?php _e('Contact developer', 'framework'); ?></h3>
					
						

						
						
						
						
						
                </section>-->
                <?php
            }
    }
}

?>