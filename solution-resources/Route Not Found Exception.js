Route::any('{url}', function(){
    // Redirect A User To The "404 Page" or specific route Laravel
    return redirect('/404');
    // Redirect Back User Is There If The Route Not Exist Or Face Not Found
    return back();
})->where('url', '.*');


// ref: https://www.insidethediv.com/laravel-route-not-found-exception
