<?php

namespace SubscribeMailChimpList\Widgets;

use SubscribeMailChimpList;
use SubscribeMailChimpList\Utils\WidgetHelper;
use WP_Widget;

class SubscribeMailChimpWidget extends WP_Widget {
	use WidgetHelper;

	public $css = true;

	private $textdomain = __NAMESPACE__;
	private $suffix = " - SubscribeMailChimpWidget";

	function __construct() {
		$this->textdomain = SubscribeMailChimpList::$textdomine;
		$className        = get_called_class();
		$className        = str_replace( "\\", '-', $className );
		parent::__construct(
			$className,
			__( "Subscribe widget ", 'SubscribeMailChimpList' ) . $this->suffix,
			[
				'description' => __( "Mailchimp subscribe form", 'SubscribeMailChimpList' ) . $this->suffix
			]
		);
	}

	public function widget( $args, $instance ) {

		echo $args['before_widget'];
		echo "<div class='SubscribeMailChimpList__form-wrapper-widget'>";
		echo apply_filters( 'SubscribeMailChimpList__shortcode-content', [ 'title' => $instance['title'] ] );
		echo "</div>";

		echo $args['after_widget'];
	}

	public function form( $instance ) {
		if ( ! isset( $instance['title'] ) ) {
			$instance['title'] = __( 'Subscribe to our newsletter', 'SubscribeMailChimpList' );
		}
		?>
        <p>
            <label for="<?php echo $this->get_field_id( 'title' ); ?>">
				<?php _e( 'Title', 'SubscribeMailChimpList' ); ?>
            </label>

            <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>"
                   name="<?php echo $this->get_field_name( 'title' ); ?>"
                   type="text" value="<?php echo esc_attr( $instance['title'] ); ?>"/>

        </p>
		<?php
	}

	public function update( $new_instance, $old_instance ) {
		$instance['title'] = esc_textarea( $new_instance['title'] );

		return $instance;
	}


}