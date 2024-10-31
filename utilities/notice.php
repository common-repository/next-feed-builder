<?php
namespace NextFeed\Utilities;

if ( ! defined( 'ABSPATH' ) ) die( 'Forbidden' );
/**
 * plugin notice class.
 * Handles dynamically notices for lazy developers.
 *
 * @author ThemeDev
 * @since 1.0.0
 */


class Notice {

	private static $instance;
	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 */
	public function _init() {
		add_action(	'admin_footer', [ $this, 'enqueue_scripts' ], 999);
		add_action( 'wp_ajax_themedevfeed-ajax', [ $this, '__dismiss' ] );
	}


	/**
	 * Dismiss Notice.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function __dismiss() {
		
		$id   = ( isset( $_POST['id'] ) ) ? sanitize_key($_POST['id']) : '';
		$time = ( isset( $_POST['time'] ) ) ? sanitize_text_field($_POST['time']) : '';
		$meta = ( isset( $_POST['meta'] ) ) ? sanitize_text_field($_POST['meta']) : '';
		
		$key_ = $id.'_'.get_current_user_id();

		if ( ! empty( $id ) ) {
			if ( 'user' === $meta ) {
				update_user_meta( get_current_user_id(), $id, true );
			} else {
				set_transient( $key_, true, $time );
			}
			wp_send_json_success();
		}
		wp_send_json_error();
	}

	/**
	 * Enqueue Scripts.
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public function enqueue_scripts() {
		echo "
			<script>
			jQuery(document).ready(function ($) {
				$( '.nextfeed-notice.is-dismissible' ).on( 'click', '.notice-dismiss', function() {
					
					_this 		= $( this ).parents( '.themedev-nextfeed-n' );
					var id 	= 	_this.attr( 'id' ) || '';
					var time 	= _this.attr( 'dismissible-time' ) || '';
					var meta 	= _this.attr( 'dismissible-meta' ) || '';
					
					$.ajax({
						url: ajaxurl,
						type: 'POST',
						data: {
							action 	: 'themedevfeed-ajax',
							id 		: id,
							meta 	: meta,
							time 	: time
						},
						success: function (response) {
							
						}
					});
			
				});
			
			});
			</script>
		";
	}

	/**
	 * Show Notices
	 *
	 * @since 1.0.0
	 * @return void
	 */
	public static function push($notice) {

		$defaults = [
			'id'               => 'nextfeed-idnotices',
			'type'             => 'info',
			'show_if'          => true,
			'message'          => '',
			'class'            => 'themedev-nextfeed-n',
			'dismissible'      => false,
			'dismissible-meta' => 'transient',
			'dismissible-time' => WEEK_IN_SECONDS,
			'data'             => '',
		];

		$notice['id'] = 'nextfeed-idnotices';

		$notice = wp_parse_args( $notice, $defaults );

		$classes = [ 'nextfeed-notice', 'notice' ];

		$classes[] = $notice['class'];
		if ( isset( $notice['type'] ) ) {
			$classes[] = 'notice-' . $notice['type'];
		}

		if ( true === $notice['dismissible'] ) {
			$classes[] = 'is-dismissible';

			$notice['data'] = ' dismissible-time=' . esc_attr( $notice['dismissible-time'] ) . ' ';
		}

		$notice_id = $notice['id'];
		
		$notice['classes'] = implode( ' ', $classes );

		$notice['data'] .= ' dismissible-meta=' . esc_attr( $notice['dismissible-meta'] ) . ' ';
		if ( 'user' === $notice['dismissible-meta'] ) {
			$expired = get_user_meta( get_current_user_id(), $notice_id, true );
		} elseif ( 'transient' === $notice['dismissible-meta'] ) {
			$key_ = $notice_id.'_'.get_current_user_id();
			$expired = get_transient( $key_ );
		}

		if ( isset( $notice['show_if'] ) ) {
			if ( true === $notice['show_if'] ) {
				if ( false === $expired || empty( $expired ) ) {
					self::markup($notice);
				}
			}
		} else {
			self::markup($notice);
		}
	}

	/**
	 * Markup Notice.
	 *
	 * @since 1.0.0
	 * @param  array $notice Notice markup.
	 * @return void
	 */
	public static function markup( $notice = [] ) {
		?>
		<div id="<?php echo esc_attr( $notice['id'] ); ?>" class="<?php echo esc_attr( $notice['classes'] ); ?>" <?php echo $notice['data']; ?> >
			<p>
				<?php echo Help::_kses($notice['message']); ?>
			</p>

			<?php if(!empty($notice['btn'])):?>
			<p>
				<a href="<?php echo esc_url($notice['btn']['url']); ?>" class="button-primary"><?php echo esc_html($notice['btn']['label']); ?></a>
			</p>
			<?php endif; ?>
		</div>
		<?php
	}

	public static function instance(){
		if (!self::$instance){
            self::$instance = new self();
        }
        return self::$instance;
	}
}
