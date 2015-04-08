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
							  Enquiry about this property
							</button>
							<?php
                        } else {
                            echo $agent_description;
                            ?>
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
			<!-- Modal -->
			<div class="modal fade round-none" id="myModal" tabindex="-1" role="dialog"  aria-labelledby="myLargeModalLabel" aria-hidden="true">
			  <div class="modal-dialog">
				<div class="modal-content">
				  <div class="modal-header sky-blue">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<h4 class="modal-title color-white" id="myModalLabel">New Enquiry</h4>
				  </div>
				  <div class="modal-body">
				  <div class="enquiry-grid">
					<div class="form-left">
					
				
						<div class="enquiry-form">
							
							<form id="agent-contact-form" class="contact-form-small" method="post" action="<?php echo site_url(); ?>/wp-admin/admin-ajax.php">

								<input type="text" name="name" id="name" placeholder="<?php _e('Name', 'framework'); ?>" class="required" title="<?php _e('* Please provide your name', 'framework'); ?>" value="<?php echo $_COOKIE['name']; ?>">

								<input type="text" name="email" id="email" placeholder="<?php _e('Email', 'framework'); ?>" class="email required" title="<?php _e('* Please provide valid email address', 'framework'); ?>" value="<?php echo $_COOKIE['email']; ?>">

								<input type="text" name="phone" id="phone" placeholder="<?php _e('Phone', 'framework'); ?>" class="required" title="<?php _e('* Please provide a valid phone number', 'framework'); ?>" value="<?php echo $_COOKIE['phone']; ?>" >
								
								
								<select name="country" id="country" class="required" >
										<option value="Singapore">Singapore</option>
										<option value="Hong Kong">Hong Kong</option>
										<option value="China">China</option>
										<option value="Malaysia">Malaysia</option>
										<option value="Indonesia">Indonesia</option>
										
										<option value="Afganistan">Afghanistan</option>
										<option value="Albania">Albania</option>
										<option value="Algeria">Algeria</option>
										<option value="American Samoa">American Samoa</option>
										<option value="Andorra">Andorra</option>
										<option value="Angola">Angola</option>
										<option value="Anguilla">Anguilla</option>
										<option value="Antigua &amp; Barbuda">Antigua &amp; Barbuda</option>
										<option value="Argentina">Argentina</option>
										<option value="Armenia">Armenia</option>
										<option value="Aruba">Aruba</option>
										<option value="Australia">Australia</option>
										<option value="Austria">Austria</option>
										<option value="Azerbaijan">Azerbaijan</option>
										<option value="Bahamas">Bahamas</option>
										<option value="Bahrain">Bahrain</option>
										<option value="Bangladesh">Bangladesh</option>
										<option value="Barbados">Barbados</option>
										<option value="Belarus">Belarus</option>
										<option value="Belgium">Belgium</option>
										<option value="Belize">Belize</option>
										<option value="Benin">Benin</option>
										<option value="Bermuda">Bermuda</option>
										<option value="Bhutan">Bhutan</option>
										<option value="Bolivia">Bolivia</option>
										<option value="Bonaire">Bonaire</option>
										<option value="Bosnia &amp; Herzegovina">Bosnia &amp; Herzegovina</option>
										<option value="Botswana">Botswana</option>
										<option value="Brazil">Brazil</option>
										<option value="British Indian Ocean Ter">British Indian Ocean Ter</option>
										<option value="Brunei">Brunei</option>
										<option value="Bulgaria">Bulgaria</option>
										<option value="Burkina Faso">Burkina Faso</option>
										<option value="Burundi">Burundi</option>
										<option value="Cambodia">Cambodia</option>
										<option value="Cameroon">Cameroon</option>
										<option value="Canada">Canada</option>
										<option value="Canary Islands">Canary Islands</option>
										<option value="Cape Verde">Cape Verde</option>
										<option value="Cayman Islands">Cayman Islands</option>
										<option value="Central African Republic">Central African Republic</option>
										<option value="Chad">Chad</option>
										<option value="Channel Islands">Channel Islands</option>
										<option value="Chile">Chile</option>
										
										<option value="Christmas Island">Christmas Island</option>
										<option value="Cocos Island">Cocos Island</option>
										<option value="Colombia">Colombia</option>
										<option value="Comoros">Comoros</option>
										<option value="Congo">Congo</option>
										<option value="Cook Islands">Cook Islands</option>
										<option value="Costa Rica">Costa Rica</option>
										<option value="Cote DIvoire">Cote D'Ivoire</option>
										<option value="Croatia">Croatia</option>
										<option value="Cuba">Cuba</option>
										<option value="Curaco">Curacao</option>
										<option value="Cyprus">Cyprus</option>
										<option value="Czech Republic">Czech Republic</option>
										<option value="Denmark">Denmark</option>
										<option value="Djibouti">Djibouti</option>
										<option value="Dominica">Dominica</option>
										<option value="Dominican Republic">Dominican Republic</option>
										<option value="East Timor">East Timor</option>
										<option value="Ecuador">Ecuador</option>
										<option value="Egypt">Egypt</option>
										<option value="El Salvador">El Salvador</option>
										<option value="Equatorial Guinea">Equatorial Guinea</option>
										<option value="Eritrea">Eritrea</option>
										<option value="Estonia">Estonia</option>
										<option value="Ethiopia">Ethiopia</option>
										<option value="Falkland Islands">Falkland Islands</option>
										<option value="Faroe Islands">Faroe Islands</option>
										<option value="Fiji">Fiji</option>
										<option value="Finland">Finland</option>
										<option value="France">France</option>
										<option value="French Guiana">French Guiana</option>
										<option value="French Polynesia">French Polynesia</option>
										<option value="French Southern Ter">French Southern Ter</option>
										<option value="Gabon">Gabon</option>
										<option value="Gambia">Gambia</option>
										<option value="Georgia">Georgia</option>
										<option value="Germany">Germany</option>
										<option value="Ghana">Ghana</option>
										<option value="Gibraltar">Gibraltar</option>
										<option value="Great Britain">Great Britain</option>
										<option value="Greece">Greece</option>
										<option value="Greenland">Greenland</option>
										<option value="Grenada">Grenada</option>
										<option value="Guadeloupe">Guadeloupe</option>
										<option value="Guam">Guam</option>
										<option value="Guatemala">Guatemala</option>
										<option value="Guinea">Guinea</option>
										<option value="Guyana">Guyana</option>
										<option value="Haiti">Haiti</option>
										<option value="Hawaii">Hawaii</option>
										<option value="Honduras">Honduras</option>
									
										<option value="Hungary">Hungary</option>
										<option value="Iceland">Iceland</option>
										<option value="India">India</option>
										
										<option value="Iran">Iran</option>
										<option value="Iraq">Iraq</option>
										<option value="Ireland">Ireland</option>
										<option value="Isle of Man">Isle of Man</option>
										<option value="Israel">Israel</option>
										<option value="Italy">Italy</option>
										<option value="Jamaica">Jamaica</option>
										<option value="Japan">Japan</option>
										<option value="Jordan">Jordan</option>
										<option value="Kazakhstan">Kazakhstan</option>
										<option value="Kenya">Kenya</option>
										<option value="Kiribati">Kiribati</option>
										<option value="Korea North">Korea North</option>
										<option value="Korea Sout">Korea South</option>
										<option value="Kuwait">Kuwait</option>
										<option value="Kyrgyzstan">Kyrgyzstan</option>
										<option value="Laos">Laos</option>
										<option value="Latvia">Latvia</option>
										<option value="Lebanon">Lebanon</option>
										<option value="Lesotho">Lesotho</option>
										<option value="Liberia">Liberia</option>
										<option value="Libya">Libya</option>
										<option value="Liechtenstein">Liechtenstein</option>
										<option value="Lithuania">Lithuania</option>
										<option value="Luxembourg">Luxembourg</option>
										<option value="Macau">Macau</option>
										<option value="Macedonia">Macedonia</option>
										<option value="Madagascar">Madagascar</option>
										
										<option value="Malawi">Malawi</option>
										<option value="Maldives">Maldives</option>
										<option value="Mali">Mali</option>
										<option value="Malta">Malta</option>
										<option value="Marshall Islands">Marshall Islands</option>
										<option value="Martinique">Martinique</option>
										<option value="Mauritania">Mauritania</option>
										<option value="Mauritius">Mauritius</option>
										<option value="Mayotte">Mayotte</option>
										<option value="Mexico">Mexico</option>
										<option value="Midway Islands">Midway Islands</option>
										<option value="Moldova">Moldova</option>
										<option value="Monaco">Monaco</option>
										<option value="Mongolia">Mongolia</option>
										<option value="Montserrat">Montserrat</option>
										<option value="Morocco">Morocco</option>
										<option value="Mozambique">Mozambique</option>
										<option value="Myanmar">Myanmar</option>
										<option value="Nambia">Nambia</option>
										<option value="Nauru">Nauru</option>
										<option value="Nepal">Nepal</option>
										<option value="Netherland Antilles">Netherland Antilles</option>
										<option value="Netherlands">Netherlands (Holland, Europe)</option>
										<option value="Nevis">Nevis</option>
										<option value="New Caledonia">New Caledonia</option>
										<option value="New Zealand">New Zealand</option>
										<option value="Nicaragua">Nicaragua</option>
										<option value="Niger">Niger</option>
										<option value="Nigeria">Nigeria</option>
										<option value="Niue">Niue</option>
										<option value="Norfolk Island">Norfolk Island</option>
										<option value="Norway">Norway</option>
										<option value="Oman">Oman</option>
										<option value="Pakistan">Pakistan</option>
										<option value="Palau Island">Palau Island</option>
										<option value="Palestine">Palestine</option>
										<option value="Panama">Panama</option>
										<option value="Papua New Guinea">Papua New Guinea</option>
										<option value="Paraguay">Paraguay</option>
										<option value="Peru">Peru</option>
										<option value="Phillipines">Philippines</option>
										<option value="Pitcairn Island">Pitcairn Island</option>
										<option value="Poland">Poland</option>
										<option value="Portugal">Portugal</option>
										<option value="Puerto Rico">Puerto Rico</option>
										<option value="Qatar">Qatar</option>
										<option value="Republic of Montenegro">Republic of Montenegro</option>
										<option value="Republic of Serbia">Republic of Serbia</option>
										<option value="Reunion">Reunion</option>
										<option value="Romania">Romania</option>
										<option value="Russia">Russia</option>
										<option value="Rwanda">Rwanda</option>
										<option value="St Barthelemy">St Barthelemy</option>
										<option value="St Eustatius">St Eustatius</option>
										<option value="St Helena">St Helena</option>
										<option value="St Kitts-Nevis">St Kitts-Nevis</option>
										<option value="St Lucia">St Lucia</option>
										<option value="St Maarten">St Maarten</option>
										<option value="St Pierre &amp; Miquelon">St Pierre &amp; Miquelon</option>
										<option value="St Vincent &amp; Grenadines">St Vincent &amp; Grenadines</option>
										<option value="Saipan">Saipan</option>
										<option value="Samoa">Samoa</option>
										<option value="Samoa American">Samoa American</option>
										<option value="San Marino">San Marino</option>
										<option value="Sao Tome &amp; Principe">Sao Tome &amp; Principe</option>
										<option value="Saudi Arabia">Saudi Arabia</option>
										<option value="Senegal">Senegal</option>
										<option value="Serbia">Serbia</option>
										<option value="Seychelles">Seychelles</option>
										<option value="Sierra Leone">Sierra Leone</option>
										
										<option value="Slovakia">Slovakia</option>
										<option value="Slovenia">Slovenia</option>
										<option value="Solomon Islands">Solomon Islands</option>
										<option value="Somalia">Somalia</option>
										<option value="South Africa">South Africa</option>
										<option value="Spain">Spain</option>
										<option value="Sri Lanka">Sri Lanka</option>
										<option value="Sudan">Sudan</option>
										<option value="Suriname">Suriname</option>
										<option value="Swaziland">Swaziland</option>
										<option value="Sweden">Sweden</option>
										<option value="Switzerland">Switzerland</option>
										<option value="Syria">Syria</option>
										<option value="Tahiti">Tahiti</option>
										<option value="Taiwan">Taiwan</option>
										<option value="Tajikistan">Tajikistan</option>
										<option value="Tanzania">Tanzania</option>
										<option value="Thailand">Thailand</option>
										<option value="Togo">Togo</option>
										<option value="Tokelau">Tokelau</option>
										<option value="Tonga">Tonga</option>
										<option value="Trinidad &amp; Tobago">Trinidad &amp; Tobago</option>
										<option value="Tunisia">Tunisia</option>
										<option value="Turkey">Turkey</option>
										<option value="Turkmenistan">Turkmenistan</option>
										<option value="Turks &amp; Caicos Is">Turks &amp; Caicos Is</option>
										<option value="Tuvalu">Tuvalu</option>
										<option value="Uganda">Uganda</option>
										<option value="Ukraine">Ukraine</option>
										<option value="United Arab Erimates">United Arab Emirates</option>
										<option value="United Kingdom">United Kingdom</option>
										<option value="United States of America">United States of America</option>
										<option value="Uraguay">Uruguay</option>
										<option value="Uzbekistan">Uzbekistan</option>
										<option value="Vanuatu">Vanuatu</option>
										<option value="Vatican City State">Vatican City State</option>
										<option value="Venezuela">Venezuela</option>
										<option value="Vietnam">Vietnam</option>
										<option value="Virgin Islands (Brit)">Virgin Islands (Brit)</option>
										<option value="Virgin Islands (USA)">Virgin Islands (USA)</option>
										<option value="Wake Island">Wake Island</option>
										<option value="Wallis &amp; Futana Is">Wallis &amp; Futana Is</option>
										<option value="Yemen">Yemen</option>
										<option value="Zaire">Zaire</option>
										<option value="Zambia">Zambia</option>
										<option value="Zimbabwe">Zimbabwe</option>
								</select>

								<span class="con-method">Preffered contact method : </span>
								<input type="radio" name="con-method" id="con-method" style="margin-left:0px;"  class="required" title="<?php _e('* select your preffered contact method', 'framework'); ?>" value="email" checked="checked" > Email
								
								<input type="radio" name="con-method" id="con-method"  class="required" title="<?php _e('* select your preffered contact method', 'framework'); ?>" value="phone"> Phone 
								
								<input type="radio" name="con-method" id="con-method"  class="required" title="<?php _e('* select your preffered contact method', 'framework'); ?>" value="other"> Other
								<div class="gap-seperator"></div>

								<?php
								/* Display recaptcha if enabled and configured from theme options */
								get_template_part('recaptcha/custom-recaptcha');
								$author_id = get_post_meta($post->ID,'REAL_HOMES_agents',true);
								$author_name = get_the_title($author_id);
								?>
								
								<input type="hidden" name="nonce" value="<?php echo wp_create_nonce('agent_message_nonce'); ?>"/>
								<input type="hidden" name="target" value="<?php echo antispambot($agent_email); ?>">
								<input type="hidden" name="agent_email2" value="<?php echo antispambot($agent_email2); ?>">
								<input type="hidden" name="agent_email3" value="<?php echo antispambot($agent_email3); ?>">
								<input type="hidden" name="action" value="send_message_to_agent" />
								<input type="hidden" name="author_name" value="<?php echo $author_name; ?>" />
								<input type="hidden" name="property_id" value="<?php echo get_post_meta($post->ID,'REAL_HOMES_property_id',true) ?>" />
								<input type="hidden" name="property_title" value="<?php echo $property_title; ?>" />
								<input type="hidden" name="property_permalink" value="<?php echo $property_permalink; ?>" />
								<input type="hidden" name="property_price" value="<?php property_price(); ?>" />
								<input type="hidden" name="img_url" value="<?php $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' ); echo $image[0];?>" />
								<input type="submit" id="con-agent-btn" value="<?php _e('Send message','framework'); ?>"  name="submit" class="real-btn ful-width-btn">
								
								
								<img src="<?php echo get_template_directory_uri(); ?>/images/loading.gif" id="contact-loader" alt="Loading..." style="display:none;">

							</form>

							<div class="error-container"></div>
							<div id="message-sent"></div>
						</div>
					</div>
					<div class="form-right">
						<?php
							if( has_post_thumbnail( $post->ID ) ) {
								the_post_thumbnail( 'grid-view-image' );
							}
							the_title();

						?>
							<div class="prop-address">
							<?php $status_terms = get_the_terms( $post->ID,"property-status" );
																			
								if(!empty( $status_terms )){
									$status_count = 0;
									foreach( $status_terms as $term ){
										if( $status_count > 0 ){
											echo ', ';
										}
										echo "<span class=property-status-name>".$term->name."</span>";
										$status_count++;
									}
								}else{
									echo '&nbsp;';
								}
								 echo "<br />";
								 echo "<span class=property-address>".get_post_meta($post->ID,'REAL_HOMES_property_address',true)."</span>";
								 echo "<br />";
								 echo"<span class=property-price>";
								 property_price();
								 echo"</span>";
							?>
							
						</div>
					</div>
					<div class="clearfix"></div>
					
				  </div>
				 
				</div>
			  </div>
			</div>
		</div>
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