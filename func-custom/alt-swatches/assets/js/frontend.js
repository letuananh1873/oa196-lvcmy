var x = false;

jQuery( function( $ ) {
	
	

	var nbtcs_frontend = {
		init: function(){
	

			$('.variations_form').addClass( 'swatches-support' );

			$('.variations_form').on( 'click', '.swatch', this.select_attributes);
			$('.variations_form').on( 'click', '.reset_variations', this.reset_attributes);


	   		$(document).ajaxComplete(this.ajax_quick_view);
	   		$(document).ajaxStop(function(){
	   			x = false;
	   		});
		},

		ajax_quick_view: function(event, request, settings){
			if(!x && typeof(settings.data) == "string" && settings.data && settings.data.includes("action=yith_load_product_quick_view")){
				nbtcs_frontend.init();
				x = true;
			}
		},
		
		select_attributes: function(){
			var selected = [];
			var $el = $( this );
			
			var attr = $el.closest('.nbtcs-swatches');
			
			
			

			var $select = attr.prev().find('select'),
				$nbtcs_swatches = $el.closest('.nbtcs-swatches'),
				attribute_name = $select.data( 'attribute_name' ) || $select.attr( 'name' ),
				value = $el.attr( 'data-value' );
				

				$select.trigger( 'focusin' );

				// Check if this combination is available
				if ( ! $select.find( 'option[value="' + value + '"]' ).length ) {
					$el.siblings( '.swatch' ).removeClass( 'selected' );
					$select.val( '' ).change();
					$('.variations_form').trigger( 'tawcvs_no_matching_variations', [$el] );
					return;
				}

				clicked = attribute_name;

				if ( selected.indexOf( attribute_name ) === -1 ) {
					selected.push(attribute_name);
				}


			if($el.hasClass('swatch-radio')){

				$select.val( value );
			}else{
				if ( $el.hasClass( 'selected' ) ) {
					$select.val( '' );
					$el.removeClass( 'selected' );
					delete selected[selected.indexOf(attribute_name)];
				} else {
					$el.addClass( 'selected' ).siblings( '.selected' ).removeClass( 'selected' );
					$select.val( value );
				}		
			}

			$select.change();

		},
		
		select_attributes_radio: function(){
			var $el = $( this );

			alert(2);
		},
		
		reset_attributes: function(){
			$( this ).closest( '.variations_form' ).find( '.swatch.selected' ).removeClass( 'selected' );
			$( this ).closest( '.variations_form' ).find('[type="radio"]').prop('checked', false); 
			selected = [];
		}
	}
	nbtcs_frontend.init();
});