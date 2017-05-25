## Travis CI

Master branch : [![Build Status](https://travis-ci.org/kuflievskiy/birthdays.svg?branch=master)](https://travis-ci.org/kuflievskiy/birthdays)

Development branch : [![Build Status](https://travis-ci.org/kuflievskiy/birthdays.svg?branch=development)](https://travis-ci.org/kuflievskiy/birthdays)
   

## BDD 

http://codeception.com/docs/07-BDD

```bash
php vendor/bin/codecept g:feature acceptance signup
php vendor/bin/codecept dry-run acceptance signup.feature
php vendor/bin/codecept gherkin:snippets signup
php vendor/bin/codecept gherkin:steps acceptance
php vendor/bin/codecept run -g signup --html --debug --colors --steps

php vendor/bin/codecept generate:cest functional API
```

samples

https://github.com/edno/codeception-gherkin-param/blob/master/tests/acceptance/GherkinParam.feature

https://github.com/llvdl/dominoes-slim/tree/252519252e3cd884ab702f9e6390ab265eb36bff

## API

##### Method `/test/` is used to check if API access allowed.

```bash
curl -i -X GET -H 'X-SecretKey: xxxxxx' http://set.domain.name.here/api/v1/test/
```

##### Method `/calendar/2017/` is used to fetch all birthdays.

```bash
curl -i -X GET -H 'X-SecretKey: xxxxxx' http://set.domain.name.here/api/v1/calendar/2017/
```

##### Method `/calendar/2017/04/` is used to fetch birthdays for a month.

```bash
curl -i -X GET -H 'X-SecretKey: xxxxxx' http://set.domain.name.here/api/v1/calendar/2017/04/
```

##### Method `/calendar/2017/04/05/` is used to fetch birthdays for a day.

```bash
curl -i -X GET -H 'X-SecretKey: xxxxxx' http://set.domain.name.here/api/v1/calendar/2017/04/05/
```