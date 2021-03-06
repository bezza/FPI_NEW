<?php

if( !class_exists('Property_Travel_Widget') ){

    class Property_Travel_Widget extends WP_Widget {



        function Property_Travel_Widget(){

            $widget_ops = array( 'classname' => 'Property_Travel_Widget', 'description' => __('Important: This widget is only for the Property Sidebar.','framework') );

            $this->WP_Widget( 'Property_Travel_Widget', __('RealHomes - Property Travel Widget','framework'), $widget_ops );

        }



        function widget($args, $instance) {



            extract($args);



            $title = apply_filters('widget_title', $instance['title']);



            if ( empty($title) ) $title = false;



            


                echo $before_widget;



                if($title):

                    echo $before_title;

                    echo $title;

                    echo $after_title;

                endif;

				?><div class="location-grid"><?php
				get_template_part('property-details/property-near-station');
				?></div><?php


                echo $after_widget;

            

        }





        function form($instance)

        {



            $instance = wp_parse_args( (array) $instance, array( 'title' => 'Nearest Transports' ) );



            $title= esc_attr($instance['title']);

            ?>

            <p>

                <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Widget Title', 'framework'); ?></label>

                <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />

            </p>

        <?php

        }



        function update($new_instance, $old_instance)

        {

            $instance = $old_instance;



            $instance['title'] = strip_tags($new_instance['title']);

            return $instance;



        }



    }

}

?>