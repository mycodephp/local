<?php 
// Create a submenu in the block menu.
// This can be found in:
// - blocksettings for block plugins
// - modsettings for activity modules
// - localplugins for Local plugins
// The default menus are defined in admin/settings/plugins.php.
$ADMIN->add(
    'blocksettings',
    new admin_category(
        'blocksamplefolder',
        get_string('pluginname', 'mod_sample')
    )
);

// Prevent Moodle from adding settings block in standard location.
$settings = null;
?>