<?php 

class TClick_money extends WP_Widget {

	private $defaults;

	function __construct() {
		$widget_ops = array(
			'classname' => 'tclick-money', 
			'description' => __( 'Links to the sites of organizations', 'tclick-pack' ) );
		
		parent::__construct(
			'tclick-money', 
			__( 'TClick Links', 'tclick-pack' ), 
			$widget_ops
		);
		$this->defaults = array(
			'title' => '',
			'number' => 5,
			'category' => '',
			'show_date' => '',
		);
	}

	function form( $instance ) {
		$instance = wp_parse_args( (array) $instance, $this->defaults );
		$categories = get_categories();
		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php echo __( 'Title', 'tclick-pack' ); ?>: 
				<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $instance['title'] ); ?>" />
			</label>
		</p>
		<p>
		<label for="<?php echo $this->get_field_id( 'category' ); ?>">
				<?php echo __( 'Category', 'tclick-pack' ); ?>: 
				<select class="widefat" id="<?php echo $this->get_field_id( 'category' ); ?>" name="<?php echo $this->get_field_name( 'category' ); ?>">
					<option><?php _e( 'Any Category', 'tclick-pack' ); ?></option>
					<?php foreach ( $categories as $cat ) : ?>
						<option <?php selected( $instance['category'], $cat->term_id ); ?> value="<?php echo $cat->term_id; ?>"><?php echo $cat->name; ?></option>
					<?php endforeach; ?>
				</select>
			</label>
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'number' ); ?>">
				<?php echo __( 'Number of posts to show', 'tclick-pack' ); ?>
			</label>
			<input id="<?php echo $this->get_field_id( 'number' ); ?>" name="<?php echo $this->get_field_name( 'number' ); ?>" type="text" value="<?php echo esc_attr( $instance['number'] ); ?>" size="3">
		</p>
		<p>
			<input class="checkbox" type="checkbox" <?php checked( esc_attr( $instance['show_date'] ), 'on' ); ?> id="<?php echo $this->get_field_id( 'show_date' ); ?>" name="<?php echo $this->get_field_name( 'show_date' ); ?>">
			<label for="<?php echo $this->get_field_id( 'show_date' ); ?>"><?php _e( 'Display post date?', 'tclick-pack' ); ?></label>
		</p>
		<?php 
	}

	function update( $new_instance, $old_instance ) {
		$old_instance = wp_parse_args( (array) $old_instance, $this->defaults );
		foreach ($old_instance as $key => $val) {
			$old_instance[ $key ] = esc_attr( $new_instance[ $key ] );
		}
		$instance = $old_instance;
		return $instance;
	}

	function widget( $args, $instance ) {

		extract( $args, EXTR_SKIP );
		$title = empty( $instance['title'] ) ? '' : apply_filters( 'widget_title', $instance['title'] );
		$html  = $before_widget;
		if ( $title ) {
			$html .= $before_title . $title . $after_title;
		}
		// CODE...
		$html .= $after_widget;
		echo $html;
		wp_reset_query();
	}

}