<?php

if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {

	if ( '1' === get_option( 'gp_delete_on_uninstall' ) ) {
		gp_uninstall();
	}
}

function gp_uninstall() {
	global $wpdb;

	if ( ! defined( 'GP_PATH' ) ) {
		define( 'GP_PATH', __DIR__ . '/' );
	}

	if ( ! defined( 'GP_INC' ) ) {
		define( 'GP_INC', 'gp-includes/' );
	}

	if ( !function_exists( 'gp_schema_get' ) ) {
		include( GP_PATH . GP_INC . 'schema.php' );
	}

	$schema = gp_schema_get();

	foreach ( $schema as $table => $sql ) {
		$table_name = $wpdb->prefix . 'gp_' . $table;

		$wpdb->query( "DROP TABLE {$table_name};" );
	}

	delete_option( 'gp_db_version' );
	delete_option( 'gp_rewrite_rule' );
	delete_option( 'gp_delete_on_uninstall' );
}