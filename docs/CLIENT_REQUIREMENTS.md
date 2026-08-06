# CLIENT_REQUIREMENTS.md

## 案件概要
- Figmaデザインカンプをもとに、最初からWordPressオリジナルテーマとして実装する。
- 静的HTMLを作成してからWordPress化せず、Local上のWordPressテーマで直接実装する。

## コーディング条件
- gulp
- FLOCSS + BEM
- remを基本単位
- スマホファースト
- ブレークポイント768px
- 375px / 1440pxはピクセルパーフェクト

## WordPress機能条件
- Smart Custom Fields（SCF）
- SEO SIMPLE PACK
- EWWW Image Optimizer

Google Analytics
Google Search Console
XMLサイトマップは、
WordPress本体またはSEO SIMPLE PACKの管理画面設定で対応する。

### プラグイン運用
Blueprintに含まれるプラグインを確認し、

- 使用する
- 無効化する
- 削除する

をプロジェクト開始時に提案すること。

使用しないプラグインは削除理由も報告する。

新しいプラグインを追加する場合は、
用途・追加理由・代替案を提示し、承認後に追加する。

WordPress本体または導入済みプラグインで実現できる場合は、新しいプラグインを追加しない。

## 採用プラグイン
- Smart Custom Fields（SCF）
- Breadcrumb NavXT
- Contact Form 7
- Custom Post Type UI
- SEO SIMPLE PACK
- EWWW Image Optimizer

### WordPress機能の実装方針

・WordPress本体、導入済みプラグイン、管理画面設定で対応できるものは、functions.phpに独自実装しない  
・SEO設定は SEO SIMPLE PACK を優先する  
・画像最適化は EWWW Image Optimizer を優先する  
・FAQ管理は Smart Custom Fields を使用する  
・XMLサイトマップ、Google Analytics、Search Console連携はプラグインまたは管理画面設定を優先する  
・functions.phpにはテーマ表示に必要な最低限の処理のみ記述する  
・カスタム投稿、タクソノミー、Smart Custom Fieldsの追加は、明示的な指示がある場合のみ実装する  
・必要だと判断した場合も、勝手に実装せず提案する  

## デザイン基本情報
### カラー
- メイン #104C93
- サブ #0E2D52
- 背景 #F3F7FA

### フォント
- Noto Sans JP
- Roboto

## 共通UI・アニメーション条件
### ヘッダー
- PC/SP追従
- FV通過後 #FFF
- 下部シャドウ
- ホバーでメインカラー

### フッター
- メニューはopacity hover
- SNSは別タブ

### TOPへ戻る
- 全ページ
- FV後表示
- CTA前非表示

### 共通
- クリック要素はopacity hover
- transitionで自然に変化
- 詳細ページは演出アニメーション不要
- hoverなどUIアニメーションは実装

## front-page.php
- ヘッダーのCONTACTボタンは、TOPページ内のCONTACTセクション（フッター直前）へアンカーリンクする。
- FVはズーム+フェードカルーセル
- メインコピーアニメーション
- WORKSは自動ループ+ドラッグ
- WORKS画像hover scale(1.1)
- PROFILE「CODO ASSIST」を横スクロール
- CTA画像hover scale(1.1)
- FAQテキストループ（2行目のみ速度変更）
- WORKS〜PROFILE間背景グラデーションアニメーション

## single-works.php
- FVはアイキャッチ表示
- 未設定時No Image
- VOICEはSCF
- 未入力時非表示
- 下部WORKSカルーセル自動ループ+ドラッグ
- カードhoverは共通仕様

## page-price.php
- 「お見積り」は100→0カウントダウン
- その他は0→金額カウントアップ
- セクション表示時開始
- 1回のみ
- カンマ区切り

## page-profile.php
- PCのみサイドメニューsticky
- SPは通常表示
- アンカーはスムーススクロール

## 実装方針
- WordPress標準機能優先
- 複数ページで使用するパーツは template-parts 化する
- DRY原則
- 更新箇所のみSCF
- 固定文言はSCF化しない
- 未入力時は非表示

### 画像の取り扱い

・必要な画像はすべて支給済みとする
・CodeXが画像ファイルを新規作成・生成・追加してはいけない
・既存の画像ファイルのみ使用する
・画像が見つからない場合は勝手に代替画像を作成せず、どの画像が不足しているか報告する
・画像ファイル名を勝手に変更しない
・画像を別フォルダへ移動しない
・画像の最適化・リネームは指示があった場合のみ行う

## 確認事項
- 320/375/767/768/1440/1920/2650px確認
- PHP Errorなし
- Console Errorなし
- リンク切れなし
- フォーム・FAQ・投稿確認
- AI関連ファイル削除
