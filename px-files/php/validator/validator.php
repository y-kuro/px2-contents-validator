<?php

/**
 * HTML Validator
 */
namespace ykuro\contentsValidator;

/**
 * processor "validator" class
 */
class validator{

    /**
     * 変換処理の実行
     * @param object $px Picklesオブジェクト
     */
    public static function exec( $px, $json ){

        foreach( $px->bowl()->get_keys() as $key ){
            $src = $px->bowl()->pull( $key );

            $csv = $px->fs()->read_csv(__DIR__.'/test.csv');

            /*$csv  = array();
            $file = __DIR__.'/test.csv';
            $fp   = fopen($file, "r");
            var_dump( realpath('.'));
            var_dump( realpath('test.csv'));

            var_dump(__DIR__);
            var_dump(__FILE__);

            var_dump(__DIR__.'/test.csv');


             
            while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
              $csv[] = $data;
            }
            fclose($fp);*/

            var_dump($csv);


            /*$filename = './test.csv';
            if( ! file_exists( $filename ) ){
                die("ファイルが存在しません。");
            }*/

            /*// 文字化け対策
            // CSVファイルの中身をすべて取り出す
            $tmpCSV = file_get_contents( $filename );
            // 文字コードをUTF-8に変換
            $tmpCSV = mb_convert_encoding( $tmpCSV, 'UTF-8', 'CP932' );
            // 一時ファイルに保存
            $fp = tmpfile();
            fwrite( $fp, $tmpCSV );
            // ファイルポインタを先頭に戻す
            rewind( $fp );
            // ロケールを設定
            setlocale( LC_ALL, 'ja_JP, UTF-8' );

            // 1行づつ読み込み
            $lines = fgetcsv( $fp );
            list( $keywords, $errormese ) = $lines;
            $px->error( htmlspecialchars( "エラー${keywords}が発生しました！" ) );*/

            /*while( $arr = fgetcsv( $fp ) ){
                if( ! array_diff( $arr, array('') ) ){ // 空行を除外
                    continue;
                }
                list( $keywords, $errormese ) = $arr;
                $px->error( $arr[0] );
                if( preg_match( $keywords, $src )){
                    $px->error( htmlspecialchars( "エラー${errormese}が発生しました！" ) );
                }
            }*/

            /*foreach ($lines as $key => $line) {
                $errormese = explode(',', $line);
                if( preg_match($errormese[0], $src)){
                    $px->error( htmlspecialchars("エラー${errormese[1]}が発生しました！") );
                }
            }*/

            /*//ファイルロックを解除
            fflush( $fp );
            flock( $fp, LOCK_UN) ;
            //ファイルを閉じる
            fclose( $fp );*/

            $px->bowl()->replace( $src, $key );
        }

        return true;
    }
}