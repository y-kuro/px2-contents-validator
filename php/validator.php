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

            $csvs = $px->fs()->read_csv(__DIR__.'/for_validate.csv');

            /*if( preg_match( '/[Ａ-Ｚ０-９]/', $src )){
                $px->error( htmlspecialchars( "全角英数字がありますが問題ありませんか？" ) );
            };*/

            foreach ($csvs as $csv) {
                if( preg_match( '/'.preg_quote($csv[0]).'/', $src )){
                    $px->error( htmlspecialchars( "validationERROR・${csv[1]}" ) );
                };
            };



            $px->bowl()->replace( $src, $key );
        }

        return true;
    }
}