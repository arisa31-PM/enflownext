  <?php
    $news_archive_url = function_exists( 'my_get_news_archive_url' ) ? my_get_news_archive_url() : home_url( '/news/' );
    $profile_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'profile' ) : home_url( '/profile/' );
    $faq_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'faq' ) : home_url( '/faq/' );
    $contact_url = function_exists( 'my_get_page_url' ) ? my_get_page_url( 'contact' ) : home_url( '/contact/' );
    $footer_nav_items = array(
      array(
        'label' => 'WORKS',
        'sub' => '実績',
        'url' => home_url( '/works/' ),
      ),
      array(
        'label' => 'PRICE',
        'sub' => '料金',
        'url' => home_url( '/price/' ),
      ),
      array(
        'label' => 'PROFILE',
        'sub' => '経歴・職歴',
        'url' => $profile_url,
      ),
      array(
        'label' => 'NEWS',
        'sub' => 'お知らせ',
        'url' => $news_archive_url,
      ),
      array(
        'label' => 'FAQ',
        'sub' => 'よくあるご質問',
        'url' => $faq_url,
      ),
      array(
        'label' => 'CONTACT',
        'sub' => 'お問い合わせ',
        'url' => $contact_url,
      ),
    );
    $social_items = array(
      array(
        'label' => 'LINE',
        'icon' => 'icon-line.svg',
        'url' => 'https://line.me/',
        'width' => '30px',
        'height' => '28px',
      ),
      array(
        'label' => 'X',
        'icon' => 'icon-x.svg',
        'url' => 'https://x.com/',
        'width' => '27px',
        'height' => '25px',
      ),
      array(
        'label' => 'Instagram',
        'icon' => 'icon-instagram.svg',
        'url' => 'https://www.instagram.com/',
        'width' => '26px',
        'height' => '26px',
      ),
      array(
        'label' => 'Facebook',
        'icon' => 'icon-facebook.svg',
        'url' => 'https://www.facebook.com/',
        'width' => '14px',
        'height' => '28px',
      ),
    );
  ?>
  <footer class="p-footer">
    <div class="p-footer__inner">
      <div class="p-footer__brand">
        <a class="p-footer__logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">CODO ASSIST</a>
        <ul class="p-footer__sns-list" aria-label="SNSリンク">
          <?php foreach ( $social_items as $item ) : ?>
            <li class="p-footer__sns-item">
              <a class="p-footer__sns-link" href="<?php echo esc_url( $item['url'] ); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo esc_attr( $item['label'] ); ?>" style="<?php echo esc_attr( '--p-footer-sns-icon-width: ' . $item['width'] . '; --p-footer-sns-icon-height: ' . $item['height'] . ';' ); ?>">
                <img src="<?php echo esc_url( get_template_directory_uri() . '/assets/images/icons/' . $item['icon'] ); ?>" alt="" width="24" height="24" loading="lazy" decoding="async">
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
        <a class="p-footer__privacy" href="">プライバシーポリシー</a>
      </div>
      <nav class="p-footer__nav" aria-label="フッターナビゲーション">
        <ul class="p-footer__nav-list">
          <?php foreach ( $footer_nav_items as $item ) : ?>
            <li class="p-footer__nav-item">
              <a class="p-footer__nav-link" href="<?php echo esc_url( $item['url'] ); ?>">
                <span class="p-footer__nav-main"><?php echo esc_html( $item['label'] ); ?></span>
                <span class="p-footer__nav-sub"><?php echo esc_html( $item['sub'] ); ?></span>
              </a>
            </li>
          <?php endforeach; ?>
        </ul>
      </nav>
      <small class="p-footer__copy">&copy;2026 CODO ASSIST</small>
    </div>
  </footer>
  <?php get_template_part( 'template-parts/common/page-top' ); ?>
<?php wp_footer(); ?>
</body>
</html>
