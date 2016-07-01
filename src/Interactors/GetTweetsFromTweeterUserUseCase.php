<?php
namespace App\Interactors;
use App\Domain\TweeterRepository;
use App\Domain\TweetsPresenter;

/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 1/7/16
 * Time: 15:52
 */
class GetTweetsFromTweeterUserUseCase
{
    /** @var  TweeterRepository */
    private $repository;

    private $presenter;

    public function __construct(
        TweeterRepository $repository,
        TweetsPresenter $presenter
    )
    {
        $this->presenter=$presenter;
        $this->repository=$repository;
    }

    public function execute(GetTweetsFromTweeterUserRequest $request)
    {
        $this->presenter->write(
            $this->repository->findTweetsByUser($request->user(),$request->quantity())
        );
    }
}