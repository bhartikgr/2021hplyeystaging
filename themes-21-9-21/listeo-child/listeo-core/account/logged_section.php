<?php
$my_account_display = get_option('listeo_my_account_display', true );
	$submit_display = get_option('listeo_submit_display', true );
 	if( true == $my_account_display) : ?>
					
	<?php if ( is_user_logged_in() ) { 
			$current_user = wp_get_current_user();
			$roles = $current_user->roles;
			$role = array_shift( $roles ); 
			if(!empty($current_user->user_firstname)){
				$name = $current_user->user_firstname;
			} else {
				$name =  $current_user->display_name;
			}
	?>
	<div class="user-menu">
		<div class="user-name">
			<span>
				<?php
				// We need to show custome profile picture first otherwise get it from WordPress.
				$custom_avatar_id 	= get_the_author_meta( 'listeo_core_avatar_id', get_current_user_id() ) ;
				$custom_avatar 		= wp_get_attachment_image_src( $custom_avatar_id, 'listeo-avatar' );
				if ( $custom_avatar )  {
					echo "<img src='".$custom_avatar[0]."' style='border-radius : 50%'> <br/>";
				} else {
					echo get_avatar( $current_user->user_email, 32 );
				}
				?>
			</span>
			<?php esc_html_e('My Account','listeo_core') ?>
		</div>
		<ul>
		<?php if(!in_array($role,array('owner'))) : ?>
			<?php $user_bookings_page = get_option('listeo_user_bookings_page');  if( $user_bookings_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($user_bookings_page)); ?>"><i class="fa fa-calendar-check-o"></i> <?php esc_html_e('My Bookings','listeo_core');?></a></li>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
			<?php $dashboard_page = get_option('listeo_dashboard_page');  if( $dashboard_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($dashboard_page)); ?>"><i class="sl sl-icon-settings"></i> <?php esc_html_e('Dashboard','listeo_core');?></a></li>
			<?php endif; ?>
		<?php endif; ?>
		<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
			<?php $listings_page = get_option('listeo_listings_page');  if( $listings_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($listings_page)); ?>"><i class="sl sl-icon-layers"></i> <?php esc_html_e('My Listings','listeo_core');?></a></li>
			<?php endif; 
			 endif; ?>	 
			<?php if(!in_array($role,array('owner'))) : ?>
				<?php  $reviews_page = get_option('listeo_reviews_page');  if( $reviews_page ) : ?>
				<li><a href="<?php echo esc_url(get_permalink($reviews_page)); ?>"><i class="sl sl-icon-star"></i> <?php esc_html_e('Reviews','listeo_core');?></a></li>
				<?php endif; ?>
			<?php endif; ?>

			<?php if(!in_array($role,array('owner'))) : ?>
				<?php $bookmarks_page = get_option('listeo_bookmarks_page');  if( $bookmarks_page ) : ?>
				<li><a href="<?php echo esc_url(get_permalink($bookmarks_page)); ?>"><i class="sl sl-icon-heart"></i> <?php esc_html_e('Bookmarks','listeo_core');?></a></li>
				<?php endif; ?>
			<?php endif; ?>
			
			<?php $messages_page = get_option('listeo_messages_page');  if( $messages_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($messages_page)); ?>"><i class="sl sl-icon-envelope-open"></i> <?php esc_html_e('Messages','listeo_core');?>
			<?php 
				$counter = listeo_get_unread_counter();
				if($counter) { ?>
				<span class="nav-tag messages"><?php echo esc_html($counter); ?></span>
				<?php } ?>
			</a></li>
			<?php endif; ?>
			
		<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
			<?php $bookings_page = get_option('listeo_bookings_page');  if( $bookings_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($bookings_page)); ?>/?status=waiting"><i class="fa fa-calendar-check-o"></i> <?php esc_html_e('Bookings','listeo_core');?></a></li>
			<?php endif; ?>
		<?php endif; ?>

		<?php if(!in_array($role,array('owner'))) : ?>
			<?php $profile_page = get_option('listeo_profile_page');  if( $profile_page ) : ?>
			<li><a href="<?php echo esc_url(get_permalink($profile_page)); ?>"><i class="sl sl-icon-user"></i> <?php esc_html_e('My Profile','listeo_core');?></a></li>
			<?php endif; ?>
		<?php endif; ?>

			<li>
				<a href="<?php echo wp_logout_url(home_url()); ?>"><i class="sl sl-icon-power"></i> <?php esc_html_e('Logout','listeo_core');?></a>
			</li>
		</ul>
	</div>
	<?php } else { 

		$popup_login = get_option( 'listeo_popup_login' ); 
		$submit_page = get_option('listeo_submit_page');  
		if(function_exists('Listeo_Core')):
		if( $popup_login == 'ajax' && !is_page_template('template-dashboard.php') ) { ?>
						<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim sign_in_link"><!--<i class="sl sl-icon-login"></i>--> <?php esc_html_e('Sign In', 'listeo_core'); ?></a>
			<a href="#sign-in-dialog" class="sign-in popup-with-zoom-anim sign_up_link"><!--<i class="sl sl-icon-login"></i>--> <?php esc_html_e('Sign Up', 'listeo_core'); ?></a>
			
		<?php } else {
			$login_page = get_option('listeo_profile_page') ?>
			<a href="<?php echo esc_url(get_permalink($login_page)); ?>" class="sign-in"><!--<i class="sl sl-icon-login"></i>--> <?php esc_html_e('Sign In', 'listeo_core'); ?></a>
		<?php }
		endif; ?>
	<?php } ?>

<?php endif; ?>

<?php if( true == $submit_display) : ?>
	<?php if(is_user_logged_in()){ ?>
		<?php if(in_array($role,array('administrator','admin','owner'))) : ?>
			<?php $submit_page = get_option('listeo_submit_page');  if( $submit_page ) : ?>
				<a href="<?php echo esc_url(get_permalink($submit_page)); ?>" class="button border with-icon"><?php esc_html_e('Add Listing', 'listeo_core'); ?> <i class="sl sl-icon-plus"></i></a>
			<?php endif; ?>
		<?php else: ?>
			<?php $browse_page = get_post_type_archive_link( 'listing' ); ;  if( $browse_page ) : ?>
				<a href="<?php echo esc_url($browse_page); ?>" class="button border"><?php esc_html_e('Browse Listings', 'listeo_core'); ?></i></a>
			<?php endif; ?>
		<?php endif; ?>	
	<?php } else { ?>

			<?php $submit_page = get_option('listeo_submit_page'); if( $submit_page ) : ?>
				<a href="<?php echo esc_url(get_permalink($submit_page)); ?>" class="button border with-icon"><?php esc_html_e('Add Listing', 'listeo_core'); ?> <i class="sl sl-icon-plus"></i></a>
			<?php endif; ?>
	<?php } ?>
	
<?php endif; ?>