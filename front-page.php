<?php get_header(); ?>

<?php
  $theme_uri = get_template_directory_uri();
  $front_page_id = get_queried_object_id();

  if ( 0 >= $front_page_id ) {
    $front_page_id = (int) get_option( 'page_on_front' );
  }

  $fv_slides = array();

  if ( 0 < $front_page_id ) {
    $scf_fv_slides = class_exists( 'SCF' ) ? SCF::get( 'top_fv_slides', $front_page_id ) : array();

    if ( empty( $scf_fv_slides ) || ! is_array( $scf_fv_slides ) ) {
      $scf_fv_slides = get_post_meta( $front_page_id, 'top_fv_slides', true );
    }

    if ( empty( $scf_fv_slides ) || ! is_array( $scf_fv_slides ) ) {
      $top_fv_images_pc = get_post_meta( $front_page_id, 'top_fv_image_pc', false );
      $top_fv_images_sp = get_post_meta( $front_page_id, 'top_fv_image_sp', false );
      $top_fv_count     = max( count( $top_fv_images_pc ), count( $top_fv_images_sp ) );
      $scf_fv_slides    = array();

      for ( $index = 0; $index < $top_fv_count; $index++ ) {
        $scf_fv_slides[] = array(
          'top_fv_image_pc' => $top_fv_images_pc[ $index ] ?? '',
          'top_fv_image_sp' => $top_fv_images_sp[ $index ] ?? '',
        );
      }
    }

    if ( is_array( $scf_fv_slides ) ) {
      foreach ( $scf_fv_slides as $slide ) {
        if ( ! is_array( $slide ) ) {
          continue;
        }

        $slide_pc = $slide['top_fv_image_pc'] ?? '';
        $slide_sp = $slide['top_fv_image_sp'] ?? '';

        if ( '' === trim( (string) $slide_pc ) && '' === trim( (string) $slide_sp ) ) {
          continue;
        }

        $fv_slides[] = array(
          'pc' => $slide_pc,
          'sp' => $slide_sp,
        );
      }
    }
  }

  if ( empty( $fv_slides ) ) {
    $fv_slides[] = array(
      'pc' => '',
      'sp' => '',
    );
  }

  $works_query = new WP_Query(
    array(
      'post_type' => 'works',
      'posts_per_page' => -1,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
      'no_found_rows' => true,
    )
  );
  $works_count = (int) $works_query->post_count;
  $news_query = new WP_Query(
    array(
      'post_type' => 'post',
      'posts_per_page' => 3,
      'post_status' => 'publish',
      'orderby' => 'date',
      'order' => 'DESC',
      'ignore_sticky_posts' => true,
      'no_found_rows' => true,
    )
  );
  $news_page_id = (int) get_option( 'page_for_posts' );
  $news_page_url = $news_page_id ? get_permalink( $news_page_id ) : home_url( '/news/' );
  $faq_marquee_rows_sp = array(
    array(
      'line_class' => 'p-faq__loop-line--normal p-faq__loop-line--reverse',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--software',
          'text' => '対応ソフトは？',
        ),
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--slow',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
        array(
          'class' => 'p-faq__loop-item--figma',
          'text' => 'Figmaも対応できる？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--normal p-faq__loop-line--reverse',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--wordpress',
          'text' => 'WordPressも大丈夫？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--slow',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--php',
          'text' => 'PHPのフォームは作れる？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--slow p-faq__loop-line--reverse',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
        array(
          'class' => 'p-faq__loop-item--figma',
          'text' => 'Figmaも対応できる？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--normal',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--software',
          'text' => '対応ソフトは？',
        ),
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
      ),
    ),
  );
  $faq_marquee_rows_pc = array(
    array(
      'line_class' => 'p-faq__loop-line--normal p-faq__loop-line--reverse',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--software',
          'text' => '対応ソフトは？',
        ),
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
        array(
          'class' => 'p-faq__loop-item--figma',
          'text' => 'Figmaも対応できる？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--slow',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--wordpress',
          'text' => 'WordPressも大丈夫？',
        ),
        array(
          'class' => 'p-faq__loop-item--php',
          'text' => 'PHPのフォームは作れる？',
        ),
      ),
    ),
    array(
      'line_class' => 'p-faq__loop-line--normal p-faq__loop-line--reverse',
      'items' => array(
        array(
          'class' => 'p-faq__loop-item--software',
          'text' => '対応ソフトは？',
        ),
        array(
          'class' => 'p-faq__loop-item--skill',
          'text' => '得意分野は？',
        ),
        array(
          'class' => 'p-faq__loop-item--figma',
          'text' => 'Figmaも対応できる？',
        ),
      ),
    ),
  );
