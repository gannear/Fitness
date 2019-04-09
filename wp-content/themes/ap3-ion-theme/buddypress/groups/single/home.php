<div id="buddypress">

	<?php if ( bp_has_groups() ) : while ( bp_groups() ) : bp_the_group(); ?>

	<?php do_action( 'bp_before_group_home_content' ); ?>

	<div id="item-header" role="complementary">

		<?php
		/**
		 * If the cover image feature is enabled, use a specific header
		 */
		if ( bp_group_use_cover_image_header() ) :
			bp_get_template_part( 'groups/single/cover-image-header' );
		else :
			bp_get_template_part( 'groups/single/group-header' );
		endif;
		?>

	</div><!-- #item-header -->

	<button id="member-nav" class="button button-secondary button-block icon-left ion-navicon"><?php _e('Navigation', 'ap3-ion-theme') ?></button>

	<div id="item-nav">
		<div class="item-list-tabs menu-type-tabs" id="object-nav" role="navigation">
			<ul class="user-nav">

				<?php bp_get_options_nav(); ?>

			</ul>
		</div>
	</div><!-- #item-nav -->

	<?php if ( bp_is_user_profile() ) : ?>
		<button id="profile-sub-nav" class="button button-secondary button-block icon-left ion-navicon"><?php _e('Profile', 'ap3-ion-theme') ?></button>
	<?php endif; ?>

	<div id="item-body">

		<?php
		/**
		 * Does this next bit look familiar? If not, go check out WordPress's
		 * /wp-includes/template-loader.php file.
		 *
		 * @todo A real template hierarchy? Gasp!
		 */

		// Group is visible
		if ( bp_group_is_visible() ) : 

			// Looking at home location
			if ( bp_is_group_home() ) :

				// Use custom front if one exists
				$custom_front = bp_locate_template( array( 'groups/single/front.php' ), false, true );
				if     ( ! empty( $custom_front   ) ) : load_template( $custom_front, true );

				// Default to activity
				elseif ( bp_is_active( 'activity' ) ) : bp_get_template_part( 'groups/single/activity' );

				// Otherwise show members
				elseif ( bp_is_active( 'members'  ) ) : bp_get_template_part( 'groups/single/members' );

				endif;
				
			// Not looking at home
			else :

				// Group Admin
				if     ( bp_is_group_admin_page() ) : bp_get_template_part( 'groups/single/admin'        );

				// Group Activity
				elseif ( bp_is_group_activity()   ) : bp_get_template_part( 'groups/single/activity'     );

				// Group Members
				elseif ( bp_is_group_members()    ) : bp_get_template_part( 'groups/single/members' );

				// Group Invitations
				elseif ( bp_is_group_invites()    ) : bp_get_template_part( 'groups/single/send-invites' );

				// Old group forums
				elseif ( bp_is_group_forum()      ) : bp_get_template_part( 'groups/single/forum'        );

				// Membership request
				elseif ( bp_is_group_membership_request() ) : bp_get_template_part( 'groups/single/request-membership' );

				// Anything else (plugins mostly)
				else                                : bp_get_template_part( 'groups/single/plugins'      );

				endif;
			endif;

		// Group is not visible
		elseif ( ! bp_group_is_visible() ) :

			// Membership request
			if ( bp_is_group_membership_request() ) :
				bp_get_template_part( 'groups/single/request-membership' );

			// The group is not visible, show the status message
			else :

				do_action( 'bp_before_group_status_message' ); ?>

				<div id="message" class="info">
					<p><?php bp_group_status_message(); ?></p>
				</div>

				<?php do_action( 'bp_after_group_status_message' );

			endif;
		endif;

		do_action( 'bp_after_group_body' ); ?>

	</div><!-- #item-body -->

	<?php do_action( 'bp_after_group_home_content' ); ?>

	<?php endwhile; endif; ?>

</div><!-- #buddypress -->
