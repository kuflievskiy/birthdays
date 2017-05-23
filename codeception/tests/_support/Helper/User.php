<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class User extends \Codeception\Module
{
    public function provideTestUserData() {

        return [
            'email' => 'test@gmail.com',
            'skype' => 'testme',
            'first_name' => 'test first name',
            'last_name' => 'test last name',
            'birthday_date' => '1987-12-13',
            'password' => 'testpassword',
            'wishlist' => 'test wishlist data should be here',
        ];
    }
}
