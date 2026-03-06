<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$routes = ['/', '/destinations', '/faq', '/about', '/tours'];

echo "--- Route Test ---\n";
foreach ($routes as $path) {
    try {
        $request = Illuminate\Http\Request::create($path, 'GET');
        $response = $kernel->handle($request);
        echo "PATH: $path | STATUS: " . $response->getStatusCode() . "\n";
    } catch (\Exception $e) {
        echo "PATH: $path | ERROR: " . $e->getMessage() . "\n";
    }
}
echo "------------------\n";
