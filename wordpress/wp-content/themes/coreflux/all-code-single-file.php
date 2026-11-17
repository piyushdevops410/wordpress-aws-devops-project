/*
Theme Name: CoreFlux
Theme URI: https://example.com/coreflux
Author: Piyush Koshti
Description: A modern, lightweight WordPress block theme.
Version: 1.0.0
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
License: GPL v2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html
Text Domain: coreflux
Tags: full-site-editing, blog
*/

/* =========================
   theme.json
========================= */
{
  "version": 2,
  "settings": {
    "layout": { "contentSize": "720px", "wideSize": "1200px" },
    "spacing": { "padding": true, "margin": true },
    "color": {
      "palette": [
        { "name": "Primary", "slug": "primary", "color": "#0d6efd" },
        { "name": "Dark", "slug": "dark", "color": "#212529" }
      ]
    },
    "typography": {
      "fontFamilies": [
        { "fontFamily": "system-ui, sans-serif", "slug": "primary", "name": "System Font" }
      ]
    }
  },
  "styles": {
    "typography": { "fontFamily": "var(--wp--preset--font-family--primary)" },
    "elements": {
      "button": {
        "color": { "background": "var(--wp--preset--color--primary)", "text": "#ffffff" }
      }
    }
  }
}

/* =========================
   functions.php
========================= */
<?php
if (!defined('ABSPATH')) exit;

function coreflux_setup() {
    add_theme_support('wp-block-styles');
    add_theme_support('editor-styles');
}
add_action('after_setup_theme', 'coreflux_setup');

/* =========================
   templates/index.html
========================= */
<!-- wp:template-part {"slug":"header"} /-->
<!-- wp:group -->
<div class="wp-block-group">
    <!-- wp:pattern {"slug":"coreflux/hero"} /-->
    <!-- wp:pattern {"slug":"coreflux/blog-grid"} /-->
</div>
<!-- /wp:group -->
<!-- wp:template-part {"slug":"footer"} /-->

/* =========================
   templates/single.html
========================= */
<!-- wp:template-part {"slug":"header"} /-->
<!-- wp:post-title /-->
<!-- wp:post-content /-->
<!-- wp:template-part {"slug":"footer"} /-->

/* =========================
   templates/page.html
========================= */
<!-- wp:template-part {"slug":"header"} /-->
<!-- wp:post-title /-->
<!-- wp:post-content /-->
<!-- wp:template-part {"slug":"footer"} /-->

/* =========================
   parts/header.html
========================= */
<!-- wp:group {"layout":{"type":"flex","justifyContent":"space-between"}} -->
<div class="wp-block-group">
    <!-- wp:site-title /-->
    <!-- wp:navigation /-->
</div>
<!-- /wp:group -->

/* =========================
   parts/footer.html
========================= */
<!-- wp:group {"align":"full"} -->
<div class="wp-block-group alignfull">
    <!-- wp:paragraph -->
    <p>© 2026 CoreFlux Theme</p>
    <!-- /wp:paragraph -->
</div>
<!-- /wp:group -->

/* =========================
   patterns/hero.php
========================= */
<?php
/**
 * Title: Hero Section
 * Slug: coreflux/hero
 * Categories: coreflux
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"60px","bottom":"60px"}}}} -->
<div class="wp-block-group alignfull">
    <!-- wp:heading {"textAlign":"center","level":1} -->
    <h1 class="has-text-align-center">Welcome to CoreFlux</h1>
    <!-- /wp:heading -->

    <!-- wp:paragraph {"align":"center"} -->
    <p class="has-text-align-center">Build modern websites with block power.</p>
    <!-- /wp:paragraph -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link">Get Started</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->

/* =========================
   patterns/blog-grid.php
========================= */
<?php
/**
 * Title: Blog Grid
 * Slug: coreflux/blog-grid
 * Categories: coreflux
 */
?>
<!-- wp:query {"query":{"perPage":6}} -->
<div class="wp-block-query">
    <!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
        <!-- wp:post-title {"isLink":true} /-->
        <!-- wp:post-excerpt /-->
    <!-- /wp:post-template -->
</div>
<!-- /wp:query -->

/* =========================
   patterns/cta.php
========================= */
<?php
/**
 * Title: Call to Action
 * Slug: coreflux/cta
 * Categories: coreflux
 */
?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"40px","bottom":"40px"}}}} -->
<div class="wp-block-group alignfull">
    <!-- wp:heading {"textAlign":"center"} -->
    <h2 class="has-text-align-center">Start Building Today</h2>
    <!-- /wp:heading -->

    <!-- wp:buttons {"layout":{"type":"flex","justifyContent":"center"}} -->
    <div class="wp-block-buttons">
        <!-- wp:button -->
        <div class="wp-block-button"><a class="wp-block-button__link">Download Now</a></div>
        <!-- /wp:button -->
    </div>
    <!-- /wp:buttons -->
</div>
<!-- /wp:group -->

/* =========================
   readme.txt
========================= */
=== CoreFlux ===
Contributors: piyushkoshti
Tags: full-site-editing, blog
Requires at least: 6.0
Tested up to: 6.9
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPL v2 or later

A modern lightweight WordPress block theme with reusable block patterns.
