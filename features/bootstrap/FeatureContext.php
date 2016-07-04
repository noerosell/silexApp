<?php

use App\Api\TweetsJsonPresenter;
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
}
