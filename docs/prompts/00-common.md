# 共通コーディングルール

このファイルは、すべての案件で適用する共通ルールです。

静的サイト・WordPress・スマホファースト・PCファーストを問わず必ず適用してください。

---

## 基本方針

・デザインカンプを正しく再現する
・保守性を最優先する
・可読性を重視する
・再利用性を考慮する
・不要なコードを書かない
・推測で実装せず、不明点は確認する

---

## HTML

・HTML5のセマンティックタグを使用する
・見出し階層（h1〜h6）を守る
・article / section / nav / aside / footer / header を適切に使い分ける
・button と a タグを適切に使い分ける
・不要な div を増やさない
・リストは ul / ol を使用する
・Q&Aは dl / dt / dd を使用する
・日付は time タグを使用する

---

## クラス命名

・FLOCSS + BEMで命名する
・役割が分かる名前を付ける
・略称を多用しない
・連番ではなく意味のある名前を付ける
・WordPress化してもクラス名を変更しない

---

### FLOCSS + BEM の詳細ルール

- `p-` は Project のクラスとする。
- `c-` は Component のクラスとする。
- 再利用する共通UIのみ `c-` クラス化する。
- `c-` クラスを使用する場合でも、必ず該当箇所の `p-` クラスを併記する。
- HTML上で `c-` クラス単体では使用しない。
- `p-` クラスは、そのページ・セクション・配置文脈を表すために必ず付与する。
- `c-` クラスは、共通UIとしての見た目や部品性を担う。
- `p-` クラスは、Project固有の文脈・構造を担う。
- `header` / `footer` / `fv` / `problem` / `reason` など、ページ固有セクションは安易に `c-` 化しない。
- 親要素だけでなく子要素まで `p-` クラスを付与する。省略しない。
- クラスの記述順は `p → c → l` の順で統一する。

例：

```html
<div class="p-front-card c-card">
  <h3 class="p-front-card__title c-card__title">タイトル</h3>
</div>

<div class="p-section__inner l-inner">
  ...
</div>
```

- 命名に迷う場合は、勝手に `c-` / `p-` を決めず、候補と採用理由を報告する。

---

## コンポーネントとテンプレートパーツ

実装前に、「コンポーネント」と「テンプレートパーツ」の役割を混同しないこと。

### コンポーネント（Component）

サイト全体で再利用するUIを管理する。

責務
・見た目
・共通スタイル
・共通UI

例
・c-button
・c-card
・c-section-title
・c-label
・c-pagination
・c-post-meta
・c-form
・c-input

コンポーネントはSCSSで管理し、HTMLの分割単位ではない。

---

### テンプレートパーツ（template-parts）

WordPressでHTML・PHPを分割し、複数テンプレートから読み込むための部品とする。

責務
・HTML構造
・PHP処理
・WordPressループ
・共通レイアウト

例
・CTA
・パンくず
・WORKSカード
・NEWSカード
・FAQ一覧
・関連記事
・ページトップ

テンプレートパーツ内では、必要に応じてコンポーネント（cクラス）を使用する。

---

### 実装ルール

・テンプレートパーツとコンポーネントを混同しない。
・テンプレートパーツはHTML/PHPの共通化を目的とする。
・コンポーネントはUIの共通化を目的とする。
・同じテンプレートパーツ内でも、UIが共通であればcクラスを使用する。
・cクラス単体では使用せず、必ずpクラスを併記する。

---

## CSS / SCSS

・FLOCSSを維持する
・BEMを維持する
・remを基本単位とする
・heightで高さを作らない
・paddingで高さを作る
・min-heightは必要最小限とする
・!importantを使用しない
・overflow:hiddenを安易に使用しない
・transformは必要最小限にする
・calc / clamp / vwは原則使用しない
・ネストは深くしすぎない
・各scssでは @use "../../global" as *; を使用する

### SCSS構成ルール

