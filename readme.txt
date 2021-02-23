=== WPSSO Inherit Parent Metadata ===
Plugin Name: WPSSO Inherit Parent Metadata
Plugin Slug: wpsso-inherit-parent-meta
Text Domain: wpsso-inherit-parent-meta
Domain Path: /languages
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl.txt
Assets URI: https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/
Tags: featured, custom, inherit, images, post meta, custom field
Contributors: jsmoriss
Requires PHP: 7.0
Requires At Least: 4.7
Tested Up To: 5.6.2
Stable Tag: 3.5.0

Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.

== Description ==

<p><img class="readme-icon" src="https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png"> Inherit featured and custom images from parents for posts, pages, custom post types, categories, tags, and custom taxonomies.</p>

= Featured Image =

**If no featured image has been selected** &mdash; for a *post*, *page*, or *custom post type* &mdash; this add-on will assign the first featured image found from its parent, grand-parent, great-grand-parent, etc.

WordPress does not offer featured images for taxonomy terms (categories, tags, and custom taxonomies) &mdash; to assign a custom image to a term, select an image in the Document SSO metabox when editing a term. The WPSSO IPM add-on will cascade the custom image(s) to the children of that term, along with the children of those children, etc.

= Custom Images =

**If no custom image has been selected in the Document SSO metabox** &mdash; for a *post*, *page*, *custom post type*, *category*, *tag*, or *custom taxonomy* &mdash; this add-on will assign the first custom image found (if any) from its parent, grand-parent, great-grand-parent, etc.

Inherited images are assigned as default values &mdash; you can always edit any child to select a different featured or custom image (which will then be inherited by its own children).

The Inherit Parent Metadata (aka WPSSO IPM) add-on makes no permanent changes &mdash; simply deactivate the plugin to disable the inherited image feature. ;-)

There is no add-on settings page for this plugin &mdash; simply *install* and *activate* the plugin.

<h3>WPSSO Core Plugin Required</h3>

WPSSO Inherit Parent Metadata (aka WPSSO IPM) is an add-on for the [WPSSO Core plugin](https://wordpress.org/plugins/wpsso/). WPSSO Core and its add-ons make sure your content looks best on social sites and in search results, no matter how webpages are shared, re-shared, messaged, posted, embedded, or crawled.

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

**Version 3.5.0 (2020/12/02)**

* **New Features**
	* None.
* **Improvements**
	* None.
* **Bugfixes**
	* None.
* **Developer Notes**
	* Included the `$addon` argument for library class constructors.
* **Requires At Least**
	* PHP v7.0.
	* WordPress v4.7.
	* WPSSO Core v8.16.0.

**Version 3.4.1 (2020/10/17)**

* **New Features**
	* None.
* **Improvements**
	* Refactored the add-on class to extend a new WpssoAddOn abstract class.
* **Bugfixes**
	* Fixed backwards compatibility with older 'init_objects' and 'init_plugin' action arguments.
* **Developer Notes**
	* Added a new WpssoAddOn class in lib/abstracts/add-on.php.
	* Added a new SucomAddOn class in lib/abstracts/com/add-on.php.
* **Requires At Least**
	* PHP v5.6.
	* WordPress v4.7.
	* WPSSO Core v8.13.0.

== Upgrade Notice ==

= 3.5.0 =

(2020/12/02) Included the `$addon` argument for library class constructors.

= 3.4.1 =

(2020/10/17) Refactored the add-on class to extend a new WpssoAddOn abstract class.

