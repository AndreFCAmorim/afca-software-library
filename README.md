# AFCA Software Library

A WordPress plugin for managing and distributing version information for your themes and plugins via the WordPress REST API. It can also serve as an **update hub** — other WordPress sites running your plugins can point to a site running this plugin to receive automatic update notifications.

**Author:** [André Amorim](https://andreamorim.site)
**Version:** 1.1
**License:** —

---

## Features

- Registers a **Software Library** custom post type for tracking plugins, themes, and other software
- Stores key technical metadata per entry: type, download URL, version, required/tested WordPress versions, and release date
- Exposes a **public REST API endpoint** to query software info by slug
- Integrates with the **WordPress update system** — sites running your plugins can poll a hub site for new versions and receive in-dashboard update notifications
- Supports **i18n / translations** via a `.pot` file
- Cleans up scheduled tasks on plugin deactivation

---

## Requirements

| Requirement | Minimum |
|---|---|
| WordPress | 6.1 |
| PHP | 7.4 |
| Composer | Any recent version |

---

## Installation

1. Clone or download this repository into your `wp-content/plugins/` directory:
   ```bash
   cd wp-content/plugins/
   git clone <repo-url> afca-software-library
   ```

2. Install PHP dependencies via Composer:
   ```bash
   cd afca-software-library
   composer install --no-dev
   ```

3. Activate the plugin from the **WordPress Admin → Plugins** screen.

---

## Usage

### Adding a Software Entry

After activation, a **Software Library** menu item (portfolio icon) will appear in the WordPress admin sidebar.

Create a new entry and fill in the **Technical Information** meta box:

| Field | Description |
|---|---|
| **Type** | `Plugin`, `Theme`, or `Others` |
| **URL** | Direct download URL (must start with `https://`) |
| **Version** | Current version number (e.g. `1.2.3`) |
| **Required WordPress Version** | Minimum WP version needed |
| **Tested WordPress Version** | Highest WP version tested against |
| **Released Date** | Date of this release |

The post **title** is the software name and the post **content** serves as release notes.

---

## REST API

The plugin registers a public REST API endpoint:

```
GET /wp-json/afca-software-library/v1/ref/{slug}
```

### Parameters

| Parameter | Type | Description |
|---|---|---|
| `slug` | string | The slug of the Software Library post |

### Example Request

```bash
curl https://your-site.com/wp-json/afca-software-library/v1/ref/my-plugin
```

### Example Response

```json
{
  "id": 42,
  "title": "My Plugin",
  "released_notes": "Fixed a critical bug in the settings page.",
  "version": "1.2.0",
  "url": "https://your-site.com/downloads/my-plugin.zip",
  "wp_required": "6.1",
  "wp_tested": "6.5",
  "released_date": "2024-11-01"
}
```

Returns a `404` error object if no entry is found for the given slug.

---

## Using as an Update Hub

This plugin is designed so that your other plugins can point to a site running AFCA Software Library to receive automatic update checks — bypassing the WordPress.org repository.

In a plugin that should receive updates from the hub, instantiate the `Updates` class:

```php
use Afca\Plugins\SoftwareLibrary\Updates;

new Updates(
    'https://your-hub-site.com/', // Hub site URL
    'your-plugin-folder-name',    // Plugin folder/slug (must match the Software Library post slug)
    '1.0.0'                       // Current installed version
);
```

The `Updates` class will:

- Check the hub's REST API endpoint daily (via `wp_schedule_event`)
- Cache the response for 24 hours using a transient
- Inject available update data into WordPress's native plugin update system
- Show update notifications in the WordPress admin dashboard just like plugins from WordPress.org

---

## Development

Dev dependencies (PHP CodeSniffer with WordPress Coding Standards) are managed via Composer:

```bash
composer install
```

To run the linter:

```bash
./vendor/bin/phpcs --standard=phpcs.xml
```

---

## File Structure

```
afca-software-library/
├── afca-software-library.php   # Plugin entry point
├── composer.json
├── phpcs.xml                   # Coding standards config
├── uninstall.php               # Cleanup on uninstall
├── languages/
│   └── afca-software-library.pot
└── src/
    ├── Init.php                # Bootstraps all classes
    ├── PostType.php            # Registers the custom post type
    ├── MetaFields.php          # Admin meta box & field persistence
    ├── Endpoints.php           # REST API endpoint
    └── Updates.php             # Update hub integration
```

---

## Links

- [Plugin Documentation](https://andreamorim.site/plugin-documentation/sofware-library/)
- [Author Website](https://andreamorim.site)
- [Contact](mailto:contact@andreamorim.site)