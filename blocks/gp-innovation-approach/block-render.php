<?php
/**
 * Block template file: block-render.php
 *
 * Gp/section Innovation Approach Block Template.
 *
 * @param   array $block The block settings and attributes.
 * @param   string $content The block inner HTML (empty).
 * @param   bool $is_preview True during AJAX preview.
 * @param   (int|string) $post_id The post ID this block is saved to.
 */

// Create id attribute allowing for custom "anchor" value.
$id = 'section-innovation-approach-' . $block['id'];
if ( ! empty($block['anchor'] ) ) {
    $id = $block['anchor'];
}

// Create class attribute allowing for custom "className" and "align" values.
$classes = 'innovation-approach';
if ( ! empty( $block['className'] ) ) {
    $classes .= ' ' . $block['className'];
}
if ( ! empty( $block['align'] ) ) {
    $classes .= ' align' . $block['align'];
}
?>
<?php if ($is_preview): ?>
	<style type="text/css">
		<?php echo '#' . $id; ?> .button {
			display: inline-flex;
			justify-content: center;
			align-items: center;
			vertical-align: top;
			font-size: 12px;
			line-height: 24px;
			border: none;
			padding: 10px 41px;
			border-radius: 24px;
			transition: all 0.2s;
			text-decoration: none;
			cursor: pointer;
			gap: 10px;
			position: relative;
			font-weight: 500;
			text-align: center;
			white-space: nowrap;
			overflow: hidden;
			text-transform: uppercase;
		}
		<?php echo '#' . $id; ?> .button--primary {
			background-color: #C11F5A;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--primary:hover {
			background-color: #DE5126;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--primary:disabled, .button--primary.disabled {
			background-color: #BFC0BF;
			color: #7A7B78;
		}
		<?php echo '#' . $id; ?> .button--white {
			background-color: #fff;
			color: #0C304F;
		}
		<?php echo '#' . $id; ?> .button--white:hover {
			background-color: #DE5126;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--white:disabled, .button--white.disabled {
			background-color: #BFC0BF;
			color: #7A7B78;
		}
		<?php echo '#' . $id; ?> .button--navy {
			background-color: #0C304F;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--navy:hover {
			background-color: #DE5126;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--navy:disabled, .button--navy.disabled {
			background-color: #BFC0BF;
			color: #7A7B78;
		}
		<?php echo '#' . $id; ?> .button--navy-outline {
			background-color: #fff;
			color: #0C304F;
			box-shadow: inset 0 0 0 1px #0C304F;
		}
		<?php echo '#' . $id; ?> .button--navy-outline:hover {
			background-color: #184C71;
			color: #fff;
		}
		<?php echo '#' . $id; ?> .button--navy-outline:disabled, .button--navy-outline.disabled {
			background-color: #fff;
			box-shadow: inset 0 0 0 1px #BFC0BF;
			color: #7A7B78;
		}
		<?php echo '#' . $id; ?> .button--white-outline {
			background-color: transparent;
			color: #fff;
			box-shadow: inset 0 0 0 1px #fff;
		}
		<?php echo '#' . $id; ?> .button--white-outline:hover {
			background-color: #fff;
			color: #C11F5A;
		}
		<?php echo '#' . $id; ?> .button--white-outline:disabled, .button--white-outline.disabled {
			background-color: #fff;
			box-shadow: inset 0 0 0 1px #BFC0BF;
			color: #7A7B78;
		}
		<?php echo '#' . $id; ?> .h2 {
			font-weight: 500;
			font-size: 44px;
			line-height: 1.2;
			margin-top: 0;
		}
		<?php echo '#' . $id; ?> .h3 {
			font-size: 28px;
			line-height: 1.2;
			font-weight: 400;
			margin-top: 0;
		}
		.innovation-approach__image {
			order: var(--order);
		}
	</style>
<?php endif ?>

