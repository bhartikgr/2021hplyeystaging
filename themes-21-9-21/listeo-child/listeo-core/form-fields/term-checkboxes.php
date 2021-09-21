<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$field = $data->field;
$key = $data->key;
$dynamic_features = (get_option('listeo_dynamic_features') == 'on') ? 'dynamic' : '' ;

if( isset($_GET['listing_id']) && $_GET['listing_id'] != "" ){
	$listing_id = $_GET['listing_id'];

	$terms = get_the_terms( $listing_id, 'listing_category' ); 

	if( $terms ){
		$selected = false;
		$selected_check = wp_get_object_terms( $listing_id, 'listing_feature', array( 'fields' => 'ids' ) ) ;
		if ( ! empty( $selected_check ) ) {
			if ( ! is_wp_error( $selected_check ) ) {
				$selected = $selected_check;
			}
		}

		$categories = array();
		foreach( $terms as $term ){
			$categories[] = $term->term_id;
		}

		foreach ($categories as $category) {
			$cat_object = get_term_by('id', $category, 'listing_category');
			if($cat_object){
				$features = array();
				$features_temp = get_term_meta($cat_object->term_id,'listeo_taxonomy_multicheck',true);
				if($features_temp) {
					$features += $features_temp;
				}
			}
			$features = array_unique($features);
		}
	}

	if($features){
		?>

		<div class="<?php echo esc_attr($dynamic_features); ?> checkboxes in-row listeo_core-term-checklist listeo_core-term-checklist-<?php echo $key ?>">
			<?php
				require_once( ABSPATH . '/wp-admin/includes/template.php' );

				if ( empty( $field['default'] ) ) {
					$field['default'] = '';
				}

				$taxonomy = $field['taxonomy'];
				$terms = get_terms( $taxonomy, array(
				    'hide_empty' => false,
				) );
				
				foreach ($features as $feature) {
					$feature_obj = get_term_by('slug', $feature, 'listing_feature');
					if( !$feature_obj ){
						continue;
					}

					$is_checked = "";
					if($selected){
						if( in_array(  $feature_obj->term_id, $selected ) ){
							$is_checked = "checked";
						}
					}

					echo '<div class="col-md-3">';
					echo '<input value="' . $feature_obj->term_id . '" type="checkbox" name="tax_input['.$taxonomy.'][]" id="in-'.$taxonomy.'-' . $feature_obj->term_id . '"' .$is_checked. ' /> ' .
			            '<label for="in-'.$taxonomy.'-' . $feature_obj->term_id . '">'. esc_html( apply_filters( 'the_category', $feature_obj->name ) ) . '</label>';
					echo '</div>';

				}

			?>
		</div>

		<?php
	}
	else{
		?>

		<div class="<?php echo esc_attr($dynamic_features); ?> checkboxes in-row listeo_core-term-checklist listeo_core-term-checklist-<?php echo $key ?>">
	<div class="notification warning"><p><?php esc_html_e('Please choose category to display available features','listeo_core') ?></p> </div>
</div>

		<?php
	}
}
else{
	?>

		<div class="<?php echo esc_attr($dynamic_features); ?> checkboxes in-row listeo_core-term-checklist listeo_core-term-checklist-<?php echo $key ?>">
	<div class="notification warning"><p><?php esc_html_e('Please choose category to display available features','listeo_core') ?></p> </div>
</div>

		<?php
}