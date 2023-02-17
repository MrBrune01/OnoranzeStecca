<?php
function edit_page($DOM, $delimiter_string, $replace_string = '')
{
    if (isset($DOM)) {
        $start = strpos($DOM, $delimiter_string);
        $end = strpos($DOM, $delimiter_string, $start + 1);
        $DOM = substr_replace($DOM, '', $start, $end - $start);
        $DOM = str_replace($delimiter_string, $replace_string, $DOM);
        return $DOM;
    } else
        return '';
}
?>