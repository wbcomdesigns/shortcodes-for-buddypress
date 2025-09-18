# BuddyPress Shortcodes - Quick Reference

## 🎯 Activity Listing Shortcode

### Syntax
```
[activity-listing parameter="value"]
```

### Parameters Reference

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `title` | string | (empty) | Section title |
| `per_page` | int | 10 | Items per page |
| `max` | int/bool | false | Maximum items to retrieve |
| `page` | int | 1 | Page number |
| `scope` | string | false | Filter scope: `friends`, `groups`, `mentions`, `favorites` |
| `user_id` | int | false | Specific user's activities |
| `object` | string | false | Object type: `groups`, `profile`, `status`, `friends` |
| `action` | string | false | Action type: `activity_update`, `new_member`, etc. |
| `primary_id` | int | false | Primary ID filter |
| `secondary_id` | int | false | Secondary ID filter |
| `search_terms` | string | false | Search keywords |
| `display_comments` | string | "false" | Show comments: `true`, `false` |
| `allow_posting` | bool | false | Enable activity posting form |
| `pagination` | int | 1 | Show pagination: `0`, `1` |
| `load_more` | int | 0 | Enable load more: `0`, `1` |
| `hide_on_activity` | int | 1 | Hide on activity page: `0`, `1` |
| `sort` | string | "DESC" | Sort order: `ASC`, `DESC` |
| `container_class` | string | "activity" | Container CSS class |

### Common Examples
```
[activity-listing per_page="5"]
[activity-listing scope="friends" display_comments="true"]
[activity-listing object="groups" per_page="10"]
[activity-listing user_id="1" max="20"]
```

---

## 👥 Members Listing Shortcode

### Syntax
```
[members-listing parameter="value"]
```

### Parameters Reference

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `title` | string | (empty) | Section title |
| `type` | string | "active" | Sort by: `active`, `newest`, `alphabetical`, `online`, `random` |
| `per_page` | int | 20 | Members per page |
| `max` | int/bool | false | Maximum members to retrieve |
| `page` | int | false | Page number |
| `page_arg` | string | "upage" | URL parameter for pagination |
| `include` | string | false | Include specific user IDs (comma-separated) |
| `exclude` | string | false | Exclude specific user IDs (comma-separated) |
| `user_id` | int | false | Filter by user ID |
| `user_ids` | string | false | Multiple user IDs |
| `member_type` | string | false | Member type slug |
| `member_type__in` | string | "" | Include member types (comma-separated) |
| `member_type__not_in` | string | "" | Exclude member types (comma-separated) |
| `search_terms` | string | false | Search keywords |
| `meta_key` | string | false | Meta key for filtering |
| `meta_value` | string | false | Meta value for filtering |
| `xprofile_query` | array | false | XProfile field query |
| `populate_extras` | bool | false | Populate extra member data |
| `grid` | string | "yes" | Enable grid layout: `yes`, `no` |
| `loop_layout` | string | "three" | Grid columns: `one`, `two`, `three`, `four` |
| `grid_layout` | string | "list" | Layout style: `list`, `grid` |
| `grid_columns` | string | "four" | Alternative column setting |
| `container_class` | string | "members" | Container CSS class |

### Common Examples
```
[members-listing type="newest" per_page="12"]
[members-listing type="online" grid="yes" loop_layout="four"]
[members-listing exclude="1,2,3" type="active"]
[members-listing member_type="student" per_page="20"]
[members-listing search_terms="developer"]
```

---

## 👫 Groups Listing Shortcode

### Syntax
```
[groups-listing parameter="value"]
```

### Parameters Reference

