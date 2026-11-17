<?php
/**
 * Uninstall file for CLMI AJAX Pagination
 *
 * Cleans up plugin data when plugin is deleted.
 */

if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

// If multisite
if (is_multisite()) {

    $site_ids = get_sites([
        'fields' => 'ids',
    ]);

    foreach ($site_ids as $site_id) {
        switch_to_blog($site_id);

        delete_option('clmi_settings');

        restore_current_blog();
    }

} else {

    // Single site
    delete_option('clmi_settings');
}