- `styles.scss` をエントリーポイントとして管理する。
- `styles.scss` では `global` / `foundation` / `layout` / `object` を読み込む。
- 各ディレクトリは `_index.scss` で管理する。
- `settings` 配下を各SCSSファイルから直接読み込まない。
- 各SCSSファイルでは原則として以下のみ使用する。

```scss
@use "../../global" as *;

### SCSSファイルの責務

- SCSSファイルは、1つの責務（1コンポーネント・1セクション）ごとに作成する。
- 1つのSCSSファイルに複数セクションのスタイルをまとめない。
- ファイル名と管理するクラスの責務を一致させる。
- セクションごとにSCSSファイルを分割する。
- 共通コンポーネント（`c-`）はコンポーネント単位で管理し、Project（`p-`）はセクション単位で管理する。

例

- `_p-fv.scss`：FVセクション
- `_p-works.scss`：WORKSセクション
- `_p-concept.scss`：CONCEPTセクション
- `_p-profile.scss`：PROFILEセクション
- `_p-faq.scss`：FAQセクション
- `_p-news.scss`：NEWSセクション

ページ全体に共通する背景や共通制御のみ、`_p-front.scss` に記述する。

新しいセクションを追加する場合は、既存ファイルへ追記するのではなく、責務に応じて新しいSCSSファイルを作成する。

## SCSSルール

### Sass Modules

・既存の @use / @forward 構成に従うこと
・@use ".../global" as *; を使用しているファイルでは、変数・関数・Mixinは名前空間を付けずに使用すること
・既存の命名規則を変更しないこと
・名前空間付き（例：color.$primary、marker.$marker-line-background）へ勝手に書き換えないこと
・新しい変数管理ファイルや名前空間を勝手に追加しないこと
・既存コードが @use ".../global" as *; で統一されている場合は、その記述方法に合わせること。
・既存のコーディングスタイルを変更する提案や書き換えは行わないこと。

---

### Sass関数・Mixinのルール

既存プロジェクトで定義済みのSass関数・Mixinのみ使用すること。

禁止事項
・独自のMixinを新規作成しない
・独自のFunctionを新規作成しない
・既存のMixinをラップするだけのMixinを作成しない
・保守性向上を理由に勝手に抽象化しない

実装前に必ず既存の foundation/function・foundation/mixin を確認し、
既存のものを利用すること。

不足している場合でも、勝手に追加せず、その必要性を説明して提案すること。

新規Mixin・Functionが必要な場合は、
コードを書かずに理由を説明し、承認を得てから追加すること。

・保守性向上のみを理由に抽象化しないこと。
・現在の案件で1回しか使用しない処理はMixin化しないこと。

---

### _index.scss 運用ルール

- 各ディレクトリは `_index.scss` を作成し、そのディレクトリ内のSCSSを `@forward` で管理する。
- `styles.scss` は各ディレクトリの `_index.scss` のみを `@use` する。
- `styles.scss` から個別SCSSファイルを直接 `@use` しない。
- 新しいSCSSファイルを追加した場合は、対応するディレクトリの `_index.scss` に `@forward` を追加する。


### f_around の使用ルール

- `font-size` を指定する場合は、必ず `@include f_around()` を使用する。
- `font-size` / `line-height` / `font-weight` / `letter-spacing` を個別に記述しない。
- 第1引数には `font-size` のpx値を指定する。
- 第2引数には `line-height` のpx値を指定する。
- Figmaで Line Height が **Auto** の場合は、第2引数を指定しない（または `false` を指定する）。
- 第3引数は必ず `map.get($font-weights, "...")` を使用する。
- `400`・`500`・`700`・`900` などの数値を直接指定しない。
- 第4引数は、案件で使用するデザインカンプツールに応じて指定方法を変更する。
- 可読性を優先し、必要に応じて名前付き引数を使用してもよい。
- デザインカンプに値が存在しない場合は、推測して補完せず確認すること。

#### 使用例

```scss
@include f_around(
  28,
  28,
  map.get($font-weights, "bold"),
  10
);

