<?php if ($fullwidth) : ?>
<div class="mkd-full-width">
	<div class="mkd-full-width-inner">
		<?php else: ?>
		<div class="mkd-container">
			<div class="mkd-container-inner clearfix">
				<?php endif; ?>
				<div <?php topfit_mikado_class_attribute($holder_class); ?>>
					<?php if (post_password_required()) {
						echo get_the_password_form();
					} else {
						//load proper portfolio template
						topfit_mikado_get_module_template_part('templates/single/single', 'portfolio', $portfolio_template);

						//load portfolio comments
						topfit_mikado_get_module_template_part('templates/single/parts/comments', 'portfolio');

					} ?>
				</div>
			</div>
			<?php if (!post_password_required()) {
				//load portfolio navigation
				topfit_mikado_portfolio_get_single_navigation();
			} ?>
		</div>