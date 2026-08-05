<?php
/**
 * News Categories
 */

$categories = get_categories(
	array(
		'taxonomy'   => 'category',
		'hide_empty' => true,
		'orderby'    => 'name',
		'order'      => 'ASC',
	)
);
?>

<section class="p-news-sidebar__section">
	<div class="p-news-sidebar__heading">
		<h2 class="p-news-sidebar__title">CATEGORY</h2>
		<p class="p-news-sidebar__sub">カテゴリー</p>
	</div>

	<?php if ( ! empty( $categories ) && ! is_wp_error( $categories ) ) : ?>
		<ul class="p-news-sidebar__list">
			<?php foreach ( $categories as $category ) : ?>
				<li class="p-news-sidebar__item">
					<a class="p-news-sidebar__link" href="<?php echo esc_url( get_category_link( $category ) ); ?>">
						<span class="p-news-sidebar__link-text"><?php echo esc_html( $category->name ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	<?php else : ?>
		<p class="p-news-sidebar__empty">カテゴリーがありません。</p>
	<?php endif; ?>
</section>
