# Classhall Architecture Notes and Assumptions

## Observed

- The repository is a `wp-content` checkout, not a full WordPress root.
- `wp-config.php` is not present, so the actual table prefix cannot be read statically from this checkout.
- The plugin uses `$wpdb->prefix` at runtime and displays it in admin.
- Sensei LMS is installed at `plugins/woothemes-sensei/plugins/sensei-lms`.
- Sensei LMS version in source is `4.26.0`.
- Sensei declares `Requires at least: 6.8` and `Requires PHP: 7.4`.
- Sensei registers the `lesson` post type in `includes/class-sensei-posttypes.php`.
- `lesson` supports title, excerpt, thumbnail, revisions, and editor.
- `lesson` has `show_in_rest => true`, `rest_base => lessons`, and `capability_type => lesson`.
- The active child theme renders single lesson content with `the_content()` in `themes/kleo-child/sensei/single-lesson.php`.
- The child theme enqueues MathJax for `lesson`, `question`, `dwqa-question`, lesson archives, and selected homepage contexts.
- A sample `classhall.lesson.json` export contains lesson body HTML in a `Content` field and maps records to WordPress `PostId`.
- Sample lesson content includes malformed paragraph/heading nesting, bare `CONTENT`, `EVALUATION`, images, captions, tables via `[jtrt_tables]`, and chemical notation.

## Risks

- Some legacy lesson HTML is malformed, especially headings inside paragraphs.
- `CONTENT` and `EVALUATION` are often labels, not lesson headings.
- Chemical notation may already use HTML subscript tags and should not be blindly converted to LaTeX.
- Shortcodes such as `[jtrt_tables]` must remain byte-for-byte intact.
- Sensei relationships are stored in post meta and taxonomies; this plugin updates only `post_content`.
- Large database size makes `OFFSET` queries unsafe.
- Visitor-triggered cron may be unreliable, so the admin UI uses controlled AJAX batches.

## Proposed Plugin Architecture

- `CHCF_Runner`: creates and resumes runs, queries lessons by keyset pagination, applies modes.
- `CHCF_Formatter`: deterministic paragraph, heading, cleanup, and LaTeX proposals.
- `CHCF_Protection`: temporarily protects shortcodes, blocks, MathJax, tables, and embeds.
- `CHCF_Validator`: rejects output that changes protected structures or creates invalid patterns.
- `CHCF_Repository`: stores runs, changes, and backups using `$wpdb->prefix`.
- `CHCF_Rollback`: checksum guarded rollback.
- `CHCF_AI_Provider_Interface`: future AI provider abstraction.
- `CHCF_Null_AI_Provider`: no-op provider; AI disabled by default.

## Files Created

- `classhall-content-formatter.php`
- `includes/*.php`
- `assets/admin.js`
- `assets/admin.css`
- `README.md`
- `CHANGELOG.md`
- `ASSUMPTIONS.md`
- `tests/*`

