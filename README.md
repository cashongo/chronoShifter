[![Build Status](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/build.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/build-status/master)
[![Code Coverage](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/cashongo/chronoShifter/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/cashongo/chronoShifter/?branch=master)

# chronoShifter

## PHP iterators for moving around in time

Simple tools for traversal of Gregorian calendar.

## Glossary

* `Day of Month`: Numerical day of month 1-31, upper limit depends on given month.
* `Day of Week`: Monday - Sunday.
* `Workday`: A day of week that is not weekend or holiday.

## Examples

* [Day of Month, Increment](docs/DayOfMonthIncrement.html)
* [Day of Month, Decrement](docs/DayOfMonthDecrement.html)
* [Isochronic, Increment](docs/DayOfMonthIncrement.html)
* [Isochronic, Decrement](docs/DayOfMonthDecrement.html)
* [Monthly First Day of Week, Increment](docs/MonthlyFirstDayOfWeekIncrement.html)
* [Monthly First Day of Week, Decrement](docs/MonthlyFirstDayOfWeekDecrement.html)
* [Monthly Last Day of Week, Increment](docs/MonthlyLastDayOfWeekIncrement.html)
* [Monthly Last Day of Week, Decrement](docs/MonthlyLastDayOfWeekDecrement.html)
* [Monthly First Workday, Increment](docs/MonthlyFirstWorkdayIncrement.html)
* [Monthly First Workday Decrement](docs/MonthlyFirstWorkdayDecrement.html)
* [Monthly Last Workday, Increment](docs/MonthlyLastWorkdayIncrement.html)
* [Monthly Last Workday Decrement](docs/MonthlyLastWorkdayDecrement.html)

### Shifters

* **Day of Month**
    * Check if calendar day is greater than specific date.
        * Increment month if it is greater than specific date.
    * Check if given day exists in current month.
        * If it does, set the day to specific day of month.
        * Otherwise set day to last day of given month.
* **Monthly first day of week**
    * Check if calendar day is greater than first day of week for current month.
        * Increment month if it is.
    * Set calendar day.
* **Monthly last day of week**
    * Increment the month.
    * Decrement day by 1 until desired weekday.
* **Isochronic**
    * Increment by specified number of days.


## Day of month shifters

Supports iterating over specific days of month.

### Available shifters

* `COG\ChronoShifter\Shifter\DayOfMonthDecrement::__construct($day : int)`
* `COG\ChronoShifter\Shifter\DayOfMonthIncrement::__construct($day : int)`

### Example

    use COG\ChronoShifter\ChronoShifter;
    use COG\ChronoShifter\Shifter\DayOfMonthIncrement;

    $time = new \DateTime('2015-04-07 10:26:20');
    $shifter = new DayOfMonthIncrement(14);
    $iterator = new \LimitIterator(new ChronoShifter($shifter, $time), 1, 10);
    foreach($iterator as $time) {
        echo $time->format("Y-m-d H:i:s\n");
    }

    // Outputs

    2015-04-14 00:00:00
    2015-05-14 00:00:00
    2015-06-14 00:00:00
    2015-07-14 00:00:00
    2015-08-14 00:00:00
    2015-09-14 00:00:00
    2015-10-14 00:00:00
    2015-11-14 00:00:00
    2015-12-14 00:00:00
    2016-01-14 00:00:00

### Notes

It is possible that the `Day of Month` is greater than number of
days in a given month. In this case the month will not be skipped, instead
last day of month will be used.

## Monthly first day of week shifters

### Available shifters

* `COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekDecrement::__construct($weekDay:int)`
* `COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekIncrement::__construct($weekDay:int)`

### Example

    use COG\ChronoShifter\ChronoShifter;
    use COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekDecrement;

    $time = new \DateTime('2015-04-05 10:26:20');
    $shifter = new MonthlyFirstDayOfWeekDecrement(MonthlyFirstDayOfWeekDecrement::MONDAY);
    $iterator = new \LimitIterator(new ChronoShifter($shifter, $time), 1, 10);
    foreach($iterator as $time) {
        echo $time->format("Y-m-d H:i:s\n");
    }

    // Outputs

    2015-03-02 00:00:00
    2015-02-02 00:00:00
    2015-01-05 00:00:00
    2014-12-01 00:00:00
    2014-11-03 00:00:00
    2014-10-06 00:00:00
    2014-09-01 00:00:00
    2014-08-04 00:00:00
    2014-07-07 00:00:00
    2014-06-02 00:00:00


## Monthly first workday shifters

* `COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekDecrement::__construct()`
* `COG\ChronoShifter\Shifter\MonthlyFirstDayOfWeekIncrement::__construct()`

### Note

The logic to determine holidays is not part of this library. This library
provides an interface `COG\ChronoShifter\Date\HolidayProvider` which has
one method to specify whether the requested date is a holiday.

### Example

    use COG\ChronoShifter\ChronoShifter;
    use COG\ChronoShifter\Date\HolidayProvider;
    use My\Own\SwedishHolidayProvider;

    $holidayProvider = new SwedishHolidayProvider();

    $time = new \DateTime('2015-12-23 10:26:20');
    $shifter = new MonthlyFirstWorkdayIncrement();
    $shifter->setHolidayProvider($holidayProvider);
    $shifter->shift($time);
    echo $time->format("Y-m-d H:i:s\n");

    // Outputs

    2015-01-02 00:00:00

## Monthly last day of week shifters

### Available shifters

* `COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekDecrement::__construct($weekDay:int)`
* `COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekIncrement::__construct($weekDay:int)`

### Example

    use COG\ChronoShifter\ChronoShifter;
    use COG\ChronoShifter\Shifter\MonthlyLastDayOfWeekIncrement;

    $time = new \DateTime('2015-04-05 10:26:20');
    $shifter = new MonthlyLastDayOfWeekIncrement(MonthlyFirstDayOfWeekDecrement::MONDAY);
    $iterator = new \LimitIterator(new ChronoShifter($shifter, $time), 1, 10);
    foreach($iterator as $time) {
        echo $time->format("Y-m-d H:i:s\n");
    }

    // Outputs

    2015-04-27 00:00:00
    2015-05-25 00:00:00
    2015-06-29 00:00:00
    2015-07-27 00:00:00
    2015-08-24 00:00:00
    2015-09-28 00:00:00
    2015-10-26 00:00:00
    2015-11-23 00:00:00
    2015-12-28 00:00:00
    2016-01-25 00:00:00

## Isochronic shifters

Iterations such of biweekly (14) and four-weekly (28).

### Available shifters

* `COG\ChronoShifter\Shifter\IsochronicDecrement::__construct($days:int, \DateTime $reference)`
* `COG\ChronoShifter\Shifter\IsochronicIncrement::__construct($days:int, \DateTime $reference)`

### Example

    use COG\ChronoShifter\ChronoShifter;
    use COG\ChronoShifter\Shifter\IsochronicDecrement;

    $time = new \DateTime('2015-04-05 10:26:20');
    $shifter = new IsochronicDecrement(28, new \DateTime('2015-04-01'));
    $iterator = new \LimitIterator(new ChronoShifter($shifter, $time), 1, 10);
    foreach($iterator as $time) {
        echo $time->format("Y-m-d H:i:s\n");
    }

    // Outputs

    2015-04-01 00:00:00
    2015-03-04 00:00:00
    2015-02-04 00:00:00
    2015-01-07 00:00:00
    2014-12-10 00:00:00
    2014-11-12 00:00:00
    2014-10-15 00:00:00
    2014-09-17 00:00:00
    2014-08-20 00:00:00
    2014-07-23 00:00:00