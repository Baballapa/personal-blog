<?php
// https://stackoverflow.com/questions/965235/how-can-i-truncate-a-string-to-the-first-20-words-in-php
function limit_text($text, $limit)
{
    if (str_word_count($text, 0) > $limit) {
        $words = str_word_count($text, 2);
        $pos   = array_keys($words);
        $text  = substr($text, 0, $pos[$limit]) . '...';
    }
    return $text;
}
