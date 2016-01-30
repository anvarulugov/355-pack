<?php 
/**
 * AUS Basic Options
 *
 * plugin Options page generator class
 * Uses Wordpress default form html markup
 *
 * @link http://codex.wordpress.org/Creating_Options_Pages
 *
 * @package WordPress
 * @subpackage AUS Basic Options
 * @since AUS Basic 1.0.0
 * @author Dilshod Uktamov, Anvar Ulugov
 * @license GPL2
 */

class AUS_tb_options {

	private $options;
	private $developer_mode;
	private $plugin_name;
	private $plugin_slug;
	private $configs;

	function __construct( $configs = array() ) {

		if ( ! empty( $configs ) ) {
			$this->configs = $configs;
			$this->options 	= get_option( $this->configs['plugin_slug'] . '_plugin_options' );
			$this->plugin_slug = $this->configs['plugin_slug'];
			$this->plugin_name = $this->configs['plugin_name'];
		}

		$this->developer_mode = true;
		add_action( 'admin_menu', array( $this, 'create_menu_page' ) );
		add_action( 'admin_init', array( $this, 'initialize_plugin_options' ) );

		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	}

	public function register_plugin_styles() {
		wp_register_style( 'tclick-pack',  AUSAY_URL.'/css/accessbility-style.css' );
		wp_enqueue_style( 'tclick-pack' );

		wp_register_script( 'tclick-pack', AUSAY_URL . '/js/accessibility-js.js',[],'1.0.0',true);
		wp_enqueue_script( 'tclick-pack' );

	}

	/**
	 * Register Menu items
	 */

	public function create_menu_page() {
		add_options_page( 
			__( '355 Pack', 'aus-basic' ),
			__( '355 Pack' , 'aus-basic' ),
			'manage_options', 
			$this->plugin_slug . '_plugin_options', 
			array( $this, 'menu_page_display' )
		);
	}

	/**
	 * Main menu page display
	 */

	public function menu_page_display() {
		add_action( 'wp_enqueue_scripts', array( $this, 'register_plugin_styles' ) );
	?>
		<div class="wrap">
		<?php if ( $this->developer_mode ) : ?>
			<?php print_r( $this->options ); ?>
		<?php endif; ?>
		<h2><?php echo sprintf( __( '%s Options', 'aus-basic' ), $this->plugin_name ); ?></h2>
			<h4>Those accessibilities was produced by № 355 decision of Republic of Uzbekistan. Enjoy!</h4>
			<div class="how-to-use-accessibility" >
				<section style="width: 100%">
					<h3 style="padding-left:10px;">How to use:</h3>
					<ul style="margin-left:35px; list-style-type:square; margin-bottom: 20px;">
						<li><b>Step 1:</b> Set settings you want to use.</li>
						<li><b>Step 2:</b> To use All accessibilities  copy bellow shortcode and paste  (Inside html page: <i class="text-danger-accessiblity"><code>[shortcode_name]</code></i>, Inside code:  <i class="text-danger-accessiblity"><code>  echo do_shortcode('[shortcode_name name]');</code></i> ) anywhere on your site, or in any template file.</li>
						<li style="list-style-type:none !important; display:block;margin-top:.75em;">
							<b><i class="text-danger-accessiblity">Shortcode:</b></i>&nbsp;&nbsp;&nbsp;&nbsp; <i><code>[tc-ac-modes]</code></i>
						</li>
						<li><b>Step 3:</b> To use accessibility each one copy its shortcode and paste  (Inside html page: <i class="text-danger-accessiblity">[shortcode_name item=item_name]</i>, Inside code:  <i class="text-danger-accessiblity"><code> echo do_shortcode('[shortcode_name item=item_name]');</code></i> ) anywhere on your site, or in any template file.</li>
					</ul>
				</section>
			</div>
		<form action="options.php" method="post" style="padding: 20px;">
		<?php settings_fields( $this->plugin_slug . '_plugin_options_group' ); ?>
		<?php do_settings_sections( $this->plugin_slug . '_plugin_options' ); ?>
		<?php submit_button(); ?>
		</form>
		</div>
		<style>
			.text-danger-accessiblity{
				color: #c70000;
				font-style: normal;
			}
			.text-warning-accessiblity{
				color: #ffa70d;
			}
			.how-to-use-accessibility {
				border: 1px solid #CCC;
				margin-bottom: 5px;
				float: left;
				padding: 20px;
				box-shadow: 0 0 15px 2px #CACACA;
			}
			form .form-table{
				padding: 30px;
				margin-top: 20px;
			}
		</style>
		<?php wp_enqueue_media(); ?>
		<script>
		jQuery(function($) {
			$('.image-upload').click(function(e) {
			var image_field = $(this).data('field');
			var custom_uploader;
			e.preventDefault();
			//If the uploader object has already been created, reopen the dialog
			// if (custom_uploader) {
			//     custom_uploader.open();
			//     return;
			// }
			//Extend the wp.media object
			custom_uploader = wp.media.frames.file_frame = wp.media({
				title: 'Choose Css File',
				button: {
					text: 'Choose Css File'
				},
				multiple: false
			});
			//When a file is selected, grab the URL and set it as the text field's value
			custom_uploader.on('select', function() {
				attachment = custom_uploader.state().get('selection').first().toJSON();
				$(image_field).val(attachment.url);
			});
			//Open the uploader dialog
			custom_uploader.open();
		});
		});
		</script>
	<?php 
	}

