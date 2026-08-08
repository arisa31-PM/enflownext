# AIプロンプト集

## 概要

このフォルダには、Web制作を行うためのAIプロンプトをまとめています。

案件の種類によって使用するプロンプトが異なります。

必ずこのINDEXを確認し、該当するプロンプトをすべて読み込んだ上で制作してください。

共通ルールよりも個別ルールの方が優先される場合は、個別ルールを優先してください。

---

# 使用ルール

## 共通ルール

すべての案件で必ず読み込む。

```
00-common.md
```

---

# 静的サイト制作（SPファースト）

以下のファイルを読み込む。

```
00-common.md
01-static-sp.md
13-static-checklist.md
14-production-checklist.md
```

用途

・新規静的サイト制作
・LP制作
・企業サイト制作
・HTML/CSS/JavaScriptのみで構築する案件

---

# 静的サイト制作（PCファースト）

以下のファイルを読み込む。

```
00-common.md
02-static-pc.md
13-static-checklist.md
14-production-checklist.md
```

用途

・PCデザイン優先案件
・PCファースト案件

---

# WordPressオリジナルテーマ制作

以下のファイルを読み込む。

```
00-common.md
10-wordpress-theme.md
11-wordpress-quality.md
13-static-checklist.md
12-wordpress-checklist.md
14-production-checklist.md
```

用途

・最初からWordPressオリジナルテーマとして制作する案件
・静的HTMLを経由しない案件
・WordPress管理画面から更新できるサイトを構築する案件

---

# 静的サイト → WordPress化

以下のファイルを読み込む。

```
00-common.md
20-static-to-wordpress.md
11-wordpress-quality.md
13-static-checklist.md
12-wordpress-checklist.md
14-production-checklist.md
```

用途

・完成済み静的HTMLをWordPress化する案件
・HTML構造やデザインを変更せずWordPressへ移植する案件

---

# AIへの共通指示

制作開始前に、読み込んだプロンプトをすべて確認し、内容を理解してください。

実装時は以下を遵守してください。

・共通ルールを必ず守る
・品質ルールを遵守する
・納品前品質チェックを必ず実施する
・デザインカンプを忠実に再現する
・保守性、可読性、拡張性を重視する
・コードは省略せず、コピペできる完成形で出力する
・WordPress案件ではWordPress標準機能を優先する
・不要な独自実装を避ける

---

# AIへの最終指示

制作完了後は、以下の順でセルフレビューを実施してください。

1. コーディング内容を自己レビューする
2. 品質ルールに違反していないか確認する
3. 静的サイト・WordPress共通のフロントエンド品質チェックを実施する
4. WordPress案件ではWordPress固有の品質チェックを実施する
5. 本番公開前・納品前チェックを実施する
6. 問題があれば修正してからコードを出力する
7. すべて問題がなければ「納品・提出可能」と判断する
