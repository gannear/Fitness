<?php

if(!function_exists('topfit_mikado_header_register_main_navigation')) {
	/**
	 * Registers main navigation
	 */
	function topfit_mikado_header_register_main_navigation() {
		register_nav_menus(
			array(
				'main-navigation' => esc_html__('Main Navigation', 'topfit'),
                'vertical-navigation' => esc_html__('Vertical Navigation', 'topfit'),
                'divided-left-navigation' => esc_html__('Divided Left Navigation', 'topfit'),
                'divided-right-navigation' => esc_html__('Divided Right Navigation', 'topfit'),
			)
		);
	}

	add_action('after_setup_theme', 'topfit_mikado_header_register_main_navigation');
}

if(!function_exists('topfit_mikado_is_top_bar_transparent')) {
	/**
	 * Checks if top bar is transparent or not
	 *
	 * @return bool
	 */
	function topfit_mikado_is_top_bar_transparent() {
		$top_bar_enabled = topfit_mikado_is_top_bar_enabled();

		$top_bar_bg_color     = topfit_mikado_get_meta_field_intersect('top_bar_background_color');
		$top_bar_transparency = topfit_mikado_get_meta_field_intersect('top_bar_background_transparency');

		if($top_bar_enabled && $top_bar_bg_color !== '' && $top_bar_transparency !== '') {
			return $top_bar_transparency >= 0 && $top_bar_transparency < 1;
		}

		return false;
	}
}

if(!function_exists('topfit_mikado_is_top_bar_completely_transparent')) {
	function topfit_mikado_is_top_bar_completely_transparent() {
		$top_bar_enabled = topfit_mikado_is_top_bar_enabled();

		$top_bar_bg_color     = topfit_mikado_options()->getOptionValue('top_bar_background_color');
		$top_bar_transparency = topfit_mikado_options()->getOptionValue('top_bar_background_transparency');

		if($top_bar_enabled && $top_bar_bg_color !== '' && $top_bar_transparency !== '') {
			return $top_bar_transparency === '0';
		}

		return false;
	}
}

if(!function_exists('topfit_mikado_is_top_bar_enabled')) {
	function topfit_mikado_is_top_bar_enabled() {
		$id = topfit_mikado_get_page_id();

		$top_bar_enabled = topfit_mikado_get_meta_field_intersect('top_bar', $id) === 'yes';

		return $top_bar_enabled;
	}
}

if(!function_exists('topfit_mikado_get_top_bar_height')) {
    /**
     * Returns top bar height
     *
     * @return bool|int|void
     */
    function topfit_mikado_get_top_bar_height() {
        if(topfit_mikado_is_top_bar_enabled()) {
            $top_bar_height = topfit_mikado_filter_px(topfit_mikado_options()->getOptionValue('top_bar_height'));
            $header_type = topfit_mikado_get_meta_field_intersect('header_type');
            $def_top_bar_height = 45;
            return $top_bar_height !== '' ? intval($top_bar_height) : $def_top_bar_height;
        }

        return 0;
    }
}

if(!function_exists('topfit_mikado_get_sticky_header_height')) {
	/**
	 * Returns top sticky header height
	 *
	 * @return bool|int|void
	 */
	function topfit_mikado_get_sticky_header_height() {
		//sticky menu height, needed only for sticky header on scroll up
		if(topfit_mikado_options()->getOptionValue('header_type') !== 'header-vertical' &&
		   in_array(topfit_mikado_options()->getOptionValue('header_behaviour'), array('sticky-header-on-scroll-up'))
		) {

			$sticky_header_height = topfit_mikado_filter_px(topfit_mikado_options()->getOptionValue('sticky_header_height'));

			return $sticky_header_height !== '' ? intval($sticky_header_height) : 98;
		}

		return 0;

	}
}

if(!function_exists('topfit_mikado_get_sticky_header_height_of_complete_transparency')) {
	/**
	 * Returns top sticky header height it is fully transparent. used in anchor logic
	 *
	 * @return bool|int|void
	 */
	function topfit_mikado_get_sticky_header_height_of_complete_transparency() {

		if(topfit_mikado_options()->getOptionValue('header_type') !== 'header-vertical') {
			if(topfit_mikado_options()->getOptionValue('sticky_header_transparency') === '0') {
				$stickyHeaderTransparent = topfit_mikado_options()->getOptionValue('sticky_header_grid_background_color') !== '' &&
				                           topfit_mikado_options()->getOptionValue('sticky_header_grid_transparency') === '0';
			} else {
				$stickyHeaderTransparent = topfit_mikado_options()->getOptionValue('sticky_header_background_color') !== '' &&
				                           topfit_mikado_options()->getOptionValue('sticky_header_transparency') === '0';
			}

			if($stickyHeaderTransparent) {
				return 0;
			} else {
				$sticky_header_height = topfit_mikado_filter_px(topfit_mikado_options()->getOptionValue('sticky_header_height'));

				return $sticky_header_height !== '' ? intval($sticky_header_height) : 98;
			}
		}

		return 0;
	}
}

if(!function_exists('topfit_mikado_get_sticky_scroll_amount')) {
	/**
	 * Returns top sticky scroll amount
	 *
	 * @return bool|int|void
	 */
	function topfit_mikado_get_sticky_scroll_amount() {

		//sticky menu scroll amount
		if(topfit_mikado_options()->getOptionValue('header_type') !== 'header-vertical' &&
		   in_array(topfit_mikado_options()->getOptionValue('header_behaviour'), array(
			   'sticky-header-on-scroll-up',
			   'sticky-header-on-scroll-down-up'
		   ))
		) {

			$sticky_scroll_amount = topfit_mikado_filter_px(topfit_mikado_get_meta_field_intersect('scroll_amount_for_sticky'));

			return $sticky_scroll_amount !== '' ? intval($sticky_scroll_amount) : 0;
		}

		return 0;

	}
}