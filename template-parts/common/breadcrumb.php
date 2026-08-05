<?php
/**
 * Breadcrumb
 *
 * @param array $args {
 *     @type string $context_class Required project class.
 * }
 */

$context_class = isset( $args['context_class'] ) ? trim( (string) $args['context_class'] ) : '';

if ( '' === $context_class || ! function_exists( 'bcn_display' ) ) {
	return;
}
?>

<nav class="<?php echo esc_attr( $context_class ); ?> c-breadcrumb" aria-label="パンくずリスト">
	<?php bcn_display(); ?>
</nav>
