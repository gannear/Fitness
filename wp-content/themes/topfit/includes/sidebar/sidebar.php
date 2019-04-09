<?php

if (!function_exists('topfit_mikado_register_sidebars')) {
	/**
	 * Function that registers theme's sidebars
	 */
	function topfit_mikado_register_sidebars() {

		register_sidebar(array(
			'name'          => esc_html__('Sidebar', 'topfit'),
			'id'            => 'sidebar',
			'description'   => esc_html__('Default Sidebar', 'topfit'),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h5><span class="mkd-sidearea-title">',
			'after_title'   => '</span></h5>'
		));

	}

	add_action('widgets_init', 'topfit_mikado_register_sidebars');
}

if (!function_exists('topfit_mikado_add_support_custom_sidebar')) {
	/**
	 * Function that adds theme support for custom sidebars. It also creates TopFitMikadoSidebar object
	 */
	function topfit_mikado_add_support_custom_sidebar() {
		add_theme_support('TopFitMikadoSidebar');
		if (get_theme_support('TopFitMikadoSidebar')) {
			new TopFitMikadoSidebar();
		}
	}

	add_action('after_setup_theme', 'topfit_mikado_add_support_custom_sidebar');
}
