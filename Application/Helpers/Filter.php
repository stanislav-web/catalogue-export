<?php
namespace Application\Helpers;

/**
 * Class Filter
 *
 * @package Application\Helpers
 */
class Filter {

    /**
     * Filtering request URI
     *
     * @param $url
     * @return array ['path', 'query']
     */
    public static function filterRequestUrl($url) {

        // parse path
        $path = explode('/', (parse_url($url, PHP_URL_PATH)));

        // parse query string
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        return [
            'path' => array_map(function($v) {
                return trim(strip_tags($v));
            }, $path),
            'query'=> array_map(function($v) {
                return trim(strip_tags($v));
            },$query)
        ];
    }
}