<?php

/*-----------------------------------------------------------------------------------*/
/*	Enqueue Styles in Child Theme
/*-----------------------------------------------------------------------------------*/
if (!function_exists('inspiry_enqueue_child_styles')) {
    function inspiry_enqueue_child_styles(){
        if ( !is_admin() ) {
            // dequeue and deregister parent default css
            wp_dequeue_style( 'parent-default' );
            wp_deregister_style( 'parent-default' );
            //wp_deregister_script( 'custom' );

            // dequeue parent custom css
            wp_dequeue_style( 'parent-custom' );

            // parent default css
            wp_enqueue_style( 'parent-default', get_template_directory_uri().'/style.css' );

            // parent custom css
            wp_enqueue_style( 'parent-custom' );

            // child default css
            wp_enqueue_style('child-default', get_stylesheet_uri(), array('parent-default'), '1.0', 'all' );

			// child jquery.bxslider.min css
            wp_enqueue_style('jquery-bxslider',  get_stylesheet_directory_uri() . '/css/jquery.bxslider.css', array('child-default'), '1.0', 'all' );
            
            // child jqueri ui css
            wp_enqueue_style('jquery-ui-css',  get_stylesheet_directory_uri() . '/css/jquery-ui.css');
            
			// child bootstrap-slider ui css
			wp_enqueue_style('bootstrap-slider-css',  get_stylesheet_directory_uri() . '/css/bootstrap-slider.css', array(), '2.2.2', 'all');
			
			// child jqueri ui css
            wp_enqueue_style('child-custom-css',  get_stylesheet_directory_uri() . '/css/custom.css');
            
			// child custom css
            wp_enqueue_style('child-custom',  get_stylesheet_directory_uri() . '/child-custom.css', array('child-default'), '1.0', 'all' );
            
            // child jquery.bxslider.min
			wp_enqueue_script('jquery-bxslider-min',  get_stylesheet_directory_uri() . '/js/jquery.bxslider.min.js', array('jquery') );
			
			// child jquery ui js
			wp_enqueue_script('jquery-ui-js',  get_stylesheet_directory_uri() . '/js/jquery-ui.js',array('jquery'));
            
			// child map js
			//wp_enqueue_script('google-map-api', '//maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places,geometry', array('jquery'), '', false);
			
			wp_enqueue_script('bootstrap-slider', get_stylesheet_directory_uri().'/js/bootstrap-slider.js', array('jquery'), false);
			
			// child custom js
			wp_enqueue_script('child-custom-js',  get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), '1.0', true );
			
        }
    }
}
add_action( 'wp_enqueue_scripts', 'inspiry_enqueue_child_styles', PHP_INT_MAX );


