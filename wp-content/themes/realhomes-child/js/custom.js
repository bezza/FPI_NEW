(function($){

    "use strict";

    $(document).ready(function() {
	
		$('#con-agent-btn').click(function(){
			var name = $('#name').val();
			var email = $('#email').val();
			var phone = $('#phone').val();
				if(name == '' && email == '' && phone == '')
				{
					$('#name').after('<span class=\"val-error\">* Please provide your name</span>');
					$('#email').after('<span class=\"val-error\">* Please provide valid email address</span>');
					$('#phone').after('<span class=\"val-error\">* Please provide a valid phone number</span>');
				}
		});
		
		
		$(document).on('click','#sub-btn',function(){
			
			var email = $('#ret-email').val();
			var name = $('#ret-name').val(); 
			var phone = $('#ret-phone').val();
			var country = $('#ret-country').val();
			var return_property_id = $('#return_property_id').val();
			var return_property_title = $('#return_property_title').val();	
			var return_property_permalink = $('#return_property_permalink').val();
			var return_property_price = $('#return_property_price').val();
			var return_img_url = $('#return_img_url').val();
			var check_1 = '',check_2 = '',check_3 = '';
			var return_con_method = $('#return_con_method').val();
			if($("#check-1").is(':checked')){
				check_1 = $('#check-1').val();
			}
			if($("#check-2").is(':checked')){
							check_2 = $('#check-2').val();
						}
			if($("#check-3").is(':checked')){
				check_3 = $('#check-3').val();
			}			
			$('#mce-EMAIL').val(email);
			$('#mce-FNAME').val(name);			
						
			
			 $.ajax({
				  url: admin_ajax,
				  type: 'POST',
				  
				  data: {action: 'advice_form',fname: name,email: email,phone: phone,country:country,return_property_id:return_property_id,return_property_title:return_property_title,return_property_permalink:return_property_permalink,return_property_price:return_property_price,return_img_url:return_img_url,return_con_method:return_con_method,check_1:check_1,check_2:check_2,check_3:check_3},
				  success: function(data) {
					//called when successful
						$('#sub-btn').after('<p class=\"message-reply\">'+data+'</p>');
						if($('#mail_chimp_form input[name="mail_chimp"]').is(':checked'))
						{
							//$('#mc-embedded-subscribe-form').submit();
							$.ajax({
								url: admin_ajax,
								type: 'POST',
								data: {action: 'mailchimp_subscribe',fname: name,email: email},
								success: function(data) {
									$('.close').trigger('click');
								},
							});
						}	
						
				  },
				  error: function(e) {
					//called when there is an error
					console.log(e.message);
				  }
				}); 
			});








        
		
		/*-------------------------------------------------------*/
        /*	jQuery for children property filter
        /* -----------------------------------------------------*/
	
	    
		$('#priceslider').slider().on('slide', function(ev){
			$('#slideText').val(ev.value[0]);
			$('#slideText1').val(ev.value[1]);
		});
		
		
		/*------------------------------Property Sizes-----------------------------------------*/
		
		/* set slider range */
			$('#priceslider .ui-slider-handle:nth-child(2) .ui-slider-tooltip').text(1000);
			$('#priceslider .ui-slider-handle:nth-child(3) .ui-slider-tooltip').text(1500000);
			$('#sizeslider .ui-slider-handle:nth-child(2) .ui-slider-tooltip').text(100);
			$('#sizeslider .ui-slider-handle:nth-child(3) .ui-slider-tooltip').text(30000);
			
		
		
		/*-----------------------Ajax for child property search-------------------*/
		$('#filtersubmit').on('click',function(){
			$('#filter-loader').show();
			
			var min_price = $('#slideText').val();
			var max_price = $('#slideText1').val();
			var min_size = $('#sizeText').val();
			var max_size = $('#sizeText1').val();
			var bedroom = $('#bedroom').val();
			var bathrooms = $('#bathrooms').val();
			var property_type = $('#property_type').val();
			var parent_ID = $('#parent_id').val();
			
			
			 $.ajax({
				  url: admin_ajax,
				  type: 'POST',
				  
				  data: {action: 'filter_property',min_price: min_price,max_price: max_price,bedroom:bedroom,bathrooms:bathrooms,property_type:property_type,parent_ID:parent_ID},
				  success: function(data) {
					//console.log(data);
					//called when successful
						//alert(data);
						//console.log(data);
						$('.child-properties-add').children('article').remove();
						$('.child-properties-add').html(data);
						$('#filter-loader').hide();
				  },
				  error: function(e) {
					//called when there is an error
					console.log(e.message);
				  }
				}); 
		
		});
        
		/*----------------------- Ajax for get average price -------------------*/
		$('#get_average_price').on('click',function(){
			$('#average-price-loader').show(); 
			var bedroom = $('#beds').val();
			var property_for = $('#property_for').val();
			var post_id = $(this).data('id');
			$.ajax({
				url: admin_ajax,
				type: 'POST',
				data: {action: 'get_average_price',bedroom: bedroom,property_for: property_for,post_id:post_id},
				success: function(data) {
					//console.log(data);
					$('#average-price-loader').hide();
					$('.average_price_container').html(data);
				},
				error: function(e) {
					//called when there is an error
					console.log(e.message);
				}
			}); 
		
		});
		

    });
	
	if(jQuery( window ).width() > 768){
		if(jQuery('.container .sidebar').find('.sticky-sidebar')){
			var stickyTop = jQuery('.sidebar .sticky-sidebar').offset().top;
			jQuery(window).on( 'scroll', function(){
				if (jQuery(window).scrollTop() >= stickyTop) {
					jQuery('.sticky-sidebar').css({position: "fixed", width: "19%"});
				} else {
					jQuery('.sticky-sidebar').css({position: "static", width: "100%"});
				}
			});
		}
	}
	jQuery(window).on('resize',function(){
		if(jQuery( window ).width() > 768){
			if(jQuery('.container .sidebar').find('.sticky-sidebar')){
				var stickyTop = jQuery('.sidebar .sticky-sidebar').offset().top;
				jQuery(window).on( 'scroll', function(){
					if (jQuery(window).scrollTop() >= stickyTop) {
						jQuery('.sticky-sidebar').css({position: "fixed", width: "19%"});
					} else {
						jQuery('.sticky-sidebar').css({position: "static", width: "100%"});
					}
				});
			}
		}
	});
	
	
	
	  /*-----------------------------------------------------------------------------------*/
        /*	Flex Slider
        /*-----------------------------------------------------------------------------------*/
        if(jQuery().flexslider)
        {
		  /* Property detail page slider variation two */
			jQuery('a[href="#tabs-1"]').on('click',function(){
					jQuery('#property-carousel-two').flexslider({
						animation: "slide",
						controlNav: false,
						animationLoop: false,
						slideshow: false,
						itemWidth: 113,
						itemMargin: 10,
						// move: 1,
						asNavFor: '#property-slider-two',
					});
					jQuery('#property-slider-two').flexslider({
						animation: "slide",
						directionNav: true,
						controlNav: false,
						animationLoop: false,
						slideshow: true,
						sync: "#property-carousel-two",
						start: function (slider) {
							slider.removeClass('loading');
						}
					});
				
				
				//jQuery('#property-slider-two ul li').css("width",'825px');
				//jQuery('#property-carousel-two ul li').css("width",'113px');
				setTimeout(function(){ 
					  
					jQuery('#property-carousel-two').resize();
					jQuery('#property-slider-two').resize();
				}, 100);
			});
			
        }
	
	
	
})(jQuery);



