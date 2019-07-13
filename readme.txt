=== WPSSO Inherit Parent Meta (Featured Image and Custom Images) ===
Plugin Name: WPSSO Inherit Parent Meta
Plugin Slug: wpsso-inherit-parent-meta
Text Domain: wpsso-inherit-parent-meta
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
Tags: featured, custom, inherit, images, post meta, custom field
Contributors: jsmoriss
Requires At Least: 4.7
Tested Up To: 5.2.2
Stable Tag: 2.0.0

WPSSO Core add-on to inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.

== Description ==

<p style="margin:0;"><img class="readme-icon" src="https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png"></p>

= Featured Image =

**If no featured image has been selected** &mdash; for a *post*, *page*, or *custom post type* &mdash; this add-on will assign the first featured image found from its parent, grand-parent, great-grand-parent, etc.

= Custom Images =

**If no custom Open Graph or Schema image has been selected** &mdash; for a *post*, *page*, *custom post type*, *category*, *tag*, or *custom taxonomy* &mdash; this add-on will assign the first custom image found from its parent, grand-parent, great-grand-parent, etc.

Inherited featured and custom images are assigned as default values &mdash; you can always edit any child and select a different featured or custom image (which will then be inherited by its own children).

WordPress does not offer featured images for taxonomy terms (categories, tags, and custom taxonomies) &mdash; to assign a custom image to a term, select an image in the Document SSO metabox when editing a term. The WPSSO IPM add-on will cascade the custom image(s) to the children of that term, along with the children of those children, etc.

<blockquote>
The Inherit Parent Meta (aka WPSSO IPM) add-on makes no permanent changes &mdash; simply deactivate the plugin to disable the automatically inherited images. ;-)
</blockquote>

There is no add-on settings page for this plugin &mdash; simply *install* and *activate* the plugin.

<h3>Coded for Performance</h3>

The WPSSO IPM add-on uses the WordPress `wp_cache_get()` and `update_meta_cache()` functions for maximum performance and integrate fully with WordPress core functionality.

<h3>WPSSO Core Plugin Prerequisite</h3>

WPSSO Inherit Parent Meta (aka WPSSO IPM) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO IPM Add-on](https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/install-the-plugin/)
* [Uninstall the WPSSO IPM Add-on](https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/uninstall-the-plugin/)

== Frequently Asked Questions ==

== Screenshots ==

== Changelog ==

<h3 class="top">Version Numbering</h3>

Version components: `{major}.{minor}.{bugfix}[-{stage}.{level}]`

* {major} = Major structural code changes / re-writes or incompatible API changes.
* {minor} = New functionality was added or improved in a backwards-compatible manner.
* {bugfix} = Backwards-compatible bug fixes or small improvements.
* {stage}.{level} = Pre-production release: dev < a (alpha) < b (beta) < rc (release candidate).

<h3>Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-inherit-parent-meta/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-inherit-parent-meta/)

<h3>Changelog / Release Notes</h3>

**Version 2.0.0 (2019/06/24)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Maintenance release for WPSSO Core v5.0.0.

== Upgrade Notice ==

= 2.0.0 =

(2019/06/24) Maintenance release for WPSSO Core v5.0.0.

