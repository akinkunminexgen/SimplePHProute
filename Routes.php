<?php
//To call subfolders: so autoload can locate the file through
use Frontpages\History as Fhistory;
use Backpages\History as Bhistory;
use Frontpages\{AboutUs, Authors, ContactUs};
//using example oftwo history is to showcase the power of namespaces


//creating different routes to every webpages
Routes::set('', function() {
  Index::CreateView('Index');
});

//Routes::group(['namespace'=> 'backpages'],
Routes::set('backpages/history', function() {
  BHistory::CreateView('backpages/history');
  //AboutUs::test();
});

//);

Routes::set('frontpages/history', function() {
  Fhistory::CreateView('frontpages/history');
  //AboutUs::test();
});

Routes::set('contact-us', function() {
  ContactUs::CreateView('ContactUs');
});

Routes::set('authors', function() {
  Authors::CreateView('Authors');
});

Routes::set('frontpages/about-us', function() {
  AboutUs::CreateView('AboutUs');
  //AboutUs::test();
});

Routes::set('404', function() {
  Controller::view('./views/404.php');
  //AboutUs::test();
});

//to populate every route listed above
Routes::populate();
 ?>
