(function ($) {
	'use strict';

	function setProgress(message) {
		$('#chcf-progress').html('<p>' + $('<div>').text(message).html() + '</p>');
		setInlineStatus(message);
	}

	function setInlineStatus(message, type) {
		var status = $('#chcf-inline-status');
		status.removeClass('is-error is-success');
		if (type) {
			status.addClass('is-' + type);
		}
		status.text(message);
	}

	function responseMessage(response, fallback) {
		if (response && response.responseJSON && response.responseJSON.data && response.responseJSON.data.message) {
			return response.responseJSON.data.message;
		}
		if (response && response.responseText) {
			return fallback + ' Server response: ' + response.responseText.substring(0, 240);
		}
		return fallback;
	}

	function processBatch(runId) {
		$.post(chcfAdmin.ajaxUrl, {
			action: 'chcf_process_batch',
			nonce: chcfAdmin.nonce,
			run_id: runId
		}).done(function (response) {
			if (!response.success) {
				setProgress(response.data && response.data.message ? response.data.message : 'Processing failed.');
				return;
			}

			var data = response.data;
			setProgress('Run ' + runId + ': ' + data.status + '. Last processed post ID: ' + data.last_id + '. Scanned this batch: ' + (data.counts ? data.counts.scanned : 0) + '.');

			if (data.status === 'running') {
				window.setTimeout(function () {
					processBatch(runId);
				}, 800);
			} else if (data.status === 'complete') {
				setInlineStatus('Run ' + runId + ' completed. Review the Recent Runs table and chcf_changes rows.', 'success');
			}
		}).fail(function (response) {
			setProgress(responseMessage(response, 'Processing request failed.'));
		});
	}

	$('#chcf-run-form').on('submit', function (event) {
		event.preventDefault();
		var button = $(this).find('button[type="submit"]');
		button.prop('disabled', true);
		setProgress('Starting run...');
		$.post(chcfAdmin.ajaxUrl, $(this).serialize()).done(function (response) {
			button.prop('disabled', false);
			if (!response.success) {
				setInlineStatus(response.data && response.data.message ? response.data.message : 'Run could not be started.', 'error');
				return;
			}
			if (!response.data || !response.data.run_id) {
				setInlineStatus('Run could not be started because no run ID was returned. The database tables may not exist yet.', 'error');
				return;
			}
			$('#chcf-current-run').val(response.data.run_id);
			setInlineStatus('Run ' + response.data.run_id + ' started. Processing first batch...');
			processBatch(response.data.run_id);
		}).fail(function (response) {
			button.prop('disabled', false);
			setInlineStatus(responseMessage(response, 'Start request failed.'), 'error');
		});
	});

	$('.chcf-run-action').on('click', function () {
		var runId = $('#chcf-current-run').val();
		if (!runId) {
			setProgress('No active run selected.');
			return;
		}

		$.post(chcfAdmin.ajaxUrl, {
			action: $(this).data('action'),
			nonce: chcfAdmin.nonce,
			run_id: runId
		}).done(function () {
			setProgress('Run action saved.');
		});
	});

	$('.chcf-rollback').on('click', function () {
		var runId = $(this).data('run');
		if (!window.confirm('Rollback this run? Lessons edited after formatting will be marked as conflicts and left unchanged.')) {
			return;
		}

		$.post(chcfAdmin.ajaxUrl, {
			action: 'chcf_rollback_run',
			nonce: chcfAdmin.nonce,
			run_id: runId
		}).done(function (response) {
			if (response.success) {
				setProgress('Rollback complete. Restored: ' + response.data.restored + ', conflicts: ' + response.data.conflicts + ', failed: ' + response.data.failed + '.');
			}
		});
	});
})(jQuery);
