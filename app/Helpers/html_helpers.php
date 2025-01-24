<?php
function truncateHtml($html, $limit)
{
    $dom = new DOMDocument();

    // Load HTML content safely
    @$dom->loadHTML(mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8'));

    $totalLength = 0;
    $output = '';

    // Get child nodes of the <body>
    $body = $dom->getElementsByTagName('body')->item(0);
    if (!$body) {
        return '';
    }

    foreach ($body->childNodes as $node) {
        if ($totalLength >= $limit) {
            break;
        }

        $nodeHtml = $dom->saveHTML($node);
        $nodeLength = strlen(strip_tags($nodeHtml));

        if ($totalLength + $nodeLength > $limit) {
            $remainingLength = $limit - $totalLength;
            $output .= substr(strip_tags($nodeHtml), 0, $remainingLength);
            break;
        } else {
            $output .= $nodeHtml;
            $totalLength += $nodeLength;
        }
    }

    return $output;
}
