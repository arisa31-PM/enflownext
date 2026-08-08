# 品質チェックレポート

## プロジェクト情報

| 項目 | 内容 |
| --- | --- |
| 実施日 | 2026-08-08 |
| プロジェクト | ポートフォリオ課題 |
| 実行モード | 調査のみ |
| 比較対象 | 2026-08-08-01-recheck.md |
| チェック対象コミット（任意） | Git操作禁止のため未確認 |
| 判定 | 修正完了後に再チェック |

---

## サイト情報

| 項目 | 内容 |
| --- | --- |
| テーマ名 | enflownext |
| Local URL | http://enflownext.local/ |
| 本番URL | https://enflownext.com/ |
| GitHub Repository | https://github.com/arisa31-PM/enflownext |
| 担当 | Codex |

---

## 実施内容

- 静的品質チェック
- WordPress品質チェック
- 本番公開前チェック
- XMLサイトマップ再チェック
- Contact Form 7設定確認
- プラグイン設定確認
- 開発用ファイル公開状況確認
- 前回レポートとの差分確認

---

## チェック結果サマリー

| 集計項目 | 件数 |
| --- | ---: |
| 総チェック項目数 | 31 |
| OK件数 | 14 |
| 要確認件数 | 7 |
| 修正必要件数 | 7 |
| 確認不可件数 | 3 |

---

## 優先度別結果

### A：公開・動作へ影響する重大問題

- 本番フッターの「プライバシーポリシー」が空リンクのまま。`footer.php:82`
- 本番 `/privacy-policy/` は現在も 404。
- Contact Form 7 の `unsafe_email_without_protection` が Local DB の `_config_validation` に残っている。

### B：品質・UXへ影響する問題

- 本番HTMLに `meta name="generator" content="WordPress 7.0.2"` が出力されている。
- Local DBのタイムゾーンが未設定。`timezone_string` が空。
- テーマ内に本番不要ファイル・ディレクトリが残っている。`.DS_Store`、`node_modules`、`src`、`gulp/gulpfile.js`、`package.json`、`package-lock.json`、`assets-backup-before-migration-20260805`。
- 下層FVの静的フォールバック画像 `contact-fv-pc.webp`、`faq-fv-pc.webp`、`price-fv-pc.webp`、`works-fv-pc.webp`、`news-fv-pc.webp` がテーマ内に存在しない。

### C：軽微な改善

- 本番 `/works/` に `noindex` が出力されている。今回案件限定ルールによりNGではないが、公開時は解除確認が必要。
- Localで開発・移行補助系プラグインが有効。納品前に要否整理が必要。

### ユーザー確認

- Contact Form 7 の実送信、管理者宛メール受信、自動返信メール受信、迷惑メール確認。
- 本番WordPress管理画面での有効プラグイン一覧と各プラグイン設定。
- Google Analytics / Search Console の接続有無。
- 公開時の noindex / nofollow 解除タイミング。

### 本番環境確認

- `https://enflownext.com/wp-sitemap.xml` は 200。
- 子サイトマップ6件はすべて 200。
- 主要ページ `/`、`/works/`、`/price/`、`/profile/`、`/news/`、`/faq/`、`/contact/`、`/contact/thanks/` は 200。
- 404確認用 `/not-found-check/` は 404。
- 本番テーマ直下の `package.json`、`gulp/gulpfile.js`、`src/` は 404で、公開は確認されない。

### 確認不可

- ブラウザ実機確認。Browserコネクタの `agent.browsers.list()` が空のため未実施。
- Console / Network の実ブラウザ確認。
- Local画面確認。`http://enflownext.local/` は接続不可。

---

## 詳細結果

