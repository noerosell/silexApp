<?php
/**
 * Created by PhpStorm.
 * User: noe.rosell
 * Date: 3/7/16
 * Time: 17:55
 */

namespace Test\Interactors;


use App\Infrastructure\Persistence\TweeterRestApiRepository;
use App\Api\TweetsJsonPresenter;
use App\Interactors\GetTweetsFromTweeterUserRequest;
use App\Interactors\GetTweetsFromTweeterUserUseCase;
use App\Domain\TweeterUserId;
use App\Domain\TweeterUser;

class GetTweetsFromTweeterUserUseCaseTest extends \PHPUnit_Framework_TestCase
{
    private $repository;
    private $presenter;
    private $request;
    private $userId;

    private $tweeterUser;

    protected function setUp()
    {
        $this->repository=$this->getMockBuilder(TweeterRestApiRepository::class)
            ->disableOriginalConstructor()->getMock();

        $this->presenter=$this->getMockBuilder(TweetsJsonPresenter::class)->disableOriginalConstructor()->getMock();

        $this->request=$this->getMockBuilder(GetTweetsFromTweeterUserRequest::class)
            ->disableOriginalConstructor()->getMock();

        $this->userId=$this->getMockBuilder(TweeterUserId::class)->disableOriginalConstructor()->getMock();

    }

    public function testAnErrorFormatIsPresentedWhenSomethingGoesWrong()
    {
        $this->repository->expects($this->once())->method('findTweetsByUser')
            ->will($this->throwException(new \Exception('Bad luck',500)));

        $this->request->expects($this->once())->method('userId')->willReturn($this->userId);
        $this->request->expects($this->once())->method('quantity')->willReturn(10);

        $this->presenter->expects($this->once())->method('writeAnError');

        $useCase=new GetTweetsFromTweeterUserUseCase($this->repository,$this->presenter);
        $useCase->execute($this->request);
    }

    public function testWellFormatedResponseIsPresentedWhenAllGoesRight()
    {
        $this->tweeterUser=$this->getMockBuilder(TweeterUser::class)->disableOriginalConstructor()->getMock();

        $this->repository->expects($this->once())->method('findTweetsByUser')
            ->willReturn($this->tweeterUser);

        $this->request->expects($this->once())->method('userId')->willReturn($this->userId);
        $this->request->expects($this->once())->method('quantity')->willReturn(10);

        $this->presenter->expects($this->once())->method('write');

        $useCase=new GetTweetsFromTweeterUserUseCase($this->repository,$this->presenter);
        $useCase->execute($this->request);
    }
}