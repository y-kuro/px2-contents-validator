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

            $src = \Michelf\MarkdownExtra::defaultTransform($src);

            $px->bowl()->replace( $src, $key );
        }

        return true;
    }
}