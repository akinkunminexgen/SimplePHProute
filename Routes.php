<?php
//To call subfolders: so autoload can locate the file through
use Frontpages\History as Fhistory;
use Backpages\History as Bhistory;
use Frontpages\{AboutUs, Authors, ContactUs};
//using example of two history is to showcase the power of namespaces


//creating different routes to every webpage
Routes::get('', function() {
  Index::CreateView('Index');
});

Routes::group(['prefix' => 'backpages'], function() {

    Routes::get('history', function($go) {
      BHistory::CreateView($go);
    });

});

Routes::group(['prefix' => 'frontpages'], function() {

  Routes::get('history', function($go) {
    FHistory::CreateView($go);
  });

});


Routes::get('contact-us', function() {
  ContactUs::CreateView('ContactUs');
});

Routes::get('authors', function() {
  Authors::CreateView('Authors');
});

Routes::get('frontpages/about-us', function() {
  AboutUs::CreateView('AboutUs');
  //AboutUs::test();
});

Routes::get('404', function() {
  Controller::view('./views/404.php');
  //AboutUs::test();
});

//to populate every route listed above
Routes::populate();
 ?>
