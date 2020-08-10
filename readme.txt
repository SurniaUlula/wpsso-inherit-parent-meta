=== Inherit Parent Metadata | WPSSO Add-on ===
Plugin Name: WPSSO Inherit Parent Metadata
Plugin Slug: wpsso-inherit-parent-meta
Text Domain: wpsso-inherit-parent-meta
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
Tags: featured, custom, inherit, images, post meta, custom field
Contributors: jsmoriss
Requires PHP: 5.6
Requires At Least: 4.7
Tested Up To: 5.5
Stable Tag: 3.2.0

Inherit the Featured and Custom Images from Parents for Posts, Pages, Custom Post Types, Categories, Tags, and Custom Taxonomies.

== Description ==

<p style="margin:0;"><img class="readme-icon" src="https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png"></p>

Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.

= Featured Image =

**If no featured image has been selected** &mdash; for a *post*, *page*, or *custom post type* &mdash; this add-on will assign the first featured image found from its parent, grand-parent, great-grand-parent, etc.

WordPress does not offer featured images for taxonomy terms (categories, tags, and custom taxonomies) &mdash; to assign a custom image to a term, select an image in the Document SSO metabox when editing a term. The WPSSO IPM add-on will cascade the custom image(s) to the children of that term, along with the children of those children, etc.

= Custom Images =

**If no custom image has been selected in the Document SSO metabox** &mdash; for a *post*, *page*, *custom post type*, *category*, *tag*, or *custom taxonomy* &mdash; this add-on will assign the first custom image found (if any) from its parent, grand-parent, great-grand-parent, etc.

Inherited images are assigned as default values &mdash; you can always edit any child to select a different featured or custom image (which will then be inherited by its own children).

The Inherit Parent Metadata (aka WPSSO IPM) add-on makes no permanent changes &mdash; simply deactivate the plugin to disable the inherited image feature. ;-)

There is no add-on settings page for this plugin &mdash; simply *install* and *activate* the plugin.

<h3>Coded for Performance</h3>

The WPSSO IPM add-on uses the WordPress `wp_cache_get()` and `update_meta_cache()` functions for maximum performance and integrate fully with WordPress core functionality.

<h3>WPSSO Core Plugin Required</h3>

WPSSO Inherit Parent Metadata (aka WPSSO IPM) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/).

== Installation ==

<h3 class="top">Install and Uninstall</h3>

* [Install the WPSSO Inherit Parent Metadata add-on](https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/install-the-plugin/).
* [Uninstall the WPSSO Inherit Parent Metadata add-on](https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/uninstall-the-plugin/).

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

**Version 3.3.0-b.1 (2020/08/10)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Removed inheritance of the 'schema_img_url' meta data key (no longer used).
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.7.
	* WPSSO Core v8.0.0-b.1.

**Version 3.2.0 (2020/08/02)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Tested with WordPress v5.5.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.7.
	* WPSSO Core v7.15.0.

**Version 3.1.0 (2020/05/09)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Refactored the required plugin check to (optionally) check the class name and a version constant.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.7.
	* WPSSO Core v7.5.0.

**Version 3.0.0 (2020/04/21)**

* **New Features**
	* Added a new WPSSOIPM_POST_METADATA_KEYS constant to define an array of inherited post metadata keys.
* **Improvements**
	* Added the custom Pinterest image from the Document SSO metabox to the list of inherited images.
* **Bugfixes**
	* None.
* **Developer Notes**
	* None.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.7.
	* WPSSO Core v7.3.0.

== Upgrade Notice ==

= 3.3.0-b.1 =

(2020/08/10) Removed inheritance of the 'schema_img_url' meta data key (no longer used).

= 3.2.0 =

(2020/08/02) Tested with WordPress v5.5.

