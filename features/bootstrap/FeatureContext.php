<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Behat\Hook\Scope\AfterScenarioScope;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    /**
     * @var \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected $webDriver;


    protected $baseUrl;


    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {

        $this->baseUrl = "https://facebook.com";
    }



    /**
     * @Given I have a web browser
     */
    public function iHaveAWebBrowser()
    {

    }

    /**
     * @When I load the homepage
     */
    public function iLoadTheHomepage()
    {
        $this->webDriver->get($this->baseUrl."/");
    }


    /**
     * @When I load the about us
     */
    public function iLoadTheAboutUs()
    {
        $this->webDriver->get($this->baseUrl."/facebook");
    }


    /**
     * @param  $content
     * @Then I should see :content
     * @throws Exception
     */
    public function iShouldSee($content)
    {
        $pageSource = $this->webDriver->getPageSource();
        $contentFound = strpos($pageSource, $content);
        if($contentFound===false){
            throw new Exception("Cannot find content ". $content);
        }
    }


    /**
     * @param  $linkText
     * @Then I Should see :arg1  link
     * @throws Exception
     */
    public function iShouldSeeLink($linkText)
    {
        $link = $this->webDriver->findElement(WebDriverBy::linkText($linkText));
        /**
         * check if link exist
         */
        if(!$link){
            throw new Exception("There is no $linkText");
        }
        /**
         * check if link visible or not
         */
        if(!$link->isDisplayed()){
            throw new Exception("$linkText is not displayed");
        }

    }



    /**
     * @BeforeScenario
     * @param BeforeScenarioScope $event
     */
    public function openWebBrowser(BeforeScenarioScope $event)
    {
        $capabilities = DesiredCapabilities::firefox();
        $this->webDriver = RemoteWebDriver::create("http://localhost:4444/wd/hub", $capabilities);
    }

    /**
     * @AfterScenario
     * @param AfterScenarioScope $event
     */
    public function closeWebBrowser(AfterScenarioScope $event)
    {
        if($this->webDriver) $this->webDriver->quit();
    }

}
