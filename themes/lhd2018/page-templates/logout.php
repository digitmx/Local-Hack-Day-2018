<?php /* Template Name: Cerrar Sesión Usuarios */

	unset($wp_session['user']);
	unset($wp_session['logged']);
	
	wp_redirect( home_url() ); exit;

?>