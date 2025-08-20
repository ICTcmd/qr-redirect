<?php
// 1. Validate slug
$slug = preg_replace('/[^A-Za-z0-9_-]/', '', $_POST['slug']);

// 2. Save the uploaded file
$uploads = __DIR__ . '/../uploads/';
$ext     = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$dest    = $uploads . $slug . '.' . $ext;
move_uploaded_file($_FILES['file']['tmp_name'], $dest);

// 3. Update redirects.json
$jsonFile = __DIR__ . '/../redirects.json';
$map      = json_decode(file_get_contents($jsonFile), true);
$map[$slug] = 'https://qrgeneratormax.rf.gd/uploads/' . $slug . '.' . $ext;
file_put_contents($jsonFile, json_encode($map, JSON_PRETTY_PRINT));

// 4. Generate the QR code
require __DIR__ . '/../phpqrcode/qrlib.php';
$qrPath = __DIR__ . '/../qrcodes/' . $slug . '.png';
$data   = 'https://ictcmd.github.io/qr-redirect/' . $slug;
QRcode::png($data, $qrPath, QR_ECLEVEL_L, 4);

// 5. Show the result
echo "<h1>Done!</h1>";
echo "<p>Image → <a href=\"{$map[$slug]}\">{$map[$slug]}</a></p>";
echo "<p>QR Code → <img src=\"/qrcodes/{$slug}.png\"></p>";
