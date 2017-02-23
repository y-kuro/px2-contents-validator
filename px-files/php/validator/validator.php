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

            $csvs = $px->fs()->read_csv(__DIR__.'/test.csv');

            /*$csv  = array();
            $file = __DIR__.'/test.csv';
            $fp   = fopen($file, "r");

            while (($data = fgetcsv($fp, 0, ",")) !== FALSE) {
              $csv[] = $data;
            }
            fclose($fp);*/

            //foreach ($csvs as $key => $csv) {
            foreach ($csvs as $csv) {
                if( preg_match( '/'.preg_quote($csv[0]).'/', $src )){
                    $px->error( htmlspecialchars( "エラー${csv[1]}が発生しました！" ) );
                };
            };

            $px->bowl()->replace( $src, $key );
        }

        return true;
    }
}