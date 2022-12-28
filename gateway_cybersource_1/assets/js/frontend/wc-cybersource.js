/*!
 * WooCommerce CyberSource Flex Microform Handler
 * Version 2.0.0
 *
 * Copyright (c) 2012-2020, SkyVerge, Inc. (info@skyverge.com)
 * Licensed under the GNU General Public License v3.0
 * http://www.gnu.org/licenses/gpl-3.0.html
 */
jQuery( document ).ready( ( $ ) => {

	'use strict';

	/**
	 * CyberSource Credit Card Flex Microform Handler class
	 *
	 * Loads CyberSource Flex Microform in an iframe and intercepts the form submission to inject the token returned by CyberSource.
	 *
	 * @since 2.0.0-dev-2
	 */
	window.WC_Cybersource_Payment_Form_Handler = class WC_Cybersource_Payment_Form_Handler extends SV_WC_Payment_Form_Handler {

		/**
		 * Instantiates Payment Form Handler.
		 *
		 * @since 2.0.0
		 */
		constructor( args ) {

			super( args );

			this.general_error = args.general_error;
			this.jwk           = args.jwk;
			this.placeholder   = args.placeholder;
			this.styles        = args.styles;

            this.init_cybersource_microform();

			$( document.body ).on( 'sv_wc_payment_form_valid_payment_data', ( event, data ) => {

				if ( data.payment_form.id !== this.id ) {
					return data.passed_validation;
				}

				// if regular validation passed
				if ( data.passed_validation ) {

					// if a saved method is selected, we have a token
					if ( this.saved_payment_method_selected ) {
						return true;
					}

					// if a token was created on previous form submit
					if ( this.get_flex_token() ) {
						console.log( 'Flex token present, submitting form' );
						return true;
					}

					// block the UI
					this.form.block( { message: null, overlayCSS: { background: '#fff', opacity: 0.6 } } );

					// generate a flex token
					this.create_token();

					// always return false to resubmit the form
					return false;
				}

			} );

			$( document.body ).on( 'checkout_error', () => {
				this.clear_flex_data();
			} );
		}


		/**
		 * Sets the form payment fields.
		 *
		 * Initializes the Flex microform.
		 *
		 * @since 2.0.0
		 */
		set_payment_fields() {

			super.set_payment_fields();

			if ( this.jwk ) {
                this.init_cybersource_microform();
			}
		}


		/**
		 * Initializes CyberSource Flex Microform.
		 *
		 * @since 2.0.0
		 */
		init_cybersource_microform() {

			// avoid calling init_cybersource_microform() again before the request to initialize the microform instance finishes
			if ( this.initializing_microform_instance ) {
				return;
			}

			// bail if the hosted credit card form field is already part of the page
			if ( this.microform_instance && this.microform_instance.iframe && $( `#${this.microform_instance.iframe.id}` ).length ) {
				return;
			}

			this.initializing_microform_instance = true;

			this.clear_flex_data();

			const { kid } = this.jwk;

			FLEX.microform( {
				keyId: kid,
				keystore: this.jwk,
				container: '#wc-cybersource-credit-card-account-number-hosted',
				label: '#wc-cybersource-credit-card-account-number-label',
				placeholder: this.placeholder || '•••• •••• •••• ••••',
				styles: this.styles,
				encryptionType: 'rsaoaep256',
			}, ( error, microformInstance ) => {

				delete this.initializing_microform_instance;

				if ( error ) {
					console.log( error );
					return;
				}

				this.microform_instance = microformInstance;

				// handle card type changes
				microformInstance.on( 'cardTypeChange', ( data ) => {

					// clear any previous card type classes
					$( '#wc-cybersource-credit-card-account-number-hosted' ).attr( 'class', ( i, c ) => {
						return c.replace( /(^|\s)card-type-\S+/g, '' );
					} );

					// set the card type class for display
					if ( data && data.card && data.card[0] ) {
						$( '#wc-cybersource-credit-card-account-number-hosted' ).addClass( 'card-type-' + data.card[0].name );
					}

				} );
			} );
		}


		/**
		 * Validates remaining credit card data (expiry and optionally csc).
		 *
		 * @since 2.0.0
		 */
		validate_card_data() {

			let errors = [];
			let $csc   = this.payment_fields.find( '#wc-cybersource-credit-card-csc' );

			// always validate the CSC if present
			if ( $csc.length ) {

				let csc = $csc.val();

				if ( /\D/.test( csc ) ) {
					errors.push( this.params.cvv_digits_invalid );
				}

				if ( csc && ( csc.length < 3 || csc.length > 4 ) ) {
					errors.push( this.params.cvv_length_invalid );
				} else if ( ! csc && this.csc_required && ( ! this.saved_payment_method_selected || this.csc_required_for_tokens ) ) {
					errors.push( this.params.cvv_missing );
				}
			}

			// only validate the other CC fields if necessary
			if ( ! this.saved_payment_method_selected ) {

				// validate expiration date
				const expiry = $.payment.cardExpiryVal( this.payment_fields.find( '.js-sv-wc-payment-gateway-credit-card-form-expiry' ).val() );

				// validates future date
				if ( ! $.payment.validateCardExpiry( expiry ) ) {
					errors.push( this.params.card_exp_date_invalid );
				}
			}

			if ( errors.length > 0 ) {

				this.render_errors( errors );
				return false;
			}

			return true;
		}


		/**
		 * Creates a new flex token.
		 *
		 * @since 2.0.0
		 */
		create_token() {

			const expiry = $.payment.cardExpiryVal( this.payment_fields.find( '.js-sv-wc-payment-gateway-credit-card-form-expiry' ).val() );

			let expiration_month = String( expiry.month );
			let expiration_year  = String( expiry.year );

			// Cybersource requires a leading zero
			if ( expiration_month.length === 1 ) {
				expiration_month = '0' + expiration_month;
			}

			const options = {
				cardExpirationMonth: expiration_month,
				cardExpirationYear: expiration_year,
			};

			this.microform_instance.createToken( options, ( error, response ) => {

				if ( error ) {

					this.handle_token_errors( error );

				} else {

					console.log( response );

					const { token, maskedPan, cardType, _embedded } = response;

					// at this point the token may be added to the form as hidden fields
					$( '[name=wc-cybersource-credit-card-flex-token]' ).val( token );
					$( '[name=wc-cybersource-credit-card-masked-pan]' ).val( maskedPan );
					$( '[name=wc-cybersource-credit-card-card-type]' ).val( cardType );

					if ( _embedded.icsReply.instrumentIdentifier ) {

						let identifier = _embedded.icsReply.instrumentIdentifier

						$( '[name=wc-cybersource-credit-card-instrument-identifier-id]' ).val( identifier.id );
						$( '[name=wc-cybersource-credit-card-instrument-identifier-new]' ).val( identifier.new );
						$( '[name=wc-cybersource-credit-card-instrument-identifier-state]' ).val( identifier.state );
					}

					this.form.submit();
				}

			} );
		}


		/**
		 * Handles flex tokenization errors.
		 *
		 * @since 2.0.0
		 *
		 * @param error
		 */
		handle_token_errors( error ) {

			let errors = [];

			console.log( error );

			if ( error.details && error.details.responseStatus && error.details.responseStatus.reason === 'VALIDATION_ERROR' && error.details.responseStatus.details ) {

				error.details.responseStatus.details.forEach( ( detail, index ) => {

					let message = '';

					switch ( detail.location ) {

						case 'cardInfo.cardNumber':
							message = this.params.card_number_invalid;
							break;

						case 'cardInfo.cardExpirationMonth':
						case 'cardInfo.cardExpirationYear':
							message = this.params.card_exp_date_invalid;
							break;
					}

					if ( message.length ) {
						errors.push( message );
					}

				} );

			} else {

				errors.push( this.general_error );
			}

			this.render_errors( errors );
		}


		/**
		 * Renders errors.
		 *
		 * @since 2.0.0
		 *
		 * @param errors
		 */
		render_errors( errors ) {

			this.clear_flex_data();

			super.render_errors( errors );
		}


		/**
		 * Gets the flex token if set in the form.
		 *
		 * @since 2.0.0
		 *
		 * @returns string
		 */
		get_flex_token() {

			return this.payment_fields.find( 'input[name=wc-cybersource-credit-card-flex-token]' ).val();
		}


		/**
		 * Clears any form flex data.
		 *
		 * @since 2.0.0
		 */
		clear_flex_data() {

			$( '[name=wc-cybersource-credit-card-flex-token]' ).val( '' );
			$( '[name=wc-cybersource-credit-card-masked-pan]' ).val( '' );
			$( '[name=wc-cybersource-credit-card-card-type]' ).val( '' );
			$( '[name=wc-cybersource-credit-card-instrument-identifier-id]' ).val( '' );
			$( '[name=wc-cybersource-credit-card-instrument-identifier-new]' ).val( '' );
			$( '[name=wc-cybersource-credit-card-instrument-identifier-state]' ).val( '' );
		}


	};

} );
