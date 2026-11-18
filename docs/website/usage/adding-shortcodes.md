# Adding Shortcodes to a Page

## Place a shortcode

Add any of the three shortcodes to a post, page, text widget, or a block that accepts shortcodes:

```
[activity-listing]
[members-listing]
[groups-listing]
```

With no attributes, each shortcode uses its defaults (see the Shortcode Reference). Publish or preview the page and the listing renders inline.

## Add attributes

Attributes go inside the brackets as `name="value"` pairs:

```
[activity-listing per_page="5" title="Latest activity"]
[members-listing type="newest" grid="yes" loop_layout="four"]
[groups-listing type="popular" per_page="6"]
```

## Value formats

- Boolean-style attributes accept `1`/`0` or `true`/`false` depending on the attribute; check the default in the reference. For example activity uses `load_more="1"`, groups uses `show_hidden="true"`.
- Lists of IDs are comma-separated, for example `include="1,5,10"`.
- Attribute names are lowercase and must match the reference exactly. An unrecognised attribute is ignored.

## Which BuddyPress component is required

Each shortcode needs its matching BuddyPress component enabled:

| Shortcode | Requires component |
|---|---|
| `[activity-listing]` | Activity |
| `[members-listing]` | Members |
| `[groups-listing]` | Groups |

If the component is off, administrators see a short "please enable" notice in place of the listing and visitors see nothing.

## The listing needs the Nouveau template pack

All three shortcodes render through the BuddyPress Nouveau templates. If the site runs the legacy template pack and the Nouveau template functions are unavailable, the listing is replaced by an admin-only notice asking you to switch on Nouveau under Settings > BuddyPress > Options. Only administrators see that notice.
