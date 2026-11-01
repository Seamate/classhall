(function () {
	'use strict';

	var selector = '.classhall-access-info';

	function closeButton(button) {
		var panel = document.getElementById(button.getAttribute('aria-controls'));
		button.setAttribute('aria-expanded', 'false');
		if (panel) {
			panel.hidden = true;
		}
	}

	function closeAll(exceptButton) {
		document.querySelectorAll(selector + '[aria-expanded="true"]').forEach(function (button) {
			if (button !== exceptButton) {
				closeButton(button);
			}
		});
	}

	function openButton(button) {
		var panel = document.getElementById(button.getAttribute('aria-controls'));

		closeAll(button);

		if (!panel) {
			return;
		}

		button.setAttribute('aria-expanded', 'true');
		panel.hidden = false;
	}

	function toggleButton(button) {
		var panel = document.getElementById(button.getAttribute('aria-controls'));
		var shouldOpen = button.getAttribute('aria-expanded') !== 'true';

		closeAll(button);

		if (!panel) {
			return;
		}

		button.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
		panel.hidden = !shouldOpen;
	}

	function initDesktopHover() {
		var supportsHover = window.matchMedia && window.matchMedia('(hover: hover) and (pointer: fine)').matches;

		if (!supportsHover) {
			return;
		}

		document.querySelectorAll('.classhall-access-option').forEach(function (option) {
			var button = option.querySelector(selector);

			if (!button) {
				return;
			}

			button.addEventListener('mouseenter', function () {
				openButton(button);
			});

			option.addEventListener('mouseleave', function () {
				closeButton(button);
			});
		});
	}

	if (document.readyState === 'loading') {
		document.addEventListener('DOMContentLoaded', initDesktopHover);
	} else {
		initDesktopHover();
	}

	document.addEventListener('click', function (event) {
		var button = event.target.closest(selector);

		if (button) {
			toggleButton(button);
			return;
		}

		if (!event.target.closest('.classhall-access-info-panel')) {
			closeAll();
		}
	});

	document.addEventListener('keydown', function (event) {
		if (event.key === 'Escape') {
			closeAll();
		}
	});
}());
