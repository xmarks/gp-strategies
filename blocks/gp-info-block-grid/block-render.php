<?php
/**
 * Block template file: block-render.php
 *
 * Gp/info Block Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'info-block-grid-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'info-block-grid';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<style type="text/css">
	<?php echo '#' . $id; ?> {
		margin-bottom: 16px;
	}
</style>
<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-info-block-grid/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
	<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="--columns:<?php the_field( 'columns' ); ?>;--gap-v:<?php the_field( 'grid_gap_vertical' ); ?>px;--gap-h:<?php the_field( 'grid_gap_horizontal' ); ?>px;">

		<?php if ( have_rows( 'items' ) ) : ?>
			<?php while ( have_rows( 'items' ) ) : the_row(); ?>
				<?php $icon = get_sub_field( 'icon' ); ?>
				<div class="info-block-grid__item info-block-grid__item--<?php the_field( 'icon_position' ); ?>">
					<div class="info-block-grid__icon">
						<?php if ( $icon ) : ?>
							<?php legacy_sprite_svg( $icon['ID'], '32', '32' ); ?>
						<?php endif; ?>
					</div>
					<div class="info-block-grid__text"><?php the_sub_field( 'text_content' ); ?></div>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
		<?php endif; ?>
	</div>
<?php endif; ?>
