<h1>Inherit Parent Metadata</h1><h3>WPSSO Add-on</h3>

<table>
<tr><th align="right" valign="top" nowrap>Plugin Name</th><td>WPSSO Inherit Parent Metadata</td></tr>
<tr><th align="right" valign="top" nowrap>Summary</th><td>Inherit Featured and Custom Images from Parents for Posts, Pages, Custom Post Types, Categories, Tags, and Custom Taxonomies.</td></tr>
<tr><th align="right" valign="top" nowrap>Stable Version</th><td>2.2.0</td></tr>
<tr><th align="right" valign="top" nowrap>Requires PHP</th><td>5.6 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Requires WordPress</th><td>4.2 or newer</td></tr>
<tr><th align="right" valign="top" nowrap>Tested Up To WordPress</th><td>5.4</td></tr>
<tr><th align="right" valign="top" nowrap>Contributors</th><td>jsmoriss</td></tr>
<tr><th align="right" valign="top" nowrap>License</th><td><a href="https://www.gnu.org/licenses/gpl.txt">GPLv3</a></td></tr>
<tr><th align="right" valign="top" nowrap>Tags / Keywords</th><td>featured, custom, inherit, images, post meta, custom field</td></tr>
</table>

<h2>Description</h2>

<p style="margin:0;"><img class="readme-icon" src="https://surniaulula.github.io/wpsso-inherit-parent-meta/assets/icon-256x256.png"></p>

<h4>Featured Image</h4>

<p><strong>If no featured image has been selected</strong> &mdash; for a <em>post</em>, <em>page</em>, or <em>custom post type</em> &mdash; this add-on will assign the first featured image found from its parent, grand-parent, great-grand-parent, etc.</p>

<h4>Custom Images</h4>

<p><strong>If no custom Open Graph or Schema image has been selected</strong> &mdash; for a <em>post</em>, <em>page</em>, <em>custom post type</em>, <em>category</em>, <em>tag</em>, or <em>custom taxonomy</em> &mdash; this add-on will assign the first custom image found from its parent, grand-parent, great-grand-parent, etc.</p>

<p>Inherited featured and custom images are assigned as default values &mdash; you can always edit any child and select a different featured or custom image (which will then be inherited by its own children).</p>

<p>WordPress does not offer featured images for taxonomy terms (categories, tags, and custom taxonomies) &mdash; to assign a custom image to a term, select an image in the Document SSO metabox when editing a term. The WPSSO IPM add-on will cascade the custom image(s) to the children of that term, along with the children of those children, etc.</p>

<blockquote>
The Inherit Parent Metadata (aka WPSSO IPM) add-on makes no permanent changes &mdash; simply deactivate the plugin to disable the automatically inherited images. ;-)
</blockquote>

<p>There is no add-on settings page for this plugin &mdash; simply <em>install</em> and <em>activate</em> the plugin.</p>

<h3>Coded for Performance</h3>

<p>The WPSSO IPM add-on uses the WordPress <code>wp_cache_get()</code> and <code>update_meta_cache()</code> functions for maximum performance and integrate fully with WordPress core functionality.</p>

<h3>WPSSO Core Plugin Required</h3>

<p>WPSSO Inherit Parent Metadata (aka WPSSO IPM) is an add-on for the <a href="https://wordpress.org/plugins/wpsso/">WPSSO Core plugin</a>.</p>


<h2>Installation</h2>

<h3 class="top">Install and Uninstall</h3>

<ul>
<li><a href="https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/install-the-plugin/">Install the WPSSO IPM Add-on</a></li>
<li><a href="https://wpsso.com/docs/plugins/wpsso-inherit-parent-meta/installation/uninstall-the-plugin/">Uninstall the WPSSO IPM Add-on</a></li>
</ul>


<h2>Frequently Asked Questions</h2>




