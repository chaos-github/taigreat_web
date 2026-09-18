<?php

$base = 'https://www.taigreat.com.tw/';
$items = [];
$seen = [];

for ($page = 1; $page <= 14; $page++) {
    $html = file_get_contents($base.'case.php?cID=0&page='.$page);
    if ($html === false) {
        fwrite(STDERR, "Failed to fetch page {$page}\n");
        continue;
    }

    preg_match_all(
        '/data-src="(upload\/product\/[^"]+)"[^>]*alt="([^"]*)"[\s\S]*?<span>(.*?)<\/span>\s*<h3>(.*?)<\/h3>/u',
        $html,
        $matches,
        PREG_SET_ORDER
    );

    echo "page {$page}: ".count($matches)." items\n";

    foreach ($matches as $match) {
        $remoteImage = $match[1];
        $image = 'upload/case/'.basename($remoteImage);
        $title = html_entity_decode(trim($match[4]), ENT_QUOTES, 'UTF-8');
        $category = html_entity_decode(trim($match[3]), ENT_QUOTES, 'UTF-8');
        $key = $image.'|'.$title;

        if (isset($seen[$key])) {
            continue;
        }

        $seen[$key] = true;
        $items[] = [
            'title' => $title,
            'category' => $category,
            'image' => $image,
        ];
    }

    usleep(200000);
}

$dir = __DIR__.'/../database/data';
if (! is_dir($dir)) {
    mkdir($dir, 0777, true);
}

file_put_contents($dir.'/cases.json', json_encode($items, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
echo 'saved '.count($items)." items\n";
