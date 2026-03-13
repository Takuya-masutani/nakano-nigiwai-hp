<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the "wrapper" div and all content after.
 *
 * @package Hestia
 * @since Hestia 1.0
 */
?>
			<?php do_action( 'hestia_do_footer' ); ?>


	</div>

<script type="text/javascript">
let swipeOption = {
  loop: true,
  effect: 'fade',
  autoplay: {
    delay: 4000,
    disableOnInteraction: false,
  },
  speed: 2000,
  pagination: {
    el: '.swiper-pagination',
    clickable: true,
  }
}
new Swiper('.swiper-container', swipeOption);
</script>

<?php wp_footer(); ?>
<link rel="stylesheet" href="<?php echo esc_url( get_stylesheet_directory_uri() . '/customcss.css?v=2' ); ?>">

</body>
</html>
