<?php 
$video = get_post_meta( $post->ID, '_video', true ); 
if($video) : ?> 
<!-- Video -->

<div id="listing-video" class="listing-section">
	<div class="listeo_custom_sec_seprator"><hr></div>
	<h3 class="listing-desc-headline margin-top-60 margin-bottom-30"><?php esc_html_e('Video','listeo_core'); ?></h3>
	<div class="responsive-iframe">
		<?php echo wp_oembed_get( $video ); ?>
	</div>
</div>
<?php endif ?>