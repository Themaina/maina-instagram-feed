# Instagram Feed for Botble CMS

![Instagram Feed](art/banner.png)

Put your Instagram posts and reels on every page of your shop. A small floating button opens a swipeable 9:16 panel with a "Shop Now" button for each post and a link to your Instagram profile.

**Free and open source** by **Maina 888** · Maina Superintelligence Ltd

**Version:** 1.1.0 · **Requires:** Botble CMS core 7.3.0+, PHP 8.2+ · **License:** MIT

## Features

- **Floating launcher** in any corner, with a subtle pulse. Visitors can drag it out of the way, and their position is remembered.
- **Post panel** (9:16) with a carousel for several posts or reels, arrows and dots, and a close button. Escape closes it too.
- **Shop button per post:** link each post to a product page, or fall back to one default shop link.
- **Follow button** that opens your Instagram profile, icon-only or with your own label.
- **Three sizes:** Compact, Standard and Spacious.
- **Show on selected pages:** all pages, homepage, shop listing, product pages, cart or checkout (shop pages need the Ecommerce plugin).
- **Privacy mode:** show a cover image with a play button and load nothing from Instagram until the visitor taps it. Without privacy mode the post still loads only when the panel is opened, never on page load.
- **Cover images** per post, shown in privacy mode and in the admin list.
- **Phones:** show or hide on mobile, and lift the button above a theme's bottom navigation bar.
- **Auto-open** once per browser session after a delay you choose.
- **Works with the TikTok Feed and Facebook Feed plugins:** widgets in the same corner stack instead of overlapping.
- **Any theme:** the widget is added to the theme footer, uses its own small CSS and JS file, and needs no icon font.

## Screenshots

| Post panel on desktop and phone | Settings |
| --- | --- |
| ![Post panel on the storefront](art/screenshot-1.png) | ![Settings](art/screenshot-2.png) |
| **Adding a post** | **Works with the TikTok and Facebook feeds** |
| ![Adding a post](art/screenshot-3.png) | ![Widgets stacked in one corner](art/screenshot-4.png) |

## Requirements

- Botble CMS core 7.3.0 or later, PHP 8.2 or later.
- Any theme that prints the standard theme footer (all Botble themes do).
- Optional: the **Ecommerce** plugin, for the shop, product, cart and checkout page options.
- Posts and reels from a public Instagram account. Posts from private accounts cannot be shown.

## Installation

### From the Botble Marketplace (recommended)

1. Go to **Admin → Plugins → Add new**.
2. Search for **Instagram Feed**, click **Install**, then **Activate**.

Updates appear in **Admin → Plugins** whenever a new version is released.

### From a release zip

