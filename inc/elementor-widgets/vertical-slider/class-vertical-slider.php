<?php
/**
 * GP Vertical Slider Elementor Widget
 *
 * Custom Elementor widget using SplideJS for vertical slider with multiple layouts
 *
 * @package Gp_Strategies
 */

declare(strict_types=1);

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class GP_Vertical_Slider_Widget
 *
 * Elementor widget for vertical slider using SplideJS
 */
class GP_Vertical_Slider_Widget extends \Elementor\Widget_Base {

	/**
	 * Get widget name
	 *
	 * @return string
	 */
	public function get_name(): string {
		return 'gp-vertical-slider';
	}

	/**
	 * Get widget title
	 *
	 * @return string
	 */
	public function get_title(): string {
		return esc_html__( 'GP - Vertical Slider', 'gp-strategies' );
	}

	/**
	 * Get widget icon
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return 'eicon-slider-vertical';
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
		return array( 'slider', 'vertical', 'services', 'splide', 'carousel', 'gp' );
	}

	/**
	 * Get script dependencies
	 *
	 * @return array
	 */
	public function get_script_depends(): array {
		return array( 'plugins.splidejs.splide', 'plugins.elementor.vertical-slider' );
	}

	/**
	 * Get style dependencies
	 *
	 * @return array
	 */
	public function get_style_depends(): array {
		return array( 'plugins.splidejs.core', 'plugins.elementor.vertical-slider' );
	}

	/**
	 * Get available layouts
	 *
	 * @return array
	 */
	protected function get_layouts(): array {
		return array(
			'services' => esc_html__( 'Services', 'gp-strategies' ),
		);
	}