function select_bedroom(id)
{
	jQuery('.price-con select[name="bedroom"] option').removeAttr('selected');
	jQuery('.price-con select[name="bedroom"] option').each(function(){
		if(jQuery(this).val() == id)
		{
			jQuery(this).attr('selected','selected');
		}
	});
}

function select_bathrooms(id)
{
	jQuery('.price-con select[name="bathrooms"] option').removeAttr('selected');
	jQuery('.price-con select[name="bathrooms"] option').each(function(){
		if(jQuery(this).val() == id)
		{
			jQuery(this).attr('selected','selected');
		}
	});
}

function select_property_type(id)
{
	jQuery('.price-con select[name="property_type"] option').removeAttr('selected');
	jQuery('.price-con select[name="property_type"] option').each(function(){
		if(jQuery(this).val() == id)
		{
			jQuery(this).attr('selected','selected');
		}
	});
}

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
	
	/* Validate Submit Property Form */
    if( jQuery().validate ){
        $('#submit-property-form').validate({
            rules: {
                bedrooms: {
                    number: true
                },
                bathrooms: {
                    number: true
                },
                garages: {
                    number: true
                },
                price: {
                    number: true
                },
                size: {
                    number: true
                }
            }
        });
    }

    /* Apply jquery ui sortable on additional details */
    $( "#inspiry-additional-details-container" ).sortable({
        revert: 100,
        placeholder: "detail-placeholder",
        handle: ".sort-detail",
        cursor: "move"
    });

    $( '.add-detail' ).click(function( event ){
        event.preventDefault();
        var newInspiryDetail = '<div class="inspiry-detail inputs clearfix">' +
            '<div class="inspiry-detail-control"><span class="sort-detail fa fa-bars"></span></div>' +
            '<div class="inspiry-detail-title"><input type="text" name="detail-titles[]" /></div>' +
            '<div class="inspiry-detail-value"><input type="text" name="detail-values[]" /></div>' +
            '<div class="inspiry-detail-control"><a class="remove-detail" href="#"><span class="fa fa-times"></span></a></div>' +
            '</div>';

        $( '#inspiry-additional-details-container').append( newInspiryDetail );
        bindAdditionalDetailsEvents();
    });

    function bindAdditionalDetailsEvents(){

        /* Bind click event to remove detail icon button */
        $( '.remove-detail').click(function( event ){
            event.preventDefault();
            var $this = $( this );
            $this.closest( '.inspiry-detail' ).remove();
        });

    }
    bindAdditionalDetailsEvents();

    /* Check if IE9 - As image upload not works in ie9 */
    var ie = (function(){

        var undef,
            v = 3,
            div = document.createElement('div'),
            all = div.getElementsByTagName('i');

        while (
            div.innerHTML = '<!--[if gt IE ' + (++v) + ']><i></i><![endif]-->',
                all[0]
            );

        return v > 4 ? v : undef;

    }());

    if ( ie <= 9 ) {
        $('#submit-property-form').before( '<div class="ie9-message"><i class="fa fa-info-circle"></i>&nbsp; <strong>Current browser is not fully supported:</strong> Please update your browser or use a different one to enjoy all features on this page. </div>' );
    }
	if (typeof propertySubmit !== "undefined") {
    var ajaxURL = propertySubmit.ajaxURL;
    var uploadNonce = propertySubmit.uploadNonce;
    var fileTypeTitle = propertySubmit.fileTypeTitle; /* Apply jquery ui sortable on gallery items */
    $("#floor-plan-thumbs-container").sortable({
        revert: 100,
        placeholder: "sortable-placeholder",
        cursor: "move"
    }); /* initialize uploader */
    var flooruploader = new plupload.Uploader({
        browse_button: 'floor-plan-select-images',
        file_data_name: 'inspiry_upload_file',
        container: 'floor-plan-plupload-container',
        drop_element: 'floor-plan-drag-and-drop',
        url: ajaxURL + "?action=ajax_img_upload&nonce=" + uploadNonce,
        filters: {
            mime_types: [{
                title: fileTypeTitle,
                extensions: "jpg,jpeg,gif,png"
            }],
            max_file_size: '10000kb',
            prevent_duplicates: true
        }
    });
    flooruploader.init(); /* Run after adding file */
    flooruploader.bind('FilesAdded', function(up, files) {
        var html = '';
        var galleryThumb = "";
        plupload.each(files, function(file) {
            galleryThumb += '<div id="holder-' + file.id + '" class="gallery-thumb">' + '' + '</div>';
        });
        document.getElementById('floor-plan-thumbs-container').innerHTML += galleryThumb;
        up.refresh();
        flooruploader.start();
    }); /* Run during upload */
    flooruploader.bind('UploadProgress', function(up, file) {
        document.getElementById("holder-" + file.id).innerHTML = '<span>' + file.percent + "%</span>";
    }); /* In case of error */
    flooruploader.bind('Error', function(up, err) {
        document.getElementById('floor-plan-errors-log').innerHTML += "<br/>" + "Error #" + err.code + ": " + err.message;
    }); /* If files are uploaded successfully */
    flooruploader.bind('FileUploaded', function(up, file, ajax_response) {
        var response = $.parseJSON(ajax_response.response);
        if (response.success) {
            var galleryThumbHtml = '<img src="' + response.url + '" alt="" />' + '<a class="remove-image" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#remove-image" ><i class="fa fa-trash-o"></i></a>' + '<a class="mark-featured" data-property-id="' + 0 + '"  data-attachment-id="' + response.attachment_id + '" href="#mark-featured" ><i class="fa fa-star-o"></i></a>' + '<input type="hidden" class="gallery-image-id" name="floor_image_ids[]" value="' + response.attachment_id + '"/>' + '<span class="loader"><i class="fa fa-spinner fa-spin"></i></span>';
            document.getElementById("holder-" + file.id).innerHTML = galleryThumbHtml;
            floorbindThumbnailEvents();
        } else {
            console.log(response);
        }
    }); /* Bind thumbnails events with newly added gallery thumbs */
    var floorbindThumbnailEvents = function() {
        $('a.remove-image').unbind('click');
        $('a.mark-featured').unbind('click');
        $('a.mark-featured').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var starIcon = $this.find('i');
            if (starIcon.hasClass('fa-star-o')) {
                $('.gallery-thumb .featured-img-id').remove();
                $('.gallery-thumb .mark-featured i').removeClass('fa-star').addClass('fa-star-o');
                var $this = $(this);
                var input = $this.siblings('.gallery-image-id');
                var featured_input = input.clone().removeClass('gallery-image-id').addClass('featured-img-id').attr('name', 'featured_image_id');
                $this.closest('.gallery-thumb').append(featured_input);
                starIcon.removeClass('fa-star-o').addClass('fa-star');
            }
        });
        $('a.remove-image').click(function(event) {
            event.preventDefault();
            var $this = $(this);
            var gallery_thumb = $this.closest('.gallery-thumb');
            var loader = $this.siblings('.loader');
            loader.show();
            var removal_request = $.ajax({
                url: ajaxURL,
                type: "POST",
                data: {
                    property_id: $this.data('property-id'),
                    attachment_id: $this.data('attachment-id'),
                    action: "remove_gallery_image",
                    nonce: uploadNonce
                },
                dataType: "html"
            });
            removal_request.done(function(response) {
                var result = $.parseJSON(response);
                if (result.attachment_removed) {
                    gallery_thumb.remove();
                } else {
                    document.getElementById('floor-plan-errors-log').innerHTML += "<br/>" + "Error : Failed to remove attachment";
                }
            });
            removal_request.fail(function(jqXHR, textStatus) {
                alert("Request failed: " + textStatus);
            });
        });
    };
    floorbindThumbnailEvents();
}

	
});