| 項目 | 結果 | 確認方法 | 対象ページ | 対象ファイル | 問題内容 | 推奨対応 | 優先度 | 備考 |
| --- | --- | --- | --- | --- | --- | --- | --- | --- |
| 最新レポート確認 | ✅ OK | `docs/quality-reports/2026-08-08-01-recheck.md` 読み込み | 全体 | docs/quality-reports | 比較対象は最新1件のみ | 次回は本レポートのみ比較対象にする | - | 以前のレポートは履歴扱い |
| XMLサイトマップ親 | ✅ OK | `curl -L -D` | `/wp-sitemap.xml` | - | 200で取得可能 | 現状維持 | - | 前回404は解消 |
| XMLサイトマップ子 | ✅ OK | sitemap内URLへ `curl` | 子サイトマップ6件 | - | 全件200 | 現状維持 | - | post/page/works/category/works_category/users |
| WordPress generator | ❌ 修正必要 | 本番HTML確認 | `/` | `functions.php` | 本番HTMLに `WordPress 7.0.2` が出力 | 本番反映状態、実行順、キャッシュを確認 | B | Localテーマには `remove_action( 'wp_head', 'wp_generator' );` あり |
| プライバシーポリシーリンク | ❌ 修正必要 | 本番HTML/HTTP/コード確認 | 全ページ共通 | `footer.php:82` | フッターリンクが `href=""`、`/privacy-policy/` は404 | 固定ページ作成後、フッターリンクを正しいURLへ設定 | A | お問い合わせ内の同意文もリンクではなくテキスト |
| Contact Form 7 送信元 | ❌ 修正必要 | Local DB確認 | Contact Form 7 ID 175 | DB `_mail`, `_mail_2` | `wordpress@codoassistportfolio.local` | 本番ドメインのメールアドレスへ変更 | A | 本番管理画面では再確認が必要 |
| Contact Form 7 Reply-To | ✅ OK | Local DB確認 | Contact Form 7 ID 175 | DB `_mail`, `_mail_2` | 管理者宛は `[your-email]`、自動返信は `[_site_admin_email]` | 現状維持 | - | メール到達性は未確認 |
| Contact Form 7 自動返信 | ✅ OK | Local DB確認 | Contact Form 7 ID 175 | DB `_mail_2` | `active = true` | 現状維持 | - | 実受信確認はユーザー作業 |
| unsafe_email_without_protection | ❌ 修正必要 | Local DB `_config_validation` 確認 | Contact Form 7 ID 175 | DB `_config_validation` | `mail_2.recipient` に警告あり | reCAPTCHA等の保護、またはCF7推奨に沿って設定調整 | A | 現在のDB上では未解消 |
| Confirm Plus Contact Form 7 | ✅ OK | 本番HTML/テーマJS/CSS/Local active_plugins確認 | `/contact/` | `assets/js/script.js`, `assets/css/styles.css` | 確認画面UIで `wpcf7cp` を前提に実装済み | 現仕様では必要プラグインとして維持 | - | 無効化すると確認画面前提のUIが崩れる可能性 |
| 開発用ファイル公開 | ✅ OK | 本番HTTP HEAD | 本番テーマURL | - | `package.json`、`gulp/gulpfile.js`、`src/` は404 | サーバー公開は現状OK | - | テーマ内ローカルには残存 |
| テーマ内本番不要ファイル | ❌ 修正必要 | `find` | テーマ | テーマ直下ほか | 開発・バックアップファイルが残存 | 納品対象から除外、不要ファイル整理 | B | 今回は調査のみのため未修正 |
| SCF利用 | ✅ OK | コード/Local DB確認 | FAQ/WORKS/TOP | `front-page.php`, `page-faq.php`, `single-works.php` | SCF前提コード、LocalでSCF有効 | 現状維持 | - | 未入力時非表示処理あり |
| ACF依存なし | ✅ OK | `rg` | テーマ | PHP一式 | `get_field`、`the_field`、`acf_` 依存なし | 現状維持 | - | Local対象DBではACF有効なし |
| Local有効テーマ | ✅ OK | Local DB確認 | Local | DB options | `template/stylesheet = enflownext` | 現状維持 | - | 前回のDB不一致は解消 |
| Local URL | ✅ OK | Local DB確認 | Local | DB options | `siteurl/home = http://enflownext.local` | 現状維持 | - | 画面接続は不可 |
| Local画面接続 | ➖ 確認不可 | `curl -I` | `http://enflownext.local/` | - | 接続不可 | Localアプリでサイト起動後に再確認 | 確認不可 | DB設定は確認済み |
| タイムゾーン | ❌ 修正必要 | Local DB確認 | Local | DB options | `timezone_string` が空 | 管理画面で `Asia/Tokyo` を設定 | B | 前回の別DBではAsia/Tokyo |
| パーマリンク | ✅ OK | Local DB確認 | Local | DB options | `/%postname%/` | 現状維持 | - | - |
| 検索エンジン抑制 | ✅ OK | Local DB/本番HTML確認 | Local/本番 | DB/HTML | Local `blog_public = 0`、本番 `/works/` に noindex | 今回ルール上問題なし。公開時解除 | - | nofollowはrobotsとしては未確認 |
| 主要ページHTTP | ✅ OK | `curl` | 本番主要ページ | - | 主要ページ200、404確認ページ404 | 現状維持 | - | - |
| 本番SEO SIMPLE PACK | ✅ OK | 本番HTML/Local DB確認 | `/` | DB options | description/canonical/OGP出力あり | GA/GSCは管理画面で設定 | - | `google_g_id` 等はLocal DBでは空 |
| 本番EWWW出力 | ✅ OK | 本番HTML/Local DB確認 | `/` | DB options | WebP/lazyload出力、EWWW設定あり | 現状維持 | - | FVはskip-lazy/eagerあり |
| FVフォールバック画像 | ❌ 修正必要 | `find`/コード確認 | 下層 | page系テンプレート | 静的フォールバック画像が存在しない | 画像追加または存在ファイルへ変更 | B | 本番はアイキャッチ等で回避される場合あり |
| ブラウザ確認 | ➖ 確認不可 | Browserコネクタ | 全体 | - | 利用可能ブラウザ0件 | ブラウザ接続後に再確認 | 確認不可 | Playwright相当未実施 |
| Console/Network | ➖ 確認不可 | Browserコネクタ | 全体 | - | 実ブラウザ確認不可 | Chrome/Safari/Edge等で再確認 | 確認不可 | HTTP確認は実施 |

