# Classhall Live Classes API

Namespace: `classhall-live/v1`.

Implemented Phase 1 endpoints:

* `GET /classes`: public approved/published class search. Args: `subject`, `page`. Response excludes meeting links.
* `GET /me/bookings`: authenticated current-user booking list. Response excludes meeting links.
* `GET /teacher/classes`: approved teacher/private capability endpoint for own classes.

Planned extension endpoints:

* `GET /teachers`
* `POST /teacher/classes`
* `POST /reviews`
* `POST /referrals`

Security rules: every private endpoint has a permission callback, responses are minimized, meeting URLs are never returned, and paginated queries use bounded limits.

