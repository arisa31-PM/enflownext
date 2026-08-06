# 静的サイト → WordPress化

## 役割

このプロンプトは、完成している静的HTMLサイトをWordPressオリジナルテーマへ変換する場合に使用する。

共通コーディングルール（00-common.md）、WordPressテーマ設計ルール（10-wordpress-theme.md）、WordPress品質ルール（11-wordpress-quality.md）を前提として実装すること。

デザインやHTML構造は変更せず、WordPress化のみを行うこと。

---

# 基本方針

・HTML構造を変更しない
・クラス名を変更しない
・デザインを変更しない
・静的サイトと同じ見た目を維持する
・WordPress化を理由に不要なHTMLを追加しない
・WordPress標準機能を利用する
・保守性を考慮する

---

# WordPress化の手順

以下の順序で実装すること。

① テーマフォルダを作成する

② style.css を作成する

③ functions.php を作成する

④ header.php を作成する

⑤ footer.php を作成する

⑥ 共通部分を分割する

⑦ front-page.php を作成する

⑧ 固定ページを作成する

⑨ 投稿一覧を作成する

⑩ 投稿詳細を作成する

⑪ カスタム投稿を作成する

⑫ カスタムフィールドを実装する

⑬ 動作確認を行う

---

# 共通部分の分割

以下は共通テンプレートへ切り出す。

・header
・footer
・パンくず
・CTA
・関連記事
・カードUI
・ページネーション
・共通セクション

template-parts を積極的に利用すること。

---

# パス変更

静的HTMLのパスをWordPress用へ変更する。

画像

```php
<?php echo esc_url( get_template_directory_uri() ); ?>
```

トップページ

```php
<?php echo esc_url( home_url( '/' ) ); ?>
```

固定ページ

```php
<?php echo esc_url( home_url( '/slug/' ) ); ?>
```

投稿

```php
<?php the_permalink(); ?>
```

---

# header.php

head部分を header.php に切り出す。

以下を追加する。

```php
<?php wp_head(); ?>
```

body開始直後

```php
<?php wp_body_open(); ?>
```

---

# footer.php

body終了前

```php
<?php wp_footer(); ?>
```

を追加する。

---

# 投稿化

更新頻度の高いコンテンツは通常投稿へ変更する。

例

・お知らせ
・ブログ

一覧

home.php

詳細

single-post.php

---

# 固定ページ

更新頻度が低いページは固定ページへ変更する。

例

・会社概要
・サービス
・採用情報
・お問い合わせ
・プライバシーポリシー
・Thanksページ

---

# カスタム投稿

必要に応じてカスタム投稿へ変更する。

例

・施工事例
・商品
・インタビュー

archive-{post_type}.php

single-{post_type}.php

taxonomy-{taxonomy}.php

---

# カスタムフィールド

クライアントが更新する箇所のみACF化する。

・画像
・テキスト
・リンク
・繰り返し項目

固定文言はACF化しない。

---

# 確認事項

以下を確認する。

・HTML構造が変わっていない

・クラス名が変わっていない

・デザインが崩れていない

・画像が表示される

・リンクが正しい

・投稿が表示される

・固定ページが表示される

・カスタム投稿が表示される

・カスタムフィールドが表示される

・PHPエラーがない

・Console Errorがない

・レスポンシブが崩れていない

---

# 出力ルール

・変更したファイルを最初に一覧で示す

・変更内容をファイルごとに分けて出力する

・コードは省略せずコピペできる完成形で出力する

・変更理由はコード出力後に簡潔に説明する

・WordPress管理画面で必要な設定があれば最後に説明する