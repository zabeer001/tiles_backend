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
    
        'allowed_methods' => ['*'], // Allow all HTTP methods
    
        'allowed_origins' => ['http://localhost:3000'], // Allow requests from your Next.js frontend
    
        'allowed_origins_patterns' => [], // Use patterns if needed
    
        'allowed_headers' => ['*'], // Allow all headers
    
        'exposed_headers' => [], // Expose headers if needed
    
        'max_age' => 0, // Preflight request cache duration
    
        'supports_credentials' => false, // Set to true if using cookies or sessions
    

];
