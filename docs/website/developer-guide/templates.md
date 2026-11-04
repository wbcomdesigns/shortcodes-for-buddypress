# Template Overrides

The shortcodes render through template files that live in the plugin under `templates/nouveau/`. You can override them from your theme.

## Template files

| Listing | BuddyPress (Nouveau) | BuddyBoss variant |
|---|---|---|
| Activity | `activity/bp-shortcodes-activity.php` | (uses the BuddyPress variant) |
| Members | `members/bp-shortcodes-members.php` | `members/bb-shortcodes-members.php` |
| Groups | `groups/bp-shortcodes-groups.php` | `groups/bb-shortcodes-groups.php` |

The `bb-` variant is chosen automatically when the BuddyBoss Platform is active; otherwise the `bp-` variant is used.

## How templates are located

The plugin resolves a template with `bp_shortcode_locate_template()`, which searches in this order:

1. Your active theme, under the `nouveau/` subpath (for example `wp-content/themes/your-theme/nouveau/members/bp-shortcodes-members.php`).
2. Your active theme root (the bare template name).
3. The plugin's own `templates/nouveau/` folder as the fallback.

To override a template, copy the file from the plugin's `templates/nouveau/` folder into your theme under the same relative path beginning with `nouveau/`. The resolved path can also be filtered with `bp_shortcode_locate_template`.

## Nouveau is required

Since 3.0.0 the shortcodes always render the Nouveau templates, which call Nouveau-only template tags. If the site runs the legacy template pack and those functions are not defined, the plugin does not load Nouveau on demand (doing so would hijack BuddyPress's own pages). Instead it renders an admin-only notice telling the administrator to switch on the Nouveau template pack under Settings > BuddyPress > Options. Plan template overrides against the Nouveau markup.

## Template variables

Each shortcode passes a set of variables into its template (filterable via the template-args filters in Hooks and Filters), including the built query string, the raw query arguments, and, for members and groups, the computed grid/column classes. Inspect the shipped template files for the exact variables in use before overriding.
