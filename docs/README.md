# BuddyPress Shortcodes Documentation

Welcome to the official documentation for the BuddyPress Shortcodes plugin!

## 📚 Available Documentation

### [User Guide](USER-GUIDE.md)
Complete guide for using BuddyPress shortcodes in your WordPress site.
- Installation instructions
- Shortcode usage and parameters
- Practical examples
- Troubleshooting tips
- FAQs

### [Developer Guide](DEVELOPER-GUIDE.md)
Technical documentation for developers extending or customizing the plugin.
- Architecture overview
- Hooks and filters reference
- Creating custom shortcodes
- Template system
- API documentation

### [Shortcode Reference](SHORTCODE-REFERENCE.md)
Quick reference for all available shortcodes and their parameters.

## 🚀 Quick Start

### Basic Usage

Display activities:
```
[activity-listing per_page="5"]
```

Display members:
```
[members-listing type="active" grid="yes"]
```

Display groups:
```
[groups-listing type="popular" per_page="6"]
```

## 📊 Quick Parameter Reference

### Most Used Parameters

| Parameter | Activity | Members | Groups | Common Values |
|-----------|----------|---------|--------|---------------|
| `per_page` | ✅ | ✅ | ✅ | 5, 10, 20 |
| `type` | - | ✅ | ✅ | active, newest, popular |
| `grid` | - | ✅ | ✅ | yes, no |
| `loop_layout` | - | ✅ | ✅ | one, two, three, four |
| `display_comments` | ✅ | - | - | true, false |
| `scope` | ✅ | - | - | friends, groups, mentions |
| `search_terms` | ✅ | ✅ | ✅ | Any text |
| `max` | ✅ | ✅ | ✅ | Number or false |
| `title` | ✅ | ✅ | ✅ | Any text |

*See [SHORTCODE-REFERENCE.md](SHORTCODE-REFERENCE.md) for complete parameter lists.*

## 📋 Available Shortcodes

1. **`[activity-listing]`** - Display BuddyPress activity streams
2. **`[members-listing]`** - Display member directories
3. **`[groups-listing]`** - Display group directories

## 🎯 Key Features

- ✅ Display BuddyPress content anywhere on your site
- ✅ Highly customizable with numerous parameters
- ✅ Responsive and mobile-friendly
- ✅ Compatible with page builders (Elementor, Gutenberg, etc.)
- ✅ Developer-friendly with hooks and filters
- ✅ Translation ready
- ✅ Performance optimized

## 📖 Documentation Structure

```
docs/
├── README.md                    # This file
├── USER-GUIDE.md               # Comprehensive user documentation
├── DEVELOPER-GUIDE.md          # Technical developer documentation
└── SHORTCODE-REFERENCE.md     # Quick parameter reference
```

## 💡 Common Use Cases

### Community Homepage
Show latest activities, new members, and popular groups:
```
[activity-listing per_page="5" title="Recent Activity"]
[members-listing type="newest" per_page="4" title="Welcome New Members"]
[groups-listing type="popular" per_page="3" title="Popular Groups"]
```

### Member Directory Page
Full member listing with search:
```
[members-listing per_page="20" grid="yes" loop_layout="four"]
```

### Sidebar Widget
Compact activity feed:
```
[activity-listing per_page="3" display_comments="false"]
```

## 🔧 Requirements

- WordPress 5.0+
- BuddyPress 12.0+
- PHP 7.0+

## 🆘 Getting Help

1. **Documentation**: Start with the [User Guide](USER-GUIDE.md)
2. **Developer Questions**: Check the [Developer Guide](DEVELOPER-GUIDE.md)
3. **Support Forum**: Visit [WordPress.org Support](https://wordpress.org/support/plugin/shortcodes-for-buddypress/)
4. **GitHub Issues**: Report bugs at [GitHub Repository](https://github.com/wbcomdesigns/shortcodes-for-buddypress)

## 📝 Changelog

### Version 2.9.0
- Improved PHPDoc documentation
- Code quality enhancements
- Performance optimizations
- Security improvements
- Added comprehensive documentation

## 📄 License

This plugin is licensed under GPL v2 or later.

## 👥 Credits

**Developed by:** [Wbcom Designs](https://wbcomdesigns.com)
**Contributors:** See [contributors list](https://github.com/wbcomdesigns/shortcodes-for-buddypress/graphs/contributors)

---

*Last updated: December 2024*