Figmaで Line Height が Auto の場合

@include f_around(
  28,
  $weight: map.get($font-weights, "bold"),
  $spacing: 10
);
デザインカンプツール別ルール

案件開始時に、使用するデザインカンプツール（Figma / Adobe XD / Photoshop / Illustrator など）を確認する。

Figma
Letter spacing が % 表示の場合は、その数値を第4引数へそのまま指定する。
例：10% → 10
例：5% → 5
Adobe XD / Photoshop / Illustrator
Letter spacing はAdobe系ツールに表示されている数値を、そのまま第4引数へ指定する。
例：10 → 10
例：50 → 50

同じ数値でも、FigmaとAdobe系では意味が異なるため、案件開始時に必ずデザインカンプツールを確認する。

---

## レイアウト

・親要素でサイズを管理する
・Flex・Gridは必要最小限に使用する
・gapを優先する
・position:absoluteは必要最小限にする
・レイアウト調整だけのためにtransformを使用しない

【ブレークポイント】
・ブレークポイントは768px（md）の1箇所のみとする。
・メディアクエリは @include mq(md) のみ使用する。
・600px、601px、1024pxなど独自のメディアクエリは追加しない。
・@media (max-width:767px) などの直書きも原則禁止とする。

【画面幅の制御】
・レイアウト調整は width、max-width、margin-inline、padding で行う。
・画面幅ごとのメディアクエリを追加して調整しない。
・必要に応じて max-width: rem(xxx); を使用して横幅を制御することは可。

【禁止事項】
・calc() の使用禁止
・height による高さ固定禁止（min-height、padding、aspect-ratioを優先）
・画面幅指定のためだけのメディアクエリ追加禁止

---

## 画像

・画像は src/images 配下で管理する
・用途ごとにフォルダを分ける
・gulpで assets/images へ出力する
・imgには width / height 属性を付与する
・画像は親要素でサイズを管理する
・imgは width:100%; height:auto; を基本とする
・ロゴ画像は高さ100%を基本とする
・SVGで表現できるものはSVGを優先する
・FV画像には loading="eager" を使用する
・その他は loading="lazy" を使用する
・画像ファイルを勝手に追加・削除・リネームしない
・`assets/images` 配下の `.webp` は gulp による生成物として扱い、画像追加禁止ルールの違反とはみなさない。
・pictureタグはWebPフォールバックなど、画像形式の切り替えが必要な場合に使用する

### WebPフォールバック運用ルール

- WebP画像を使用する場合は、WebP非対応ブラウザ向けに必ずフォールバック画像を用意する。
- HTMLでは `picture` タグを使用し、`source` で WebP、`img` でフォールバック画像を指定する。
- `img` の `src` には `.png` / `.jpg` / `.jpeg` などのフォールバック画像を指定する。
- `source` の `srcset` には `.webp` を指定する。
- `picture` は画像形式の切り替え目的で使用し、PC/SPの画像切り替え目的では原則使用しない。
- PC/SPで画像を切り替える場合は、原則CSSで表示制御する。
- `img` には必ず `width` / `height` / `alt` を指定する。
- `source` には `width` / `height` を指定しない。
- FV画像には `loading="eager"` と `fetchpriority="high"` を指定する。
- FV以外の画像には `loading="lazy"` を指定する。

#### 実装例