	/**
	 * Initialize plugin options
	 */

	public function initialize_plugin_options() {

		add_settings_section(
			$this->plugin_slug . '_plugin_settings_section',
			'',
			'',
			$this->plugin_slug . '_plugin_options'
		);

		add_settings_field(
			'accessibility_plugin_position',
			'<label for="accessibility_plugin_position">' . __( 'Accessibility position in page', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'accessibility_plugin_position',
				'type' => 'select',
				'description' => __( 'Pelase, select Accessibility position', 'aus-basic' ),
				'options'=>[
					'left'=>'Left position',
					'right'=>'Right position',
				]
			)
		);


		add_settings_field(
			'contact_page_id',
			'<label for="contact_page_id">' . __( 'Contact page', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'contact_page_id',
				'type' => 'pages',
				'description' => __( 'Pelase, select contact page. If it isn\'t selected, it will not display.  <b class="text-danger-accessiblity">Shortcode:</b> <code>[tc-ac-modes item="contact"]</code>', 'aus-basic' ),
			)
		);

		add_settings_field(
			'sitemap_page_id',
			'<label for="sitemap_page_id">' . __( 'Sitemap page', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'sitemap_page_id',
				'type' => 'pages',
				'description' => __( 'Pelase, select sitemap page. If it isn\'t selected, it will not display.  <b class="text-danger-accessiblity">Shortcode:</b> <code>[tc-ac-modes item="site-map"]</code>', 'aus-basic' ),
			)
		);

		add_settings_field(
			'rss_page_id',
			'<label for="rss_page_id">' . __( 'Rss page', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'rss_page_id',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use this section  <b class="text-danger-accessiblity">Shortcode:</b> <code>[tc-ac-modes item="rss"]</code> ', 'aus-basic' ),
			)
		);
		add_settings_field(
			'voice_page_id',
			'<label for="voice_page_id">' . __( 'Voice section', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'voice_page_id',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use Voice section. <b class="text-danger-accessiblity">Shortcode:</b><code> [tc-ac-modes item="voice"]</code> ', 'aus-basic' ),
			)
		);
		add_settings_field(
			'mobile_page_id',
			'<label for="mobile_page_id">' . __( 'Mobile section', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'mobile_page_id',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use Mobile section. <b class="text-danger-accessiblity">Shortcode:</b> <code>[tc-ac-modes item="mobile"]</code> ', 'aus-basic' ),
			)
		);

		add_settings_field(
			'search_page_id_check',
			'<label for="search_page_id_check">' . __( 'Search section', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'search_page_id_check',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use search.', 'aus-basic' ),
			)
		);

		add_settings_field(
			'search_page_id',
			'<label for="search_page_id">' . __( 'Search section type', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'search_page_id',
				'type' => 'radio',
				'description' => __( '<b class="text-danger-accessiblity">Shortcodes:</b><code> [tc-ac-modes item="search-animate"]</code> , <code> [tc-ac-modes item="search-modal"]</code>    ', 'aus-basic' ),
				'options'=>[
					1=>'Animate search',
					2=>'Modal search',
				]
			)
		);

		add_settings_field(
			'blind_mode',
			'<label for="blind_mode">' . __( 'For the blind', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'blind_mode',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use blind mode. <b class="text-danger-accessiblity">Shortcode:</b><code> [tc-ac-modes item="blind"]</code>  ', 'aus-basic' ),
			)
		);


		add_settings_field(
			'bootstrap_style_page_id',
			'<label for="bootstrap_style_page_id">' . __( 'Button bootstrap Style ', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'bootstrap_style_page_id',
				'type' => 'select',
				'description' => __( 'Pelase, select Style. If it isn\'t select, Background color of buttons will be transparent   ', 'aus-basic' ),
				'options'=>[
					'default'=>'default',
					'primary'=>'primary',
					'success'=>'success',
					'info'=>'info',
					'warning'=>'warning',
					'danger'=>'danger',
				]
			)
		);

//		add_settings_field(
//			'custom_css',
//			'<label for="bot_token">' . __( 'Custom CSS', 'aus-basic' ) . '</label>',
//			array( $this, 'input'),
//			$this->plugin_slug . '_plugin_options',
//			$this->plugin_slug . '_plugin_settings_section',
//			array(
//				'id' => 'custom_css',
//				'type' => 'textarea',
//				'description' => __( 'Custom css to change design of blind mode', 'aus-basic' ),
//
//			)
//		);


		add_settings_field(
			'language_page_id',
			'<label for="language_page_id">' . __( 'Language Management (qTranslate Configuration)', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'language_page_id',
				'type' => 'checkbox',
				'description' => __( 'Pelase, check to use languages. This section required <a href="http://wordpress.org/plugins/qtranslate-x/">qTranslate-X</a> plugin', 'aus-basic' ),
			)
		);

		add_settings_field(
			'position_language',
			'<label for="position_language">' . __( 'Accessibility Language position in page', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'position_language',
				'type' => 'select',
				'description' => __( 'Pelase, select position', 'aus-basic' ),
				'options'=>[
					'left'=>'Left position',
					'right'=>'Right position',
				]
			)
		);


		add_settings_field(
			'language_uz',
			'<label for="language_uz">' . __( 'O\'zbek', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'language_uz',
				'type' => 'checkbox',
				'description' => __( '<b class="text-danger-accessiblity">Shortcode:</b><code> [tc-ac-modes item="uz"] </code>  ', 'aus-basic' ),
			)
		);

//
//		add_settings_field(
//			'language_uzkr',
//			'<label for="language_uzkr">' . __( 'Ўзбек', 'aus-basic' ) . '</label>',
//			array( $this, 'input'),
//			$this->plugin_slug . '_plugin_options',
//			$this->plugin_slug . '_plugin_settings_section',
//			array(
//				'id' => 'language_uzkr',
//				'type' => 'checkbox',
//				'description' => __( '<b class="text-danger-accessiblity">Shortcode:</b><code>[tc-ac-modes item="uzkr"] </code>  ', 'aus-basic' ),
//			)
//		);
		add_settings_field(
			'language_ru',
			'<label for="language_ru">' . __( 'Русский', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'language_ru',
				'type' => 'checkbox',
				'description' => __( '<b class="text-danger-accessiblity">Shortcode:</b><code>[tc-ac-modes item="ru"] </code>  ', 'aus-basic' ),
			)
		);
		add_settings_field(
			'language_en',
			'<label for="language_en">' . __( 'English', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'language_en',
				'type' => 'checkbox',
				'description' => __( '<b class="text-danger-accessiblity">Shortcode:</b><code>[tc-ac-modes item="en"] </code>  ', 'aus-basic' ),
			)
		);

		add_settings_field(
			'language_show',
			'<label for="language_show">' . __( 'Display Language', 'aus-basic' ) . '</label>',
			array( $this, 'input'),
			$this->plugin_slug . '_plugin_options',
			$this->plugin_slug . '_plugin_settings_section',
			array(
				'id' => 'language_show',
				'type' => 'radio',
				'description' => __( 'Display Language', 'aus-basic' ),
				'options'=>[
					'text'=>'Only text',
					'image'=>'Only image',
					'image_text'=>'Image and text',
				]
			)
		);


		register_setting(
			$this->plugin_slug . '_plugin_options_group',
			$this->plugin_slug . '_plugin_options',
			array( $this, 'senitize')
		);

	}

