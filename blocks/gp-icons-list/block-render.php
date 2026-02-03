<?php if (get_field('disable_temporary') == true) {
  return;
}
/**
 * Block template file: block-render.php
 *
 * Gp/icon List Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'icon-list-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'icon-list';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}

if ( get_field('list_style') == 'vertical'){
	$classes .=' vertical';
}else{
	$classes .=' horizontal';
}

?>
<?php if ($is_preview): ?>
<style type="text/css">
	.icon-list {
		display: flex;
		flex-direction: column;
		gap: 12px;
	}
	.icon-list.horizontal {
		display: flex;
		column-gap: 44px;
		flex-wrap: wrap;
		flex-direction: row;
	}
	.icon-list.horizontal .icon-list__wrapper {
		flex-direction: column;
	}
	.icon-list__wrapper {
		display: flex;
		text-align: center;
		align-items: center;
		gap: 12px;
	}
	.icon-list__wrapper .icon {
		width: 44px;
		height: 44px;
		background-color: #1E8AA8;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		color: #fff;
	}
	.icon-list__wrapper .title {
		font-style: normal;
		font-weight: 400;
		font-size: 14px;
		line-height: 150%;
	}
</style>
<?php endif; ?>


<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-icons-list/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>">
	<?php if ( have_rows( 'add_list_item' ) ) : ?>
		<?php while ( have_rows( 'add_list_item' ) ) : the_row();
			$choose_svg = get_sub_field( 'choose_svg' ); ?>
            <div class="icon-list__wrapper">
                <?php
                if ( $choose_svg ) : ?>
                    <div class="icon">
                        <?php sprite_svg( $choose_svg['ID'], '32', '32' ); ?>
                    </div>
                <?php endif; ?>
                <div class="title">
                    <?php the_sub_field( 'text' ); ?>
                </div>
            </div>
		<?php endwhile; ?>
	<?php else : ?>
		<?php // No rows found ?>
	<?php endif; ?>
</div>
<?php endif; ?>
