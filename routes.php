<?php
/**
 * Created by PhpStorm.
 * User: munxar
 * Date: 06.02.2017
 * Time: 09:55
 */
use Illuminate\Support\Facades\Route;

/**
 * returns the image url for a vimeo image
 */
Route::get('images/vimeo/{movie_id}', function() {

    return "tada";
});