---

## プラグイン設定確認

### 設定が必要なもの

| プラグイン | 現在の状態 | 設定画面 | 設定方法 | 今回未設定でも問題ないか |
| --- | --- | --- | --- | --- |
| Smart Custom Fields | Localで有効。テーマはSCF前提。 | 管理画面 > Smart Custom Fields | FAQ、TOP FV、WORKS VOICE等のフィールド、入力例、説明文、必須設定を確認 | 表示に必要な入力済み項目があれば提出前は可。ただし納品前に設定確認必須 |
| SEO SIMPLE PACK | Localで有効。本番HTMLにSEO SIMPLE PACK 3.6.2出力あり。LocalのGA/GSC項目は空。 | 管理画面 > SEO PACK | title/description/OGP、GA、Search Console、noindex対象を確認 | スクール提出前はGA/GSC未設定でも可。公開時は要設定 |
| EWWW Image Optimizer | Localで有効。WebP/lazyload設定あり。本番HTMLもEWWW出力あり。 | 管理画面 > 設定 > EWWW Image Optimizer | WebP変換、Lazy Load、メタデータ削除、画像リサイズを確認 | 現状表示は問題なし。公開前に一括最適化と主要画像確認推奨 |
| Contact Form 7 | Localで有効。本番フォーム出力あり。送信元が `.local`。 | 管理画面 > お問い合わせ > CONTACTページ > メール | 送信元を本番ドメインのメールへ変更、管理者宛/自動返信/Reply-Toを確認 | 未設定のままは不可。送受信テスト前に修正必要 |
| Confirm Plus Contact Form 7 | Localで有効。本番で確認画面用CSS/JS出力あり。 | 管理画面 > お問い合わせ > 対象フォーム、またはプラグイン設定 | 確認画面ボタン文言、送信フロー、確認画面表示を確認 | 現仕様では必要。未確認のまま提出は要注意 |
| Breadcrumb NavXT | Localで有効。テーマがBreadcrumb NavXTのフックを使用。 | 管理画面 > 設定 > Breadcrumb NavXT | 投稿/固定/カスタム投稿/タクソノミーのパンくず表示名を確認 | 基本表示が崩れていなければ提出前は可。納品前に下層全体確認 |
| Custom Post Type UI | Localで有効。WORKS投稿タイプ運用に必要。 | 管理画面 > CPT UI | `works` と `works_category` の公開設定、アーカイブ、rewriteを確認 | WORKSが表示できているため提出前は可。設定エクスポート/再現性は要確認 |
| SiteGuard | 前回別DBで有効、現Local対象DBでは未確認。pluginsには存在。 | 管理画面 > SiteGuard | ログインURL変更、画像認証、管理ページアクセス制限を確認 | スクール提出前は必須ではない。公開時は要設定 |

