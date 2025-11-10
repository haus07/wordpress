<?php

define('T_SHIRT_PRINTING_SHOP_NOTICE_BUY_NOW',__('https://www.wpradiant.net/products/t-shirt-printing-wordpress-theme','t-shirt-printing-shop'));

define('T_SHIRT_PRINTING_SHOP_BUY_BUNDLE',__('https://www.wpradiant.net/products/wordpress-theme-bundle','t-shirt-printing-shop'));

// Upsell
if ( class_exists( 'WP_Customize_Section' ) ) {
	class T_Shirt_Printing_Shop_Upsell_Section extends WP_Customize_Section {
		public $type = 't-shirt-printing-shop-upsell';
		public $button_text = '';
		public $url = '';
		public $background_color = '';
		public $text_color = '';
		protected function render() {
			$background_color = ! empty( $this->background_color ) ? esc_attr( $this->background_color ) : '#3e5aef';
			$text_color       = ! empty( $this->text_color ) ? esc_attr( $this->text_color ) : '#fff';
			?>
			<li id="accordion-section-<?php echo esc_attr( $this->id ); ?>" class="t_shirt_printing_shop_upsell_section accordion-section control-section control-section-<?php echo esc_attr( $this->id ); ?> cannot-expand">
				<h3 class="accordion-section-title" style="color:#fff; background:<?php echo esc_attr( $background_color ); ?>;border-left-color:<?php echo esc_attr( $background_color ); ?>;">
					<?php echo esc_html( $this->title ); ?>
					<a href="<?php echo esc_url( $this->url ); ?>" class="button button-secondary alignright" target="_blank" style="margin-top: -4px;"><?php echo esc_html( $this->button_text ); ?></a>
				</h3>
			</li>
			<?php
		}
	}
}
function t_shirt_printing_shop_admin_notice_style() {
	wp_enqueue_style('t-shirt-printing-shop-custom-admin-notice-style', esc_url(get_template_directory_uri()) . '/get-started/getstart.css');
}
add_action('admin_enqueue_scripts', 't_shirt_printing_shop_admin_notice_style');

/**
 * Display the admin notice if not dismissed.
 */
function t_shirt_printing_shop_admin_notice() {
    // Check if the notice is dismissed
    $t_shirt_printing_shop_dismissed = get_user_meta(get_current_user_id(), 't_shirt_printing_shop_dismissed_notice', true);
    $t_shirt_printing_shop_current_page = '';
    if(isset($_GET['page'])) {
    	$t_shirt_printing_shop_current_page = admin_url( "admin.php?page=".sanitize_text_field($_GET["page"]));
    }

    // Display the notice only if not dismissed
    if (!$t_shirt_printing_shop_dismissed && $t_shirt_printing_shop_current_page != admin_url( "admin.php?page=wordclever-templates")) {
        ?>
        <div class="updated notice notice-success is-dismissible notice-get-started-class" data-notice="get-start" style="display: flex;padding: 10px;">
        		<div class="notice-content">
	        		<div class="notice-holder">
	                        <h5><span class="theme-name"><span><?php echo __('Welcome to T Shirt Printing Shop', 't-shirt-printing-shop'); ?></span></h5>
	                        <h1><?php echo __('Enhance Your Website Development with Radiant Blocks!!', 't-shirt-printing-shop'); ?></h1>
	                        </h3>
	                        <div class="notice-text">
	                            <p class="blocks-text"><?php echo __('Effortlessly craft websites for any niche with Radiant Blocks! Experience seamless functionality and stunning responsiveness as you enhance your digital presence with Block WordPress Themes. Start building your ideal website today!', 't-shirt-printing-shop') ?></p>
	                        </div>
	                        <a href="javascript:void(0);" id="install-activate-button" class="button admin-button info-button">
							   <?php echo __('Getting started', 't-shirt-printing-shop'); ?>
							</a>

							<script type="text/javascript">
							document.getElementById('install-activate-button').addEventListener('click', function () {
							    const t_shirt_printing_shop_button = this;
							    const t_shirt_printing_shop_redirectUrl = '<?php echo esc_url(admin_url("themes.php?page=t-shirt-printing-shop")); ?>';
							    // First, check if plugin is already active
							    jQuery.post(ajaxurl, { action: 'check_wordclever_activation' }, function (response) {
							        if (response.success && response.data.active) {
							            // Plugin already active — just redirect
							            window.location.href = t_shirt_printing_shop_redirectUrl;
							        } else {
							            // Show Installing & Activating only if not already active
							            t_shirt_printing_shop_button.textContent = 'Installing & Activating...';

							            jQuery.post(ajaxurl, {
							                action: 'install_and_activate_wordclever_plugin',
							                nonce: '<?php echo wp_create_nonce("install_activate_nonce"); ?>'
							            }, function (response) {
							                if (response.success) {
							                    window.location.href = t_shirt_printing_shop_redirectUrl;
							                } else {
							                    alert('Failed to activate the plugin.');
							                    t_shirt_printing_shop_button.textContent = 'Try Again';
							                }
							            });
							        }
							    });
							});
							</script>

	                       <a href="<?php echo esc_url( T_SHIRT_PRINTING_SHOP_NOTICE_BUY_NOW ); ?>" target="_blank" id="go-pro-button" class="button admin-button buy-now-button"><?php echo __('Buy Now ', 't-shirt-printing-shop'); ?></a>

	                        <a href="<?php echo esc_url( T_SHIRT_PRINTING_SHOP_BUY_BUNDLE ); ?>" target="_blank" id="bundle-button" class="button admin-button bundle-button"><?php echo __('Get Bundle', 't-shirt-printing-shop'); ?></a>

	                        <a href="<?php echo esc_url( T_SHIRT_PRINTING_SHOP_DOC_URL ); ?>" target="_blank" id="doc-button" class="button admin-button bundle-button"><?php echo __('Free Documentation', 't-shirt-printing-shop'); ?></a>
	            	</div>
	            </div>
                <div class="theme-hero-screens">
                    <img src="<?php echo esc_url(get_template_directory_uri() . '/get-started/notice.png'); ?>" />
                </div>
        </div>
        <?php
    }
}

// Hook to display the notice
add_action('admin_notices', 't_shirt_printing_shop_admin_notice');

/**
 * AJAX handler to dismiss the notice.
 */
function t_shirt_printing_shop_dismissed_notice() {
    // Set user meta to indicate the notice is dismissed
    update_user_meta(get_current_user_id(), 't_shirt_printing_shop_dismissed_notice', true);
    die();
}

// Hook for the AJAX action
add_action('wp_ajax_t_shirt_printing_shop_dismissed_notice', 't_shirt_printing_shop_dismissed_notice');

/**
 * Clear dismissed notice state when switching themes.
 */
function t_shirt_printing_shop_switch_theme() {
    // Clear the dismissed notice state when switching themes
    delete_user_meta(get_current_user_id(), 't_shirt_printing_shop_dismissed_notice');
}

// Hook for switching themes
add_action('after_switch_theme', 't_shirt_printing_shop_switch_theme');  