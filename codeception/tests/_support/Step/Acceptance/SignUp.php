<?php
namespace Step\Acceptance;

require_once dirname(dirname(dirname( __FILE__ ))) .'/Helper/User.php';

/**
 * class SignUp
 **
 * */
class SignUp {

    protected $I;

    /**
     * @param \AcceptanceTester $I
     */
    public function __construct( \AcceptanceTester $I, \Helper\User $u ) {
        $this->I = $I;
        $this->userHelper = $u;

        $this->userData = $this->userHelper->provideTestUserData();
    }

    /**
     * @Given I open home page
     */
    public function iOpenHomePage()
    {
        $this->I->amOnPage('/');
    }

    /**
     * @When I click on `Create Account` tab
     */
    public function iClickOnCreateAccountTab()
    {
        $this->I->click('Create Account');
    }

    /**
     * @When I see submit form
     */
    public function iSeeSubmitForm()
    {
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="email"]');
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="skype"]');
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="first_name"]');
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="last_name"]');
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="birthday_date"]');
        $this->I->seePageHasElement('form[action="/sign-up"] input[name="password"]');
        $this->I->seePageHasElement('form[action="/sign-up"] textarea[name="wishlist"]');
    }

    /**
     * @Then I submit the form
     */
    public function iSubmitTheForm()
    {
        $this->I->fillField('form[action="/sign-up"] input[name=email]', $this->userData['email']);
        $this->I->fillField('form[action="/sign-up"] input[name=skype]', $this->userData['skype']);
        $this->I->fillField('form[action="/sign-up"] input[name=first_name]', $this->userData['first_name']);
        $this->I->fillField('form[action="/sign-up"] input[name=last_name]', $this->userData['last_name']);

        //$this->I->fillField('form[action="/sign-up"] input[name=birthday_date]', $this->userData['birthday_date']);
        $this->I->executeJS('jQuery(\'form[action=\"/sign-up\"] input[name=birthday_date]\').val(\'' . $this->userData['birthday_date'] . '\')');

        $this->I->fillField('form[action="/sign-up"] input[name=password]', $this->userData['password']);
        $this->I->fillField('form[action="/sign-up"] textarea[name=wishlist]', $this->userData['wishlist']);
        $this->I->click('form[action="/sign-up"] button' );
    }

    /**
     * @Then See my birthday on calendar
     */
    public function seeMyBirthdayOnCalendar()
    {
        $this->I->seeCurrentUrlEquals( '/calendar/' . date('Y') );

        $this->I->see( $this->userData['first_name'] . ' ' . $this->userData['last_name'] );
    }

    /**
     * @Then I click on `Profile` link
     */
    public function iClickOnProfileLink()
    {
        $this->I->click( 'Profile' );
    }

    /**
     * @Then See valid data
     */
    public function seeValidData()
    {
        $this->I->assertEquals($this->I->grabValueFrom('input[name="email"]'), $this->userData['email']);
        $this->I->assertEquals($this->I->grabValueFrom('input[name="skype"]'), $this->userData['skype']);
        $this->I->assertEquals($this->I->grabValueFrom('input[name="first_name"]'), $this->userData['first_name']);
        $this->I->assertEquals($this->I->grabValueFrom('input[name="last_name"]'), $this->userData['last_name']);
        $this->I->assertEquals($this->I->grabValueFrom('input[name="birthday_date"]'), $this->userData['birthday_date']);
        $this->I->assertEquals($this->I->grabValueFrom('textarea[name="wishlist"]'), $this->userData['wishlist']);
    }

}