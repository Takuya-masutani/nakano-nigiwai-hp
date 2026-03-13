<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the page header div.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
$wrapper_div_classes = 'wrapper ';
if ( is_single() ) {
	$wrapper_div_classes .= join( ' ', get_post_class() );
}

$layout               = apply_filters( 'hestia_header_layout', get_theme_mod( 'hestia_header_layout', 'default' ) );
$disabled_frontpage   = get_theme_mod( 'disable_frontpage_sections', false );
$wrapper_div_classes .=
	(
		( is_front_page() && ! is_page_template() && ! is_home() && false === (bool) $disabled_frontpage ) ||
		( class_exists( 'WooCommerce', false ) && ( is_product() || is_product_category() ) ) ||
		( is_archive() && ( class_exists( 'WooCommerce', false ) && ! is_shop() ) )
	) ? '' : ' ' . $layout . ' ';

$header_class = '';
$hide_top_bar = get_theme_mod( 'hestia_top_bar_hide', true );
if ( (bool) $hide_top_bar === false ) {
	$header_class .= 'header-with-topbar';
}

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
	<meta charset='<?php bloginfo( 'charset' ); ?>'>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="thumbnail" content="<?php echo esc_url( site_url() ); ?>/wp-content/uploads/2025/10/nigiwai_aki-1.png" alt="中野にぎわいフェスタ">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
	<script src="<?php echo esc_url( site_url() ); ?>/wp-content/uploads/jquery.easing.min.js"></script>
	<script src="<?php echo esc_url( site_url() ); ?>/wp-content/uploads/jquery.smoothScroll.js"></script>

	<meta name="google-site-verification" content="jBzH4tmrUOX4F5AAXNDaHuwlzBfEKBOB5pzF5xvtAgU" />
	<!-- Google tag (gtag.js) -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-J84ZQW9N3V"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-J84ZQW9N3V');
	</script>

	<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />	
	<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Kaisei+Decol&family=Kaisei+Opti&family=Mochiy+Pop+One&family=Yusei+Magic&display=swap" rel="stylesheet">

	<script>
	jQuery( function( $ ) {
		$( 'a[href^="#"]' ).SmoothScroll( {
			duration: 2000,
			offset: 70,
			easing  : 'easeOutQuint'
		} );
	} );
	</script>
	<script src="<?php echo esc_url( site_url() ); ?>/wp-content/uploads/wow.min.js"></script>
	<link rel="stylesheet" href="<?php echo esc_url( site_url() ); ?>/wp-content/uploads/animate.css">
	<script>
	 new WOW().init();
	</script>
	<style>footer { background-color: #1a2a4a !important; }</style>
</head>

<body <?php if ( is_front_page() ) { ?>id="home" <?php } ?><?php body_class(); ?>>
	<?php wp_body_open(); ?>
	<div class="<?php echo esc_attr( $wrapper_div_classes ); ?>">
		<header class="header <?php echo esc_attr( $header_class ); ?>">
			<?php
			hestia_before_header_trigger();
			do_action( 'hestia_do_top_bar' );
			do_action( 'hestia_do_header' );
			hestia_after_header_trigger();
			?>
		</header>

	<?php if ( is_front_page() ) { ?>
		<div id="kv">
			
			<div class="catchphrase fadeIn_cp">
			</div>

			<div class="wrap">
				<div class="swiper-container">
					<div class="swiper-wrapper">
						
						<!-- スライド0枚目 -->
						<div class="swiper-slide">
							<div class="slide-img">
								<img src="<?php echo esc_url( home_url( '/' ) ); ?>wp-content/uploads/2026/03/2026-spring-top.png" alt="中野にぎわいフェスタイベント写真">
							</div>
						</div>
						
					</div>
					<div class="swiper-pagination"></div>
				</div>
			</div>

		</div>

		</div>
	<?php } ?>