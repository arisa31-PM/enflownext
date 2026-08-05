<?php
/**
 * News Archive Card
 */

$post_id       = get_the_ID();
$categories    = get_the_category( $post_id );
$category_name = 'お知らせ';

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	$first_category = reset( $categories );

	if ( $first_category instanceof WP_Term && '' !== $first_category->name ) {
		$category_name = $first_category->name;
	}
}

$news_title = get_the_title( $post_id );
?>

<article class="p-news-archive-card">
	<a class="p-news-archive-card__link" href="<?php echo esc_url( get_permalink( $post_id ) ); ?>">
		<div class="p-news-archive-card__meta">
			<time class="p-news-archive-card__date" datetime="<?php echo esc_attr( get_the_date( 'c', $post_id ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d', $post_id ) ); ?></time>
			<span class="p-news-archive-card__category"><?php echo esc_html( $category_name ); ?></span>
		</div>
		<?php if ( '' !== $news_title ) : ?>
			<p class="p-news-archive-card__text"><?php echo esc_html( $news_title ); ?></p>
		<?php endif; ?>
	</a>
</article>