### 設定不要または納品前に削除検討

| プラグイン | 現在の状態 | 判断 | 備考 |
| --- | --- | --- | --- |
| Admin Bar Position | Localで有効 | 設定不要、納品前は無効化/削除候補 | 管理バー位置調整用途 |
| All-in-One WP Migration | Localで有効 | 移行時のみ必要 | 公開後常用しないなら削除候補 |
| Duplicate Post | Localで有効 | 運用上必要なら維持、不要なら削除 | 記事複製用途 |
| Show Current Template | Localで有効 | 納品前は削除推奨 | 開発専用 |
| Stops Core Theme and Plugin Updates | Localで有効 | 公開運用では要確認 | 更新停止はセキュリティリスクになり得る |
| Advanced Custom Fields | 対象DBでは有効ではない。別DBで有効を確認 | この案件では不要 | テーマ内ACF依存なし。残っていれば削除 |

---

## 修正履歴

| 修正日 | 修正内容 | 担当 | 再チェック結果 |
| --- | --- | --- | --- |
| 2026-08-08 | 調査のみ実施。コード修正、DB更新、WP管理画面変更、Git操作、ビルドは未実施。 | Codex | 修正完了後に再チェック |

---

## 最終判定

修正完了後に再チェック。

XMLサイトマップの404は解消しており、子サイトマップも取得可能。Local DBのサイトURL・有効テーマ不一致も解消している。一方で、プライバシーポリシーリンクとページ404、Contact Form 7の送信元メール、`unsafe_email_without_protection`、本番 generator 出力、Localタイムゾーン未設定、本番不要ファイル残存があるため、現時点では「納品・提出可能」とは判断しない。

---

## 備考

- 今回の案件限定ルールにより、`noindex / nofollow` はスクール提出前のため正常扱いとし、NG判定にはしない。
- 公開時には noindex / nofollow、SEO SIMPLE PACKのnoindex対象、WordPress表示設定を必ず解除・確認する。
- 本番トップでは `noindex` は未確認だが、`/works/` では `noindex` が確認された。
- Browserコネクタは利用可能ブラウザ0件のため、レスポンシブ、Console、Networkの実ブラウザ確認は未実施。
- 次回品質チェックでは、この `2026-08-08-02-quality-check.md` のみを比較対象とする。

---

## 前回レポートとの比較

### 解消した問題

