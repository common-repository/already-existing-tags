<?php
defined( 'ABSPATH' ) || die( 'Cannot access pages directly.' );
?>

<div class="wrap">

<h2>Already Existing Tags</h2>

<?php settings_errors(); ?>

<form action="options.php" method="post">

<?php
settings_fields( 'aet-settings-group' );

if ( get_option( 'aet_turn_on' ) && ! aet_halt() ) {
	echo '<h3>STATUS: enabled</h3>';
} elseif ( get_option( 'aet_turn_on' ) && aet_halt() ) {
	echo '<h3>STATUS: enabled... but there is nothing to examine</h3>';
} else {
	echo '<h3>STATUS: disabled</h3>';
}
?>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="aet-turn-on" name="aet_turn_on" value="1" <?php checked( get_option( 'aet_turn_on' ) ); ?> />
<label for="aet-turn-on">Turn on.</label>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="aet-block-manually-added-tags" name="aet_block_manually_added_tags" value="1" <?php checked( get_option( 'aet_block_manually_added_tags' ) ); ?> />
<label for="aet-block-manually-added-tags">Block manually added tags (previously assigned tags will also be removed when the post is updated).</label>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="aet-examine-post-title" name="aet_examine_post_title" value="1" <?php checked( get_option( 'aet_examine_post_title' ) ); ?> />
<label for="aet-examine-post-title">Examine post title.</label>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="aet-examine-post-content" name="aet_examine_post_content" value="1" <?php checked( get_option( 'aet_examine_post_content' ) ); ?> />
<label for="aet-examine-post-content">Examine post content.</label>
</td>
</tr>

<tr>
<td>
<input type="checkbox" id="aet-filter-by-category" name="aet_filter_by_category" value="1" <?php checked( get_option( 'aet_filter_by_category' ) ); ?> />
<label for="aet-filter-by-category">Filter by category.</label>
</td>
</tr>
</table>

<h3 id="included-categories" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'softened'; ?>">Included categories</h3>

<div id="categories-container" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'softened'; ?>">

<?php
$cat_args   = array(
	'hide_empty' => 0,
);
$categories = get_categories( $cat_args );

foreach ( $categories as $key => $value ) {
	echo '<div class="category-block">' . "\n";
	echo '<input type="checkbox" class="chkbx" id="aet-included-categories-' . esc_attr( $value->term_id ) . '" name="aet_included_categories[]" value="' . esc_attr( $value->term_id ) . '"';

	if ( in_array( $value->term_id, aet_included_categories(), true ) ) {
		echo ' checked="checked"';
	}

	echo ' />' . "\n";
	echo '<label for="aet-included-categories-' . esc_attr( $value->term_id ) . '">' . esc_html( $value->name ) . '</label>' . "\n";
	echo '</div>' . "\n";
}
?>

<div id="categories-container-mask" class="<?php echo get_option( 'aet_filter_by_category' ) ? '' : 'active'; ?>"></div>
</div>

<h3>Clean uninstall</h3>

<table class="form-table">
<tr>
<td>
<input type="checkbox" id="aet-clean-uninstall" name="aet_clean_uninstall" value="1" <?php checked( get_option( 'aet_clean_uninstall' ) ); ?> />
<label for="aet-clean-uninstall">Delete all options from database when you delete this plugin (they won't be deleted on just deactivation).</label>
</td>
</tr>
</table>

<?php submit_button(); ?>

</form>

<h4>Do you like this plugin?</h4>

<ul>
<li>Please, <a href="https://wordpress.org/support/plugin/already-existing-tags/reviews/" target="_blank">rate it on the repository</a>.</li>
</ul>

<h4>Thank you!</h4>

</div>
