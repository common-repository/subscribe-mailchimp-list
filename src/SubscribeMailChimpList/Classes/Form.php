<?php


namespace SubscribeMailChimpList\Classes;


class Form {

	public function __construct( ) {

		add_filter( 'SubscribeMailChimpList__shortcode-content', [ $this, 'form_html' ], 10, 1 );

		add_action( 'SubscribeMailChimpList__form', function ( $attrs ) {
			echo $this->form_html( $attrs );
		}, 10, 1 );

	}

	public function form_html( $attrs ) {
		ob_start();
		?>
        <div class="SubscribeMailChimpList__form-wrapper">
            <div class="SubscribeMailChimpList__form-wrap">

				<?php if ( ! empty( $attrs['title'] ) ): ?>
                    <div class="SubscribeMailChimpList__form-title">
						<?php echo $attrs['title']; ?>
                    </div>
				<?php endif; ?>

                <form action="<?php echo AjaxHandle::$form_action; ?>" method="post" class="SubscribeMailChimpList__form">

                    <div class="SubscribeMailChimpList__form-fields-wrapper">

                        <input name="email" type="email" placeholder="<?php _e( 'Enter your E-mail...', 'SubscribeMailChimpList' ); ?>"
                               class="SubscribeMailChimpList__form-input">

                        <button type="submit" class="SubscribeMailChimpList__form-button">
							<?php _e( 'Subscribe', 'SubscribeMailChimpList' ); ?>
                        </button>

                    </div>

                    <div class="SubscribeMailChimpList__form-alerts-wrap
                    <?php echo( empty( $attrs['alert-class'] ) ? 'no-message' : $attrs['alert-class'] ); ?>"
                    data-alert="alert-area"
                    >

						<?php if ( ! empty( $attrs['alert'] ) ): ?>
							<?php echo $attrs['alert']; ?>
						<?php endif; ?>
                    </div>

                </form>

            </div>
        </div>
		<?php
		$res = ob_get_contents();
		ob_clean();

		return $res;
	}

}