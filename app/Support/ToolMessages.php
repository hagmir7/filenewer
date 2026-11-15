<?php

namespace App\Support;

use Illuminate\Support\Str;

class ToolMessages
{
    public static function html(string $html): string
    {
        $parts = preg_split('/(<(?:"[^"]*"|\'[^\']*\'|[^\'">])*>)/s', $html, -1, PREG_SPLIT_DELIM_CAPTURE);
        $skip = 0;

        foreach ($parts as &$part) {
            if (str_starts_with($part, '<')) {
                if (preg_match('/^<\s*(\/?)\s*(pre|code|script|style|textarea)\b/i', $part, $tag)) {
                    $skip += $tag[1] === '/' ? -1 : 1;
                    $skip = max(0, $skip);
                }

                if ($skip === 0) {
                    $part = preg_replace_callback('/\b(title|aria-label|placeholder)=("|\')(.*?)\2/s', function (array $match): string {
                        $value = html_entity_decode($match[3], ENT_QUOTES | ENT_HTML5, 'UTF-8');

                        return $match[1].'='.$match[2].e(self::text($value)).$match[2];
                    }, $part);
                }
            } elseif ($skip === 0) {
                $decoded = html_entity_decode($part, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                $key = Str::squish($decoded);

                if (self::hasCopy($key)) {
                    preg_match('/^\s*/u', $part, $leading);
                    preg_match('/\s*$/u', $part, $trailing);
                    $part = $leading[0].e(self::text($key)).$trailing[0];
                }
            }
        }

        return implode('', $parts);
    }

    private static function text(string $text): string
    {
        $key = Str::squish($text);

        return self::hasCopy($key) ? (string) __($key) : $text;
    }

    private static function hasCopy(string $text): bool
    {
        $withoutParameters = preg_replace('/:[A-Za-z_][A-Za-z_0-9]*/', '', $text);

        return (bool) preg_match('/[A-Za-z]{2}/', $withoutParameters);
    }
}
