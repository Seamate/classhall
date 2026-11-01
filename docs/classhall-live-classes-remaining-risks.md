# Remaining Risks

* Production database isolation level and object cache behavior must be tested for simultaneous last-seat bookings.
* Full WordPress and WooCommerce automated tests could not be authored against a local test harness because only `wp-content` is present.
* Existing `kleo-live-classes` data is not migrated automatically; a migration plan is needed if production already uses it.
* Admin list screens are serviceable but should become paginated `WP_List_Table` screens before large-scale launch.
* Meeting URLs are not encrypted at rest.
* Product sync occurs on approval/status hooks; existing approved records may need a CLI reconciliation run after deployment.
* Public teacher profile routes require permalink flushing through plugin activation or a manual Settings > Permalinks save after deploying over an already-active copy.
