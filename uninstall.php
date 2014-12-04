<?php
if ( !defined( 'WP_UNINSTALL_PLUGIN' ) )
  exit();

require_once("model/database.php");

$databaseInstance = new KeywordToLinkDatabase();

global $wpdb;

$wpdb->query("DROP TABLE IF EXISTS " . $databaseInstance->_link_table);
$wpdb->query("DROP TABLE IF EXISTS " . $databaseInstance->_link_click_table);
$wpdb->query("DROP TABLE IF EXISTS " . $databaseInstance->_link_display_table);
