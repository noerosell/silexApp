<?php
namespace App {

    use Silex\Application;
    use Symfony\Component\HttpFoundation\Request;

    class defaultController
    {
        public function getTweets(Request $request, Application $app)
        {
            return 'HOLA';
        }

    }
}


