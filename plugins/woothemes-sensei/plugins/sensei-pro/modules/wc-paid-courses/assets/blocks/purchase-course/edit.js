/**
 * External dependencies
 */
import { find } from 'lodash';

/**
 * WordPress dependencies
 */
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import ProductsList from './products-list';

/**
 * Edit purchase course button with product list.
 *
 * @param {Object} props Component propertes.
 */
export const EditPurchaseButton = ( props ) => {
	const { products, EditTakeCourse } = props;

	const [ userSelectedProductId, setUserSelectedProductId ] =
		useState( null );

	let selectedProduct = null;

	if ( userSelectedProductId ) {
		selectedProduct = find( products, { id: userSelectedProductId } );
	}

	if ( 1 === products.length || ! selectedProduct ) {
		selectedProduct = products[ 0 ];
	}

	// Override the default "Take Course" text with "Buy" in the editor.
	const modifiedProps = { ...props };
	if ( modifiedProps.attributes?.text === 'Take Course' ) {
		modifiedProps.attributes = {
			...modifiedProps.attributes,
			text: __( 'Buy', 'sensei-pro' ),
		};
	}

	return (
		<>
			{ products.length > 1 && (
				<ProductsList
					products={ products }
					onChange={ setUserSelectedProductId }
					selectedProductId={ selectedProduct.id }
				/>
			) }
			<EditTakeCourse { ...modifiedProps } />
		</>
	);
};
