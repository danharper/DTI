# DTI

Parse ISO 8601 dates and intervals.

[![Build Status](https://travis-ci.org/danharper/DTI.png?branch=master)](https://travis-ci.org/danharper/DTI)
[![Total Downloads](https://poser.pugx.org/danharper/dti/downloads)](https://packagist.org/packages/danharper/dti)

## Installation

Install via Composer by adding the following line to the dependencies in your composer.json:

```
danharper/dti: "~1.0"
```

And run `composer install`/`composer update`

## Usage

```php
$dti = new danharper\DTI;
```

Passing a single ISO 8601 datetime string will provide you with an array containing that time, and the current time.

```php
list($from, $to) = $dti->parse('2007-03-01T13:00:00Z');
```

Passing a single ISO 8601 duration string will substract that duration from the current time.

```php
list($from, $to) = $dti->parse('PT2H30M');
// from is set to 2h30m before the current time
```

Optionally, provide `parse()` with the default time to use instead of the current time:

```php
$dti->parse('PT2H30M', new DateTime('2001-01-01'));
```

Passing a ISO 8601 duration string consisting of two datetimes, will give you them:

```php
$dti->parse('2007-03-01T13:00:00Z/2008-05-11T15:30:00Z');
```

A duration string consisting of a datetime and a duration will give the datetime provided, and the datetime with the duration added to it.

```php
$dti->parse('2007-03-01T13:00:00Z/P1Y2M10DT2H30M');
```

And in reverse, will give you the datetime with the duration substracted, and the datetime:

```php
$dti->parse('PT2H30M/2007-03-01T13:00:00Z');
```
