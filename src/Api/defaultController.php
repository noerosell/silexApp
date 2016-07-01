<?php
namespace App\Api {

    use App\Interactors\GetTweetsFromTweeterUserRequest;
    use App\Interactors\GetTweetsFromTweeterUserUseCase;
    use Silex\Application;
    use Symfony\Component\HttpFoundation\JsonResponse;
    use Symfony\Component\HttpFoundation\Request;
    use Symfony\Component\HttpFoundation\Response;

    class defaultController
    {
        public function getTweets(Request $request, Application $app)
        {

            /** @var  GetTweetsFromTweeterUserUseCase */
            $useCase=$app['get.tweets.from.tweeter.user'];
            $requestUseCase=new GetTweetsFromTweeterUserRequest(
                $request->get('tweeterUser'),
                $request->get('quantity')
            );
            $result=$useCase->execute($requestUseCase);

            return new JsonResponse($result,200);
        }

    }
}


