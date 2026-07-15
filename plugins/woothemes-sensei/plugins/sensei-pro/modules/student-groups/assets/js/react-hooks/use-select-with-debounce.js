/**
 * External dependencies
 */
import { debounce } from 'lodash';

/**
 * WordPress dependencies
 */
import { useSelect } from '@wordpress/data';
import { useState, useEffect, useMemo } from '@wordpress/element';

/**
 * Use select hook with debounce.
 *
 * @param {Function} mapSelect Map select function.
 * @param {Array}    deps      Use select dependencies.
 * @param {number}   wait      Wait time for the debounce.
 *
 * @return {*} Returns what useSelect returns through the mapSelect argument.
 */
const useSelectWithDebounce = ( mapSelect, deps, wait ) => {
	const [ depsState, setDepsState ] = useState( deps );

	const debounceSetDepsState = useMemo(
		() =>
			debounce( ( newDeps ) => {
				setDepsState( newDeps );
			}, wait ),
		[ wait ]
	);

	useEffect( () => {
		debounceSetDepsState( deps );
		// eslint-disable-next-line react-hooks/exhaustive-deps -- Dependencies coming from args.
	}, deps );

	// Cleanup - Cancel any pending debounced calls on unmount or when debounced function changes.
	useEffect( () => {
		return () => {
			debounceSetDepsState.cancel();
		};
	}, [ debounceSetDepsState ] );

	return useSelect( mapSelect, [ ...depsState, mapSelect ] );
};

export default useSelectWithDebounce;
