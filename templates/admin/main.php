<?php

use \MDBHC\WpdbWrapper;

WpdbWrapper::activate();

global $wpdb;

$wpdb->query("SELECT * FROM `wp_mariadb_versions`");
$wpdb->insert(
    'test_execution_time',
    [
        'test' => "test123",
    ],
    [
        '%s',
    ]
);


WpdbWrapper::deactivate();

// print_r(get_class_methods($wpdb));

?>
<h2>MariaDB Health Checks</h2>