add_action( 'admin_init', 'REAL_HOMES_register_child_meta_boxes' );
function REAL_HOMES_register_child_meta_boxes()
{
    // Make sure there's no errors when the plugin is deactivated or during upgrade
    if ( !class_exists( 'RW_Meta_Box' ) )
        return;

    global $meta_boxes;
	$prefix = 'REAL_HOMES_';


	$meta_boxes = array();

	// Property Details Meta Box
	$meta_boxes[] = array(
		// Meta box id, UNIQUE per meta box. Optional since 4.1.5
		'id' => 'property_details',

		// Meta box title - Will appear at the drag and drop handle bar. Required.
		'title' => __('Property Details','framework'),

		// Post types, accept custom post types as well - DEFAULT is array('post'). Optional.
		'pages' => array( 'property' ),

		// Where the meta box appear: normal (default), advanced, side. Optional.
		'context' => 'normal',

		// Order of meta box: high (default), low. Optional.
		'priority' => 'high',

		// List of meta fields
		'fields' => array(
		   
			array(
				'name'             => __('Floor Plan','framework'),
				'id'               => "{$prefix}floor_plan",
				'desc' => __('Provide images for floor plan on property detail page. Images should have minimum size of 770px by 386px for thumbnails on right and 830px by 460px for thumbnails on bottom. ( Bigger images will be cropped automatically )','framework'),
				'type'             => 'image_advanced',
				'max_file_uploads' => 48
			),
			array(
				'id'        => "{$prefix}video_id",
				'name'      => __('Youtube video id','framework'),
				'desc'      => __('Provide youtube video id only','framework'),
				'type'      => 'text',
				'std'       => ""
			),
			array(
				'id'        => "{$prefix}property_yield",
				'name'      => __('Property Yield','framework'),
				'desc'      => __('Provide Property Yield. ( Plesae only provide digits ) Example Value: 5%','framework'),
				'type'      => 'text',
				'std'       => ""
			),
			array(
				'id'        => "{$prefix}development_strapline",
				'name'      => __('Development Strapline','framework'),
				'desc'      => __('Development Strapline. ','framework'),
				'type'      => 'text',
				'std'       => ""
			)
		)
	);
	// Agent Meta Box
	
	$meta_boxes[] = array(

		'id' => 'agent-meta-box',

		'title' => __('Provide Related Information', 'framework'),

		'pages' => array('agent'),

		'context' => 'normal',

		'priority' => 'high',

		'fields' => array(

			array(

				'name' => __('Email Address', 'framework'),

				'id' => "{$prefix}agent_email",

				'desc' => __("Provide Agent Email Address. Agent related messages from contact form on property details page, will be sent on this email address.", "framework"),

				'type' => 'text'

			),
			array(

				'name' => __('2nd Email Address', 'framework'),

				'id' => "{$prefix}agent_email2",

				'desc' => __("Provide Agent Email Address. Agent related messages from contact form on property details page, will be sent on this email address.", "framework"),

				'type' => 'text'

			),
			array(

				'name' => __('3rd Email Address', 'framework'),

				'id' => "{$prefix}agent_email3",

				'desc' => __("Provide Agent Email Address. Agent related messages from contact form on property details page, will be sent on this email address.", "framework"),

				'type' => 'text'

			),
			array(

				'name' => __('Mobile Number', 'framework'),

				'id' => "{$prefix}mobile_number",

				'desc' => __("Provide Agent mobile number", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('Office Number', 'framework'),

				'id' => "{$prefix}office_number",

				'desc' => __("Provide Agent office number", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('Fax Number', 'framework'),

				'id' => "{$prefix}fax_number",

				'desc' => __("Provide Agent fax number", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('Facebook URL', 'framework'),

				'id' => "{$prefix}facebook_url",

				'desc' => __("Provide Agent Facebook URL", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('Twitter URL', 'framework'),

				'id' => "{$prefix}twitter_url",

				'desc' => __("Provide Agent Twitter URL", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('Google Plus URL', 'framework'),

				'id' => "{$prefix}google_plus_url",

				'desc' => __("Provide Agent Google Plus URL", "framework"),

				'type' => 'text'

			),

			array(

				'name' => __('LinkedIn URL', 'framework'),

				'id' => "{$prefix}linked_in_url",

				'desc' => __("Provide Agent LinkedIn URL", "framework"),

				'type' => 'text'

			)

		)

	);
    $meta_boxes = apply_filters('framework_theme_meta',$meta_boxes);
    foreach ( $meta_boxes as $meta_box ){
        new RW_Meta_Box( $meta_box );
    }
}



require_once( get_stylesheet_directory().'/widgets/' . 'property-travel-widget.php');
require_once( get_stylesheet_directory().'/widgets/' . 'property-market-info-widget.php');
require_once( get_stylesheet_directory().'/framework/functions/contact_form_handler.php');
require_once( get_stylesheet_directory().'/framework/functions/property_filter.php');
require_once( get_stylesheet_directory().'/framework/functions/property-submit-handler.php');
/*-----------------------------------------------------------------------------------*/
//	Register Widgets
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'register_child_theme_widgets' ) ){
    function register_child_theme_widgets() {
        register_widget( 'Property_Travel_Widget' );
        register_widget( 'Property_Market_Info_Widget' );
    }
}
add_action( 'widgets_init', 'register_child_theme_widgets' );


function nice_number($n) {
	// first strip any formatting;
	$n = (0+str_replace(",","",$n));

	// is this a number?
	if(!is_numeric($n)) return false;

	// now filter it;
	if($n>=1000000000000) return round(($n/1000000000000),2).' trillion';
	else if($n>=1000000000) return round(($n/1000000000),2).' billion';
	else if($n>=1000000) return round(($n/1000000),2).' m';
	else if($n>=1000) return round(($n/1000),2).' k';

	return number_format($n);
}


/*-----------------------------------------------------------------------------------*/
/*	 add variables in header
/*-----------------------------------------------------------------------------------*/
add_action('wp_head','add_custom_variables');
function add_custom_variables()
{
	?>
	<script type="text/javascript">
	var admin_ajax = '<?php echo admin_url()."admin-ajax.php"?>';
	</script><?php
}
/*-----------------------------------------------------------------------------------*/
/*	 Mailchimp subscribe
/*-----------------------------------------------------------------------------------*/
add_action( 'wp_ajax_mailchimp_subscribe', 'mailchimp_subscribe' );
add_action( 'wp_ajax_nopriv_mailchimp_subscribe', 'mailchimp_subscribe' );

function mailchimp_subscribe(){
	require_once 'property-details/MCAPI.class.php';
	$api = new MCAPI('2e2d8d1415f2c5d5c8554447259a8f34-us8');	
	$merge_vars = array('FNAME'=>$_POST["fname"]);
	
	// Submit subscriber data to MailChimp
	// For parameters doc, refer to: http://apidocs.mailchimp.com/api/1.3/listsubscribe.func.php
	$retval = $api->listSubscribe( 'e321b56a75', $_POST["email"], $merge_vars, 'html', false, true );
	
	if ($api->errorCode){
		echo "<h4>Please try again.</h4>";
		print_r($retval);
		print_r($api);
	} else {
		echo "<h4>Thank you, you have been added to our mailing list.</h4>";
	}
	die();
}

add_action( 'init', 'build_child_taxonomies', 0 );
if( !function_exists( 'build_child_taxonomies' ) ){
function build_child_taxonomies(){
	$london_zones_labels = array('name' => __('London Zones', 'framework'), 'singular_name' => __('London Zones', 'framework'), 'search_items' => __('Search London Zones', 'framework'), 'popular_items' => __('Popular London Zones', 'framework'), 'all_items' => __('All London Zones', 'framework'), 'parent_item' => __('Parent London Zones', 'framework'), 'parent_item_colon' => __('Parent London Zones:', 'framework'), 'edit_item' => __('Edit London Zone', 'framework'), 'update_item' => __('Update London Zone', 'framework'), 'add_new_item' => __('Add New London Zone', 'framework'), 'new_item_name' => __('New London Zone Name', 'framework'), 'separate_items_with_commas' => __('Separate London Zones with commas', 'framework'), 'add_or_remove_items' => __('Add or remove London Zone', 'framework'), 'choose_from_most_used' => __('Choose from the most used London Zones', 'framework'), 'menu_name' => __('London Zones', 'framework'));
	register_taxonomy('london-zone', array('property'), array('hierarchical' => true, 'labels' => $london_zones_labels, 'show_ui' => true, 'query_var' => true, 'rewrite' => array('slug' => __('london-zone', 'framework'))));
}
}



/*-----------------------------------------------------------------------------------*/
/*	Properties Search Filter
/*-----------------------------------------------------------------------------------*/
if(!function_exists('child_real_homes_search')){
    function child_real_homes_search($search_args){
		
        /* taxonomy query and meta query arrays */
        $tax_query = array();
        $meta_query = array();

        /* Keyword Based Search */
        if( isset ( $_GET['keyword'] ) ) {
            $keyword = trim( $_GET['keyword'] );
            if ( ! empty( $keyword ) ) {
                $search_args['s'] = $keyword;
            }
        }

        /* property type taxonomy query */
        if( (!empty($_GET['type'])) && ( $_GET['type'] != 'any') ){
            $tax_query[] = array(
                'taxonomy' => 'property-type',
                'field' => 'slug',
                'terms' => $_GET['type']
            );
        }

        /* property location taxonomy query */
        global $location_select_names;
        $locations_count = count( $location_select_names );
        for ( $l = $locations_count - 1; $l >= 0; $l-- ) {
            if( isset( $_GET[ $location_select_names[$l] ] ) ){
                $current_location = $_GET[ $location_select_names[$l] ];
                if( ( ! empty ( $current_location ) ) && ( $current_location != 'any' ) ){
                    $tax_query[] = array (
                        'taxonomy' => 'property-city',
                        'field' => 'slug',
                        'terms' => $current_location
                    );
                    break;
                }
            }
        }

        /* property feature taxonomy query */
        if ( isset( $_GET['features'] ) ) {
            $required_features_slugs = $_GET['features'];
            if ( is_array ( $required_features_slugs ) ) {

                $slugs_count = count ( $required_features_slugs );
                if ( $slugs_count > 0 ) {

                    /* build an array of existing features slugs to validate required feature slugs */
                    $existing_features_slugs = array();
                    $existing_features = get_terms( 'property-feature', array( 'hide_empty' => false ) );
                    $existing_features_count = count ( $existing_features );
                    if ( $existing_features_count > 0 ) {
                        foreach ($existing_features as $feature) {
                            $existing_features_slugs[] = $feature->slug;
                        }
                    }

                    foreach ( $required_features_slugs as $feature_slug ) {
                        if( in_array( $feature_slug, $existing_features_slugs ) ){  // validate slug
                            $tax_query[] = array (
                                'taxonomy' => 'property-feature',
                                'field' => 'slug',
                                'terms' => $feature_slug
                            );
                        }
                    }
                }
            }

        }

        /* property status taxonomy query */
        if((!empty($_GET['status'])) && ( $_GET['status'] != 'any' ) ){
            $tax_query[] = array(
                'taxonomy' => 'property-status',
                'field' => 'slug',
                'terms' => $_GET['status']
            );
        }

        /* Property Bedrooms Parameter */
        if((!empty($_GET['bedrooms'])) && ( $_GET['bedrooms'] != 'any' ) ){
            $meta_query[] = array(
                'key' => 'REAL_HOMES_property_bedrooms',
                'value' => $_GET['bedrooms'],
                'compare' => '>=',
                'type'=> 'DECIMAL'
            );
        }

        /* Property Bathrooms Parameter */
        if((!empty($_GET['bathrooms'])) && ( $_GET['bathrooms'] != 'any' ) ){
            $meta_query[] = array(
                'key' => 'REAL_HOMES_property_bathrooms',
                'value' => $_GET['bathrooms'],
                'compare' => '>=',
                'type'=> 'DECIMAL'
            );
        }

        /* Property ID Parameter */
        if( isset($_GET['property-id']) && !empty($_GET['property-id'])){
            $property_id = trim($_GET['property-id']);
            $meta_query[] = array(
                'key' => 'REAL_HOMES_property_id',
                'value' => $property_id,
                'compare' => 'LIKE',
                'type'=> 'CHAR'
            );
        }

        /* Logic for Min and Max Price Parameters */
        if( isset($_GET['min-price']) && ($_GET['min-price'] != 'any') && isset($_GET['max-price']) && ($_GET['max-price'] != 'any') ){
            $min_price = doubleval($_GET['min-price']);
            $max_price = doubleval($_GET['max-price']);
            if( $min_price >= 0 && $max_price > $min_price ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_price',
                    'value' => array( $min_price, $max_price ),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                );
            }
        }elseif( isset($_GET['min-price']) && ($_GET['min-price'] != 'any') ){
            $min_price = doubleval($_GET['min-price']);
            if( $min_price > 0 ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_price',
                    'value' => $min_price,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                );
            }
        }elseif( isset($_GET['max-price']) && ($_GET['max-price'] != 'any') ){
            $max_price = doubleval($_GET['max-price']);
            if( $max_price > 0 ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_price',
                    'value' => $max_price,
                    'type' => 'NUMERIC',
                    'compare' => '<='
                );
            }
        }


        /* Logic for Min and Max Area Parameters */
        if( isset($_GET['min-area']) && !empty($_GET['min-area']) && isset($_GET['max-area']) && !empty($_GET['max-area']) ){
            $min_area = intval($_GET['min-area']);
            $max_area = intval($_GET['max-area']);
            if( $min_area >= 0 && $max_area > $min_area ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_size',
                    'value' => array( $min_area, $max_area ),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                );
            }
        }elseif( isset($_GET['min-area']) && !empty($_GET['min-area']) ){
            $min_area = intval($_GET['min-area']);
            if( $min_area > 0 ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_size',
                    'value' => $min_area,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                );
            }
        }elseif( isset($_GET['max-area']) && !empty($_GET['max-area']) ){
            $max_area = intval($_GET['max-area']);
            if( $max_area > 0 ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_size',
                    'value' => $max_area,
                    'type' => 'NUMERIC',
                    'compare' => '<='
                );
            }
        }
		
		/* Logic for Yield Parameters */
		if( isset($_GET['yield']) && !empty($_GET['yield']) ){
            $yield = $_GET['yield'];
            if( $yield == '0-5' ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_yield',
                    'value' => 5,
                    'type' => 'NUMERIC',
                    'compare' => '<='
                );
            }
			elseif( $yield == '5-10' ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_yield',
                    'value' => array( 5, 10 ),
                    'type' => 'NUMERIC',
                    'compare' => 'BETWEEN'
                );
            }
			elseif( $yield == '10' ){
                $meta_query[] = array(
                    'key' => 'REAL_HOMES_property_yield',
                    'value' => 10,
                    'type' => 'NUMERIC',
                    'compare' => '>='
                );
            }
        }
		
		/* property feature taxonomy query */
        if ( isset( $_GET['zone'] ) && $_GET['zone'] != '' && $_GET['location'] == 'london') {
			$tax_query[] = array(
                'taxonomy' => 'london-zone',
                'field' => 'slug',
                'terms' => $_GET['zone']
            );
		}
		
        /* if more than one taxonomies exist then specify the relation */
        $tax_count = count( $tax_query );
        if( $tax_count > 1 ){
            $tax_query['relation'] = 'AND';
        }

        /* if more than one meta query elements exist then specify the relation */
        $meta_count = count( $meta_query );
        if( $meta_count > 1 ){
            $meta_query['relation'] = 'AND';
        }

        if( $tax_count > 0 ){
            $search_args['tax_query'] = $tax_query;
        }

        /* if meta query has some values then add it to base home page query */
        if( $meta_count > 0 ){
            $search_args['meta_query'] = $meta_query;
        }

        /* Sort By Price */
        if( (isset($_GET['min-price']) && ($_GET['min-price'] != 'any')) || ( isset($_GET['max-price']) && ($_GET['max-price'] != 'any') ) ){
            $search_args['orderby'] = 'meta_value_num';
            $search_args['meta_key'] = 'REAL_HOMES_property_price';
            $search_args['order'] = 'ASC';
        }

        return $search_args;
    }
}
add_filter('child_real_homes_search_parameters','child_real_homes_search');

