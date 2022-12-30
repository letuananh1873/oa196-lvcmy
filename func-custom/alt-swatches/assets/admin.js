jQuery( function( $ ) {
	var wp = window.wp;
	/**
	 * Variations Price Matrix actions
	 */
	var nbt_cs_admin = {

		/**
		 * Initialize variations actions
		 */
		init: function() {
			$( '#term-color, .term-color' ).wpColorPicker();
			$(document).on('click', '.nbtcs-upload-image-button', this.upload_image);
			$(document).on( 'click', '.nbtcs-remove-image-button', this.remove_upload_image);
			$(document).on('click', '#_color_swatches', this.enable_color_swatches);
			$(document).on('click', 'li.color_swatches_options a', this.initial_load);
			$(document).on('click', '.save_color_swatches', this.save_color_swatches);

			$(document).on('click', '.cs-radio', this.style_selected);
	   		$(document).on('click', '.enable_custom_checkbox', this.custom_repeater);
	   		

	   		$(document).on('change', '.cs-type-tax', this.change_type);
			this.check_enable_color_swatches();
		},
		initial_load: function(){
			nbtcs_ajax.block();

			var tpl = $('#tpl-color-swatches').html();
			var wrapper_attributes = $( '#variable_product_options' ).find( '.woocommerce_variations' ).data( 'attributes' );
			if(wrapper_attributes == undefined){
				total_attr = 0;
			}else{
				var total_attr = Object.keys(wrapper_attributes).length;
			}

			$.ajax({
				url: woocommerce_admin_meta_boxes_variations.ajax_url,
				data: {
					action:     'cs_load_variations',
					security:   woocommerce_admin_meta_boxes_variations.load_variations_nonce,
					product_id: woocommerce_admin_meta_boxes_variations.post_id,
					attributes: wrapper_attributes
				},
				type: 'POST',
				datatype: 'json',
				success: function( response ) {
					var rs = JSON.parse(response);
					$('.woocommerce-message').remove();
					
					if(rs.complete != undefined){
						$('#color_swatches').html(tpl);
						$('.color_swatches.wc-metaboxes').html(rs.html);
						$('.term-color' ).wpColorPicker();
					}else{
						$('#price_matrix_options_inner').html($html_msg);
					}

					nbtcs_ajax.unblock();
				},
				error:function(){
					alert('There was an error when processing data, please try again !');
					nbtcs_ajax.unblock();
				}
			});
		},
		style_selected: function(){
			var $this =  $(this).closest('li');
			$(this).closest('ul').find('li').removeClass('selected');
			$(this).closest('ul').find('.input-radio').removeAttr('checked')
			$this.find('.input-radio').attr('checked', 'checked');
			$this.addClass('selected');
		},
		custom_repeater: function(){
			var $this = $(this).closest('.woocommerce_attribute_data').find('.pm_repeater');
			if($(this).is(':checked')){
				$this.show();
			}else{
				$this.hide();
			}
		},
		change_type: function(){
	
			var $tax = $(this).closest('.woocommerce_attribute').attr('data-taxonomy');
			var $table = $(this).closest('.woocommerce_attribute').find('.pm_repeater');
			var $type = $(this).val();
			var wrapper_attributes = $( '#variable_product_options' ).find( '.woocommerce_variations' ).data( 'attributes' );
			if(wrapper_attributes == undefined){
				total_attr = 0;
			}else{
				var total_attr = Object.keys(wrapper_attributes).length;
			}

			if($type != '0'){
			$table.show();
				nbtcs_ajax.block();
				$.ajax({
					url: woocommerce_admin_meta_boxes_variations.ajax_url,
					data: {
						action:     'cs_load_style',
						security:   woocommerce_admin_meta_boxes_variations.load_variations_nonce,
						product_id: woocommerce_admin_meta_boxes_variations.post_id,
						attributes: wrapper_attributes,
						tax: $tax,
						type: $type
					},
					type: 'POST',
					datatype: 'json',
					success: function( response ) {
						var rs = JSON.parse(response);
						$('.woocommerce-message').remove();
						
						console.log($type);
						
						if(rs.complete != undefined){
							$table.html(rs.html);
							if($type == 'radio' || $type == 'label' ){
								$table.hide();
							}
							$('.term-color' ).wpColorPicker();
						}

						nbtcs_ajax.unblock();
					},
					error:function(){
						alert('There was an error when processing data, please try again !');
						nbtcs_ajax.unblock();
					}
				});
			}else{
				$table.hide();
			}


		},
		upload_image: function(e){

				e.preventDefault();
				var $button = $( this ).closest('.nbtcs-wrap-image');
				
		

			// Create the media frame.
			var frame = wp.media.frames.downloadable_file = wp.media( {
				title   : nbtcs.i18n.mediaTitle,
				button  : {
					text: nbtcs.i18n.mediaButton
				},
				multiple: false
			} );

			// When an image is selected, run a callback.
			frame.on( 'select', function () {
				var attachment = frame.state().get( 'selection' ).first().toJSON(),
					img_src = attachment.sizes.full.url;
				if( typeof attachment.sizes.thumbnail != 'undefined' ) {
					img_src = attachment.sizes.thumbnail.url;
				}

				console.log($button);

				$button.addClass('class_name' + attachment.id);
				$button.find( 'input.nbtcs-term-image' ).val( attachment.id );
				$button.find( '.nbtcs-remove-image-button' ).show();
				$button.find( 'img' ).attr( 'src', img_src );
			} );

			// Finally, open the modal.
			frame.open();
		},
		remove_upload_image: function(){
			var $button = $( this );

			$button.siblings( 'input.nbtcs-term-image' ).val( '' );
			$button.siblings( '.nbtcs-remove-image-button' ).show();
			$button.parent().prev( '.nbtcs-term-image-thumbnail' ).find( 'img' ).attr( 'src', nbtcs.placeholder );

			return false;
		},
		check_enable_color_swatches: function(){
			var $cs = $('#_color_swatches');
			if($cs.closest('label').hasClass('yes')){
				$cs.prop('checked', true);
				$('.color_swatches_options').removeClass('hide');
			}else{
				$cs.prop('checked', false);
				$('.color_swatches_options').addClass('hide');

			}
		},
		enable_color_swatches: function(){
			if($(this).is(':checked')){
			 	$('.color_swatches_options').removeClass('hide');
			}else{
				$('.color_swatches_options').addClass('hide');
				$('.woocommerce_options_panel').hide();
				$('#inventory_product_data').show();
				$('.product_data_tabs > li').removeClass('active');
				$('.inventory_options.inventory_tab').addClass('active');
			}
		},
		save_color_swatches: function(){
			nbtcs_ajax.block();
			var type = [];
			var tax = [];
			
			var custom = [];
			$('.cs-type-tax :selected').each(function(i, selected){ 
				type[i] = $(selected).val();
				tax[i] = $(selected).closest('select').attr('data-id'); 
			});

			var style = [];

			var datas = [];
			
			$('#color_swatches .woocommerce_attribute').each(function(i, selected){ 
				style[i] = $(selected).find('.input-radio:checked').attr('value');

				var $tax = $(selected).attr('data-taxonomy');
				var $type = $(selected).find('.cs-type-tax').val();
				var data = [$type];

				if($type != 'radio'){
					var color = $(selected).find('.term-alt-color').map(function(_, el) {
					    return $(el).val();
					}).get();
					
					var image = $(selected).find('.nbtcs-term-image').map(function(_, el) {
					    return $(el).val();
					}).get();

					if($type == 'image'){
						data.push({image: image});
					}else{
						data.push({color: color});
					}
					
				}

				datas.push(data);



			});

				console.log(datas);



	
			$.ajax({
				url: woocommerce_admin_meta_boxes_variations.ajax_url,
				data: {
					action: 'cs_save',
					product_id: woocommerce_admin_meta_boxes_variations.post_id,
					type: type,
					tax: tax,
					style: style,
					custom: datas
				},
				type: 'POST',
				datatype: 'json',
				success: function( response ) {
					var rs = JSON.parse(response);

					nbtcs_ajax.unblock();

				},
				error:function(){
					alert('There was an error when processing data, please try again !');
					nbtcs_ajax.unblock();
				}
			});
		}
	}


	var nbtcs_ajax = {
		/**
		 * Init jQuery.BlockUI
		 */
		block: function() {
			$('#color_swatches').block({
				message: null,
				overlayCSS: {
					background: '#fff',
					opacity: 0.6
				}
			});
		},

		/**
		 * Remove jQuery.BlockUI
		 */
		unblock: function() {
			$('#color_swatches').unblock();
		}
	}
	
	nbt_cs_admin.init();

});