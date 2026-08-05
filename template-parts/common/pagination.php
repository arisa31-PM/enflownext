<?php
/**
 * Common Pagination
 *
 * @param array $args {
 *     @type int    $current       Current page number.
 *     @type int    $total         Total page count.
 *     @type string $context_class Required project class.
 * }
 */

$context_class = isset( $args['context_class'] ) ? trim( (string) $args['context_class'] ) : '';

if ( '' === $context_class ) {
	return;
}

$current = isset( $args['current'] ) ? (int) $args['current'] : max( 1, (int) get_query_var( 'paged' ) );
$total   = isset( $args['total'] ) ? (int) $args['total'] : 0;

if ( 0 >= $total && isset( $GLOBALS['wp_query'] ) && $GLOBALS['wp_query'] instanceof WP_Query ) {
	$total = (int) $GLOBALS['wp_query']->max_num_pages;
}

$current = max( 1, $current );
$total   = max( 1, $total );
$current = min( $current, $total );

$pagination_classes = array(
	$context_class,
	'c-pagination',
);

$context_list_class   = $context_class . '-list';
$context_item_class   = $context_class . '-item';
$context_button_class = $context_class . '-button';
$context_number_class = $context_class . '-number';

$prev_page = $current - 1;
$next_page = $current + 1;
?>

<nav class="<?php echo esc_attr( implode( ' ', $pagination_classes ) ); ?>" aria-label="ページネーション">
	<ul class="<?php echo esc_attr( $context_list_class ); ?> c-pagination__list">
		<li class="<?php echo esc_attr( $context_item_class ); ?> c-pagination__item">
			<?php if ( 1 < $current ) : ?>
				<a class="<?php echo esc_attr( $context_button_class ); ?> c-pagination__button c-pagination__button--prev" href="<?php echo esc_url( get_pagenum_link( $prev_page ) ); ?>" aria-label="前のページへ">&lt;</a>
			<?php else : ?>
				<span class="<?php echo esc_attr( $context_button_class ); ?> c-pagination__button c-pagination__button--prev c-pagination__button--disabled" aria-disabled="true">&lt;</span>
			<?php endif; ?>
		</li>
		<?php for ( $page = 1; $page <= $total; $page++ ) : ?>
			<li class="<?php echo esc_attr( $context_item_class ); ?> c-pagination__item">
				<?php if ( $page === $current ) : ?>
					<span class="<?php echo esc_attr( $context_number_class ); ?> c-pagination__number c-pagination__number--current" aria-current="page"><?php echo esc_html( (string) $page ); ?></span>
				<?php else : ?>
					<a class="<?php echo esc_attr( $context_number_class ); ?> c-pagination__number" href="<?php echo esc_url( get_pagenum_link( $page ) ); ?>" aria-label="<?php echo esc_attr( $page . 'ページ目へ' ); ?>"><?php echo esc_html( (string) $page ); ?></a>
				<?php endif; ?>
			</li>
		<?php endfor; ?>
		<li class="<?php echo esc_attr( $context_item_class ); ?> c-pagination__item">
			<?php if ( $current < $total ) : ?>
				<a class="<?php echo esc_attr( $context_button_class ); ?> c-pagination__button c-pagination__button--next" href="<?php echo esc_url( get_pagenum_link( $next_page ) ); ?>" aria-label="次のページへ">&gt;</a>
			<?php else : ?>
				<span class="<?php echo esc_attr( $context_button_class ); ?> c-pagination__button c-pagination__button--next c-pagination__button--disabled" aria-disabled="true">&gt;</span>
			<?php endif; ?>
		</li>
	</ul>
</nav>