/*-----------------------------------------------------------------------------------*/
/*	Properties sorting
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'child_sort_properties' ) ){
    /**
     * @param $property_query_args
     * @return mixed
     */
    function child_sort_properties($property_query_args){
        if (isset($_GET['sortby'])) {
            $orderby = $_GET['sortby'];
            if ($orderby == 'price-asc') {
                $property_query_args['orderby'] = 'meta_value_num';
                $property_query_args['meta_key'] = 'REAL_HOMES_property_price';
                $property_query_args['order'] = 'ASC';
            } else if ($orderby == 'price-desc') {
                $property_query_args['orderby'] = 'meta_value_num';
                $property_query_args['meta_key'] = 'REAL_HOMES_property_price';
                $property_query_args['order'] = 'DESC';
            } else if ($orderby == 'date-asc') {
                $property_query_args['orderby'] = 'date';
                $property_query_args['order'] = 'ASC';
            } else if ($orderby == 'date-desc') {
                $property_query_args['orderby'] = 'date';
                $property_query_args['order'] = 'DESC';
            } else if ($orderby == 'yield-asc') {
                $property_query_args['orderby'] = 'meta_value_num';
                $property_query_args['meta_key'] = 'REAL_HOMES_property_yield';
                $property_query_args['order'] = 'ASC';
            } else if ($orderby == 'yield-desc') {
                $property_query_args['orderby'] = 'meta_value_num';
                $property_query_args['meta_key'] = 'REAL_HOMES_property_yield';
                $property_query_args['order'] = 'DESC';
            }
        }
        return $property_query_args;
    }
}

