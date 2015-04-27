<div class="span6 ">


    <article class="property-item clearfix">


        <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>





        <figure>


            <a href="<?php the_permalink(); ?>">


                <?php


                global $post;


                if( has_post_thumbnail( $post->ID ) ) {


                    the_post_thumbnail( 'property-thumb-image' );


                } else {


                    inspiry_image_placeholder( 'property-thumb-image' );


                }


                ?>


            </a>





            <?php display_figcaption( $post->ID ); ?>





        </figure>





        <div class="detail">


            <h5 class="price">


                <?php


                // price


                property_price();





                // property types


                echo inspiry_get_property_types( $post->ID );


                ?>


            </h5>


            <p><?php framework_excerpt(12); ?></p>


            <a class="more-details" href="<?php the_permalink() ?>"><?php _e('More Details ','framework'); ?><i class="fa fa-caret-right"></i></a>


        </div>
<div style="clear:both"></div>
<div class="property-meta stipline"> 
<?
$type_terms = get_the_terms( $post->ID,"property-type" );
 if(!empty( $type_terms )){
  foreach( $type_terms as $typeterm ){

                      $property_type=$typeterm->term_id;

                    }
 }
if($property_type=='2'){ if(get_post_meta($post->ID, 'REAL_HOMES_development_strapline', true)!=''){ echo '<span><i class="fa fa-info-circle fa-2x"></i></span><span>'.get_post_meta($post->ID, 'REAL_HOMES_development_strapline', true).'</span>';  }}
?>

</div>



        <div class="property-meta">


            <?php get_template_part('property-details/property-metas'); ?>


        </div>


    </article>


</div>