	public function senitize( $input ) {
		$output = array();

		foreach ($input as $key => $value) {
			if ( isset( $input[ $key ] ) ) {
				if ( is_array( $input[ $key ] ) ) {
					foreach ( $input[ $key ] as $sub_key => $sub_value ) {
						$output[ $key ][ $sub_key ] = strip_tags( stripslashes( $sub_value ) );
					}
				} else {
					$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
				}
			}
		}

		return apply_filters( array( $this, 'senitize' ), $output, $input);

	}

	public function _esc_attr( $option ) {
		if( isset( $this->options[ $option ] ) )
			return $this->options[ $option ];
		else
			return false;
	}

	/**
	 * Initialize plugin options callbacks
	 */
	public function plugin_general_options_ballback() {

		$html = '<h4>' . __( 'General Options', 'aus-basic' ) . '</h4>';
		//echo $html;

	}


	public function input( $args, $name_type = 'option', $post_id = false ) {

		$defaults = array(
			'id' => '',
			'type' => '',
			'title' => '',
			'description' => '',
			'options' => array(),
			'editor' => array(
				'visual' => true,
				'teeny'=>true,
				'textarea_rows'=>4,
			),
			'atts' => array(),
		);

		$configs = array_replace_recursive( $defaults, $args );
		extract( $configs, EXTR_OVERWRITE );

		if ( ( $type == 'select' || $type == 'cats' || $type == 'categories' ) && ! empty( $atts ) && array_key_exists( 'multiple', $atts ) ) {
			$multiple = true;
		} else {
			$multiple = false;
		}

		if ( $name_type == 'option' ) {
			$field_name = $this->plugin_slug . '_plugin_options' . '[' . $id . ']';
			$value = $this->_esc_attr( $id, $type );
		} elseif ( $name_type == 'metabox' && $post_id ) {
			$field_name = $id;
			$value = get_post_meta( $post_id, $id, true );
		}
		

		$editor['textarea_name'] = $field_name;

		$attributes = '';
		if( isset( $atts ) and ! empty( $atts ) ) {
			foreach ($atts as $attribute => $attr_value) {
				$attributes .= $attribute . '="' . $attr_value . '"';
			}
		}

		switch ( $type ) {

			case 'radio':
				$input = '<fieldset>';
				foreach ($options as $key => $option) {
					$input .= '<label title="' . $option . '">';
					$input .= '<input type="radio" name="' . $field_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<span>' . $option . '</span>';
					$input .= '</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
				}
				$input .= '</fieldset>';
				break;
			case 'radioimage':
				$input = '<fieldset>';
				$input .= '<ul class="radioimage">';
				foreach ( $options as $key => $option ) {
					$input .= "<li>";
					$input .= '<label title="' . $option . '">';
					$input .= '<input style="display:none" type="radio" name="' . $field_name . '" value="' . $key . '" ' . ( $value == $key ? 'checked="checked"' : '' ) . ' />';
					$input .= '<img' . ( $value == $key ? ' class="checked"' : '' ) . '  src="' . get_aus_uri() . '/media/img/' . $option . '" />';
					//$input .= '<span>' . $option . '</span>';
					$input .= '</label>';
					$input .= "</li>";
				}
				$input .= '</ul>';
				$input .= '</fieldset>';
				break;
			case 'textarea':
				if ( $editor['visual'] === true ) {
					ob_start();
					wp_editor($value, $id, $editor);
					$input = ob_get_contents();
					ob_end_clean();
				} else {
					$input = '<textarea name="' . $field_name . '" id="' .$id . '"' . $attributes . '>' . $value . '</textarea>';
				}
				break;
			case 'select':
				$input  = '<select name="' . $field_name . ( $multiple ? '[]' : '' ) . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $options as $key => $option ) {
					if ( $multiple ) {
						$selected = ( in_array( $key, $value ) ? 'selected="selected"' : '' );
					} else {
						$selected = ( $value == $key ? 'selected="selected"' : '' );
					}
					$input .= '<option ' . $selected . ' value="'. $key .'">' . $option . '</option>';
				}
				$input .= '</select>';
				break;

			case 'pages':
				$input = '<select name="' . $field_name . ( $multiple ? '[]' : '' ) . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( get_pages() as $page ) {
					if ( $multiple ) {
						$selected = ( in_array( get_page_link( $page->ID ), $value ) ? 'selected="selected"' : '' );
					} else {
						$selected = ( $value == get_page_link( $page->ID ) ? 'selected="selected"' : '' );
					}
					$input .= '<option ' . $selected . ' value="'. get_page_link( $page->ID ) .'">' . $page->post_title . '</option>';
				}
				$input .= '</select>';
				break;

			case 'categories':
			case 'cats':
				$input = '<select name="' . $field_name . ( $multiple ? '[]' : '' ) . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( get_categories( array( 'hide_empty' => false ) ) as $cat ) {
					if ( $multiple ) {
						$selected = ( in_array( $cat->cat_ID, $value ) ? 'selected="selected"' : '' );
					} else {
						$selected = ( $value == $cat->cat_ID ? 'selected="selected"' : '' );
					}
					$input .= '<option ' . $selected . ' value="'. $cat->cat_ID .'">' . $cat->cat_name . '</option>';
				}
				$input .= '</select>';
				break;

			case 'thumbnails':
				$input = '<select name="' . $field_name . '" id="' .$id . '" ' . $attributes . '>';
				$input .= '<option value="0">&ndash; ' . __( 'Select', 'aus-basic' ) . ' &ndash;</option>';
				foreach ( $this->get_image_sizes() as $thumbnail => $size ) {
					$input .= '<option ' . ( $value == $thumbnail ? 'selected="selected"' : '' ) . ' value="'. $thumbnail . '">' . $thumbnail . ' - ' . $size['width'] . 'x' . $size['height'] . 'px</option>';
				}
				$input .= '</select>';
				break;

			case 'image':
				$input = '<input id="' .$id . '" type="text" size="36" name="' . $field_name . '" placeholder="http://..." value="' . $value . '" />';
				$input .= '<input class="button image-upload" data-field="#' . $id . '" type="button" value="' . __( 'Upload CSS file', 'aus-basic' ) . '" />';
				break;

			case 'checkbox':
				$input = '<fieldset class="checkbox-label">';
				$input .= '<label title="' . $id . '">';
				$input .= '<input name="' . $field_name . '" id="' .$id . '" type="' .$type . '" value="1"' . $attributes  . ( $value ? 'checked="checked"' : '' ) . ' />';
				$input .= $title;
				$input .= '</label>';
				$input .= '<span class="checkbox' . ( $value ? ' checked' : '' ) . '"></span>';
				$input .= '</fieldset>';
				break;

			default:
			case 'email':
			case 'text':
				$input = '<input name="' . $field_name . '" id="' .$id . '" type="' .$type . '" value="' . $value . '"' . $attributes . ' />';
				break;

		}

