<?php

/**
 * Oxy Tab Component Class. Child of Tabs
 * 
 * @since 0.1.3
 */

Class Oxy_Tab_Component extends CT_Component {

	var $options;

	function __construct( $options ) {

		// run initialization
		$this->init( $options );
		
		// Add shortcodes
		add_shortcode( $this->options['tag'], array( $this, 'add_shortcode' ) );

		for ( $i = 2; $i <= 16; $i++ ) {
			add_shortcode( $this->options['tag'] . "_" . $i, array( $this, 'add_shortcode' ) );
		}

		// change component button place
		remove_action("ct_toolbar_fundamentals_list", array( $this, "component_button" ) );
	}


	/**
	 * Add a [oxy_tab] shortcode to WordPress
	 *
	 * @since 0.1
	 */

	function add_shortcode( $atts, $content, $name ) {
		
		if ( ! $this->validate_shortcode( $atts, $content, $name ) ) {
			return '';
		}

		$options = $this->set_options( $atts );

		ob_start();

		?><div id="<?php echo esc_attr($options['selector']); ?>" class="<?php if(isset($options['classes'])) echo esc_attr($options['classes']); ?>" <?php do_action("oxygen_vsb_component_attr", $options, $this->options['tag']); ?>><?php echo do_shortcode( $content ); ?></div><?php

		return ob_get_clean();
	}
}


// Create toolbar inctances
global $oxygen_vsb_components;
$oxygen_vsb_components['tab'] = new Oxy_Tab_Component ( 

		array( 
			'name' 		=> __("Tab", "oxygen"),
			'tag' 		=> 'oxy_tab',
			'params' 	=> array(
					array(
						"type" 			=> "flex-layout",
						"heading" 		=> __("Layout Child Elements", "oxygen"),
						"param_name" 	=> "flex-direction",
						"css" 			=> true,
					),
					array(
						"type" 			=> "checkbox",
						"heading" 		=> __("Allow multiline"),
						"param_name" 	=> "flex-wrap",
						"value" 		=> "",
						"true_value" 	=> "wrap",
						"false_value" 	=> "",
						"condition" 	=> "flex-direction=row"
					),
					array(
						"type" => "positioning",
					),
					array(
						"type" 			=> "columnwidth",
						"heading" 		=> __("Width"),
						"param_name" 	=> "width",
						"value" 		=> "",
					),
					array(
						"type" 			=> "colorpicker",
						"heading" 		=> __("Background color"),
						"param_name" 	=> "background-color",
					),
				),
			'advanced' 	=> array(
					'typography' => array(
						'values' 	=> array (
								'font-family' 	=> "",
								'font-size' 	=> "",
								'font-weight' 	=> "",
							)
					),
					'flex' => array(
						'values' 	=> array (
								'display' 		 => 'flex',
								'flex-direction' => 'column',
								'align-items' 	 => 'flex-start',
								'justify-content'=> '',
								'text-align' 	 => '',
								'flex-wrap' 	 => 'nowrap',
							)
					),
                    'allowed_html' => 'post',
                    'allow_shortcodes' => true,
			),


			
		)
);

?>