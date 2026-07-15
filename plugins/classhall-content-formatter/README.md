# Classhall Content Formatter

Private WordPress admin plugin for safely formatting existing Classhall/Sensei lesson content in small resumable batches.

## Installation

1. Copy `classhall-content-formatter` into `wp-content/plugins/`.
2. Activate **Classhall Content Formatter** in WordPress admin.
3. Open **Tools > Classhall Content Formatter**.
4. Start with dry-run mode. The plugin does not run automatically on activation.

## What It Creates

The plugin creates three database tables using the active WordPress table prefix:

- `{prefix}chcf_runs`: run settings, filters, status, counters, and last processed post ID.
- `{prefix}chcf_changes`: individual proposed changes plus one full `post_content` review record per changed lesson.
- `{prefix}chcf_backups`: original and updated full content for applied automatic changes and rollback.

The table prefix is detected from `$wpdb->prefix` at runtime and shown on the admin page.

## Processing Workflow

The default mode is dry-run. Use:

1. Dry-run on 20 lessons.
2. Review proposed full HTML and individual changes in `{prefix}chcf_changes`.
3. Run a larger dry-run on representative subjects.
4. Use automatic mode only after reviewing results.
5. Roll back per run if needed.

## Safety Model

The formatter:

- Uses keyset pagination by post ID.
- Defaults to a batch size of 10 and max 20 lessons per run.
- Protects shortcodes, Gutenberg comments, MathJax, tables, figures, scripts, styles, iframes, pre/code blocks, and existing display math.
- Validates image URLs, links, shortcode names/counts, table counts, embed counts, MathJax balance, paragraph nesting, and text length.
- Uses `wp_update_post()` for automatic changes.
- Stores backups before automatic writes.
- Verifies updated content checksum before rollback.

## AI Provider Setup

The plugin supports an OpenAI provider and keeps AI disabled until you configure it.

1. Open **Tools > Classhall Content Formatter**.
2. In **AI Provider Settings**, set **Provider** to `OpenAI`.
3. Paste an OpenAI API key.
4. Keep the default endpoint unless you are using a compatible proxy:
   `https://api.openai.com/v1/chat/completions`
5. Start with `gpt-4o-mini` or another structured-output-capable model available to your OpenAI account.
6. Keep **Temperature** at `0`.
7. Set **Max AI calls per run** conservatively while testing.
8. Tick **Enable AI-assisted classification** and save settings.
9. In **New Run**, keep **Dry-run** selected and tick **AI-assisted classification**.

The API key is stored in the `chcf_api_key` WordPress option with autoload disabled. It is never printed back into HTML.

The provider asks the model for structured JSON decisions only. AI decisions are validated before being used, and the AI is never allowed to overwrite a whole lesson by itself.

## Dry-Run Instructions

1. Select `lesson`.
2. Select `publish` and `draft`.
3. Leave mode as `Dry-run`.
4. Keep batch size at `10`.
5. Set max lessons per run to `20`.
6. Click **Start processing**.

Dry-run does not update `wp_posts.post_content`.

## Review Workflow

Review proposed changes in `{prefix}chcf_changes`.

- `change_type = document` contains full original and proposed HTML.
- Other change rows explain heading, paragraph, LaTeX, or cleanup decisions.
- Rows with `status = flagged` need manual review.
- Rows with validation errors must not be auto-applied.

## Rollback

Use **Rollback run** on a run that applied automatic changes. Rollback restores only when the current lesson content checksum matches the plugin's stored updated checksum. If a lesson was manually edited after formatting, it is marked as a conflict.

## Staging Checklist

- Activate on staging first.
- Confirm `lesson` is registered by Sensei.
- Confirm table prefix on the admin page.
- Run deterministic dry-run on 20 lessons.
- Include Mathematics, English, Basic Science, Chemistry, Physics, Foods and Nutrition, and Music.
- Review image, shortcode, table, MathJax, and block-heavy lessons.
- Apply only a small approved automatic batch.
- Verify frontend rendering.

## Production Checklist

- Take a database backup.
- Keep dry-run as the first production operation.
- Use small batches.
- Monitor failed and flagged counts.
- Roll out by subject or post ID ranges.
- Keep rollback records until frontend QA is complete.
