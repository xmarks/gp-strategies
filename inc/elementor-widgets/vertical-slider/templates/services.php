<?php
/**
 * Vertical Slider - Services Layout Template
 *
 * @package Gp_Strategies
 *
 * Available variables:
 * @var array  $settings         Widget settings
 * @var array  $slides           Slides data
 * @var string $widget_id        Widget ID
 * @var bool   $show_arrows      Whether to show arrows
 * @var bool   $show_pagination  Whether to show pagination
 * @var object $this             Widget instance
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>

<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
	<div class="splide__track">
		<ul class="splide__list">
			<?php foreach ( $slides as $index => $slide ) : ?>
				<?php
				$slide_key = 'slide_' . $index;
				$this->add_render_attribute( $slide_key, 'class', 'splide__slide gp-vs__slide', true );

				$image_url         = $slide['slide_image']['url'] ?? '';
				$image_id          = $slide['slide_image']['id'] ?? 0;
				$link_url          = $slide['slide_link']['url'] ?? '';
				$link_is_external  = ! empty( $slide['slide_link']['is_external'] ) ? 'target="_blank"' : '';
				$link_nofollow     = ! empty( $slide['slide_link']['nofollow'] ) ? 'rel="nofollow"' : '';
				$slide_title       = $slide['slide_title'] ?? '';
				$slide_description = $slide['slide_description'] ?? '';
				?>
				<li <?php echo $this->get_render_attribute_string( $slide_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
					<div class="gp-vs__inner">
						<?php if ( $image_url ) : ?>
							<div class="gp-vs__image">
								<?php
								if ( $image_id ) {
									echo wp_get_attachment_image( $image_id, 'medium' );
								} else {
									?>
									<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $slide_title ); ?>">
									<?php
								}
								?>
							</div>
						<?php endif; ?>

						<div class="gp-vs__content">
							<?php if ( $slide_title ) : ?>
								<h3 class="gp-vs__title"><?php echo esc_html( $slide_title ); ?></h3>
							<?php endif; ?>

							<?php if ( $slide_description ) : ?>
								<p class="gp-vs__description"><?php echo esc_html( $slide_description ); ?></p>
							<?php endif; ?>

							<?php if ( $link_url && '#' !== $link_url ) : ?>
								<a href="<?php echo esc_url( $link_url ); ?>" class="gp-vs__link" <?php echo esc_attr( $link_is_external ); ?> <?php echo esc_attr( $link_nofollow ); ?>>
									<?php esc_html_e( 'Learn More', 'gp-strategies' ); ?>
								</a>
							<?php endif; ?>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</div>
