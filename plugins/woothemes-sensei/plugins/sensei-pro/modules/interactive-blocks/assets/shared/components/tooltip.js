/**
 * WordPress dependencies
 */
import { useState } from '@wordpress/element';

/**
 * External dependencies
 */
import {
	useFloating,
	useInteractions,
	useHover,
	useFocus,
	useRole,
	useDismiss,
	flip,
	shift,
	offset,
	useTransitionStyles,
} from '@floating-ui/react';

/**
 * Frontend tooltip component. Shows 'message' in a tooltip when hovered or focused.
 *
 * @param {Object}  props
 * @param {*}       props.message   Tooltip content.
 * @param {string}  props.placement Positioning.
 * @param {boolean} props.disabled  Disable showing the tooltip on hover.
 */
export const Tooltip = ( { message, placement, disabled, ...props } ) => {
	const [ isOpen, setIsOpen ] = useState( false );

	const { refs, floatingStyles, context } = useFloating( {
		placement: placement || 'top',
		strategy: 'fixed',
		middleware: [ offset( 8 ), flip(), shift() ],
		open: isOpen,
		onOpenChange: setIsOpen,
	} );

	const { styles: transitionStyles } = useTransitionStyles( context );

	const { getReferenceProps, getFloatingProps } = useInteractions( [
		useHover( context, { enabled: ! disabled } ),
		useFocus( context, { enabled: ! disabled } ),
		useRole( context, { role: 'tooltip' } ),
		useDismiss( context ),
	] );

	if ( disabled ) {
		const Tag = props.as ?? 'div';
		return <Tag { ...props } />;
	}

	return (
		<>
			<div
				ref={ refs.setReference }
				{ ...getReferenceProps() }
				{ ...props }
			/>
			{ isOpen && (
				<div
					ref={ refs.setFloating }
					style={ { ...floatingStyles, ...transitionStyles } }
					{ ...getFloatingProps() }
					className="sensei-lms-tooltip"
				>
					{ message }
				</div>
			) }
		</>
	);
};
