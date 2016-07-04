<?php

use Abraham\TwitterOAuth\TwitterOAuth;
use App\Api\TweetsJsonPresenter;
use App\Domain\TweeterUserId;
use App\Infrastructure\Persistence\TweeterRestApiRepository;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{

    private $presenter;
    private $repositoryResponse;
    private $resultPresenter;
    private $twitterConnection;
    private $tweeterRepository;
    private $cacheClient;
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->presenter=new TweetsJsonPresenter();
        $this->resultPresenter=unserialize(base64_decode(
            file_get_contents(__DIR__.'/../resources/formated.result.presenter')
        ));
        $this->twitterConnection= new TwitterOAuth(
        TweeterRestApiRepository::$_TWEETER_CONSUMER_KEY,
        TweeterRestApiRepository::$_TWEETER_CONSUME_SECRET,
        TweeterRestApiRepository::$_TWEETER_ACCESS_TOKEN,
        TweeterRestApiRepository::$_TWEETER_ACCESS_TOKEN_SECRET
        );
        $this->tweeterRepository=new TweeterRestApiRepository($this->twitterConnection);

    }

    /**
     * @When : I request :arg1 twits for a given screen_name
     */
    public function iRequestTwitsForAGivenScreenName($arg1)
    {
        $this->repositoryResponse=
            unserialize(base64_decode(file_get_contents(
                __DIR__.'/../resources/repository.response.txt'
            )));

    }


    /**
     * @Then : I should receive :arg1 twits in a correct format
     */
    public function iShouldReceiveTwitsInACorrectFormat($arg1)
    {
        $result=$this->presenter->write($this->repositoryResponse);
        PHPUnit_Framework_Assert::assertSame($result,$this->resultPresenter);
    }

    /**
     * @Then : I should receive :arg1 twits in format which we can parse.
     */
    public function iShouldReceiveTwitsInFormatWhichWeCanParse($arg1)
    {
        $this->repositoryResponse=
            unserialize(base64_decode(file_get_contents(
                __DIR__.'/../resources/repository.response.txt'
            )));
        $result=$this->tweeterRepository->findTweetsByUser(new TweeterUserId('@mariotux'),10);
        PHPUnit_Framework_Assert::assertEquals($result,$this->repositoryResponse);
    }
}
