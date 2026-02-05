<?php if (get_field('disable_temporary') == true) {
  return;
}
/**
 * Block template file: block-render.php
 *
 * Gp/count Grid Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'count-grid-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'content-count-grid';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>

<?php if ($is_preview): ?>
<style type="text/css">
    <?php echo '#' . $id; ?> code{
        padding: 30px;
        background-color: #c5c5c5;
        border: 1px dashed;
        color: #fff;
        text-align: center;
        display: block;
    }
</style>
<?php endif; ?>
<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-count-grid/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="--columns:<?php the_field( 'columns' ); ?>;--gap-v:<?php the_field( 'grid_gap_vertical' ); ?>px;--gap-h:<?php the_field( 'grid_gap_horizontal' ); ?>px;">
	<?php if ( have_rows( 'items' ) ) : ?>
		<?php while ( have_rows( 'items' ) ) : the_row(); ?>
			<div class="count-block">
				<div class="count-block__num">
					<?php if (get_field('active_count_effect')): ?>
						<?php if ($is_preview): ?><?php the_sub_field( 'large_number' ); ?><?php endif; ?>
						<span class="num-val" data-number="<?php the_sub_field( 'large_number' ); ?>"></span><span class="prefix"><?php the_sub_field( 'symbol' ); ?></span>&nbsp;
					<?php else: ?>
						<?php the_sub_field( 'large_number' ); ?><?php the_sub_field( 'symbol' ); ?>
					<?php endif; ?>

				</div>
				<div class="count-block__description"><?php the_sub_field( 'description' ); ?></div>
			</div>
		<?php endwhile; ?>
	<?php else: ?>
		<?php if ($is_preview): ?>
		<code>Add at least one item</code>
		<?php endif; ?>
	<?php endif; ?>
</div>
<?php endif; ?>
