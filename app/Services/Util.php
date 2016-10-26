<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/26
 * Time: 14:14
 */

namespace App\Services;


class Util
{

    public static function replaceToTemplate( $body_json, $replace_patterns ){
        $patterns = [];
        $replacements = [];
        foreach ( $replace_patterns as $key => $value){
            $patterns[] = "/$key/";
            $replacements[] = $value;
        }
        return preg_replace( $patterns, $replacements, $body_json);
    }

}