		$html  = '';
		$html .= $input;
		if( ! empty( $description ) )
			$html .= '<p class="description">' . $description . '</p>';
		echo $html;
	}

	public function get_image_sizes( $size = '' ) {

		global $_wp_additional_image_sizes;

		$sizes = array();
		$get_intermediate_image_sizes = get_intermediate_image_sizes();

		// Create the full array with sizes and crop info
		foreach( $get_intermediate_image_sizes as $_size ) {

			if ( in_array( $_size, array( 'thumbnail', 'medium', 'large' ) ) ) {

				$sizes[ $_size ]['width'] = get_option( $_size . '_size_w' );
				$sizes[ $_size ]['height'] = get_option( $_size . '_size_h' );
				$sizes[ $_size ]['crop'] = (bool) get_option( $_size . '_crop' );

			} elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
				$sizes[ $_size ] = array( 
					'width' => $_wp_additional_image_sizes[ $_size ]['width'],
					'height' => $_wp_additional_image_sizes[ $_size ]['height'],
					'crop' =>  $_wp_additional_image_sizes[ $_size ]['crop']
				);
			}

		}

		// Get only 1 size if found
		if ( $size ) {

			if( isset( $sizes[ $size ] ) ) {
				return $sizes[ $size ];
			} else {
				return false;
			}

		}

		return $sizes;
	}

	public function display_aus_accessibility ()
	{
		if($this->options){ ?>
			<div style="clear: both"></div>
			<?php if($this->options['language_page_id']): ?>
			<div class="main-accessibility pull-<?=$this->options['position_language']?>" >
				<?php $style =  $this->options['bootstrap_style_page_id']?>
				<ul>
					<?php if( $this->options['language_uz']): ?>
						<li class="accessibility-language lang-uz">
							<a href="<?= get_bloginfo('wpurl')?>/uz/" hreflang="uz" title="O'zbekcha (uz)" class="qtranxs_image <?= get_bloginfo('language')=='uz'?'active':'' ?> qtranxs_image_uz btn-<?= $style ?>">
								<img style="display: <?php
									 if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
									 }else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/uz.gif" alt="O'zbekcha (uz)">
								<span   style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >O'zbekcha</span>
							</a>
						</li>
					<?php endif;?>
					<?php if( $this->options['language_ru']): ?>
						<li class="accessibility-language lang-ru">
							<a href="<?= get_bloginfo('wpurl')?>/ru/" hreflang="ru" title="Русский (ru)" class="<?= get_bloginfo('language')=='ru-RU'?'active':'' ?> qtranxs_image qtranxs_image_ru btn-<?= $style ?>">
								<img style="display: <?php
								if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/ru.gif" alt="Русский (ru)">
								<span style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >Русский</span>
							</a>
						</li>
					<?php endif;?>
					<?php if( $this->options['language_en']): ?>
						<li class="accessibility-language lang-en">
							<a href="<?= get_bloginfo('wpurl')?>/en/" hreflang="ru" title="English (en)" class="qtranxs_image qtranxs_image_en <?= get_bloginfo('language')=='en-US'?'active':'' ?> btn-<?= $style ?>">
								<img style="display: <?php
								if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/en.gif" alt="English (en)">
								<span   style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >English </span>
							</a>
						</li>
					<?php endif;?>
				</ul>
			</div>
			<?php endif; ?>

			<div class="main-accessibility pull-<?=$this->options['accessibility_plugin_position']?>" >
				<?php $style =  $this->options['bootstrap_style_page_id']?>
				<ul>

					<?php if($this->options['rss_page_id']): ?>
						<li class="accessibility-rss">
							<a class="btn btn-<?= $style ?>" href="<?= get_bloginfo('rss_url')?>">
								<i class="fa fa-rss"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['voice_page_id']): ?>
						<li class="accessibility-bullhorn">
							<a class="btn btn-<?= $style ?>"  href="#" data-toggle="modal" data-target="#bullhornModal">
								<i class="glyphicon glyphicon-bullhorn"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['mobile_page_id']): ?>
						<li class="accessibility-mobile">
							<a href="#" class="btn btn-<?= $style ?>"
									onclick="window.open(window.location,'mobile','location=1, scrollbars=1, toolbar=1, resizable=1, width=450, height=1000')">
								<i class="glyphicon glyphicon-phone"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['sitemap_page_id']): ?>
						<li class="accessibility-sitemap">
							<a class="btn btn-<?= $style ?>" href="<?php echo $this->options['sitemap_page_id'] ?>">
								<i class="fa fa-sitemap"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['contact_page_id']): ?>
						<li class="accessibility-contact">
							<a class="btn btn-<?= $style ?>" href="<?= $this->options['contact_page_id']?>">
								<i class="glyphicon glyphicon-envelope"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['blind_mode']): ?>
						<li class="accessibility-blend">
							<div class="dropdown" >
								<a href="#" class="btn btn-<?= $style ?> dropdown-toggle dropdown-accessibility"  id="menu1"  type="button" data-toggle="dropdown" ><i class="glyphicon glyphicon-eye-open"></i>
									<span class="accessibility-hidden-text">Ko'zi ojizlar uchun</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-accessibility"  role="menu" aria-labelledby="menu1">
									<h4 class="accessibility-header">Вид</h4>
									<li><div id="normal-mode" >A1</div></li>
									<li><div id="white-black-mode"  >A2</div></li>
									<li><div id="dark-mode"  >A3</div></li>
									<br><br><br>
									<h4 class="accessibility-header">Размер шрифта</h4>
									<h5 id="accessibility-zoom-value-header">Увеличить на <span id="accessibility-zoom-value">0%</span></h5>
									<input type="range" id="accessibility-zoom"  value="0"  data-value="0" min="0" max="100" step="20">

									<br>
								</ul>
							</div>
						</li>
					<?php endif;?>

					<?php if($this->options['search_page_id_check'] and $this->options['search_page_id'] and $this->options['search_page_id']==2): ?>
						<li class="accessibility-search">
							<a  data-toggle="modal" data-target="#searchModal" data-id="<?= $style ?>" class="search-toggler btn btn-<?= $style ?>  search-button-blur">
								<i class="glyphicon glyphicon-search"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['search_page_id_check'] and $this->options['search_page_id'] and $this->options['search_page_id']==1): ?>
						<li class="accessibility-search">
							<form method="get" role="form" id="searchform" action="<?php bloginfo('home'); ?>/">
								<div id="hidden-search" style="display: inline-block">
									<input  class="form-control search-form"  type="text"  autocomplete="off" placeholder="Search..."  value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="15" >
								</div>
								<a  class=" btn btn-<?= $style ?> search-button-simple">
									<i class="glyphicon glyphicon-search"></i>
								</a>
							</form>
						</li>
					<?php endif;?>
				</ul>

				<?php if($this->options['voice_page_id']):?>
				<!-- Modal -->
				<div id="bullhornModal" class="modal fade" role="dialog">
					<button id="btn-voice" style="display: none;" class="btn btn-<?= $style ?>"  data-toggle="tooltip" data-placement="top" title="Belgilangan tugmani tinglash uchun quyidagi tugmani bosing.">
						<i class="glyphicon glyphicon-bullhorn"></i>
					</button>
					<section id="voice-section" style="display: none"></section>
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title" >Ovozli tizim</h4>
							</div>
							<div class="modal-body">
								<p>Sahifadagi biron bir so'z, jumla yoki matnni belgilab, ushbu belgilangan sohani ovoz yordamida eshitishingiz mumkin.</p>
							</div>
							<div class="modal-footer" style="padding: 10px;">
								<button type="button" class="btn btn-<?= $style ?>" data-dismiss="modal">Yopish</button>
							</div>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
			<div style="clear: both"></div>
		<?php };
	}

	public function display_aus_accessibility_item ($item)
	{
		if($this->options){ ?>
			<div class="main-accessibility main-accessibility-item " >
				<?php $style =  $this->options['bootstrap_style_page_id']?>
				<ul>

					<?php if( $this->options['language_uz'] and $item=='uz'): ?>
						<li class="accessibility-language lang-uz">
							<a href="<?= get_bloginfo('wpurl')?>/uz/" hreflang="uz" title="O'zbekcha (uz)" class="<?= get_bloginfo('language')=='uz'?'active':'' ?> qtranxs_image qtranxs_image_uz btn-<?= $style ?>">
								<img style="display: <?php
								if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/uz.gif" alt="O'zbekcha (uz)">
								<span  style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >O'zbekcha</span>
							</a>
						</li>
					<?php endif;?>
					<?php if( $this->options['language_ru'] and $item=='ru'): ?>
						<li class="accessibility-language lang-ru">
							<a href="<?= get_bloginfo('wpurl')?>/ru/" hreflang="ru" title="Русский (ru)" class="<?= get_bloginfo('language')=='ru-RU'?'active':'' ?> qtranxs_image qtranxs_image_ru btn-<?= $style ?>">
								<img style="display: <?php
								if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/ru.gif" alt="Русский (ru)">
								<span style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >Русский</span>
							</a>
						</li>
					<?php endif;?>
					<?php if( $this->options['language_en'] and $item=='en'): ?>
						<li class="accessibility-language lang-en">
							<a href="<?= get_bloginfo('wpurl')?>/en/" hreflang="ru" title="English (en)" class="<?= get_bloginfo('language')=='en-US'?'active':'' ?> qtranxs_image qtranxs_image_en  btn-<?= $style ?>">
								<img style="display: <?php
								if ($this->options['language_show']=='image' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" src="<?= AUSAY_URL?>/img/en.gif" alt="English (en)">
								<span style="display: <?php
								if ($this->options['language_show']=='text' or $this->options['language_show']=='image_text' ){echo 'inline-block';
								}else{ echo 'none';}?>" >English </span>
							</a>
						</li>
					<?php endif;?>

					<?php if($this->options['rss_page_id'] and $item=='rss'): ?>
						<li class="accessibility-rss">
							<a class="btn btn-<?= $style ?>" href="<?= get_bloginfo('rss_url')?>">
								<i class="fa fa-rss"></i>
							</a>
						</li>
					<?php endif;?>

					<?php if($this->options['voice_page_id'] and $item=='voice'): ?>
						<li class="accessibility-bullhorn">
							<a class="btn btn-<?= $style ?>"  href="#" data-toggle="modal" data-target="#bullhornModal">
								<i class="glyphicon glyphicon-bullhorn"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['mobile_page_id'] and $item=='mobile'): ?>
						<li class="accessibility-mobile">
							<a href="#" class="btn btn-<?= $style ?>"
									onclick="window.open(window.location,'mobile','location=1, scrollbars=1, toolbar=1, resizable=1, width=450, height=1000')">
								<i class="glyphicon glyphicon-phone"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['sitemap_page_id'] and $item=='site-map'): ?>
						<li class="accessibility-sitemap">
							<a class="btn btn-<?= $style ?>" href="<?php echo $this->options['sitemap_page_id'] ?>">
								<i class="fa fa-sitemap"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['contact_page_id'] and $item=='contact'): ?>
						<li class="accessibility-contact">
							<a class="btn btn-<?= $style ?>" href="<?= $this->options['contact_page_id']?>">
								<i class="glyphicon glyphicon-envelope"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['blind_mode'] and $item=='blind'): ?>
						<li class="accessibility-blend">
							<div class="dropdown" >
								<a class="btn btn-<?= $style ?> dropdown-toggle dropdown-accessibility"  id="menu1"  type="button" data-toggle="dropdown" ><i class="glyphicon glyphicon-eye-open"></i>
									<span class="accessibility-hidden-text">Ko'zi ojizlar uchun</span>
								</a>
								<ul class="dropdown-menu dropdown-menu-accessibility"  role="menu" aria-labelledby="menu1">
									<h4 class="accessibility-header">Вид</h4>
									<li><div id="normal-mode" >A1</div></li>
									<li><div id="white-black-mode"  >A2</div></li>
									<li><div id="dark-mode"  >A3</div></li>
									<br><br><br>
									<h4 class="accessibility-header">Размер шрифта</h4>
									<h5 id="accessibility-zoom-value-header">Увеличить на <span id="accessibility-zoom-value">0%</span></h5>
									<input type="range" id="accessibility-zoom"  value="0"  data-value="0" min="0" max="100" step="20">

									<br>
								</ul>
							</div>
						</li>
					<?php endif;?>

					<?php if($this->options['search_page_id_check'] and $this->options['search_page_id'] and $this->options['search_page_id']==2 and $item=='search-modal'): ?>
						<li class="accessibility-search">
							<a  data-toggle="modal" data-target="#searchModal" data-id="<?= $style ?>" class="search-toggler btn btn-<?= $style ?>  search-button-blur">
								<i class="glyphicon glyphicon-search"></i>
							</a>
						</li>
					<?php endif;?>
					<?php if($this->options['search_page_id_check'] and $this->options['search_page_id'] and $this->options['search_page_id']==1 and $item=='search-animate'): ?>
						<li class="accessibility-search">
							<form method="get" role="form" id="searchform" action="<?php bloginfo('home'); ?>/">
								<div id="hidden-search" style="display: inline-block">
									<input  class="form-control search-form"  type="text"   autocomplete="off" placeholder="Search..."  value="<?php echo wp_specialchars($s, 1); ?>" name="s" id="s" size="15" >
								</div>
								<a  class=" btn btn-<?= $style ?> search-button-simple">
									<i class="glyphicon glyphicon-search"></i>
								</a>
							</form>
						</li>
					<?php endif;?>
				</ul>

				<!-- Modal -->
			<?php if($this->options['voice_page_id'] and $item=='voice'):?>
				<button id="btn-voice" style="display: none;" class="btn btn-<?= $style ?>"  data-toggle="tooltip" data-placement="top" title="Belgilangan tugmani tinglash uchun quyidagi tugmani bosing.">
					<i class="glyphicon glyphicon-bullhorn"></i>
				</button>
				<section id="voice-section" style="display: none"></section>
				<div id="bullhornModal" class="modal fade" role="dialog">
					<div class="modal-dialog">
						<!-- Modal content-->
						<div class="modal-content">
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal">&times;</button>
								<h4 class="modal-title" >Ovozli tizim</h4>
							</div>
							<div class="modal-body">
								<p>Sahifadagi biron bir so'z, jumla yoki matnni belgilab, ushbu belgilangan sohani ovoz yordamida eshitishingiz mumkin.</p>
							</div>
							<div class="modal-footer" style="padding: 10px;">
								<button type="button" class="btn btn-<?= $style ?>" data-dismiss="modal">Yopish</button>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
			</div>
		<?php };
	}

}