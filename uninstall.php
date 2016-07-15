<?php

if ( defined( 'WP_UNINSTALL_PLUGIN' ) ) {  

	if ( '1' === get_option( 'gp_delete_on_uninstall' ) ) {
		gp_uninstall();
	}
}

function gp_uninstall() {
	global $wpdb;
	
	$schema = gp_schema_get();
	
	foreach ( $schema as $table ) {
		$table_name = 'gp_' . $table;
		
		if ( is_set( $wpdb->$table_name ) ) {
			$wpdb->query( "DROP TABLE {$wpdb->$table_name};" );
		}
	}
	
	delete_option( 'gp_db_version' );
	delete_option( 'gp_rewrite_rule' );
	delete_option( 'gp_delete_on_uninstall' );
}