<?php

	$sectionTitleTag = 'h2';
	if (get_field( 'section_title_tag' )) {
		$sectionTitleTag = get_field( 'section_title_tag' );
	}

	$contentTitleTag = 'h3';
	if (get_field( 'content_title_tag' )) {
		$contentTitleTag = get_field( 'content_title_tag' );
	}

	$sectionBgColor = '#C11F5A';
	if (get_field( 'section_background_color' )) {
		$sectionBgColor = get_field( 'section_background_color' );
	}

	$sectionTextColor = '#FFFFFF';
	if (get_field( 'section_text_color' )) {
		$sectionTextColor = get_field( 'section_text_color' );
	}

	if (get_field( 'image_position' ) == '2') {
		$classes .= ' innovation-approach--right-img';
	}

 ?>
<style type="text/css">
	<?php echo '#' . $id; ?> .innovation-approach__wrap::before{
		background-color: <?php echo $sectionBgColor; ?>;
	}
	<?php echo '#' . $id; ?> .innovation-approach__info {
		color: <?php echo $sectionTextColor; ?>;
		background-color: <?php echo $sectionBgColor; ?>;
	}
	<?php echo '#' . $id; ?> .h2 {
		margin-top: 0;
	}
	<?php echo '#' . $id; ?> .h3 {
		margin-top: 0;
	}
	<?php echo '#' . $id; ?> .innovation-approach__text a {
		color: var(--linkColor);
	}
	<?php echo '#' . $id; ?> .innovation-approach__text a:hover {
		text-decoration: none;
	}
	<?php echo '#' . $id; ?> ul:not([class])>li:not([class]):before {
		color: var(--dotColor);
	}
</style>


<?php if (isset( $block['data']['preview_image_help'] )  ): ?>
    <?php echo '<img src="' . get_stylesheet_directory_uri() . '/blocks/gp-innovation-approach/' . $block['data']['preview_image_help'] .'" style="width:100%; height:auto;">'; ?>
<?php else: ?>
<div id="<?php echo esc_attr( $id ); ?>" class="<?php echo esc_attr( $classes ); ?>" style="--dotColor:<?php the_field( 'bullet_list_color' ); ?>;--linkColor:<?php the_field( 'text_link_color' ); ?>;">
	<div class="container">
		<?php if (get_field( 'section_title' )): ?>
			<<?php echo $sectionTitleTag; ?> class="innovation-approach__title h2"><?php the_field( 'section_title' ); ?></<?php echo $sectionTitleTag; ?>>
		<?php endif ?>
		<div class="innovation-approach__wrap">
			<div class="innovation-approach__image" style="--order: <?php the_field( 'image_position' ); ?>">
				<?php $section_image = get_field( 'section_image' ); ?>
				<?php if ( $section_image ) : ?>
					<img src="<?php echo esc_url( $section_image['url'] ); ?>" alt="<?php echo esc_attr( $section_image['alt'] ); ?>" />
				<?php endif; ?>
			</div>
			<div class="innovation-approach__info">
				<div class="innovation-approach__content">
					<<?php echo $contentTitleTag; ?> class="innovation-approach__content-title h3"><?php the_field( 'content_title' ); ?></<?php echo $contentTitleTag; ?>>
					<div class="innovation-approach__text"><?php the_field( 'content_text' ); ?></div>
					<?php if ( have_rows( 'buttons' ) ) : ?>
						<div class="innovation-approach__buttons">
							<?php while ( have_rows( 'buttons' ) ) : the_row(); ?>
								<?php $button = get_sub_field( 'button' ); ?>
								<?php if ( $button ) : ?>
									<a class="button <?php the_sub_field( 'button_style' ); ?>" href="<?php echo esc_url( $button['url'] ); ?>" target="<?php echo esc_attr( $button['target'] ); ?>"><span class="button__text"><?php echo esc_html( $button['title'] ); ?></span></a>
								<?php endif; ?>
							<?php endwhile; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