```html
<picture>
  <source
    srcset="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/sample.webp"
    type="image/webp"
  >
  <img
    src="<?php echo esc_url( get_template_directory_uri() ); ?>/assets/images/sample.png"
    alt=""
    width="600"
    height="400"
    loading="lazy"
    decoding="async"
  >
</picture>

### 画像ファイルの操作禁止

- CodeXは画像ファイルを新規作成しない。
- 画像ファイルを追加しない。
- 画像ファイルを削除しない。
- 画像ファイルをリネームしない。
- 画像ファイルを別フォルダへ移動しない。
- 画像が不足している場合は、勝手に代替画像を作成せず、不足している画像名・用途・必要箇所を報告する。

---

## JavaScript

・ES6で記述する
・const / let を使用する
・varは使用しない
・不要なグローバル変数を作らない
・イベントは適切に解除する
・Console Errorを出さない

---

## hover

・hoverはopacityを基本とする
・transitionを設定する
・クリックできる要素はhoverを付ける
・デザイン指定がある場合はその仕様を優先する

---

## ボタン

・高さはpaddingで作る
・クリック領域を十分確保する
・buttonとaタグを適切に使い分ける

---

## WordPress

・画像パスは get_template_directory_uri() を使用する
・リンクは home_url() を使用する
・相対パスを書かない
・管理画面で更新しない固定文言は無理にフィールド化しない

---

## プラグイン

・WordPress標準機能または導入済みプラグインで対応できるものは独自実装しない
・SEOは SEO SIMPLE PACK を優先する
・画像最適化は EWWW Image Optimizer を優先する
・FAQ管理は Smart Custom Fields を使用する
・functions.php は必要最小限の処理のみ記述する

---

## 品質

・Console Errorを出さない
・PHP Errorを出さない
・リンク切れを残さない
・長い文章でも崩れない
・画像未設定でも大きく崩れない
・レスポンシブで破綻しない

---

## AIへの指示

・推測で実装しない
・不足している画像は勝手に作成しない
・不要なライブラリを追加しない
・不要なプラグインを追加しない
・対象ページ以外を勝手に修正しない
・必要だと思う機能は実装せず提案する

---

## 出力ルール

・作成・修正するファイル名を明示する
・ファイルごとにコードを分けて出力する
・コードは省略せず完成形で出力する
・長い説明は不要
・実装後はセルフレビューを行う

---

###### プラグイン運用ルール

本プロジェクトでは、WordPress Blueprint を利用してサイトを作成する。

Blueprint により、以下のプラグインは初期状態で導入されているものとする。

- Admin Bar Position
- Advanced Custom Fields
- All-in-One WP Migration and Backup
- Breadcrumb NavXT
- Contact Form 7
- Custom Post Type UI
- Easy Updates Manager
- EWWW Image Optimizer
- Intuitive Custom Post Order
- SEO SIMPLE PACK
- Show Current Template
- SiteGuard WP Plugin
- Yoast Duplicate Post


### CodeXへの指示

- プロジェクト開始時に導入済みプラグインを確認する。
- `CLIENT_REQUIREMENTS.md` を参照し、この案件で採用するプラグインを確認する。
- Blueprintに含まれるプラグインと採用プラグインが重複する場合は、そのまま使用する。
- **クライアントから別途指定されたプラグインが既存プラグインと役割が重複する場合は、既存プラグインを無効化する。**
- プラグインの削除は勝手に行わず、理由を添えて提案する。
- 新しいプラグインを追加する場合は、用途・追加理由・代替案を提示し、ユーザーの承認後に追加する。
- WordPress標準機能または導入済みプラグインで実現できる場合は、新しいプラグインを追加しない。
- 独自実装する前に、導入済みプラグインで対応可能かを必ず確認する。

---

## 修正ルール

- 対象ページ以外は修正しない。
- 共通パーツを修正する場合は、影響範囲を報告してから修正する。
- 勝手なリファクタリングは禁止する。
- デザイン変更を伴う修正は行わない。
- 判断に迷う場合は、勝手に実装せず提案する。

---

### Component化のタイミング

- 共通UIは、複数ページ・複数セクションで使用することが確定したタイミングでComponent化する。
- TOPページ実装中は、無理にComponent化しない。
- Component化する際は、事前に対象箇所・影響範囲をレビューし、承認後に実装する。