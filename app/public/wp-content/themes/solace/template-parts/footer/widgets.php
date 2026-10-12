<?php
/**
 * The template for displaying footer widgets or custom page container.
 *
 * @package Vast
 * @since 1.0.0
 */

?>

<?php
ob_start();
$footern = array( 'footer-1', 'footer-2', 'footer-3', 'footer-4' );
$nfoot = count( $footern );
for ( $i = 0; $i < $nfoot; $i++ ) {
	dynamic_sidebar( $footern[ $i ] );
}
$foot = ob_get_clean();

if ( $foot && get_theme_mod( 'footer-option', 'footer-widget' ) === 'footer-widget' ) {

?>
<div id="bottom" class="container">
	<div class="row d-flex flex-wrap justify-content-between">
		<?php
		$i = 0;
		foreach ( $footern as $key ) {
			if ( is_active_sidebar( $footern[ $i ] ) ) {
				echo wp_kses_post( '<div class="col-sm-12 col-md-6 col-lg">' );
				dynamic_sidebar( $footern[ $i ] );
				echo wp_kses_post( '</div>' );
			}
			$i++;
		}
		?>
	</div><!-- .row -->
</div><!-- #bottom.container -->
<?php } ?>
