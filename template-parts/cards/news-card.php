<?php
/**
 * News Card
 */

$post_id = get_the_ID();
$categories = get_the_category( $post_id );
$category_name = 'お知らせ';

if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) {
	$first_category = reset( $categories );

	if ( $first_category instanceof WP_Term && '' !== $first_category->name ) {
		$category_name = $first_category->name;
	}
}

$news_title = get_the_title( $post_id );
?>

<a class="p-news__link" href="<?php echo esc_url( get_permalink() ); ?>">
  <time class="p-news__date" datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>"><?php echo esc_html( get_the_date( 'Y.m.d' ) ); ?></time>
  <span class="p-news__category"><?php echo esc_html( $category_name ); ?></span>
  <span class="p-news__text"><span class="p-news__text-inner"><?php echo esc_html( $news_title ); ?></span></span>
</a>
