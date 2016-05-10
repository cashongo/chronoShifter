[![Build Status](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/?branch=master)

# ChronoShifter

## PHP framework for navigating through time using the Gregorian calendar.

## Contents

### Shifters

Shifters transform time.

```
use COG\ChronoShifter\Direction\Increasing;
use COG\ChronoShifter\Period\Month;
use COG\ChronoShifter\Selector\Specific;
use COG\ChronoShifter\Shifter\ChronoShifter;

$shifter = new ChronoShifter(new Month('2015-01-05'), new Specific(new Increasing(), 5));
$shifter->next('2015-01-05'); // '2015-02-05'
```

Shifters are designed to be composable and extendible. The number of combinations they can be used in is high, and it
is fairly simple to create new shifters, directions, periods, and selectors.

There are more shifters available to combine or alter the results.

### Periods

Periods encapsulate the logic how to traverse between periods. Periods are commonly used for answering questions such as
"When is the first Friday of this month?"

```
use COG\ChronoShifter\Period\Month;

$month = new Month('2015-01-12');
$month->getStartDate(); // '2015-12-01'
$month->getEndDate(); // '2015-12-31'
$month->next();
$month->getStartDate(); // '2015-01-01'
$month->getEndDate(); // '2015-01-31'
```

IsoChronic period represents an evenly divided period of time.

```
use COG\ChronoShifter\Period\IsoChronic;

$iso = new IsoChronic('2015-01-11', '2015-01-11', 7);
$iso->getStartDate(); // '2015-01-11'
$iso->getEndDate(); // '2015-01-17'
$iso->next();
$iso->getStartDate(); // '2015-01-18'
$iso->getEndDate(); // '2015-01-24'
```

### Evaluators

Evaluators encapsulate facts about dates.

```
use COG\ChronoShifter\Evaluator\DayOfWeek;

$evaluator = new DayOfWeek(DayOfWeek::MONDAY);
$evaluator->is('2015-01-24'); // False
```

There are 5 evalutors for basic facts about dates, and logical evaluators
AND/OR/NOT to support combining the evaluators however necessary:

* `DayOfWeek($dayOfWeek : int)`
* `Holiday($holidayProvider : HolidayProvider);`
* `Weekday();`
* `Weekend();`
* `Workday($holidayProvider : HolidayProvider);`
* `LogicalAnd($first : Evaluator, $second : Evaluator);`
* `LogicalOr($first : Evaluator, $second : Evaluator);`
* `LogicalNot($evaluator : Evaluator);`

### Selectors

Selectors use a period, direction and evaluator to find a match.

* `FirstOf($direction : Direction, $evaluator : Evaluator);`
* `LastOf($direction : Direction, $evaluator : Evaluator);`
* `Specific($direction : Direction, $number : int);`

### Directions

Directions specify how to traverse between periods. There are two supplied with
ChronoShifter: increment to future or decrement to past.

* `Increasing();`
* `Decreasing();`

### HolidayProvider

There are many ways how to represent holidays, and ChronoShifter provides
an interface, so you can plug in your application's holiday logic.

```
use COG\ChronoShifter\HolidayProvider\ArrayHolidayProvider;

$holidayProvider = new ArrayHolidayProvider(array('2015-01-01'));
$holidayProvider->isHoliday('2014-12-31'); // False
$holidayProvider->isHoliday('2015-01-01'); // True
```

## Examples

* [Day of Month, Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/DayOfMonthIncrement.html)
* [Day of Month, Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/DayOfMonthDecrement.html)
* [Isochronic (7d), Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/IsochronicIncrement-1.html)
* [Isochronic (7d), Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/IsochronicDecrement-1.html)
* [Isochronic (14d), Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/IsochronicIncrement-2.html)
* [Isochronic (14d), Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/IsochronicDecrement-2.html)
* [Monthly First Day of Week, Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyFirstDayOfWeekIncrement.html)
* [Monthly First Day of Week, Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyFirstDayOfWeekDecrement.html)
* [Monthly Last Day of Week, Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyLastDayOfWeekIncrement.html)
* [Monthly Last Day of Week, Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyLastDayOfWeekDecrement.html)
* [Monthly First Workday, Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyFirstWorkdayIncrement.html)
* [Monthly First Workday, Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyFirstWorkdayDecrement.html)
* [Monthly Last Workday, Increment](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyLastWorkdayIncrement.html)
* [Monthly Last Workday, Decrement](https://htmlpreview.github.io/?https://github.com/cashongo/chronoShifter/blob/master/examples/MonthlyLastWorkdayDecrement.html)
