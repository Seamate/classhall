# Cloudways Performance Implementation Notes

Cloudways identified server-side caching and memory pressure as the main causes of slow response time. The codebase now prefers Breeze page cache when Breeze has generated its config, but the following live-server steps are still required outside `wp-content`.

## wp-config.php

Keep only one `DISABLE_WP_CRON` definition and make sure `WP_CACHE` is defined before WordPress loads.

```php
define( 'DISABLE_WP_CRON', true );
define( 'WP_CACHE', true );
define( 'WP_CACHE_KEY_SALT', 'classhall.com:' );
```

Remove the duplicate `DISABLE_WP_CRON` definition reported around line 65.

## Breeze

Activate Breeze in WordPress admin, then enable:

- Cache System
- Gzip compression, if not already handled by Nginx
- Browser cache
- Database cleanup on a controlled schedule only

Avoid aggressive JS/CSS combine/defer settings until the homepage, checkout, login, lessons, quizzes, and Ultimate Member pages have been smoke-tested.

## Object Cache Pro

The local export currently contains `plugins/redis-cache-pro.disabled` and no `wp-content/object-cache.php` drop-in. On the live server:

- Rename/restore the plugin folder to `redis-cache-pro` if Cloudways expects that path.
- Activate Object Cache Pro.
- Confirm Redis is connected from the plugin dashboard.
- Confirm `wp-content/object-cache.php` exists after activation.

## Ultimate Member

The child theme already disables the expensive Ultimate Member account-status backfill queue unless `CLASSHALL_ALLOW_UM_STATUS_BACKFILL` is explicitly enabled. Further UM work should be based on the exact slow query from Cloudways or Query Monitor so login/register/profile behavior is not damaged.

## Server

If swap usage continues after Breeze and Object Cache Pro are active, reduce PHP-FPM workers or increase RAM. A server using swap under normal traffic will still feel slow even with WordPress-level optimizations.
