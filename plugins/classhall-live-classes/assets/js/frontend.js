(function () {
	function copy(text) {
		if (navigator.clipboard && navigator.clipboard.writeText) {
			return navigator.clipboard.writeText(text);
		}

		var input = document.createElement('input');
		input.value = text;
		document.body.appendChild(input);
		input.select();
		document.execCommand('copy');
		document.body.removeChild(input);
		return Promise.resolve();
	}

	document.addEventListener('click', function (event) {
		var copyButton = event.target.closest('[data-chl-copy]');
		var nativeButton = event.target.closest('[data-chl-native-share]');
		var wrap = event.target.closest('.chl-share');

		if (!wrap) {
			return;
		}

		if (copyButton) {
			copy(wrap.getAttribute('data-share-url') || window.location.href);
		}

		if (nativeButton && navigator.share) {
			navigator.share({
				title: wrap.getAttribute('data-share-title') || document.title,
				text: wrap.getAttribute('data-share-text') || '',
				url: wrap.getAttribute('data-share-url') || window.location.href
			});
		}
	});

	document.addEventListener('submit', function (event) {
		var form = event.target.closest('.chl-form');
		var button;

		if (!form || form.getAttribute('data-chl-submitting') === '1') {
			if (form) {
				event.preventDefault();
			}
			return;
		}

		form.setAttribute('data-chl-submitting', '1');
		button = form.querySelector('button[type="submit"], input[type="submit"]');
		if (button) {
			button.disabled = true;
			button.setAttribute('aria-disabled', 'true');
		}
	});

	document.addEventListener('submit', function (event) {
		var form = event.target.closest('.chl-teacher-search');
		var search;
		var classFilter;

		if (!form) {
			return;
		}

		search = form.querySelector('[name="live_teacher_search"]');
		classFilter = form.querySelector('[name="live_teacher_class"]');
		if (search && search.value.trim() !== '' && classFilter) {
			classFilter.value = '';
		}
	});

	function filterSubjects(form) {
		var level = form.querySelector('[data-chl-class-level]');
		var subject = form.querySelector('[data-chl-subject]');
		var empty = form.querySelector('[data-chl-subject-empty]');
		var selectedLevel;
		var visibleCount = 0;

		if (!level || !subject) {
			return;
		}

		selectedLevel = level.value;
		Array.prototype.forEach.call(subject.options, function (option) {
			var levels = option.getAttribute('data-class-levels') || '';
			var source = option.getAttribute('data-subject-source') || '';
			var isPlaceholder = option.value === '';
			var visible = isPlaceholder || source === 'subject' || (selectedLevel !== '' && levels.split(',').indexOf(selectedLevel) !== -1);

			if (!isPlaceholder) {
				option.textContent = cleanSubjectLabel(option.textContent);
			}
			option.hidden = !visible;
			option.disabled = !visible;
			if (visible && !isPlaceholder) {
				visibleCount += 1;
			}
		});

		if (subject.selectedOptions.length && subject.selectedOptions[0].disabled) {
			subject.value = '';
		}

		subject.setAttribute('data-chl-filtered-count', String(visibleCount));
		if (empty) {
			empty.hidden = visibleCount > 0;
		}
	}

	function cleanSubjectLabel(label) {
		var acronyms = {
			crs: 'CRS',
			gsm: 'GSM',
			ict: 'ICT',
			irs: 'IRS'
		};

		return label
			.replace(/\(\s*\)/g, '')
			.replace(/\s*[-\u2010-\u2015\u2212]+\s*$/g, '')
			.replace(/^\s*[-\u2010-\u2015\u2212]+\s*/g, '')
			.replace(/\s+/g, ' ')
			.trim()
			.toLowerCase()
			.replace(/\b\w/g, function (letter) {
				return letter.toUpperCase();
			})
			.replace(/\b(Crs|Gsm|Ict|Irs)\b/g, function (word) {
				return acronyms[word.toLowerCase()] || word;
			});
	}

	function syncClassType(form) {
		var classType = form.querySelector('[data-chl-class-type]');
		var capacityField = form.querySelector('[data-chl-capacity-field]');
		var capacityInput;

		if (!classType || !capacityField) {
			return;
		}

		capacityInput = capacityField.querySelector('input');
		if (classType.value === 'group') {
			capacityField.hidden = false;
			capacityField.style.display = '';
			if (capacityInput) {
				capacityInput.disabled = false;
			}
			return;
		}

		capacityField.hidden = true;
		capacityField.style.display = 'none';
		if (capacityInput) {
			capacityInput.value = '1';
			capacityInput.disabled = true;
		}
	}

	function syncPlatformHelp(form) {
		var platform = form.querySelector('[data-chl-platform]');
		var link = form.querySelector('[data-chl-platform-link]');
		var platforms = {
			google_meet: {
				label: 'Open Google Meet',
				url: 'https://meet.google.com/new'
			},
			zoom: {
				label: 'Open Zoom',
				url: 'https://zoom.us/meeting/schedule'
			},
			microsoft_teams: {
				label: 'Open Microsoft Teams',
				url: 'https://teams.microsoft.com/'
			},
			other: {
				label: 'Open meeting platform',
				url: 'https://www.google.com/search?q=create+online+meeting+link'
			}
		};
		var selected;

		if (!platform || !link) {
			return;
		}

		selected = platforms[platform.value] || platforms.google_meet;
		link.href = selected.url;
		link.textContent = selected.label;
		link.setAttribute('aria-label', selected.label);
	}

	function syncRecurrence(form) {
		var selected = form.querySelector('[data-chl-recurrence]:checked');
		var days = form.querySelector('[data-chl-recurring-days]');
		var boxes;
		var showDays;

		if (!selected || !days) {
			return;
		}

		showDays = selected.value === 'multiple_days';
		days.hidden = !showDays;
		days.style.display = showDays ? '' : 'none';
		boxes = days.querySelectorAll('input[type="checkbox"]');
		Array.prototype.forEach.call(boxes, function (box) {
			box.disabled = !showDays;
		});
	}

	function handleFieldChange(event) {
		var level = event.target.closest('[data-chl-class-level]');
		var classType = event.target.closest('[data-chl-class-type]');
		var platform = event.target.closest('[data-chl-platform]');
		var recurrence = event.target.closest('[data-chl-recurrence]');
		var autoSubmit = event.target.closest('[data-chl-auto-submit]');
		var star = event.target.closest('.chl-star-rating input[type="radio"]');

		if (level) {
			filterSubjects(level.closest('form'));
		}

		if (classType) {
			syncClassType(classType.closest('form'));
		}

		if (platform) {
			syncPlatformHelp(platform.closest('form'));
		}

		if (recurrence) {
			syncRecurrence(recurrence.closest('form'));
		}

		if (autoSubmit && autoSubmit.form) {
			autoSubmit.form.submit();
		}

		if (star) {
			syncStarRating(star.closest('.chl-star-rating'));
		}
	}

	function syncStarRating(rating) {
		var checked;

		if (!rating) {
			return;
		}

		checked = rating.querySelector('input[type="radio"]:checked');
		rating.setAttribute('data-rating', checked ? checked.value : '');
	}

	document.addEventListener('change', handleFieldChange);
	document.addEventListener('input', handleFieldChange);

	document.addEventListener('DOMContentLoaded', function () {
		Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), filterSubjects);
		Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncClassType);
		Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncPlatformHelp);
		Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncRecurrence);
		Array.prototype.forEach.call(document.querySelectorAll('.chl-star-rating'), syncStarRating);
	});

	Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), filterSubjects);
	Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncClassType);
	Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncPlatformHelp);
	Array.prototype.forEach.call(document.querySelectorAll('.chl-form'), syncRecurrence);
	Array.prototype.forEach.call(document.querySelectorAll('.chl-star-rating'), syncStarRating);
}());
