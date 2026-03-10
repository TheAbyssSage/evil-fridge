<?php
// generate_pdf.php

// 1. Make sure dompdf is installed via Composer
require __DIR__ . '/vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// 2. Basic validation: only allow POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo 'Method Not Allowed';
    exit;
}

// 3. Collect and sanitize user input
$keeperName  = isset($_POST['keeper_name']) ? trim($_POST['keeper_name']) : '';
$fridgeName  = isset($_POST['fridge_name']) ? trim($_POST['fridge_name']) : '';
$location    = isset($_POST['location']) ? trim($_POST['location']) : '';
$incantation = isset($_POST['incantation']) ? trim($_POST['incantation']) : '';

// Simple required fields check
if ($keeperName === '' || $fridgeName === '' || $location === '') {
    http_response_code(400);
    echo 'Missing required fields. Please go back and fill out the form.';
    exit;
}

// Escape values for safe HTML output in the PDF
function e(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

// If no incantation given, use a default one
if ($incantation === '') {
    $incantation = "By frosty coils and humming core,\nI seal your evil evermore.";
}

// 4. Build the HTML for the PDF
//    We keep it simple and styled inline. dompdf understands basic CSS.
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Fridge Seal of Containment</title>
    <style>
        body {
            font-family: DejaVu Sans, Arial, sans-serif;
            background-color: #f8fafc;
            color: #0f172a;
            margin: 0;
            padding: 0;
        }
        .page {
            padding: 40px;
            border: 4px double #0f172a;
        }
        h1, h2, h3 {
            text-align: center;
            margin: 0.4em 0;
        }
        h1 {
            font-size: 28px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        h2 {
            font-size: 18px;
            font-weight: normal;
        }
        .subtitle {
            text-align: center;
            margin-bottom: 20px;
            font-size: 12px;
            letter-spacing: 1px;
        }
        .section {
            margin-top: 20px;
        }
        .label {
            font-weight: bold;
        }
        .box {
            border: 1px solid #0f172a;
            padding: 10px;
            margin-top: 5px;
            min-height: 40px;
        }
        .incantation {
            white-space: pre-line; /* Keep line breaks from textarea */
            font-style: italic;
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #6b7280;
        }
        .seal-circle {
            margin: 25px auto 10px;
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 3px solid #b91c1c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="page">
    <h1>Fridge Seal of Containment</h1>
    <h2>Evil Fridge Containment Society</h2>
    <div class="subtitle">
        Official certificate for the binding and sealing of malevolent refrigerator entities.
    </div>

    <div class="section">
        <span class="label">Fridge Name / Alias:</span>
        <div class="box">' . e($fridgeName) . '</div>
    </div>

    <div class="section">
        <span class="label">Fridge Location:</span>
        <div class="box">' . e($location) . '</div>
    </div>

    <div class="section">
        <span class="label">Designated Fridge Keeper:</span>
        <div class="box">' . e($keeperName) . '</div>
    </div>

    <div class="section">
        <span class="label">Incantation of Binding:</span>
        <div class="box incantation">' . e($incantation) . '</div>
    </div>

    <div class="section">
        <div class="seal-circle">
            EVIL FRIDGE<br>
            CONTAINED &amp; SEALED
        </div>
        <p style="text-align: center; font-size: 11px;">
            Place this seal upon the fridge door to finalize containment.<br>
            For best results, apply under a flickering kitchen light.
        </p>
    </div>

    <div class="footer">
        Generated on ' . date('Y-m-d H:i') . ' &middot;
        This document is 100% parody and has no legal or supernatural power.
    </div>
</div>
</body>
</html>
';

// 5. Configure dompdf
$options = new Options();
$options->set('isRemoteEnabled', false); // No remote assets needed here
$dompdf = new Dompdf($options);

// Load HTML
$dompdf->loadHtml($html);

// Set paper size and orientation (A4 portrait)
$dompdf->setPaper('A4', 'portrait');

// Render PDF (this can be relatively heavy, but fine for single-page docs)
$dompdf->render();

// 6. Stream the file as a download
$fileNameSafe = preg_replace('/[^a-z0-9_\-]/i', '_', $fridgeName);
if ($fileNameSafe === '') {
    $fileNameSafe = 'evil_fridge_seal';
}

$dompdf->stream($fileNameSafe . '_seal.pdf', [
    'Attachment' => true, // true = force download
]);

exit;
