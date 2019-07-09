<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Base Path
    |--------------------------------------------------------------------------
    |
    | This value determines the base path that will be used to find relative
    | file assets. Usually, this path should be your public path.
    |
    */
    'base_path' => public_path(),

    /*
    |--------------------------------------------------------------------------
    | Query Parameter Version
    |--------------------------------------------------------------------------
    |
    | This value determines the query parameter that will be used to append
    | the version to an asset (i.e. example.css?v=231). If this value is kept
    | NULL, the asset's version will be appended in the URL before the
    | extension (i.e. example.231.css).
    |
    */

    'query_parameter_version' => null,
];
