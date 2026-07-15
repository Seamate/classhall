/**
 * WordPress dependencies
 */
import { ToolbarDropdownMenu } from '@wordpress/components';
import { __, sprintf } from '@wordpress/i18n';

/**
 * Internal dependencies
 */
import HeadingLevelIcon from './heading-level-icon';

const HEADING_LEVELS = [ 1, 2, 3, 4, 5, 6 ];

const POPOVER_PROPS = {
	className: 'block-library-heading-level-dropdown',
};

/**
 * HeadingLevelDropdown props.
 *
 * @typedef WPHeadingLevelDropdownProps
 *
 * @property {number} selectedLevel The currently selected heading level (1-6).
 */

/**
 * Dropdown for selecting a heading level (1 through 6).
 *
 * @param {WPHeadingLevelDropdownProps} props Component props.
 *
 * @return {JSX.Element} The toolbar.
 */
export default function HeadingLevelDropdown( { selectedLevel, onChange } ) {
	return (
		<ToolbarDropdownMenu
			popoverProps={ POPOVER_PROPS }
			icon={ <HeadingLevelIcon level={ selectedLevel } /> }
			label={ __( 'Change heading level', 'sensei-pro' ) }
			controls={ HEADING_LEVELS.map( ( targetLevel ) => {
				{
					const isActive = targetLevel === selectedLevel;

					return {
						icon: (
							<HeadingLevelIcon
								level={ targetLevel }
								isPressed={ isActive }
							/>
						),
						label: sprintf(
							// translators: %d: heading level e.g: "1", "2", "3"
							__( 'Heading %d', 'sensei-pro' ),
							targetLevel
						),
						isActive,
						onClick() {
							onChange( targetLevel );
						},
						role: 'menuitemradio',
					};
				}
			} ) }
		/>
	);
}
