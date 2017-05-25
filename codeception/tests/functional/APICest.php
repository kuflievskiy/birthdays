<?php

class APICest
{
    /**
     * __construct
     * */
    public function __construct()
    {

        $this->headerXSecretKey = 'Codeception';

    }

    public function _before(FunctionalTester $I)
    {
    }

    public function _after(FunctionalTester $I)
    {
    }

    /**
     * @param $I FunctionalTester
     * Method `/api/v1/test/` is used to check if API access allowed.
     * */
    public function test(FunctionalTester $I)
    {
        $I->wantTo( 'ensure that `/api/v1/test/` API method works' );

        $I->haveHttpHeader('X-SecretKey', $this->headerXSecretKey);
        $I->sendGET( '/api/v1/test/' );
        // {"success":true,"code":200,"message":"OK"}

        codecept_debug($I->grabResponse());

        $I->seeResponseCodeIs(200);
        $I->seeResponseContainsJson([
            'success' => true,
            'code' => 200,
            'message' => 'OK',
        ]);

        // {"success":false,"code":403,"message":"Forbidden"}
    }

    /**
     * @param $I FunctionalTester
     * Method `/api/v1/calendar/2017/` is used to fetch all birthdays.
     */
    public function testCalendarYear(FunctionalTester $I)
    {
        $I->wantTo( 'ensure that `/api/v1/calendar/2017/` API method works' );
        $I->haveHttpHeader('X-SecretKey', $this->headerXSecretKey);
        $I->sendGET( '/api/v1/calendar/2017/' );

        $response = $I->grabResponse();
        codecept_debug($response);

        $I->seeResponseCodeIs(200);

        /*
            [
                {
                    "id":1,
                    "email":"xxxxx@xxxx.xxx",
                    "created_at":"-0001-11-30 00:00:00",
                    "updated_at":"2017-05-19 15:20:55",
                    "first_name":"xxxxx",
                    "last_name":"xxxxx",
                    "birthday_date":"xxxx-xx-xx",
                    "wishlist":"xxxxx",
                    "user_activation_key":"",
                    "blocked":0,
                    "skype":"xxx"
                }
            ]
        */


        json_decode($response);
        $I->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    /**
     * @param $I FunctionalTester
     * Method `/api/v1/calendar/2017/04/` is used to fetch birthdays for a month.
     * */
    public function testCalendarYearMonth(FunctionalTester $I)
    {
        $I->wantTo( 'ensure that `/api/v1/calendar/2017/04/` API method works' );
        $I->haveHttpHeader('X-SecretKey', $this->headerXSecretKey);

        $I->sendGET( '/api/v1/calendar/2017/04/' );

        codecept_debug($I->grabResponse());
        $I->seeResponseCodeIs(200);

        $response = $I->grabResponse();

        json_decode($response);
        $I->assertEquals(JSON_ERROR_NONE, json_last_error());
    }

    /**
     * @param $I FunctionalTester
     * Method `/api/v1/calendar/2017/04/05/` is used to fetch birthdays for a day.
     * */
    public function testCalendarYearMonthDay(FunctionalTester $I)
    {
        $I->wantTo( 'ensure that `/api/v1/calendar/2017/04/05/` API method works' );
        $I->haveHttpHeader('X-SecretKey', $this->headerXSecretKey);

        $I->sendGET( '/api/v1/calendar/2017/04/05/' );

        codecept_debug($I->grabResponse());
        $I->seeResponseCodeIs(200);

        $response = $I->grabResponse();

        json_decode($response);
        $I->assertEquals(JSON_ERROR_NONE, json_last_error());
    }
}
