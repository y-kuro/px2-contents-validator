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

					$csvs = $this->px->fs()->read_csv( $csv_file_path );

					/*if( preg_match( '/[Ａ-Ｚ０-９]/', $src )){
						$this->px->error( "全角英数字がありますが問題ありませんか？" );
					};*/

					foreach ($csvs as $csv) {
						if( preg_match( '/'.preg_quote($csv[0]).'/', $src )){
							$this->px->error( "validationERROR・${csv[1]}" );
						};
					};

				}
			}

			$this->px->bowl()->replace( $src, $key );
		}

		return true;
	}

}
