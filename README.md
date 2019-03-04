y-kuro/px2-contents-validator
=========

validate contents for px2

## Usage - 使い方

Pickles 2 の `config.php` に定義します。

```php
	/**
	 * processor
	 */
	$conf->funcs->processor = new stdClass;

	$conf->funcs->processor->html = array(

		// バリデーション
		'ykuro\contentsValidator\validator::exec('.json_encode( array(
			// バリデーション規則の定義
			'rules' => array(
				// CSVファイルで定義 (複数指定可)
				'csv' => array(
					'./px-files/validator/for_validate.csv',
				),
			),
		) ).')' ,

	);
```

CSVファイルのフォーマットは次の通りです。

- A列: キーワード
- B列: バリデーション方法
- C列: エラーメッセージ

バリデーション方法には、次の種類があります。

- not_contain (default) = キーワードは含まれないべき。キーワードが含まれれば警告する。
- contain = キーワードは含まれるべき。キーワードが含まれなければ警告する。

バリデーションを通らなかった場合、 Pickles 2 はエラーを出力します。
このエラーは、プレビュー時に画面上に赤枠で表示されます。
または パブリッシュエラーとして 報告されます。