?>

<main class="p-front-page">
  <?php if ( ! empty( $fv_slides ) ) : ?>
  <section class="p-fv js-fv" aria-label="ファーストビュー">
    <div class="p-fv__inner">
      <div class="p-fv__slider swiper js-fv-slider">
        <div class="p-fv__wrapper swiper-wrapper">
          <?php foreach ( $fv_slides as $index => $slide ) : ?>
            <div class="p-fv__slide swiper-slide">
              <?php
              echo my_get_responsive_picture(
                array(
                  'pc_image'        => $slide['pc'],
                  'sp_image'        => $slide['sp'],
                  'pc_size'         => 'full',
                  'sp_size'         => 'large',
                  'class'           => 'p-fv__image',
                  'picture_class'   => 'p-fv__picture',
                  'alt'             => '',
                  'loading'         => 'eager',
                  'fetchpriority'   => 'high',
                  'fallback_width'  => 750,
                  'fallback_height' => 1200,
                )
              );
              ?>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
      <div class="p-fv__content l-inner">
        <p class="p-fv__lead js-copy-text">High quality code</p>
        <h1 class="p-fv__title js-copy-text">
          <span class="p-fv__title-accent p-fv__title-accent--skill">スキル</span>だけじゃない<br>
          <span class="p-fv__title-accent p-fv__title-accent--partner">パートナーに。</span>
        </h1>
      </div>
    </div>
    <div class="p-fv__scroll" aria-hidden="true">
      <span>SCROLL</span>
    </div>
  </section>
  <?php endif; ?>

  <section class="p-works" id="works">
    <?php if ( 0 < $works_count ) : ?>
      <div class="p-works__inner l-inner">
        <div class="p-works__heading c-section-heading">
          <h2 class="p-works__title c-section-heading__title">WORKS</h2>
          <p class="p-works__sub c-section-heading__sub">実績</p>
        </div>
        <?php if ( 1 === $works_count ) : ?>
          <div class="p-works__list">
            <?php set_query_var( 'works_card_is_slider', false ); ?>
            <?php while ( $works_query->have_posts() ) : ?>
              <?php $works_query->the_post(); ?>
              <?php get_template_part( 'template-parts/cards/works-card' ); ?>
            <?php endwhile; ?>
          </div>
        <?php else : ?>
          <div class="p-works__controls">
            <button class="p-works__button c-slider-button c-slider-button--prev js-works-prev" type="button" aria-label="前の実績へ"></button>
            <button class="p-works__button c-slider-button c-slider-button--next js-works-next" type="button" aria-label="次の実績へ"></button>
          </div>
          <div class="p-works__slider swiper js-works-slider">
            <div class="p-works__wrapper swiper-wrapper">
              <?php set_query_var( 'works_card_is_slider', true ); ?>
              <?php while ( $works_query->have_posts() ) : ?>
                <?php $works_query->the_post(); ?>
                <?php get_template_part( 'template-parts/cards/works-card' ); ?>
              <?php endwhile; ?>
            </div>
          </div>
        <?php endif; ?>
        <a class="p-works__more c-more-link" href="<?php echo esc_url( home_url( '/works/' ) ); ?>">
          <span class="c-more-link__text">Read more</span>
          <span class="c-more-link__icon" aria-hidden="true"></span>
        </a>
      </div>
    <?php endif; ?>
  </section>

  <?php set_query_var( 'works_card_is_slider', null ); ?>
  <?php wp_reset_postdata(); ?>

  <section class="p-concept js-gradient-section">
    <div class="p-concept__inner l-inner">
      <img class="p-concept__mark" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/icon-cross-line.svg' ); ?>" alt="" width="50" height="50" loading="lazy" decoding="async" aria-hidden="true">
      <div class="p-concept__content">
        <h2 class="p-concept__title">
          <span class="p-concept__title-text">
            技術は、<br class="u-sp">
            <span class="p-concept__title-plain">形にするための手段。</span>
          </span>
          <span class="p-concept__title-sub">
            <span class="p-concept__title-highlight">目的は“ちゃんと伝わるWEB”</span>
          </span>
        </h2>
        <p class="p-concept__text">ここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキストここにテキスト</p>
      </div>
      <div class="p-concept__picture">
        <picture>
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-concept-pc.webp' ); ?>" media="(min-width: 768px)" type="image/webp">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-concept-pc.png' ); ?>" media="(min-width: 768px)" type="image/png">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-concept.webp' ); ?>" type="image/webp">
          <img class="p-concept__image" src="<?php echo esc_url( $theme_uri . '/assets/images/top-concept.png' ); ?>" alt="ノートパソコンでコードを書いている様子" width="690" height="479" loading="lazy" decoding="async">
        </picture>
      </div>
      <img class="p-concept__mark p-concept__mark--bottom" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/icon-cross-line.svg' ); ?>" alt="" width="50" height="50" loading="lazy" decoding="async" aria-hidden="true">
    </div>
  </section>

  <section class="p-profile" id="profile">
    <div class="p-profile__inner l-inner">
      <div class="p-profile__head">
        <div class="p-profile__heading c-section-heading">
          <div class="p-profile__heading-main">
            <h2 class="p-profile__title c-section-heading__title">PROFILE</h2>
            <p class="p-profile__sub c-section-heading__sub">経歴・職歴</p>
          </div>
          <p class="p-profile__copy">
            丁寧な作業と<span class="p-profile__copy-palt">コミュニケーション</span>で<br><span class="p-profile__copy-text"><span class="p-profile__copy-palt">ハイクオリティ</span>な<span class="p-profile__copy-palt">コード</span>を納品。</span>
            <img class="p-profile__copy-line" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/icon-profile-title-line.svg' ); ?>" alt="" width="618" height="16" loading="lazy" decoding="async" aria-hidden="true">
          </p>
        </div>
        <a class="p-profile__more c-more-link" href="<?php echo esc_url( my_get_page_url( 'profile' ) ); ?>">
          <span class="c-more-link__text">Read more</span>
          <span class="c-more-link__icon" aria-hidden="true"></span>
        </a>
      </div>
      <div class="p-profile__visual">
        <picture class="p-profile__picture p-profile__picture--main">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile1-pc.webp' ); ?>" media="(min-width: 768px)" type="image/webp">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile1-pc.png' ); ?>" media="(min-width: 768px)" type="image/png">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile1.webp' ); ?>" type="image/webp">
          <img class="p-profile__image p-profile__image--main" src="<?php echo esc_url( $theme_uri . '/assets/images/top-profile1.png' ); ?>" alt="プロフィール写真" width="712" height="378" loading="lazy" decoding="async">
        </picture>
        <div class="p-profile__marquee" aria-hidden="true">
          <div class="p-profile__marquee-track">
            <div class="p-profile__marquee-group">
              <img class="p-profile__marquee-image p-profile__marquee-image--codo" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/profile-marquee-codo.svg' ); ?>" alt="" width="231" height="59" loading="lazy" decoding="async">
              <img class="p-profile__marquee-image p-profile__marquee-image--assist" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/profile-marquee-assist.svg' ); ?>" alt="" width="88" height="49" loading="lazy" decoding="async">
            </div>
            <div class="p-profile__marquee-group" aria-hidden="true">
              <img class="p-profile__marquee-image p-profile__marquee-image--codo" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/profile-marquee-codo.svg' ); ?>" alt="" width="231" height="59" loading="lazy" decoding="async">
              <img class="p-profile__marquee-image p-profile__marquee-image--assist" src="<?php echo esc_url( $theme_uri . '/assets/images/icons/profile-marquee-assist.svg' ); ?>" alt="" width="88" height="49" loading="lazy" decoding="async">
            </div>
          </div>
        </div>
        <picture class="p-profile__picture p-profile__picture--middle">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile2-pc.webp' ); ?>" media="(min-width: 768px)" type="image/webp">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile2-pc.png' ); ?>" media="(min-width: 768px)" type="image/png">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile2.webp' ); ?>" type="image/webp">
          <img class="p-profile__image p-profile__image--middle" src="<?php echo esc_url( $theme_uri . '/assets/images/top-profile2.png' ); ?>" alt="キーボードで作業している手元" width="568" height="324" loading="lazy" decoding="async">
        </picture>
        <picture class="p-profile__picture p-profile__picture--bottom">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile3-pc.webp' ); ?>" media="(min-width: 768px)" type="image/webp">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile3-pc.png' ); ?>" media="(min-width: 768px)" type="image/png">
          <source srcset="<?php echo esc_url( $theme_uri . '/assets/images/top-profile3.webp' ); ?>" type="image/webp">
          <img class="p-profile__image p-profile__image--bottom" src="<?php echo esc_url( $theme_uri . '/assets/images/top-profile3.png' ); ?>" alt="デジタル画面と手元のイメージ" width="588" height="268" loading="lazy" decoding="async">
        </picture>
      </div>
    </div>
  </section>

  <section class="p-faq" id="faq">
    <div class="p-faq__inner l-inner">
      <div class="p-faq__content">
        <div class="p-faq__head">
          <div class="p-faq__heading c-section-heading c-section-heading--white">
            <h2 class="p-faq__title c-section-heading__title">FAQ</h2>
            <p class="p-faq__sub c-section-heading__sub">よくあるご質問</p>
          </div>
          <a class="p-faq__more c-more-link c-more-link--white" href="<?php echo esc_url( my_get_page_url( 'faq' ) ); ?>">
            <span class="c-more-link__text">Read more</span>
            <span class="c-more-link__icon" aria-hidden="true"></span>
          </a>
        </div>
        <div class="p-faq__loop" aria-hidden="true">
          <div class="p-faq__loop-rows u-sp">
            <?php foreach ( $faq_marquee_rows_sp as $row ) : ?>
              <p class="p-faq__loop-line <?php echo esc_attr( $row['line_class'] ); ?>">
                <span class="p-faq__loop-track">
                  <span class="p-faq__loop-group">
                    <?php foreach ( $row['items'] as $item ) : ?>
                      <span class="p-faq__loop-item <?php echo esc_attr( $item['class'] ); ?>"><?php echo esc_html( $item['text'] ); ?></span>
                    <?php endforeach; ?>
                  </span>
                  <span class="p-faq__loop-group" aria-hidden="true">
                    <?php foreach ( $row['items'] as $item ) : ?>
                      <span class="p-faq__loop-item <?php echo esc_attr( $item['class'] ); ?>"><?php echo esc_html( $item['text'] ); ?></span>
                    <?php endforeach; ?>
                  </span>
                </span>
              </p>
            <?php endforeach; ?>
          </div>
          <div class="p-faq__loop-rows u-pc">
            <?php foreach ( $faq_marquee_rows_pc as $row ) : ?>
              <p class="p-faq__loop-line <?php echo esc_attr( $row['line_class'] ); ?>">
                <span class="p-faq__loop-track">
                  <span class="p-faq__loop-group">
                    <?php foreach ( $row['items'] as $item ) : ?>
                      <span class="p-faq__loop-item <?php echo esc_attr( $item['class'] ); ?>"><?php echo esc_html( $item['text'] ); ?></span>
                    <?php endforeach; ?>
                  </span>
                  <span class="p-faq__loop-group" aria-hidden="true">
                    <?php foreach ( $row['items'] as $item ) : ?>
                      <span class="p-faq__loop-item <?php echo esc_attr( $item['class'] ); ?>"><?php echo esc_html( $item['text'] ); ?></span>
                    <?php endforeach; ?>
                  </span>
                </span>
              </p>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php if ( $news_query->have_posts() ) : ?>
    <section class="p-news" id="news">
      <div class="p-news__inner l-inner">
        <div class="p-news__head">
          <div class="p-news__heading c-section-heading">
            <h2 class="p-news__title c-section-heading__title">NEWS</h2>
            <p class="p-news__sub c-section-heading__sub">お知らせ</p>
          </div>
          <div class="p-news__more p-news__more--head u-pc">
            <a class="p-news__more-link c-more-link" href="<?php echo esc_url( $news_page_url ); ?>">
              <span class="c-more-link__text">Read more</span>
              <span class="c-more-link__icon" aria-hidden="true"></span>
            </a>
          </div>
        </div>
        <div class="p-news__content">
          <div class="p-news__list">
            <?php while ( $news_query->have_posts() ) : ?>
              <?php $news_query->the_post(); ?>
              <?php get_template_part( 'template-parts/cards/news-card' ); ?>
            <?php endwhile; ?>
          </div>
          <div class="p-news__more p-news__more--content u-sp">
            <a class="p-news__more-link c-more-link" href="<?php echo esc_url( $news_page_url ); ?>">
              <span class="c-more-link__text">Read more</span>
              <span class="c-more-link__icon" aria-hidden="true"></span>
            </a>
          </div>
        </div>
      </div>
    </section>
    <?php wp_reset_postdata(); ?>
  <?php else : ?>
    <?php wp_reset_postdata(); ?>
  <?php endif; ?>

  <section class="p-common-cta c-cta js-cta" id="contact" aria-label="お問い合わせとよくあるご質問">
    <div class="p-common-cta__inner c-cta__inner l-inner l-inner--cta">
      <?php get_template_part( 'template-parts/common/contact-cta' ); ?>
      <?php get_template_part( 'template-parts/common/faq-cta' ); ?>
    </div>
  </section>
</main>

<?php get_footer(); ?>
