<?php

if(!function_exists('topfit_mikado_reset_options_map')) {
	/**
	 * Reset options panel
	 */
	function topfit_mikado_reset_options_map() {

		topfit_mikado_add_admin_page(
			array(
				'slug'  => '_reset_page',
				'title' => esc_html__('Reset', 'topfit'),
				'icon'  => 'icon_refresh'
			)
		);

		$panel_reset = topfit_mikado_add_admin_panel(
			array(
				'page'  => '_reset_page',
				'name'  => 'panel_reset',
				'title' => esc_html__('Reset', 'topfit'),
			)
		);

		topfit_mikado_add_admin_field(array(
			'type'          => 'yesno',
			'name'          => 'reset_to_defaults',
			'default_value' => 'no',
			'label'         => esc_html__('Reset to Defaults', 'topfit'),
			'description'   => esc_html__('This option will reset all Mikado Options values to defaults', 'topfit'),
			'parent'        => $panel_reset
		));

	}

	add_action('topfit_mikado_options_map', 'topfit_mikado_reset_options_map', 19);

}