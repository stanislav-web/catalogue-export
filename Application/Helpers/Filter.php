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
        $path = trim(parse_url($url, PHP_URL_PATH), '/');
        $path_chunks = preg_split('/\/+/', $path);
        $chunks = [];

        for($i = 0, $count = count($path_chunks); $i < $count; $i += 2) {
            $chunks[$path_chunks[$i]] = trim(strip_tags($path_chunks[$i + 1]));
        }
        // parse query string
        parse_str(parse_url($url, PHP_URL_QUERY), $query);

        return [
            'path' => $chunks,
            'query'=> array_map(function($v) {
                return trim(strip_tags($v));
            },$query)
        ];
    }
}