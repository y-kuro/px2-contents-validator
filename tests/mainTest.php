<?php
/**
 * test for Pickles 2 Validator
 */
class mainTest extends PHPUnit_Framework_TestCase{
	private $fs;

	public function setup(){
		mb_internal_encoding('UTF-8');
		$this->fs = new tomk79\filesystem();
	}


	/**
	 * 普通にインスタンス化して実行してみるテスト
	 */
	public function testStandard(){
		// トップページを実行
		$output = $this->passthru( [
			'php',
			__DIR__.'/testdata/standard/.px_execute.php' ,
			'-o', 'json',
			'/' ,
		] );
		// var_dump($output);
		$output = json_decode($output);
		// var_dump($output->errors);

		$this->assertSame( count($output->errors), 1 );
		$this->assertSame( $output->errors[0], 'validationERROR: コメント "comment_area_check" が含まれていません。含めてください。' );


		// 後始末
		$output = $this->passthru( [
			'php', __DIR__.'/testdata/standard/.px_execute.php', '/?PX=clearcache'
		] );
		clearstatcache();
		$this->assertTrue( !is_dir( __DIR__.'/testdata/standard/caches/p/' ) );
		$this->assertTrue( !is_dir( __DIR__.'/testdata/standard/px-files/_sys/ram/caches/sitemaps/' ) );

	}

	/**
	 * コマンドを実行し、標準出力値を返す
	 * @param array $ary_command コマンドのパラメータを要素として持つ配列
	 * @return string コマンドの標準出力値
	 */
	private function passthru( $ary_command ){
		set_time_limit(60*10);
		$cmd = array();
		foreach( $ary_command as $row ){
			$param = escapeshellcmd($row);
			array_push( $cmd, $param );
		}
		$cmd = implode( ' ', $cmd );
		ob_start();
		passthru( $cmd );
		$bin = ob_get_clean();
		set_time_limit(30);
		return $bin;
	}
}
