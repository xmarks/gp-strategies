<?php if (get_field('disable_temporary') == true) {
  return;
}
/**
 * Block template file: block-render.php
 *
 * Gp/highlight Cta Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'highlight-cta-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'highlight-cta';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}


if(isset($block['backgroundColor'])) {

    $backgroundColor =  $block['backgroundColor'];

}elseif (isset($block['style']['color']['background'])) {

    $backgroundColor =  $block['style']['color']['background'];

}else{

   $backgroundColor =  '#C11F5A';

};

if(isset($block['textColor'])) {

    $textColor =  $block['textColor'];

}elseif(isset($block['style']['color']['text'])){

    $textColor = $block['style']['color']['text'];

}else{

    $textColor = '#fff';

}
?>

<style type="text/css">
    <?php echo '#' . $id; ?> {
        <?php
        if ($backgroundColor) {
            echo 'background-color:'.$backgroundColor.';';
        };
        if ($textColor) {
            echo 'color:'.$textColor.';';
        };
        ?>
    }
</style>

<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-highlight-cta/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
    <p>
        <?php the_field( 'description' ); ?>
        <?php $link = get_field( 'link' ); ?>
        <?php if ( $link ) : ?>
            <a class="not-color" href="<?php echo esc_url( $link['url'] ); ?>" target="<?php echo esc_attr( $link['target'] ); ?>"><?php echo esc_html( $link['title'] ); ?></a>
        <?php endif; ?>
    </p>
</div>
<?php endif; ?>