| Parameter | Type | Default | Description |
|-----------|------|---------|-------------|
| `title` | string | (empty) | Section title |
| `type` | string | "alphabetical" | Sort by: `active`, `newest`, `alphabetical`, `popular`, `random` |
| `order` | string | "DESC" | Sort order: `ASC`, `DESC` |
| `orderby` | string | "last_activity" | Order by field |
| `per_page` | int | 20 | Groups per page |
| `max` | int/bool | false | Maximum groups to retrieve |
| `page` | int | 1 | Page number |
| `page_arg` | string | "grpage" | URL parameter for pagination |
| `user_id` | int | false | User's groups |
| `slug` | string | false | Group slug |
| `search_terms` | string | false | Search keywords |
| `group_type` | string | false | Group type slug |
| `group_type__in` | string | "" | Include group types (comma-separated) |
| `group_type__not_in` | string | "" | Exclude group types (comma-separated) |
| `meta_query` | array | false | Meta query array |
| `include` | string | false | Include specific group IDs (comma-separated) |
| `exclude` | string | false | Exclude specific group IDs (comma-separated) |
| `parent_id` | int | 0 | Parent group ID |
| `show_hidden` | bool | false | Show hidden groups: `true`, `false` |
| `update_meta_cache` | bool | true | Update meta cache |
| `grid` | string | "yes" | Enable grid layout: `yes`, `no` |
| `loop_layout` | string | "three" | Grid columns: `one`, `two`, `three`, `four` |
| `container_class` | string | "group" | Container CSS class |

### Common Examples
```
[groups-listing type="popular" per_page="6"]
[groups-listing type="newest" grid="yes" loop_layout="two"]
[groups-listing show_hidden="true" type="active"]
[groups-listing group_type="public" order="ASC"]
[groups-listing search_terms="sports" per_page="12"]
```

---

## 🎨 Layout Options

### Grid Layouts

All three shortcodes support grid layouts with these options:

| Parameter | Options | Description |
|-----------|---------|-------------|
| `grid` | `yes`, `no` | Enable/disable grid layout |
| `loop_layout` | `one`, `two`, `three`, `four` | Number of columns |

### Examples
```
<!-- Single column list -->
[members-listing grid="no"]

<!-- Two column grid -->
[groups-listing grid="yes" loop_layout="two"]

<!-- Four column grid -->
[members-listing grid="yes" loop_layout="four"]
```

---

## 🔍 Filtering Options

### By Type
```
[members-listing type="online"]        <!-- Online members -->
[members-listing type="newest"]        <!-- New members -->
[groups-listing type="popular"]        <!-- Popular groups -->
[activity-listing scope="friends"]     <!-- Friends' activities -->
```

### By Search
```
[members-listing search_terms="john"]
[groups-listing search_terms="photography"]
```

### By Include/Exclude
```
[members-listing include="1,5,10"]     <!-- Only these users -->
[groups-listing exclude="2,3,4"]       <!-- Exclude these groups -->
```

### By Meta/Type
```
[members-listing member_type="premium"]
[groups-listing group_type="private"]
```

---

## ⚡ Performance Tips

### Optimal Per Page Values
- Activities: 5-10 items
- Members: 12-20 items
- Groups: 6-12 items

### Use Max Parameter
```
[activity-listing per_page="10" max="50"]
```

### Disable Extras for Better Performance
```
[members-listing populate_extras="false"]
[groups-listing update_meta_cache="false"]
```

---

## 🎯 Common Combinations

### Homepage Widgets
```
<!-- Compact activity feed -->
[activity-listing per_page="3" display_comments="false"]

<!-- Featured members -->
[members-listing type="active" per_page="4" grid="yes" loop_layout="four"]

<!-- Popular groups -->
[groups-listing type="popular" per_page="3" grid="yes"]
```

### Full Directory Pages
```
<!-- Complete members directory -->
[members-listing per_page="20" grid="yes" loop_layout="three" pagination="1"]

<!-- All groups with search -->
[groups-listing per_page="15" type="alphabetical" order="ASC"]
```

### Filtered Displays
```
<!-- Online members only -->
[members-listing type="online" per_page="10"]

<!-- Group activities only -->
[activity-listing object="groups" per_page="10"]

<!-- Specific user's groups -->
[groups-listing user_id="1" per_page="20"]
```

---

## 📝 Notes

1. **Boolean values**: Use `true`/`false` or `1`/`0`
2. **String values**: Don't need quotes in shortcode
3. **Lists**: Use comma-separated values (e.g., `"1,2,3"`)
4. **Empty defaults**: Parameters with `false` or `(empty)` defaults are optional
5. **Case sensitive**: Parameter names are case-sensitive

---

*Quick Reference Version 2.9.0 - December 2024*