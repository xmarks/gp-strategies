<?php
/**
 * Vertical Slider Services Elementor Widget
 *
 * Custom Elementor widget using SplideJS for vertical slider
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Vertical_Slider_Services_Widget
 *
 * Elementor widget for vertical services slider using SplideJS
 */
class Vertical_Slider_Services_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'vertical-slider-services';
	}

	/**
	 * Get widget title
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'Vertical Slider Services', 'gp-strategies' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-slides';
	}

	/**
	 * Get widget categories
	 *
	 * @return array
	 */
	public function get_categories(): array {
		return array( 'gp-strategies', 'general' );
	}

	/**
	 * Get widget keywords
	 *
	 * @return array
	 */
	public function get_keywords(): array {
		return array( 'slider', 'vertical', 'services', 'splide', 'carousel' );
	}

	/**
	 * Get script dependencies
	 *
	 * @return array
	 */
	public function get_script_depends(): array {
		return array( 'splide-js', 'vertical-slider-services-js' );
	}

	/**
	 * Get style dependencies
	 *
	 * @return array
	 */
	public function get_style_depends(): array {
		return array( 'splide-core-css', 'vertical-slider-services-css' );
	}

	/**
	 * Register widget controls
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		// Content Section - Slides.
		$this->start_controls_section(
			'section_slides',
			array(
				'label' => esc_html__( 'Slides', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'slide_image',
			array(
				'label'   => esc_html__( 'Image', 'gp-strategies' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => array(
					'url' => \Elementor\Utils::get_placeholder_image_src(),
				),
			)
		);

		$repeater->add_control(
			'slide_title',
			array(
				'label'       => esc_html__( 'Title', 'gp-strategies' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => esc_html__( 'Service Title', 'gp-strategies' ),
				'label_block' => true,
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'slide_description',
			array(
				'label'   => esc_html__( 'Description', 'gp-strategies' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'default' => esc_html__( 'Service description goes here.', 'gp-strategies' ),
				'dynamic' => array(
					'active' => true,
				),
			)
		);

		$repeater->add_control(
			'slide_link',
			array(
				'label'       => esc_html__( 'Link', 'gp-strategies' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => esc_html__( 'https://your-link.com', 'gp-strategies' ),
				'default'     => array(
					'url'         => '#',
					'is_external' => false,
					'nofollow'    => false,
				),
				'dynamic'     => array(
					'active' => true,
				),
			)
		);

		$this->add_control(
			'slides',
			array(
				'label'       => esc_html__( 'Slides', 'gp-strategies' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => array(
					array(
						'slide_title'       => esc_html__( 'Service One', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for service one.', 'gp-strategies' ),
					),
					array(
						'slide_title'       => esc_html__( 'Service Two', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for service two.', 'gp-strategies' ),
					),
					array(
						'slide_title'       => esc_html__( 'Service Three', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for service three.', 'gp-strategies' ),
					),
				),
				'title_field' => '{{{ slide_title }}}',
			)
		);

		$this->end_controls_section();

		// Content Section - Slider Settings.
		$this->start_controls_section(
			'section_slider_settings',
			array(
				'label' => esc_html__( 'Slider Settings', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_responsive_control(
			'slider_height',
			array(
				'label'      => esc_html__( 'Height', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', 'vh', 'em' ),
				'range'      => array(
					'px' => array(
						'min'  => 200,
						'max'  => 1000,
						'step' => 10,
					),
					'vh' => array(
						'min' => 20,
						'max' => 100,
					),
					'em' => array(
						'min' => 10,
						'max' => 50,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 500,
				),
				'selectors'  => array(
					'{{WRAPPER}} .vertical-slider-services' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'autoplay',
			array(
				'label'        => esc_html__( 'Autoplay', 'gp-strategies' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gp-strategies' ),
				'label_off'    => esc_html__( 'No', 'gp-strategies' ),
				'return_value' => 'yes',
				'default'      => '',
			)
		);

		$this->add_control(
			'autoplay_interval',
			array(
				'label'     => esc_html__( 'Autoplay Interval (ms)', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::NUMBER,
				'min'       => 1000,
				'max'       => 10000,
				'step'      => 500,
				'default'   => 3000,
				'condition' => array(
					'autoplay' => 'yes',
				),
			)
		);

		$this->add_control(
			'loop',
			array(
				'label'        => esc_html__( 'Loop', 'gp-strategies' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gp-strategies' ),
				'label_off'    => esc_html__( 'No', 'gp-strategies' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'speed',
			array(
				'label'   => esc_html__( 'Transition Speed (ms)', 'gp-strategies' ),
				'type'    => \Elementor\Controls_Manager::NUMBER,
				'min'     => 100,
				'max'     => 2000,
				'step'    => 100,
				'default' => 400,
			)
		);

		$this->end_controls_section();

		// Style Section - Slide.
		$this->start_controls_section(
			'section_style_slide',
			array(
				'label' => esc_html__( 'Slide', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'slide_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .vss-slide' => 'background-color: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'slide_padding',
			array(
				'label'      => esc_html__( 'Padding', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'      => '20',
					'right'    => '20',
					'bottom'   => '20',
					'left'     => '20',
					'unit'     => 'px',
					'isLinked' => true,
				),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'slide_gap',
			array(
				'label'      => esc_html__( 'Gap Between Slides', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 50,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Border::get_type(),
			array(
				'name'     => 'slide_border',
				'label'    => esc_html__( 'Border', 'gp-strategies' ),
				'selector' => '{{WRAPPER}} .vss-slide',
			)
		);

		$this->add_responsive_control(
			'slide_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Image.
		$this->start_controls_section(
			'section_style_image',
			array(
				'label' => esc_html__( 'Image', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'image_width',
			array(
				'label'      => esc_html__( 'Width', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px', '%' ),
				'range'      => array(
					'px' => array(
						'min'  => 50,
						'max'  => 500,
						'step' => 10,
					),
					'%'  => array(
						'min' => 10,
						'max' => 100,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 150,
				),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide__image' => 'width: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_responsive_control(
			'image_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Content.
		$this->start_controls_section(
			'section_style_content',
			array(
				'label' => esc_html__( 'Content', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'title_heading',
			array(
				'label' => esc_html__( 'Title', 'gp-strategies' ),
				'type'  => \Elementor\Controls_Manager::HEADING,
			)
		);

		$this->add_control(
			'title_color',
			array(
				'label'     => esc_html__( 'Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#333333',
				'selectors' => array(
					'{{WRAPPER}} .vss-slide__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .vss-slide__title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'description_heading',
			array(
				'label'     => esc_html__( 'Description', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
			)
		);

		$this->add_control(
			'description_color',
			array(
				'label'     => esc_html__( 'Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#666666',
				'selectors' => array(
					'{{WRAPPER}} .vss-slide__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .vss-slide__description',
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .vss-slide__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Link.
		$this->start_controls_section(
			'section_style_link',
			array(
				'label' => esc_html__( 'Link', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'link_color',
			array(
				'label'     => esc_html__( 'Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#0066cc',
				'selectors' => array(
					'{{WRAPPER}} .vss-slide__link' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'link_hover_color',
			array(
				'label'     => esc_html__( 'Hover Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#004499',
				'selectors' => array(
					'{{WRAPPER}} .vss-slide__link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .vss-slide__link',
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend
	 *
	 * @return void
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$slides   = $settings['slides'];

		if ( empty( $slides ) ) {
			return;
		}

		$widget_id = $this->get_id();

		// Build Splide options.
		$splide_options = array(
			'direction' => 'ttb',
			'height'    => $settings['slider_height']['size'] . $settings['slider_height']['unit'],
			'wheel'     => true,
			'type'      => ( 'yes' === $settings['loop'] ) ? 'loop' : 'slide',
			'speed'     => (int) $settings['speed'],
			'gap'       => $settings['slide_gap']['size'] . $settings['slide_gap']['unit'],
		);

		if ( 'yes' === $settings['autoplay'] ) {
			$splide_options['autoplay'] = true;
			$splide_options['interval'] = (int) $settings['autoplay_interval'];
		}

		$this->add_render_attribute(
			'wrapper',
			array(
				'class'               => 'vertical-slider-services splide',
				'id'                  => 'vss-' . esc_attr( $widget_id ),
				'data-splide-options' => wp_json_encode( $splide_options ),
			)
		);
		?>

		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
			<div class="splide__track">
				<ul class="splide__list">
					<?php foreach ( $slides as $index => $slide ) : ?>
						<?php
						$slide_key = 'slide_' . $index;
						$this->add_render_attribute( $slide_key, 'class', 'splide__slide vss-slide' );

						$image_url = ! empty( $slide['slide_image']['url'] ) ? $slide['slide_image']['url'] : '';
						$image_id  = ! empty( $slide['slide_image']['id'] ) ? $slide['slide_image']['id'] : 0;

						$link_url         = ! empty( $slide['slide_link']['url'] ) ? $slide['slide_link']['url'] : '';
						$link_is_external = ! empty( $slide['slide_link']['is_external'] ) ? 'target="_blank"' : '';
						$link_nofollow    = ! empty( $slide['slide_link']['nofollow'] ) ? 'rel="nofollow"' : '';
						?>
						<li <?php echo $this->get_render_attribute_string( $slide_key ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>>
							<div class="vss-slide__inner">
								<?php if ( $image_url ) : ?>
									<div class="vss-slide__image">
										<?php
										if ( $image_id ) {
											echo wp_get_attachment_image( $image_id, 'medium' );
										} else {
											?>
											<img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $slide['slide_title'] ); ?>">
											<?php
										}
										?>
									</div>
								<?php endif; ?>

								<div class="vss-slide__content">
									<?php if ( ! empty( $slide['slide_title'] ) ) : ?>
										<h3 class="vss-slide__title"><?php echo esc_html( $slide['slide_title'] ); ?></h3>
									<?php endif; ?>

									<?php if ( ! empty( $slide['slide_description'] ) ) : ?>
										<p class="vss-slide__description"><?php echo esc_html( $slide['slide_description'] ); ?></p>
									<?php endif; ?>

									<?php if ( $link_url && '#' !== $link_url ) : ?>
										<a href="<?php echo esc_url( $link_url ); ?>" class="vss-slide__link" <?php echo esc_attr( $link_is_external ); ?> <?php echo esc_attr( $link_nofollow ); ?>>
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

		<?php
	}

	/**
	 * Render widget output in the editor
	 *
	 * Written as a Backbone JavaScript template and used to generate the live preview.
	 *
	 * @return void
	 */
	protected function content_template(): void {
		?>
		<#
		var widgetId = view.getID();
		var splideOptions = {
			direction: 'ttb',
			height: settings.slider_height.size + settings.slider_height.unit,
			wheel: true,
			type: settings.loop === 'yes' ? 'loop' : 'slide',
			speed: parseInt(settings.speed),
			gap: settings.slide_gap.size + settings.slide_gap.unit
		};

		if (settings.autoplay === 'yes') {
			splideOptions.autoplay = true;
			splideOptions.interval = parseInt(settings.autoplay_interval);
		}
		#>

		<div class="vertical-slider-services splide" id="vss-{{{ widgetId }}}" data-splide-options='{{{ JSON.stringify(splideOptions) }}}'>
			<div class="splide__track">
				<ul class="splide__list">
					<# _.each(settings.slides, function(slide, index) { #>
						<li class="splide__slide vss-slide">
							<div class="vss-slide__inner">
								<# if (slide.slide_image.url) { #>
									<div class="vss-slide__image">
										<img src="{{{ slide.slide_image.url }}}" alt="{{{ slide.slide_title }}}">
									</div>
								<# } #>

								<div class="vss-slide__content">
									<# if (slide.slide_title) { #>
										<h3 class="vss-slide__title">{{{ slide.slide_title }}}</h3>
									<# } #>

									<# if (slide.slide_description) { #>
										<p class="vss-slide__description">{{{ slide.slide_description }}}</p>
									<# } #>

									<# if (slide.slide_link.url && slide.slide_link.url !== '#') { #>
										<a href="{{{ slide.slide_link.url }}}" class="vss-slide__link">
											<?php esc_html_e( 'Learn More', 'gp-strategies' ); ?>
										</a>
									<# } #>
								</div>
							</div>
						</li>
					<# }); #>
				</ul>
			</div>
		</div>
		<?php
	}
}
