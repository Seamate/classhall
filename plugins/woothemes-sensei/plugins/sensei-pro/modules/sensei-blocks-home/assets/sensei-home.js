/**
 * WordPress dependencies
 */
import { createRoot } from '@wordpress/element';

/**
 * Internal dependencies
 */
import Main from './main';

const rootElement = document.getElementById( 'sensei-home-page' );

if ( rootElement ) {
	createRoot( rootElement ).render( <Main /> );
}
