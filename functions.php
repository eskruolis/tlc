<?php
//NO DIRECT ACCESS TO FILE
defined('ABSPATH') || exit;

//DEFINE THE MODULES
$customstrap_includes = array(
    '/clean-head.php',    // Eliminates useless meta tags, emojis, etc            
    '/enqueues.php',     // Enqueue scripts and styles.                         
    '/understrap-tweaks.php', // Overrides theme tags
    '/customizer-assets/google-fonts.php', //loads an array for the fonts list in Customizer
    '/customizer-assets/customizer.php',    //Defines Customizer options
    '/customizer-assets/scss-compiler.php', //To interface the Customizer with the SCSS php compiler	 
);
//INCLUDE THE FILES
foreach ($customstrap_includes as $file) {
    $filepath = locate_template('functions' . $file);
    if (!$filepath) {
        trigger_error(sprintf('Error locating /inc%s for inclusion', $file), E_USER_ERROR);
    }
    require_once $filepath;
}

//OPTIONAL: DISABLE WORDPRESS COMMENTS
if (get_theme_mod("singlepost_disable_comments")) require_once locate_template('/functions/optin/disable-comments.php');

//OPTIONAL: LIGHTBOX WORDPRESS COMMENTS
if (get_theme_mod("enable_lightbox")) require_once locate_template('/functions/optin/lightbox.php');

//OPTIONAL: SHARING BUTTONS
if (get_theme_mod("enable_sharing_buttons")) require_once locate_template('/functions/optin/sharing-buttons.php');

//OPTIONAL: BACK TO TOP
if (get_theme_mod("enable_back_to_top")) require_once locate_template('/functions/optin/back-to-top.php');


// LOAD CHILD THEME TEXTDOMAIN
add_action('after_setup_theme', function () {
    load_child_theme_textdomain('understrap-child', get_stylesheet_directory() . '/languages');
});

// CUSTOM ADDITIONAL CSS 
add_action('wp_enqueue_scripts', 'cs_enqueue_child_theme_styles');
function cs_enqueue_child_theme_styles()
{
    wp_enqueue_style('custom', get_stylesheet_directory_uri() . '/style.css');
    wp_enqueue_style('fonts-custom', get_stylesheet_directory_uri() . '/fonts/fontawesome/css/all.min.css');
}

// CUSTOM ADDITIONAL JS 
add_action('wp_enqueue_scripts', 'cs_custom_script_load');
function cs_custom_script_load()
{
    wp_enqueue_script('custom', get_stylesheet_directory_uri() . '/js/owl-js.js', array('jquery'), null, true);
    wp_enqueue_script('custom-js', get_stylesheet_directory_uri() . '/js/custom.js', array('jquery'), null, true);
}



/*-------------------------------------------------------------------------------
Add Owl Carousel
-------------------------------------------------------------------------------*/

// Enqueue Scripts/Styles for our owl.carousel.2
function twof_add_owlcarousel()
{
    wp_enqueue_script('owlcarousel', get_stylesheet_directory_uri() . '/inc/owl/owl.carousel.js', array('jquery'), false, true);
    wp_enqueue_script('owlcarousel-min', get_stylesheet_directory_uri() . '/inc/owl/owl.carousel.min.js', array('jquery'), false, true);
    wp_enqueue_script('slick-min', get_stylesheet_directory_uri() . '/inc/slickslider/slick.min.js', array('jquery'), false, true);
    wp_enqueue_script('flex-js', get_stylesheet_directory_uri() . '/inc/flexslider/jquery.flexslider.js', array('jquery'), false, true);

    wp_enqueue_style('slick-style', get_stylesheet_directory_uri() . '/inc/slickslider/slick-theme.css');
    // wp_enqueue_style( 'flex-style', get_stylesheet_directory_uri() . '/inc/flexslider/flexslider.css' );
    wp_enqueue_style('slick-theme-style', get_stylesheet_directory_uri() . '/inc/slickslider/slick.css');
    wp_enqueue_style('owlcarousel-style', get_stylesheet_directory_uri() . '/inc/owl/assets/owl.theme.default.css');
    wp_enqueue_style('owlcarousel-styles-min', get_stylesheet_directory_uri() . '/inc/owl/assets/owl.carousel.css');
}
add_action('wp_enqueue_scripts', 'twof_add_owlcarousel');

// add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );

function wpb_wiz_after_theme_setup()
{
    remove_theme_support('wc-product-gallery-slider');
}
// add_action( 'after_setup_theme', 'wpb_wiz_after_theme_setup', 99 );

add_action('wp_footer', 'custom_quantity_fields_script');
function custom_quantity_fields_script()
{
    ?>
    <script type='text/javascript'>
        jQuery(function($) {
            if (!String.prototype.getDecimals) {
                String.prototype.getDecimals = function() {
                    var num = this,
                        match = ('' + num).match(/(?:\.(\d+))?(?:[eE]([+-]?\d+))?$/);
                    if (!match) {
                        return 0;
                    }
                    return Math.max(0, (match[1] ? match[1].length : 0) - (match[2] ? +match[2] : 0));
                }
            }
            // Quantity "plus" and "minus" buttons
            $(document.body).on('click', '.plus, .minus', function() {
                var $qty = $(this).closest('.quantity').find('.qty'),
                    currentVal = parseFloat($qty.val()),
                    max = parseFloat($qty.attr('max')),
                    min = parseFloat($qty.attr('min')),
                    step = $qty.attr('step');

                // Format values
                if (!currentVal || currentVal === '' || currentVal === 'NaN') currentVal = 0;
                if (max === '' || max === 'NaN') max = '';
                if (min === '' || min === 'NaN') min = 0;
                if (step === 'any' || step === '' || step === undefined || parseFloat(step) === 'NaN') step = 1;

                // Change the value
                if ($(this).is('.plus')) {
                    if (max && (currentVal >= max)) {
                        $qty.val(max);
                    } else {
                        $qty.val((currentVal + parseFloat(step)).toFixed(step.getDecimals()));
                    }
                } else {
                    if (min && (currentVal <= min)) {
                        $qty.val(min);
                    } else if (currentVal > 0) {
                        $qty.val((currentVal - parseFloat(step)).toFixed(step.getDecimals()));
                    }
                }

                // Trigger change event
                $qty.trigger('change');
            });
        });
    </script>
<?php
}


function twof_archive_price_rating() { 

global $product;
$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

    ?>
    <div class="rating-wrap">
    <div class="woocommerce-product-rating">
		<?php echo wc_get_rating_html( $average, $rating_count ); // WPCS: XSS ok. ?>
		<?php if ( comments_open() ) : ?>
			<?php //phpcs:disable ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">(<?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'woocommerce' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?>)</a>
			<?php // phpcs:enable ?>
		<?php endif ?>
	</div>


<?php
}


// woocomerce mods
function woocommerce_template_loop_product_title() { 
    echo '<a class="title">' . get_the_title() . '</a>'; 
} 