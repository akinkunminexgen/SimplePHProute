<?php

//to load class files from different folder so as to ignore requre_once etc
//note: no subfolders can be loaded, namespace must be used as an identifier
function myAutoload($class_name)
 {
   //echo $class_name.'<br>';
   if (file_exists( __DIR__.'/classes/'.$class_name.'.php'))
      {
          require_once __DIR__.'/classes/'.$class_name.'.php';
      }
      elseif (file_exists( __DIR__.'/Controllers/'.$class_name.'.php'))
        {
            require_once  __DIR__.'/Controllers/'.$class_name.'.php';
        }
      elseif (file_exists( __DIR__.'/Models/'.$class_name.'.php'))
          {
              require_once  __DIR__.'/Models/'.$class_name.'.php';
          }
    elseif (file_exists( __DIR__.'/Config/'.$class_name.'.php'))
    {
        require_once  __DIR__.'/Config/'.$class_name.'.php';
    }
          /*elseif (file_exists( __DIR__.'/'.$class_name.'.php'))
              {
                  require_once  __DIR__.'/'.$class_name.'.php';
              }*/
}

 spl_autoload_register('myAutoload');
  require_once('Routes.php');

 ?>
