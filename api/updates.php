<?php
define( 'API_URL', 'https://packages.wenmarkdigital.com/sellers-json/packages/' );

$pluginDirectory = '../packages/';
$pattern = '/sellers-json_(\d+\.\d+\.\d+)\.zip$/';

// Step 1: Retrieve all files in the /plugin/ directory matching the pattern
$files = glob($pluginDirectory . 'sellers-json_*.zip');

// Step 2: Sort the filenames by version number, descending
usort($files, function ($a, $b) {
    // Extract version numbers from filenames
    preg_match('/(\d+\.\d+\.\d+)/', $a, $versionA);
    preg_match('/(\d+\.\d+\.\d+)/', $b, $versionB);

    // Compare versions
    return version_compare($versionB[1], $versionA[1]);
});

header('Content-Type: application/json');
// Step 3: Return the first filename in a JSON object
if (!empty($files)) {
    $firstFile = $files[0];

    preg_match($pattern, $firstFile, $matches);

    $version = $matches[1];

    $result = [
        'version' => $version,
        'package' => API_URL . $matches[0],
    ];

    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo json_encode(['error' => 'No matching files found.'], JSON_PRETTY_PRINT);
}
