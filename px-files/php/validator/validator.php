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

            $patterns = array(
            	 '/<div>(.*)<div>/s',
            	 '/<span>(.*)<span>/s',
            );

            $errormese = array(
            	'divが2つ並んでいます',
            	'spanが2つ並んでいます',
            );

            foreach( $patterns as $key => $pattern) {
            	if( preg_match($pattern, $src)){
	            	$px->error( htmlspecialchars("エラー${errormese[$key]}が発生しました！") );
	            }
            }

            // $src = \Michelf\MarkdownExtra::defaultTransform($src);

            $px->bowl()->replace( $src, $key );
        }

        return true;
    }
}