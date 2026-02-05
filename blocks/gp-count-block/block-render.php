<?php if (get_field('disable_temporary') == true) {
  return;
}
/**
 * Block template file: block-render.php
 *
 * Gp/count Block Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'count-block-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'count-block';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

?>

<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-count-block/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
    <div class="count-block__num">
        <?php if (get_field('active_count_effect')): ?>
        <span class="num-val" data-number="<?php the_field( 'large_number' ); ?>"></span>
        <?php else: ?>
        <?php the_field( 'large_number' ); ?>
         <?php endif; ?>
        <?php the_field( 'symbol' ); ?>
    </div>
    <div class="count-block__description"><?php the_field( 'description' ); ?></div>
</div>
<?php endif; ?>