1. Download `instagram-feed-x.y.z.zip` from the [latest release](https://github.com/Themaina/maina-instagram-feed/releases/latest).
2. Go to **Admin → Plugins → Add new → Upload**, pick the zip, then **Activate**.

### Manually

1. Copy the `instagram-feed` folder to `platform/plugins/instagram-feed`.
2. Go to **Admin → Plugins** and click **Activate** (or run `php artisan cms:plugin:activate instagram-feed`). Activation creates the `instagram_feed_posts` table and publishes the CSS and JS.

### Updating from 1.0.x

Install the new version over the old one and keep the plugin active. A migration adds the `cover_image` column; your posts and settings stay as they are.

## Getting started

1. Go to **Admin → Instagram Feed → Create**.
2. Paste the address of a public post or reel, e.g. `https://www.instagram.com/p/Cabc123XYZ/` or `https://www.instagram.com/reel/Cabc123XYZ/`. Optionally add a "Shop this look" link and a cover image.
3. Go to **Admin → Settings → Others → Instagram Feed**, enter your Instagram handle and choose where the widget appears.

## Configuration

**Admin → Settings → Others → Instagram Feed**

| Setting | What it does |
| --- | --- |
| Enable Instagram feed widget | Shows or hides the widget everywhere. |
| Instagram username | Your handle (`yourshop`, `@yourshop` or your profile URL). Used for the follow button; blank hides it. |
| Widget position | Bottom left, bottom right, top left or top right. |
| Allow visitors to drag the widget | Visitors can move the button; the spot is remembered in their browser. |
| Widget size | Compact, Standard or Spacious. |
| Follow button text | Optional label next to the Instagram icon. Blank shows an icon-only button. |
| Shop button text / Default shop link | Text of the shop button and where it goes when a post has no link of its own. The link can be a full `https://` address or a path such as `/products`. |
| Show on pages | All pages, or any of homepage, shop listing, product pages, cart and checkout. |
| Number of posts to show | 1 to 30 published posts, lowest display order first. |
| Show on mobile devices | Turn off to hide the widget on screens narrower than 768 px. |
| Distance from the bottom on phones | For bottom positions on phones. Raise it (e.g. 90 px) if your theme has a bottom navigation bar, as Shofy does. |
| Privacy mode | Shows the cover image and a play button; nothing loads from Instagram until the visitor taps it. |
| Auto-open on first visit / delay | Opens the panel once per browser session after the delay. |

**Admin → Instagram Feed** (one row per post)

| Field | What it does |
| --- | --- |
| Label | Internal name for the admin list. Also used as the iframe title for screen readers. |
| Instagram post or reel URL | Address of a public post (`/p/…`), reel (`/reel/…`) or IGTV video (`/tv/…`). |
| Shop this look (link) | Where the shop button goes while this post is showing. |
| Cover image | Shown before the post loads in privacy mode. A 9:16 portrait image works best. |
| Display order / Status | Lowest number first. Only published posts are shown. |

## How it works

- The plugin hooks into the theme footer and adds one small CSS file, one JS file and the widget markup when at least one published post exists and the current page is allowed.
- Each post is shown with Instagram's official embed (`https://www.instagram.com/p/<code>/embed/`). The iframe address is only set when the visitor opens the panel or moves to that slide, or taps it in privacy mode, so a page view on its own makes no request to Instagram.
- The post code is read from the URL when you save, so the storefront never calls Instagram's API and no access token is needed.
- Drag position (`localStorage`) and the "already auto-opened" flag (`sessionStorage`) stay in the visitor's browser. Nothing about visitors is stored on your server.
- When the TikTok Feed or Facebook Feed plugin is placed in the same corner, the widgets stack above each other.

## Customising

- **Styles:** every class starts with `if-`, e.g. `.if-toggle`, `.if-panel`, `.if-shop-btn`. Override them in your theme's CSS.
- **Markup:** copy `resources/views/widget.blade.php` to `resources/views/vendor/plugins/instagram-feed/widget.blade.php` in your site root and edit the copy.
- **Translations:** copy `resources/lang/en/instagram-feed.php` to `lang/vendor/plugins/instagram-feed/<locale>/instagram-feed.php` in your site root.

## Troubleshooting

| Problem | Fix |
| --- | --- |
| The widget does not appear | Check that it is enabled, at least one post is published, the current page is ticked under *Show on pages*, and (on phones) *Show on mobile devices* is on. Then run `php artisan optimize:clear`. |
| "This is not an Instagram post or reel link" | Open the post on instagram.com and copy the address from the browser (`https://www.instagram.com/p/…` or `/reel/…`). A profile link is not a post. |
| The panel stays blank or shows an error from Instagram | The post was deleted, the account is private, or embedding is turned off for it. Use another post. |
| The button sits on top of the theme's bottom menu on phones | Raise *Distance from the bottom on phones*, e.g. to 90. |
| Old CSS after an update | The asset URL carries the plugin version, so a normal reload is enough. If a CDN caches `vendor/core/plugins/instagram-feed`, purge it. |
| Cookie consent | Turn on *Privacy mode*: Instagram is contacted only after the visitor taps a post. |

## Uninstall

Remove the plugin from **Admin → Plugins**. The `instagram_feed_posts` table and all `instagram_feed_*` settings are deleted. Uploaded cover images stay in your media library.

## Development

Unit tests cover post-link parsing, embed URLs and profile links:

```bash
composer require --dev phpunit/phpunit
vendor/bin/phpunit -c platform/plugins/instagram-feed/phpunit.xml.dist
```

The storefront JS and CSS are built from `resources/js` and `resources/sass` with Laravel Mix (`webpack.mix.js`). The built files in `public/` are committed, so no build step is needed to use the plugin.

## File structure

```
instagram-feed/
├── plugin.json
├── config/permissions.php
├── database/migrations/
├── public/{css,js}/          (built assets)
├── resources/{js,sass,lang/en,views}
├── routes/web.php
├── src/{Forms, Http, Models, Providers, Support, Tables, Plugin.php}
├── tests/
└── art/                      (marketplace images, not shipped in the zip)
```

## Support

- Questions and bug reports: [GitHub issues](https://github.com/Themaina/maina-instagram-feed/issues)
- Security problems: see [SECURITY.md](SECURITY.md)
- Changes in each version: [CHANGELOG.md](CHANGELOG.md)

Instagram is a trademark of Meta Platforms, Inc. This plugin is not affiliated with or endorsed by Instagram or Meta.

## License

Free and open source under the [MIT License](LICENSE). © 2026 Maina Superintelligence Ltd. Made by Maina 888.
