/**
 * WordPress dependencies
 */
import { __ } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import metadata from './block.json';
import edit from './tutor-ai-edit';
import { ReactComponent as icon } from '../icons/tutor-ai.svg';

const tutorAiBlock = {
	...metadata,
	title: __( 'Tutor AI', 'sensei-pro' ),
	icon,
	description: __(
		'Guide your students in finding the right answer with the help of AI, allowing them to delve deeper into the topic.',
		'sensei-pro'
	),
	keywords: [
		__( 'tutor', 'sensei-pro' ),
		__( 'ai', 'sensei-pro' ),
		__( 'question', 'sensei-pro' ),
	],
	edit,
	save: ( { children, blockProps } ) => {
		return <div { ...blockProps }>{ children }</div>;
	},
};

export default tutorAiBlock;
