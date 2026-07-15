# Changelog

## 0.2.3

- Added Subject/Course dropdown using Sensei's `_lesson_course` relationship.
- Replaced raw taxonomy term ID entry with a term dropdown.
- Protected list markup from paragraph and heading conversion.
- Prevented blank lines from being proposed as empty paragraphs.

## 0.2.2

- Changed the review table to display raw escaped HTML fragments so paragraph and heading tags are visible.
- Highlighted proposed fragments in the review UI.

## 0.2.1

- Added admin review panel for document-level proposed changes.
- Added per-run View changes links.
- Added lesson editor/frontend links and side-by-side original/proposed HTML view.

## 0.2.0

- Added OpenAI provider settings.
- Added non-autoloaded API key storage.
- Added OpenAI structured JSON provider implementation.
- Connected AI-assisted classification into formatter runs.

## 0.1.1

- Added visible inline run status near the Start button.
- Added AJAX failure messages for start and batch requests.
- Added cache-busting version bump for admin assets.

## 0.1.0

- Initial private plugin scaffold.
- Added admin page under Tools.
- Added runs, changes, and backups tables.
- Added resumable keyset batch runner.
- Added deterministic formatting engine.
- Added protected-content validation.
- Added checksum-based rollback.
- Added AI provider interface with null provider.
- Added documentation and focused tests.
