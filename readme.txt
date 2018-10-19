=== WPSSO Inherit Parent Meta for Posts, Pages, Custom Post Types, Categories, Tags, and Custom Taxonomies ===
Plugin Name: WPSSO Inherit Parent Meta
Plugin Slug: wpsso-inherit-parent-meta
Text Domain: wpsso-inherit-parent-meta
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
Tags: featured, custom, inherit, images, post meta, custom field
Contributors: jsmoriss
Requires PHP: 5.4
Requires At Least: 4.7
Tested Up To: 5.0
Stable Tag: 1.2.0

WPSSO Core add-on to inherit the featured image and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.

== Description ==

<p style="margin:0;"><img class="readme-icon" src="https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png"></p>

**If no featured image has been selected** &mdash; for a *post*, *page*, or *custom post type* &mdash; this add-on will assign the first featured image found from its parent, grand-parent, great-grand-parent, etc.

**If no custom Open Graph or Schema image has been selected** &mdash; for a *post*, *page*, *custom post type*, *category*, *tag*, or *custom taxonomy* &mdash; this add-on will assign the first custom image found from its parent, grand-parent, great-grand-parent, etc.

Inherited featured and custom images are assigned as default values &mdash; you can always edit any child and select a different featured or custom image (which will then be inherited by its own children).

WordPress does not offer "featured" images for taxonomy terms (categories, tags, and custom taxonomies), so to assign an image to a term, select an image in the Document SSO (Social and Search Optimization) metabox when editing that term. This add-on will cascade those custom images to the children of that term, along with the children of those children, etc.

The Inherit Parent Meta (aka WPSSO IPM) add-on makes no permanent changes &mdash; simply deactivate the plugin to disable the automatically inherited images. ;-)

There is no add-on settings page for this plugin &mdash; simply *install* and *activate* the plugin.

<h3>Coded for Performance</h3>

The WPSSO IPM add-on uses the WordPress `wp_cache_get()` and `update_meta_cache()` functions for maximum performance and fully integrate with WordPress core functionality.

<h3>WPSSO Core Plugin Prerequisite</h3>

WPSSO Inherit Parent Meta (aka WPSSO IPM) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/) (Free or Pro version).

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

<h3>Free / Standard Version Repositories</h3>

* [GitHub](https://surniaulula.github.io/wpsso-inherit-parent-meta/)
* [WordPress.org](https://plugins.trac.wordpress.org/browser/wpsso-inherit-parent-meta/)

<h3>Changelog / Release Notes</h3>

**Version 1.2.0 (2018/07/22)**

* *New Features*
	* None.
* *Improvements*
	* Maintenance release.
* *Bugfixes*
	* None.
* *Developer Notes*
	* None.

== Upgrade Notice ==

= 1.2.0 =

(2018/07/22) Maintenance release.

