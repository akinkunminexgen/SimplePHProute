<?php
//To call subfolders: so autoload can locate the file through
use Frontpages\History as Fhistory;
use Backpages\History as Bhistory;
use Frontpages\{AboutUs, Authors, ContactUs};
//using example of two history is to showcase the power of namespaces


//creating different routes to every webpage
Routes::get('', function() {
  IndexController::CreateView('Index');
});

Routes::group(['prefix' => 'products'], function() {

  Routes::get('/', function($theRoute) {
    ProductController::CreateView($theRoute);
  });
  Routes::groupEnd();
});

Routes::enableMiddleware();
Routes::group(['prefix' => 'backpages', 'middleware' => 'auth;role' /*adding more than one role*/], function() {
    Routes::get('history', function($go) {
      BHistory::CreateView($go);
    });

    Routes::group(['prefix' => 'colorpatterns'], function() {

      Routes::get('red', function($go) {
        IndexController::CreateView($go);
      });
    
      Routes::get('blue', function($go) {
        IndexController::CreateView($go);
      });
    });

    Routes::groupEnd();
});
Routes::group(['prefix' => 'categories'], function() {

  Routes::get('/', function($theRoute) {
    CategoryController::CreateView($theRoute);
  });
  Routes::groupEnd();
});


Routes::enableMiddleware(); // this must be declared before a group that has middleware
Routes::group(['prefix' => 'frontpages', 'middleware' => 'role'], function() {

  Routes::get('history', function($go) {
    FHistory::CreateView($go);
  });

  Routes::get('about-us', function() {
    AboutUs::CreateView('AboutUs');
  });
  Routes::groupEnd();
});


Routes::get('404', function() {
  Controller::view('./views/404.php');
  //AboutUs::test();
});

//to populate every route listed above
Routes::populate();
 ?>