/*-----------------------------------------------------------------------------------*/
/*	Load Location Related Script
/*-----------------------------------------------------------------------------------*/
if(!function_exists('child_load_location_script')){
    function child_load_location_script(){

        if ( ! is_admin() ) {

            /* all property city terms */
            $all_locations = get_terms('property-city',array(
                'hide_empty' => false,
                'orderby' => 'count',
                'order' => 'desc',
            ));

            /* select boxes names */
            global $location_select_names;

            /* number of select boxes based on theme option */
            $location_select_count = intval( get_option( 'theme_location_select_number' ) );
            if( ! ( $location_select_count > 0 && $location_select_count < 5) ){
                $location_select_count = 1;
            }

            /* location parameters in request, if any */
            $locations_in_params = array();
            foreach ( $location_select_names as $location_name ) {
                if( isset( $_GET[ $location_name ] ) ) {
                    $locations_in_params[ $location_name ] = $_GET[ $location_name ];
                }
				else
				{
					$locations_in_params[ $location_name ] = 'london';
				}
            }

            /* combine all data into one */
            $location_data_array = array(
                'any' => __('Any','framework'),
                'all_locations' => $all_locations,
                'select_names' => $location_select_names,
                'select_count' => $location_select_count,
                'locations_in_params' => $locations_in_params,
            );

            /* provide location data array before custom script */
            wp_localize_script( 'custom', 'locationData', $location_data_array );

        }
    }
}
remove_action('after_location_fields', 'load_location_script');
add_action('child_after_location_fields', 'child_load_location_script');

/*----------------Bedrooms option in search form------------------------*/

if(!function_exists('numbers_list')){

    function numbers_list_bed($numbers_list_for){

        $numbers_array = array('Studio',1,2,3,4,5,6,7,8,9,10);

        $searched_value = '';



        if($numbers_list_for == 'bedrooms'){

            if(isset($_GET['bedrooms'])){

                $searched_value = $_GET['bedrooms'];

            }

        }

        if(!empty($numbers_array)){

            foreach($numbers_array as $number){

                if($searched_value == $number){

                    echo '<option value="'.$number.'" selected="selected">'.$number.'</option>';

                }else if($number=='Studio') {

                    echo '<option value="0">'.$number.'</option>';

                }else {

                    echo '<option value="'.$number.'">'.$number.'</option>';

                }

            }

        }



        if($searched_value == 'any' || empty($searched_value)) {

           // echo '<option value="any" selected="selected">'.__( 'Studio', 'framework').'</option>';

        } else {

            //echo '<option value="any">'.__( 'Studio', 'framework').'</option>';

        }

    }

}



