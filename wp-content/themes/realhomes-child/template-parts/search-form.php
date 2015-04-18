<?php
global $theme_search_fields;
if( !empty($theme_search_fields) ):
?>
<div class="as-form-wrap">
    <form class="advance-search-form clearfix" action="<?php global $theme_search_url; echo $theme_search_url; ?>" method="get">
    <?php

    if ( in_array ( 'keyword-search', $theme_search_fields ) ) {
        ?>
        <div class="option-bar large">
            <label for="keyword-txt"><?php _e('Keyword', 'framework'); ?></label>
            <input type="text" name="keyword" id="keyword-txt" value="<?php echo isset ( $_GET['keyword'] ) ? $_GET['keyword'] : ''; ?>" placeholder="<?php _e('Any', 'framework'); ?>" />
        </div>
        <?php
    }

    if ( in_array ( 'property-id', $theme_search_fields ) ) {
        ?>
        <div class="option-bar large">
            <label for="property-id-txt"><?php _e('Property ID', 'framework'); ?></label>
            <input type="text" name="property-id" id="property-id-txt" value="<?php echo isset($_GET['property-id'])?$_GET['property-id']:''; ?>" placeholder="<?php _e('Any', 'framework'); ?>" />
        </div>
        <?php
    }

    if( in_array ( 'location', $theme_search_fields ) ) {

        /* number of locations chosen from theme options */
        $location_select_count = intval( get_option( 'theme_location_select_number' ) );
        if( ! ( $location_select_count > 0 && $location_select_count < 5) ){
            $location_select_count = 1;
        }
		
        /* global variable that contains location select boxes names */
        global $location_select_names;

        /* Default location select boxes titles */
        $location_select_titles = array(
            __( 'City', 'framework' ),
            __( 'Main Location', 'framework' ),
            __( 'Child Location', 'framework' ),
            __( 'Grand Child Location', 'framework' ),
            __( 'Great Grand Child Location', 'framework' )
        );

        /* override select boxes titles based on theme options data */
        for ( $i = 1; $i <= 4; $i++  ) {
            $temp_location_title = get_option( 'theme_location_title_' . $i );
            if( $temp_location_title ) {
                $location_select_titles[ $i - 1 ] = $temp_location_title;
            }
        }

        /* Generate required location select boxes */
        for( $i=0; $i < $location_select_count; $i++ ) {
            ?>
            <div class="option-bar large">
                <label for="<?php echo $location_select_names[$i];  ?>"><?php echo $location_select_titles[$i] ?></label>
                <span class="selectwrap">
                    <select name="<?php echo $location_select_names[$i]; ?>" id="<?php echo $location_select_names[$i];  ?>" class="search-select"></select>
                </span>
            </div>
            <?php
        }

        /* important action hook - related JS works based on it */
        do_action( 'child_after_location_fields' );
    }

    if ( in_array ( 'status', $theme_search_fields ) ) {
        ?>
        <div class="option-bar large">
            <label for="select-status"><?php _e('Property Status', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="status" id="select-status" class="search-select">
                    <?php advance_search_options('property-status'); ?>
                </select>
            </span>
        </div>
        <?php
    }

    if ( in_array ( 'type', $theme_search_fields ) ) {
        ?>
        <div class="option-bar large">
            <label for="select-property-type"><?php _e('Property Type', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="type" id="select-property-type" class="search-select">
                    <?php advance_hierarchical_options('property-type'); ?>
                </select>
            </span>
        </div>
        <?php
    }

    if ( in_array( 'min-beds', $theme_search_fields ) ) {
        ?>
        <div class="option-bar small">
            <label for="select-bedrooms"><?php _e('Min Beds', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="bedrooms" id="select-bedrooms" class="search-select">
                    <?php numbers_list_bed('bedrooms'); ?>
						
                </select>
            </span>
        </div>
        <?php
    }

    if ( in_array ( 'min-baths', $theme_search_fields ) ) {
        ?>
        <div class="option-bar small">
            <label for="select-bathrooms"><?php _e('Min Baths', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="bathrooms" id="select-bathrooms" class="search-select">
                    <?php numbers_list('bathrooms'); ?>
                </select>
            </span>
        </div>
        <?php
    }

    if ( in_array( 'min-max-price', $theme_search_fields ) ) {
        ?>
        <div class="option-bar small price-for-others">
            <label for="select-min-price"><?php _e('Min Price', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="min-price" id="select-min-price" class="search-select">
                    <?php min_prices_list(); ?>
                </select>
            </span>
        </div>

        <div class="option-bar small price-for-others">
            <label for="select-max-price"><?php _e('Max Price', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="max-price" id="select-max-price" class="search-select">
                    <?php max_prices_list(); ?>
                </select>
            </span>
        </div>

        <div class="option-bar small price-for-rent hide-fields">
            <label for="select-min-price"><?php _e('Min Price', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="min-price" id="select-min-price-for-rent" class="search-select" disabled="disabled">
                    <?php min_prices_for_rent_list(); ?>
                </select>
            </span>
        </div>

        <div class="option-bar small price-for-rent hide-fields">
            <label for="select-max-price"><?php _e('Max Price', 'framework'); ?></label>
            <span class="selectwrap">
                <select name="max-price" id="select-max-price-for-rent" class="search-select" disabled="disabled">
                    <?php max_prices_for_rent_list(); ?>
                </select>
            </span>
        </div>
        <?php
    }

    if ( in_array ( 'min-max-area', $theme_search_fields ) ) {
        $area_unit = get_option("theme_area_unit");
        ?>
        <div class="option-bar small">
            <label for="min-area"><?php _e('Min Area', 'framework'); ?> <span><?php if($area_unit){ echo "($area_unit)"; } ?></span></label>
            <input type="text" name="min-area" id="min-area" pattern="[0-9]+" value="<?php echo isset($_GET['min-area'])?$_GET['min-area']:''; ?>" placeholder="<?php _e('Any', 'framework'); ?>" title="<?php _e('Please only provide digits!','framework'); ?>" />
        </div>

        <div class="option-bar small">
            <label for="max-area"><?php _e('Max Area', 'framework'); ?> <span><?php if($area_unit){ echo "($area_unit)"; } ?></span></label>
            <input type="text" name="max-area" id="max-area" pattern="[0-9]+" value="<?php echo isset($_GET['max-area'])?$_GET['max-area']:''; ?>" placeholder="<?php _e('Any', 'framework'); ?>" title="<?php _e('Please only provide digits!','framework'); ?>" />
        </div>
        <?php
    }
    ?>
	<?php
    if ( in_array ( 'features', $theme_search_fields ) ) {
        /* all property features terms */
        $all_features = get_terms( 'property-feature' );
		$all_zones = get_terms( 'london-zone' );
        $required_features_slugs = array();
        if ( isset( $_GET['features'] ) ) {
            $required_features_slugs = $_GET['features'];
        }
		
		if(isset($_GET['zone'])){
			$required_zone = $_GET['zone'];
		}
		else{
			$required_zone = '';
		}
		
		if(isset($_GET['yield'])){
			$required_yield = $_GET['yield'];
		}
        $features_count = count ( $all_features );
        if ( $features_count > 0 ) {
            ?>
            <div class="clearfix"></div>

            <div class="more-option-trigger">
                <a href="#">
                    <i class="fa <?php echo ( count( $required_features_slugs ) > 0 )? 'fa-minus-square-o': 'fa-plus-square-o'; ?>"></i>
                    <?php _e( 'More Search Options', 'framework' ); ?>
                </a>
            </div>

            <div class="more-options-wrapper clearfix <?php echo ( count( $required_features_slugs ) > 0 )? '': 'collapsed'; ?>">
            <div class="option-bar small london-zone">
				<label for="london-zone"><?php _e('London Travel Zone', 'framework'); ?></label>
				<span class="selectwrap">
					<select name="zone" id="london-zone" class="search-select">
						<option value="" <?php if($zone->slug == $required_zone){ echo "selected='selected'"; }?>>Any</option>
						<?php foreach ($all_zones as $zone ) {?>
						<option value="<?php echo $zone->slug; ?>" <?php if($zone->slug == $required_zone){ echo "selected='selected'"; }?>><?php echo ucwords( $zone->name ); ?><small>(<?php echo $zone->count; ?>)</small></option>
						<?php } ?>
					</select>
				</span>
			</div>
			<div class="option-bar small yield">
				<label for="yield"><?php _e('Rental Yield', 'framework'); ?></label>
				<span class="selectwrap">
					<select name="yield" id="yield" class="search-select">
						<option value="" <?php if($required_yield == ''){ echo "selected='selected'"; }?>>Any</option>
						<option value="0-5" <?php if($required_yield == '0-5'){ echo "selected='selected'"; }?>>0-5%</option>
						<option value="5-10" <?php if($required_yield == '5-10'){ echo "selected='selected'"; }?>>5-10%</option>
						<option value="10" <?php if($required_yield == '10'){ echo "selected='selected'"; }?>>10%+</option>
					</select>
				</span>
			</div>
			<div class="option-bar yield">
				<label for="yield"><?php _e('Min Area', 'framework'); ?></label>
				<span class="selectwrap">
					<select name="min-area" id="min-area"  class="search-select">
						<option value="0">Min</option>
						<option value="500">500 sqft (46 sqm)</option>
						<option value="750">750 sqft (70 sqm)</option>
						<option value="1000">1,000 sqft (93 sqm)</option>
						<option value="1200">1,200 sqft (112 sqm)</option>
						<option value="1500">1,500 sqft (139 sqm)</option>
						<option value="2000">2,000 sqft (186 sqm)</option>
						<option value="2500">2,500 sqft (232 sqm)</option>
						<option value="3000">3,000 sqft (279 sqm)</option>
						<option value="4000">4,000 sqft (372 sqm)</option>
						<option value="5000">5,000 sqft (465 sqm)</option>
						<option value="7500">7,500 sqft (697 sqm)</option>
						<option value="10000">10,000 sqft (929 sqm)</option>
					</select>
				</span>
			</div>
			<div class="option-bar features">
				<label for="features"><?php _e('Property Features', 'framework'); ?></label>
			<?php	
            foreach ($all_features as $feature ) {
                ?>
                <div class="option-bar">
                    <input type="checkbox"
                           id="feature-<?php echo $feature->slug; ?>"
                           name="features[]"
                           value="<?php echo $feature->slug; ?>"
                        <?php if ( in_array( $feature->slug, $required_features_slugs ) ) { echo 'checked'; } ?> />
                    <label for="feature-<?php echo $feature->slug; ?>"><?php echo ucwords( $feature->name ); ?> <small>(<?php echo $feature->count; ?>)</small></label>
                </div>
                <?php
            }
            ?>
            </div>
			
			
			
			
            </div>
            <?php
        }
    }
    ?>
	<?php $total_property = wp_count_posts( 'property' ); ?>
	
    <div class="option-bar main-search">		<span class="avail-properties"><?php echo $total_property->publish;?> Properties Available</span>
        <input type="submit" value="<?php _e('Search', 'framework'); ?>" class=" real-btn btn">
    </div>
    </form>
	
</div>
<?php
endif;
?>