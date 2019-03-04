<?php

/**
 * HTML Validator
 */
namespace ykuro\contentsValidator;

/**
 * processor "validator" class
 */
class validator{

	/** Pickles Object */
	private $px;

	/** Plugin Options */
	private $plugin_options;


	/**
	 * 変換処理の実行
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_options プラグイン設定
	 */
	public static function exec( $px, $plugin_options ){
		$validator = new self($px, $plugin_options);
		$validator->validate();
		return true;
	}

	/**
	 * Constructor
	 * @param object $px Picklesオブジェクト
	 * @param object $plugin_options プラグイン設定
	 */
	public function __construct( $px, $plugin_options ){
		$this->px = $px;
		$this->plugin_options = json_decode(json_encode($plugin_options), true);
	}

	/**
	 * バリデーションを実行する
	 */
	private function validate(){

		foreach( $this->px->bowl()->get_keys() as $key ){
			$src = $this->px->bowl()->pull( $key );

			if( is_array( $this->plugin_options['rules']['csv'] ) ){
				foreach( $this->plugin_options['rules']['csv'] as $csv_file_path ){

					$csv_rows = $this->px->fs()->read_csv( $csv_file_path );

					/*if( preg_match( '/[Ａ-Ｚ０-９]/', $src )){
						$this->px->error( "全角英数字がありますが問題ありませんか？" );
					};*/

					foreach ($csv_rows as $csv_row) {
						$keyword = $csv_row[0];
						$method = strtolower($csv_row[1]);
						$error_msg = $csv_row[2];

						if( !strlen($method) ){ $method = 'not_contain'; }

						$preg_result = preg_match( '/'.preg_quote($keyword, '/').'/s', $src );
						switch( $method ){
							case 'contain':
								if( !$preg_result ){
									$this->px->error( "validationERROR: ".$error_msg );
								}
								break;
							case 'not_contain':
								if( $preg_result ){
									$this->px->error( "validationERROR: ".$error_msg );
								}
								break;
						}
					};

				}
			}

			$this->px->bowl()->replace( $src, $key );
		}

		return true;
	}

}
