<?php

function printHelp($self, $options) {
    printf("Usage: %s [options]\n", $self);
    printf("Options:\n");
    foreach ($options as $option) {
        printf("  %s, %-32s %20s\n",
            $option[0],
            '--' . $option[1] . ($option[2] ? ' <' . $option[2] . '>' : ''),
            $option[3]
        );
    }
}

function parseOptions($options) {
    $opts = '';
    $longopts = [];
    foreach ($options as $option) {
        $required_value = $option[2] != false;

        $opts .= $option[0] . ($required_value ? ':' : '');
        $longopts[] = $option[1] . ($required_value ? ':' : '');
    }

    return getopt($opts, $longopts);
}


$self = $argv[0];
$base_url = "http://web4.cartoonmad.com";
$options = [
    // [opt, longopt, required_value, description]
    ["c", "comic", "comic_id", "The comic id from cartoonmad.com"],
    ["H", "hash", "url_hash", "The comic url hash from catoonmad.com"],
    ["e", "episod", "episod_number", "The comic episod number"],
    ["o", "output-dir", "directory_path", "Output directory path"],
    ["h", "help", false, "Print command line manual"]
];

if ($argc < 2) {
    printHelp($self, $options);
    exit;
}

$parsed_options = parseOptions($options);
if (empty($parsed_options)) {
    printHelp($self, $options);
    exit;
}

$comic_id = '';
$hash = '';
$episod = '';
$output_dir = '';
$print_help = false;

foreach ($parsed_options as $key => $value) {
    switch ($key) {
        case 'h':
        case 'help':
            $print_help = true;
            break;

        case 'c':
        case 'comic':
            $comic_id = $value;
            break;

        case 'H':
        case 'hash':
            $hash = $value;
            break;

        case 'e':
        case 'episod':
            $episod = str_pad($value, 3, '0', STR_PAD_LEFT);
            break;

        case 'o':
        case 'output-dir':
            $output_dir = $value;
            break;
    }
}

if ($print_help || 
    (empty($comic_id) || empty($hash) || empty($episod) || empty($output_dir))
) {
    printHelp($self, $options);
    exit;
}

if (!file_exists($output_dir)) {
    mkdir($output_dir);
}

foreach (range(1, 999) as $number) {
    $pic_number = str_pad($number, 3, '0', STR_PAD_LEFT); 
    $pic_url = "${base_url}/${hash}/${comic_id}/${episod}/{$pic_number}.jpg";

    $pic = file_get_contents($pic_url);
    if ($pic == false) {
        break;
    } else {
        $dest_file_name = "${output_dir}/${pic_number}.jpg";
        file_put_contents($dest_file_name, $pic);

        printf("%s --> %s\n", $pic_url, $dest_file_name);
    }
}

echo "Download complete!!\n";
