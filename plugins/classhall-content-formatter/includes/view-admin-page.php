<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $wpdb;
$post_types = get_post_types( array( 'show_ui' => true ), 'objects' );
$courses = get_posts(
	array(
		'post_type'      => 'course',
		'post_status'    => array( 'publish', 'draft', 'private' ),
		'posts_per_page' => 500,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'no_found_rows'  => true,
	)
);
$taxonomy_terms = array();
foreach ( $taxonomies as $taxonomy ) {
	$terms = get_terms(
		array(
			'taxonomy'   => $taxonomy->name,
			'hide_empty' => false,
			'number'     => 500,
		)
	);
	if ( ! is_wp_error( $terms ) && $terms ) {
		$taxonomy_terms[ $taxonomy->name ] = array(
			'label' => $taxonomy->label,
			'terms' => $terms,
		);
	}
}
$selected_run_id = isset( $_GET['chcf_run_id'] ) ? absint( $_GET['chcf_run_id'] ) : 0;
$selected_changes = $selected_run_id ? $repository->get_document_changes_for_run( $selected_run_id, 30 ) : array();
?>
<div class="wrap chcf-wrap">
	<h1><?php esc_html_e( 'Classhall Content Formatter', 'classhall-content-formatter' ); ?></h1>
	<p class="description">
		<?php esc_html_e( 'Private dry-run first formatter for Sensei lesson content. No run starts until you press Start.', 'classhall-content-formatter' ); ?>
	</p>

	<div class="chcf-grid">
		<form id="chcf-run-form" class="chcf-panel">
			<h2><?php esc_html_e( 'New Run', 'classhall-content-formatter' ); ?></h2>
			<div id="chcf-inline-status" class="chcf-inline-status" role="status" aria-live="polite">
				<?php esc_html_e( 'Ready. Keep dry-run selected for the first pass.', 'classhall-content-formatter' ); ?>
			</div>
			<input type="hidden" name="action" value="chcf_start_run">
			<input type="hidden" name="nonce" value="<?php echo esc_attr( wp_create_nonce( 'chcf_admin' ) ); ?>">

			<label>
				<span><?php esc_html_e( 'Post type', 'classhall-content-formatter' ); ?></span>
				<select name="post_type">
					<?php foreach ( $post_types as $post_type ) : ?>
						<option value="<?php echo esc_attr( $post_type->name ); ?>" <?php selected( 'lesson', $post_type->name ); ?>><?php echo esc_html( $post_type->labels->singular_name ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
				<span><?php esc_html_e( 'Post statuses', 'classhall-content-formatter' ); ?></span>
				<select name="post_status[]" multiple>
					<option value="publish" selected><?php esc_html_e( 'Published', 'classhall-content-formatter' ); ?></option>
					<option value="draft" selected><?php esc_html_e( 'Draft', 'classhall-content-formatter' ); ?></option>
					<option value="private"><?php esc_html_e( 'Private', 'classhall-content-formatter' ); ?></option>
					<option value="pending"><?php esc_html_e( 'Pending', 'classhall-content-formatter' ); ?></option>
				</select>
			</label>

			<label>
				<span><?php esc_html_e( 'Subject / course', 'classhall-content-formatter' ); ?></span>
				<select name="course_id">
					<option value="0"><?php esc_html_e( 'All subjects', 'classhall-content-formatter' ); ?></option>
					<?php foreach ( $courses as $course ) : ?>
						<option value="<?php echo esc_attr( $course->ID ); ?>"><?php echo esc_html( get_the_title( $course ) . ' (#' . $course->ID . ')' ); ?></option>
					<?php endforeach; ?>
				</select>
			</label>

			<label>
				<span><?php esc_html_e( 'Lesson taxonomy term', 'classhall-content-formatter' ); ?></span>
				<select name="taxonomy_term">
					<option value=""><?php esc_html_e( 'Any term', 'classhall-content-formatter' ); ?></option>
					<?php foreach ( $taxonomy_terms as $taxonomy_name => $term_group ) : ?>
						<optgroup label="<?php echo esc_attr( $term_group['label'] ); ?>">
							<?php foreach ( $term_group['terms'] as $term ) : ?>
								<option value="<?php echo esc_attr( $taxonomy_name . ':' . $term->term_id ); ?>"><?php echo esc_html( $term->name ); ?></option>
							<?php endforeach; ?>
						</optgroup>
					<?php endforeach; ?>
				</select>
			</label>

			<div class="chcf-columns">
				<label><span><?php esc_html_e( 'Specific post ID', 'classhall-content-formatter' ); ?></span><input type="number" min="0" name="specific_post_id"></label>
				<label><span><?php esc_html_e( 'Starting post ID', 'classhall-content-formatter' ); ?></span><input type="number" min="0" name="start_post_id"></label>
				<label><span><?php esc_html_e( 'Ending post ID', 'classhall-content-formatter' ); ?></span><input type="number" min="0" name="end_post_id"></label>
				<label><span><?php esc_html_e( 'Batch size', 'classhall-content-formatter' ); ?></span><input type="number" min="1" max="50" name="batch_size" value="10"></label>
				<label><span><?php esc_html_e( 'Max lessons per run', 'classhall-content-formatter' ); ?></span><input type="number" min="1" max="500" name="max_lessons_per_run" value="20"></label>
				<label><span><?php esc_html_e( 'Confidence threshold', 'classhall-content-formatter' ); ?></span><input type="number" min="0" max="1" step="0.01" name="confidence_threshold" value="0.92"></label>
			</div>

			<fieldset>
				<legend><?php esc_html_e( 'Mode', 'classhall-content-formatter' ); ?></legend>
				<label><input type="radio" name="mode" value="dry_run" checked> <?php esc_html_e( 'Dry-run', 'classhall-content-formatter' ); ?></label>
				<label><input type="radio" name="mode" value="review"> <?php esc_html_e( 'Review', 'classhall-content-formatter' ); ?></label>
				<label><input type="radio" name="mode" value="automatic"> <?php esc_html_e( 'Automatic', 'classhall-content-formatter' ); ?></label>
			</fieldset>

			<fieldset>
				<legend><?php esc_html_e( 'Formatting', 'classhall-content-formatter' ); ?></legend>
				<label><input type="checkbox" name="paragraph_formatting" value="1" checked> <?php esc_html_e( 'Paragraph formatting', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="heading_detection" value="1" checked> <?php esc_html_e( 'Heading detection', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="latex_conversion" value="1" checked> <?php esc_html_e( 'LaTeX conversion', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="empty_paragraph_cleanup" value="1" checked> <?php esc_html_e( 'Empty paragraph cleanup', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="skip_processed" value="1" checked> <?php esc_html_e( 'Skip already processed lessons', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="reprocess_flagged" value="1"> <?php esc_html_e( 'Reprocess flagged lessons', 'classhall-content-formatter' ); ?></label>
				<label><input type="checkbox" name="ai_enabled" value="1"> <?php esc_html_e( 'AI-assisted classification', 'classhall-content-formatter' ); ?></label>
			</fieldset>

			<p class="submit">
				<button type="submit" class="button button-primary"><?php esc_html_e( 'Start processing', 'classhall-content-formatter' ); ?></button>
				<button type="button" class="button chcf-run-action" data-action="chcf_pause_run"><?php esc_html_e( 'Pause', 'classhall-content-formatter' ); ?></button>
				<button type="button" class="button chcf-run-action" data-action="chcf_resume_run"><?php esc_html_e( 'Resume', 'classhall-content-formatter' ); ?></button>
				<button type="button" class="button chcf-run-action" data-action="chcf_stop_run"><?php esc_html_e( 'Stop', 'classhall-content-formatter' ); ?></button>
			</p>
			<input type="hidden" id="chcf-current-run" value="">
		</form>

		<div class="chcf-panel">
			<h2><?php esc_html_e( 'Progress', 'classhall-content-formatter' ); ?></h2>
			<div id="chcf-progress" class="chcf-progress">
				<p><?php esc_html_e( 'No active run.', 'classhall-content-formatter' ); ?></p>
			</div>
			<h3><?php esc_html_e( 'Runtime Facts', 'classhall-content-formatter' ); ?></h3>
			<ul>
				<li><?php echo esc_html( sprintf( 'Detected table prefix: %s', $wpdb->prefix ) ); ?></li>
				<li><?php echo esc_html( sprintf( 'WordPress version: %s', get_bloginfo( 'version' ) ) ); ?></li>
				<li><?php echo esc_html( sprintf( 'PHP version: %s', PHP_VERSION ) ); ?></li>
				<li><?php echo esc_html( sprintf( 'Action Scheduler available: %s', function_exists( 'as_enqueue_async_action' ) ? 'yes' : 'no' ) ); ?></li>
				<li><?php echo esc_html( sprintf( 'AI provider: %s', $settings['provider'] ) ); ?></li>
			</ul>
		</div>
	</div>

	<div class="chcf-panel">
		<h2><?php esc_html_e( 'AI Provider Settings', 'classhall-content-formatter' ); ?></h2>
		<?php if ( ! empty( $_GET['chcf_settings_saved'] ) ) : ?>
			<div class="notice notice-success inline"><p><?php esc_html_e( 'AI settings saved.', 'classhall-content-formatter' ); ?></p></div>
		<?php endif; ?>
		<form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
			<?php wp_nonce_field( 'chcf_save_settings' ); ?>
			<input type="hidden" name="action" value="chcf_save_settings">
			<div class="chcf-columns">
				<label>
					<span><?php esc_html_e( 'Provider', 'classhall-content-formatter' ); ?></span>
					<select name="provider">
						<option value="none" <?php selected( 'none', $settings['provider'] ); ?>><?php esc_html_e( 'None', 'classhall-content-formatter' ); ?></option>
						<option value="openai" <?php selected( 'openai', $settings['provider'] ); ?>><?php esc_html_e( 'OpenAI', 'classhall-content-formatter' ); ?></option>
					</select>
				</label>
				<label>
					<span><?php esc_html_e( 'Model', 'classhall-content-formatter' ); ?></span>
					<input type="text" name="model" value="<?php echo esc_attr( $settings['model'] ); ?>" placeholder="gpt-4o-mini">
				</label>
				<label>
					<span><?php esc_html_e( 'Endpoint', 'classhall-content-formatter' ); ?></span>
					<input type="url" name="endpoint" value="<?php echo esc_attr( $settings['endpoint'] ); ?>">
				</label>
				<label>
					<span><?php esc_html_e( 'Temperature', 'classhall-content-formatter' ); ?></span>
					<input type="number" min="0" max="1" step="0.01" name="temperature" value="<?php echo esc_attr( $settings['temperature'] ); ?>">
				</label>
				<label>
					<span><?php esc_html_e( 'Token limit', 'classhall-content-formatter' ); ?></span>
					<input type="number" min="200" max="4000" name="token_limit" value="<?php echo esc_attr( $settings['token_limit'] ); ?>">
				</label>
				<label>
					<span><?php esc_html_e( 'Request timeout', 'classhall-content-formatter' ); ?></span>
					<input type="number" min="5" max="120" name="timeout" value="<?php echo esc_attr( $settings['timeout'] ); ?>">
				</label>
				<label>
					<span><?php esc_html_e( 'Max AI calls per run', 'classhall-content-formatter' ); ?></span>
					<input type="number" min="0" max="500" name="max_ai_calls" value="<?php echo esc_attr( $settings['max_ai_calls'] ); ?>">
				</label>
				<label>
					<span><?php esc_html_e( 'OpenAI API key', 'classhall-content-formatter' ); ?></span>
					<input type="password" name="api_key" value="" autocomplete="off" placeholder="<?php echo get_option( 'chcf_api_key', '' ) ? esc_attr__( 'Saved - leave blank to keep existing key', 'classhall-content-formatter' ) : esc_attr__( 'Paste API key', 'classhall-content-formatter' ); ?>">
				</label>
				<label class="chcf-checkbox-label">
					<input type="checkbox" name="ai_enabled" value="1" <?php checked( ! empty( $settings['ai_enabled'] ) ); ?>>
					<?php esc_html_e( 'Enable AI-assisted classification for runs where the AI checkbox is selected', 'classhall-content-formatter' ); ?>
				</label>
			</div>
			<p class="description">
				<?php esc_html_e( 'The key is stored in a non-autoloaded WordPress option and is never printed back into HTML. Keep dry-run mode while testing AI results.', 'classhall-content-formatter' ); ?>
			</p>
			<p><button type="submit" class="button button-secondary"><?php esc_html_e( 'Save AI settings', 'classhall-content-formatter' ); ?></button></p>
		</form>
	</div>

	<div class="chcf-panel">
		<h2><?php esc_html_e( 'Recent Runs', 'classhall-content-formatter' ); ?></h2>
		<table class="widefat striped">
			<thead><tr><th>ID</th><th>Mode</th><th>Status</th><th>Last ID</th><th>Scanned</th><th>Changed</th><th>Flagged</th><th>Failed</th><th>Actions</th></tr></thead>
			<tbody>
				<?php if ( $runs ) : ?>
					<?php foreach ( $runs as $run ) : ?>
						<tr>
							<td><?php echo esc_html( $run->run_id ); ?></td>
							<td><?php echo esc_html( $run->mode ); ?></td>
							<td><?php echo esc_html( $run->status ); ?></td>
							<td><?php echo esc_html( $run->last_processed_post_id ); ?></td>
							<td><?php echo esc_html( $run->total_scanned ); ?></td>
							<td><?php echo esc_html( $run->total_changed ); ?></td>
							<td><?php echo esc_html( $run->total_flagged ); ?></td>
							<td><?php echo esc_html( $run->total_failed ); ?></td>
							<td>
								<a class="button" href="<?php echo esc_url( add_query_arg( 'chcf_run_id', absint( $run->run_id ) ) ); ?>"><?php esc_html_e( 'View changes', 'classhall-content-formatter' ); ?></a>
								<button class="button chcf-rollback" data-run="<?php echo esc_attr( $run->run_id ); ?>"><?php esc_html_e( 'Rollback run', 'classhall-content-formatter' ); ?></button>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr><td colspan="9"><?php esc_html_e( 'No formatter runs yet.', 'classhall-content-formatter' ); ?></td></tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if ( $selected_run_id ) : ?>
		<div class="chcf-panel chcf-review-panel">
			<h2><?php echo esc_html( sprintf( __( 'Proposed Lesson Changes for Run %d', 'classhall-content-formatter' ), $selected_run_id ) ); ?></h2>
			<?php if ( $selected_changes ) : ?>
				<?php foreach ( $selected_changes as $document_change ) : ?>
					<?php
					$post = get_post( absint( $document_change->post_id ) );
					$fragments = $repository->get_fragment_changes_for_post( $selected_run_id, $document_change->post_id );
					$errors = $document_change->validation_errors ? json_decode( $document_change->validation_errors, true ) : array();
					?>
					<section class="chcf-review-item">
						<header class="chcf-review-header">
							<div>
								<h3><?php echo esc_html( $post ? get_the_title( $post ) : sprintf( __( 'Post %d', 'classhall-content-formatter' ), $document_change->post_id ) ); ?></h3>
								<p>
									<?php echo esc_html( sprintf( 'Post ID: %d | Status: %s | Confidence: %.2f', $document_change->post_id, $document_change->status, $document_change->confidence ) ); ?>
								</p>
							</div>
							<div class="chcf-review-actions">
								<?php if ( $post ) : ?>
									<a class="button" href="<?php echo esc_url( get_edit_post_link( $post->ID, '' ) ); ?>"><?php esc_html_e( 'Open editor', 'classhall-content-formatter' ); ?></a>
									<a class="button" href="<?php echo esc_url( get_permalink( $post ) ); ?>" target="_blank" rel="noopener noreferrer"><?php esc_html_e( 'View lesson', 'classhall-content-formatter' ); ?></a>
								<?php endif; ?>
							</div>
						</header>

						<?php if ( $errors ) : ?>
							<div class="chcf-validation-errors">
								<strong><?php esc_html_e( 'Validation warnings:', 'classhall-content-formatter' ); ?></strong>
								<ul>
									<?php foreach ( $errors as $error ) : ?>
										<li><?php echo esc_html( $error ); ?></li>
									<?php endforeach; ?>
								</ul>
							</div>
						<?php endif; ?>

						<?php if ( $fragments ) : ?>
							<table class="widefat striped chcf-fragments">
								<thead><tr><th><?php esc_html_e( 'Type', 'classhall-content-formatter' ); ?></th><th><?php esc_html_e( 'Original', 'classhall-content-formatter' ); ?></th><th><?php esc_html_e( 'Proposed', 'classhall-content-formatter' ); ?></th><th><?php esc_html_e( 'Reason', 'classhall-content-formatter' ); ?></th></tr></thead>
								<tbody>
									<?php foreach ( $fragments as $fragment ) : ?>
										<tr>
											<td><?php echo esc_html( $fragment->change_type ); ?></td>
											<td><pre class="chcf-inline-code"><?php echo esc_html( $fragment->original_fragment ); ?></pre></td>
											<td><pre class="chcf-inline-code chcf-proposed-code"><?php echo esc_html( $fragment->proposed_fragment ); ?></pre></td>
											<td><?php echo esc_html( $fragment->reason ); ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
						<?php endif; ?>

						<details class="chcf-diff-details">
							<summary><?php esc_html_e( 'Show full original and proposed HTML', 'classhall-content-formatter' ); ?></summary>
							<div class="chcf-diff-grid">
								<div>
									<h4><?php esc_html_e( 'Original', 'classhall-content-formatter' ); ?></h4>
									<pre><?php echo esc_html( $document_change->original_fragment ); ?></pre>
								</div>
								<div>
									<h4><?php esc_html_e( 'Proposed', 'classhall-content-formatter' ); ?></h4>
									<pre><?php echo esc_html( $document_change->proposed_fragment ); ?></pre>
								</div>
							</div>
						</details>
					</section>
				<?php endforeach; ?>
			<?php else : ?>
				<p><?php esc_html_e( 'No document-level proposed changes were saved for this run. If the run shows 0 changed and 0 flagged, the formatter considered those lessons unchanged or skipped them as already processed.', 'classhall-content-formatter' ); ?></p>
			<?php endif; ?>
		</div>
	<?php endif; ?>
</div>
