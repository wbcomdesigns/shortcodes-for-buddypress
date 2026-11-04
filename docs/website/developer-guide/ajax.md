# Load More AJAX

The activity listing supports a load-more control that fetches the next page of activity over AJAX. This page documents the single AJAX endpoint the plugin registers.

## Endpoint

| Property | Value |
|---|---|
| Action | `bpsp_activities_load` |
| Availability | Logged-in (`wp_ajax_`) and logged-out (`wp_ajax_nopriv_`) |
| Handler | `Shortcodes_For_Buddypress_Public::buddypress_shortcodes_load_activities()` |
| URL | `admin-ajax.php` |

There are no REST API routes in this plugin; load-more is the only AJAX endpoint.

## Request

The front-end script sends:

| Field | Meaning |
|---|---|
| `action` | `bpsp_activities_load` |
| `page` | Next page number |
| `limit` | Page size |
| `nonce` | Security nonce (`bpsp-nonce`) |

The nonce and the AJAX URL are localized to the script as `buddypress_shortcode.ajax_nonce` and `buddypress_shortcode.ajax_url`. The localized data is filterable via `bp_activity_localized_params`.

## Security and limits

- The handler verifies the nonce (`bpsp-nonce`) before doing any work and returns early if it fails.
- The requested page size is clamped server-side to a safe maximum, so a crafted public request cannot force an unbounded activity query.
- No capability check is required because the endpoint only reads and returns public activity markup for the same stream the page already shows.

## Enabling it

Load-more is off by default. Turn it on per listing with the shortcode attribute:

```
[activity-listing load_more="1"]
```

The plugin's front-end script binds the control and appends each fetched page to the stream.
