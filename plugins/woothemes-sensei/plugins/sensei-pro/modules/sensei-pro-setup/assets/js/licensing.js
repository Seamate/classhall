/**
 * WordPress dependencies
 */
import { createRoot } from '@wordpress/element';

/**
 * Internal dependencies
 */
import { Setup } from './Setup';

const rootElement = document.getElementById( 'sensei-pro-setup__container' );

if ( rootElement ) {
	createRoot( rootElement ).render( <Setup /> );
}
