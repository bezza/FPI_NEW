<?php get_template_part("template-parts/carousel_partners"); ?>

<!-- Start Footer -->
<footer id="footer-wrapper">

       <div id="footer" class="container">

                <div class="row">

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-first-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-second-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="clearfix visible-tablet"></div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-third-column' ) ) : ?>
                            <?php endif; ?>
                        </div>

                        <div class="span3">
                            <?php if ( ! dynamic_sidebar( 'footer-fourth-column' ) ) : ?>
                            <?php endif; ?>
                        </div>
                </div>

       </div>

        <!-- Footer Bottom -->
        <div id="footer-bottom" class="container">

                <div class="row">
                        <div class="span6">
                            <?php
                            $copyright_text = get_option('theme_copyright_text');
                            echo ( $copyright_text ) ? '<p class="copyright">'.$copyright_text.'</p>' : '';
                            ?>
                        </div>
                        <div class="span6">
                            <?php
                            $designed_by_text = get_option('theme_designed_by_text');
                            echo ( $designed_by_text ) ? '<p class="designed-by">'.$designed_by_text.'</p>' : '';
                            ?>
                        </div>
                </div>

        </div>
        <!-- End Footer Bottom -->

</footer><!-- End Footer -->

<?php
if( !is_user_logged_in() ){
    get_template_part('template-parts/modal-login');
}
?>
<?php wp_footer(); ?>

<!-- bxSlider Javascript file -->
<script src="<?php echo get_template_directory_uri(); ?>/js/jquery.bxslider.min.js"></script>
<!-- bxSlider CSS file -->
<link href="<?php echo get_template_directory_uri(); ?>/css/jquery.bxslider.css" rel="stylesheet" />

  <script type="text/javascript">
  jQuery(document).ready(function($){
    $( "#tabs" ).tabs();
	
	jQuery( window).load(function(){
		var window_height = jQuery(window).width();
		if(window_height < 768){
			jQuery('.tab').bxSlider({
				pager:false,
			});
		}
	})
	jQuery( window ).resize(function() {
		var window_height = jQuery(window).width();
		if(window_height < 768){
			jQuery('.tab').bxSlider({
				pager:false,
			});
		}
		else
		{
			jQuery( "#tabs" ).tabs();
		}
	});
	

	
  });
  
        
  </script>
</body>
</html>