- 本番XMLサイトマップ `/wp-sitemap.xml` の404は解消。現在は200。
- 各子サイトマップもすべて200で取得可能。
- Local DBの `siteurl/home/template/stylesheet` 不一致は解消。現在は `http://enflownext.local`、`enflownext`。
- 対象Local DBではSCFとEWWWが有効、ACFは有効プラグインに含まれていない。
- 本番テーマ直下の `package.json`、`gulp/gulpfile.js`、`src/` はHTTP 404で、公開は確認されない。

### 継続している問題

- フッターのプライバシーポリシーリンクが空。
- `/privacy-policy/` が404。
- 本番HTMLにWordPress generatorが出力されている。
- テーマ内に本番不要ファイル・ディレクトリが残っている。
- 下層FVの静的フォールバック画像がテーマ内に存在しない。
- Browser/実機での表示、Console、Network確認は未実施。

### 新しく発見した問題

- Contact Form 7の送信元メールが `wordpress@codoassistportfolio.local`。
- Contact Form 7の `_config_validation` に `unsafe_email_without_protection` が残存。
- Local DBの `timezone_string` が空。
- 本番 `/works/` に `noindex` が出力されている。今回ルール上は問題なしだが公開時解除が必要。

### 今回の案件では問題なしと判断した項目

- `noindex / nofollow` はスクール提出前のためNG判定しない。
- Confirm Plus Contact Form 7 は、現在のフォーム確認画面仕様で必要。
- XMLサイトマップは現在取得可能。
- 本番で主要な開発用ファイルURLは404。
- テーマ内にACF関数依存はない。

### 確認不可

- Local画面表示。
- 実ブラウザのレスポンシブ、Console、Network。
- 本番管理画面上のプラグイン設定詳細。
- 実メール送受信。

---

## 私がWordPress管理画面で行う作業

- プライバシーポリシー固定ページを作成し、公開状態とURLを確認する。
- Contact Form 7の送信元メールを本番ドメインのメールアドレスへ変更する。
- Contact Form 7の設定検証で `unsafe_email_without_protection` を解消する。
- Contact Form 7の管理者宛メール、自動返信メール、Reply-To、送受信、迷惑メールを確認する。
- SEO SIMPLE PACKでGA、Search Console、OGP、noindex対象を確認する。
- 公開時に noindex / nofollow を解除する。
- WordPress一般設定でタイムゾーンを `Asia/Tokyo` に設定する。
- Smart Custom Fieldsの入力例、説明文、必須設定、未入力時表示を確認する。
- 有効プラグインのうち開発・移行補助系の要否を判断し、不要なら無効化/削除する。

---

## CodeXで対応可能な作業

- フッターのプライバシーポリシーリンクを `home_url('/privacy-policy/')` 等へ修正する。
- 本番 generator 非表示が確実に反映されるよう、テーマ側の実装位置や反映差分を確認・修正する。
- 下層FVのフォールバック画像参照を存在ファイルへ変更する、または不足画像リストを整理する。
- テーマ内の本番不要ファイル整理方針を提示する。
- SCF未入力時の出力制御、ACF依存なしの再確認を行う。
- ブラウザ接続後にレスポンシブ、Console、Networkの再チェックを行う。

---

## 次回の品質チェックで重点的に確認する項目

- 本レポートを唯一の比較対象として、XMLサイトマップが継続して200か確認する。
- プライバシーポリシーリンクと `/privacy-policy/` が解消しているか確認する。
- Contact Form 7の送信元メール、Reply-To、自動返信、`unsafe_email_without_protection` を再確認する。
- WordPress generatorが本番HTMLから消えているか確認する。
- タイムゾーンが `Asia/Tokyo` になっているか確認する。
- 本番不要ファイルの納品対象除外・整理状況を確認する。
- 公開時は noindex / nofollow 解除を確認する。

---

## 参照チェックリスト

チェック項目は以下を参照し、このファイルには重複して記載しない。

- `13-static-checklist.md`
- `12-wordpress-checklist.md`
- `14-production-checklist.md`