	/**
	 * Register widget controls
	 *
	 * @return void
	 */
	protected function register_controls(): void {
		// Content Section - Layout.
		$this->start_controls_section(
			'section_layout',
			array(
				'label' => esc_html__( 'Layout', 'gp-strategies' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'layout',
			array(
				'label'   => esc_html__( 'Layout', 'gp-strategies' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'services',
				'options' => $this->get_layouts(),
			)
		);

		$this->end_controls_section();

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
						'slide_title'       => esc_html__( 'Slide One', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for slide one.', 'gp-strategies' ),
					),
					array(
						'slide_title'       => esc_html__( 'Slide Two', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for slide two.', 'gp-strategies' ),
					),
					array(
						'slide_title'       => esc_html__( 'Slide Three', 'gp-strategies' ),
						'slide_description' => esc_html__( 'Description for slide three.', 'gp-strategies' ),
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
					'{{WRAPPER}} .gp-vertical-slider' => 'height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'show_arrows',
			array(
				'label'        => esc_html__( 'Arrows', 'gp-strategies' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gp-strategies' ),
				'label_off'    => esc_html__( 'No', 'gp-strategies' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->add_control(
			'show_pagination',
			array(
				'label'        => esc_html__( 'Pagination', 'gp-strategies' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'gp-strategies' ),
				'label_off'    => esc_html__( 'No', 'gp-strategies' ),
				'return_value' => 'yes',
				'default'      => 'yes',
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
					'{{WRAPPER}} .gp-vs__slide' => 'background-color: {{VALUE}};',
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
					'{{WRAPPER}} .gp-vs__slide' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
				'selector' => '{{WRAPPER}} .gp-vs__slide',
			)
		);

		$this->add_responsive_control(
			'slide_border_radius',
			array(
				'label'      => esc_html__( 'Border Radius', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gp-vs__slide' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__image' => 'width: {{SIZE}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__image img' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__image' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__title' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'selector' => '{{WRAPPER}} .gp-vs__title',
			)
		);

		$this->add_responsive_control(
			'title_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gp-vs__title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__description' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'description_typography',
				'selector' => '{{WRAPPER}} .gp-vs__description',
			)
		);

		$this->add_responsive_control(
			'description_margin',
			array(
				'label'      => esc_html__( 'Margin', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'selectors'  => array(
					'{{WRAPPER}} .gp-vs__description' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
					'{{WRAPPER}} .gp-vs__link' => 'color: {{VALUE}};',
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
					'{{WRAPPER}} .gp-vs__link:hover' => 'color: {{VALUE}};',
				),
			)
		);

		$this->add_group_control(
			\Elementor\Group_Control_Typography::get_type(),
			array(
				'name'     => 'link_typography',
				'selector' => '{{WRAPPER}} .gp-vs__link',
			)
		);

		$this->end_controls_section();

		// Style Section - Arrows.
		$this->start_controls_section(
			'section_style_arrows',
			array(
				'label'     => esc_html__( 'Arrows', 'gp-strategies' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_arrows' => 'yes',
				),
			)
		);

		$this->add_control(
			'arrows_color',
			array(
				'label'     => esc_html__( 'Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .splide__arrow svg' => 'fill: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'arrows_background_color',
			array(
				'label'     => esc_html__( 'Background Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.5)',
				'selectors' => array(
					'{{WRAPPER}} .splide__arrow' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'arrows_size',
			array(
				'label'      => esc_html__( 'Size', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 20,
						'max'  => 60,
						'step' => 2,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 40,
				),
				'selectors'  => array(
					'{{WRAPPER}} .splide__arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();

		// Style Section - Pagination.
		$this->start_controls_section(
			'section_style_pagination',
			array(
				'label'     => esc_html__( 'Pagination', 'gp-strategies' ),
				'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
				'condition' => array(
					'show_pagination' => 'yes',
				),
			)
		);

		$this->add_control(
			'pagination_color',
			array(
				'label'     => esc_html__( 'Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.3)',
				'selectors' => array(
					'{{WRAPPER}} .splide__pagination__page' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_control(
			'pagination_active_color',
			array(
				'label'     => esc_html__( 'Active Color', 'gp-strategies' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => 'rgba(0, 0, 0, 0.8)',
				'selectors' => array(
					'{{WRAPPER}} .splide__pagination__page.is-active' => 'background: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'pagination_size',
			array(
				'label'      => esc_html__( 'Size', 'gp-strategies' ),
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min'  => 6,
						'max'  => 20,
						'step' => 1,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .splide__pagination__page' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Get template path for layout
	 *
	 * @param string $layout Layout name.
	 * @return string
	 */
	protected function get_template_path( string $layout ): string {
		return get_template_directory() . '/inc/elementor-widgets/vertical-slider/templates/' . $layout . '.php';
	}

	/**
	 * Render widget output on the frontend
	 *
	 * @return void
	 */
	protected function render(): void {
		$settings = $this->get_settings_for_display();
		$slides   = $settings['slides'] ?? array();
		$layout   = $settings['layout'] ?? 'services';

		if ( empty( $slides ) ) {
			return;
		}

		$widget_id       = $this->get_id();
		$show_arrows     = 'yes' === ( $settings['show_arrows'] ?? 'yes' );
		$show_pagination = 'yes' === ( $settings['show_pagination'] ?? 'yes' );

		// Get slider height with defaults.
		$slider_height_size = $settings['slider_height']['size'] ?? 500;
		$slider_height_unit = $settings['slider_height']['unit'] ?? 'px';

		// Get slide gap with defaults.
		$slide_gap_size = $settings['slide_gap']['size'] ?? 10;
		$slide_gap_unit = $settings['slide_gap']['unit'] ?? 'px';

		// Build Splide options.
		$splide_options = array(
			'direction'  => 'ttb',
			'height'     => $slider_height_size . $slider_height_unit,
			'wheel'      => true,
			'type'       => ( 'yes' === ( $settings['loop'] ?? 'yes' ) ) ? 'loop' : 'slide',
			'speed'      => (int) ( $settings['speed'] ?? 400 ),
			'gap'        => $slide_gap_size . $slide_gap_unit,
			'arrows'     => $show_arrows,
			'pagination' => $show_pagination,
		);

		if ( 'yes' === ( $settings['autoplay'] ?? '' ) ) {
			$splide_options['autoplay'] = true;
			$splide_options['interval'] = (int) ( $settings['autoplay_interval'] ?? 3000 );
		}

		// Build wrapper classes.
		$wrapper_classes = array( 'gp-vertical-slider', 'gp-vertical-slider--' . $layout, 'splide' );
		if ( ! $show_arrows ) {
			$wrapper_classes[] = 'gp-vs--hide-arrows';
		}
		if ( ! $show_pagination ) {
			$wrapper_classes[] = 'gp-vs--hide-pagination';
		}

		$this->add_render_attribute(
			'wrapper',
			array(
				'class'               => implode( ' ', $wrapper_classes ),
				'id'                  => 'gp-vs-' . esc_attr( $widget_id ),
				'data-splide-options' => wp_json_encode( $splide_options ),
			)
		);

		// Load layout template.
		$template_path = $this->get_template_path( $layout );

		if ( file_exists( $template_path ) ) {
			include $template_path;
		}
	}

	/**
	 * Render widget output in the editor
	 *
	 * @return void
	 */
	protected function content_template(): void {
		?>
		<#
		var widgetId = view.getID();
		var layout = settings.layout || 'services';
		var showArrows = settings.show_arrows === 'yes';
		var showPagination = settings.show_pagination === 'yes';

		var sliderHeightSize = settings.slider_height && settings.slider_height.size ? settings.slider_height.size : 500;
		var sliderHeightUnit = settings.slider_height && settings.slider_height.unit ? settings.slider_height.unit : 'px';
		var slideGapSize = settings.slide_gap && settings.slide_gap.size ? settings.slide_gap.size : 10;
		var slideGapUnit = settings.slide_gap && settings.slide_gap.unit ? settings.slide_gap.unit : 'px';

		var splideOptions = {
			direction: 'ttb',
			height: sliderHeightSize + sliderHeightUnit,
			wheel: true,
			type: settings.loop === 'yes' ? 'loop' : 'slide',
			speed: parseInt(settings.speed) || 400,
			gap: slideGapSize + slideGapUnit,
			arrows: showArrows,
			pagination: showPagination
		};

		if (settings.autoplay === 'yes') {
			splideOptions.autoplay = true;
			splideOptions.interval = parseInt(settings.autoplay_interval) || 3000;
		}

		var wrapperClasses = ['gp-vertical-slider', 'gp-vertical-slider--' + layout, 'splide'];
		if (!showArrows) {
			wrapperClasses.push('gp-vs--hide-arrows');
		}
		if (!showPagination) {
			wrapperClasses.push('gp-vs--hide-pagination');
		}
		#>

		<div class="{{{ wrapperClasses.join(' ') }}}" id="gp-vs-{{{ widgetId }}}" data-splide-options='{{{ JSON.stringify(splideOptions) }}}'>
			<div class="splide__track">
				<ul class="splide__list">
					<# _.each(settings.slides, function(slide, index) { #>
						<li class="splide__slide gp-vs__slide">
							<div class="gp-vs__inner">
								<# if (slide.slide_image && slide.slide_image.url) { #>
									<div class="gp-vs__image">
										<img src="{{{ slide.slide_image.url }}}" alt="{{{ slide.slide_title || '' }}}">
									</div>
								<# } #>

								<div class="gp-vs__content">
									<# if (slide.slide_title) { #>
										<h3 class="gp-vs__title">{{{ slide.slide_title }}}</h3>
									<# } #>

									<# if (slide.slide_description) { #>
										<p class="gp-vs__description">{{{ slide.slide_description }}}</p>
									<# } #>

									<# if (slide.slide_link && slide.slide_link.url && slide.slide_link.url !== '#') { #>
										<a href="{{{ slide.slide_link.url }}}" class="gp-vs__link">
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
