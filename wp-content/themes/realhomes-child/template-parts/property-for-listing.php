<div class="property-item-wrapper">
<style>
.stipline span:nth-child(2) {
    display: inline-block !important;
    font-size: 12px;
    line-height: 13px;
    vertical-align: middle !important;
    width: 86%;
	border:0px !important;
	height: 21px; padding-top: 17px; padding-bottom: 10px; padding-left: 5px; 
	
}
@media (max-width:480px){
	.listing-layout .property-item .property-meta span {
    border-right: 1px solid #dedede ;
    border-right: medium none;
    margin-right: 0;
    padding-right: 0;
    width: 13%;
}
.stipline span:nth-child(1) {  border-right: 1px solid #dedede !important;}
	.stipline span:nth-child(2) {
    display: inline-block !important;
    font-size: 11px;
    line-height: 13px;
    padding-top: 11px;
    vertical-align: middle !important;
    width: 80% !important;
	height: 21px; padding-top: 5px; padding-bottom: 5px; padding-left: 5px; 
	}
	

	#logo a {
	  margin-top: 10px;
	  margin-left: 40px;
	}
}
</style>

    <article class="property-item clearfix">





        <h4><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h4>





        <figure>


            <a href="<?php the_permalink() ?>">


                <?php


                global $post;


                if( has_post_thumbnail( $post->ID ) ) {


                    the_post_thumbnail( 'property-thumb-image' );


                }else{


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





                // Property Type. For example: Villa, Single Family Home


                echo inspiry_get_property_types( $post->ID );


                ?>


            </h5>


            <p><?php framework_excerpt( 25 ); ?></p>


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