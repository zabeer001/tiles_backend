<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Cross-Origin Resource Sharing (CORS) Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure your settings for cross-origin resource sharing
    | or "CORS". This determines what cross-origin operations may execute
    | in web browsers. You are free to adjust these settings as needed.
    |
    | To learn more: https://developer.mozilla.org/en-US/docs/Web/HTTP/CORS
    |
    */

    'paths' => ['api/*'], // Apply CORS to all API routes
    
    'allowed_methods' => ['*'], // Allow all HTTP methods (GET, POST, etc.)
    
    'allowed_origins' => ['http://localhost:3000'], // Only allow requests from Next.js dev server
    
    'allowed_origins_patterns' => [], // No regex patterns for origins
    
    'allowed_headers' => ['*'], // Allow all headers in requests
    
    'exposed_headers' => [], // Don't expose any special headers
    
    'max_age' => 0, // Don't cache preflight requests
    
     'supports_credentials' => true,
    

];
