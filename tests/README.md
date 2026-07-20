# DISC ID Unit Tests

This folder contains the native unit tests for the DISC Personality Test application.

## Overview

The unit tests are written in **native PHP** without any external dependencies (such as Composer or PHPUnit). This allows tests to run instantly on any machine with PHP installed.

To verify logic database-independently, the test suite implements mock equivalents of PHP's standard `mysqli` driver (`MockMySQLi` and `MockMySQLiResult`).

## Features Tested

* **DISC Results Processing**: Validates `getDISCResults()` to ensure it correctly maps questionnaire scores to the profile dimensions (D, I, S, C).
* **Pattern Classification**: Validates `getPattern()` across various DISC profiles (e.g. Developer, Objective Thinker) and checks default/fallback scenarios.

## How to Run

Execute the test suite using the PHP command line interface from the project root:

```bash
php tests/run_tests.php
```

## Structure

* [run_tests.php](run_tests.php): The primary test runner script.
  * **Mock Driver**: Simulates database interactions.
  * **Assert Class**: Provides lightweight color-coded validation helpers.
  * **Test Cases**: The individual assertions verifying the formulas in `inc/formula.php`.

## How to Add New Tests

Open [run_tests.php](run_tests.php) and add tests under the appropriate group:

1. **Seed Mock Database Answers**: Set `responses[]` to your desired mock row database returns:
   ```php
   $dbMock->responses[] = ['d' => 4, 'i' => 2, 's' => 1, 'c' => 1];
   ```
2. **Execute and Assert**: Use `Assert::equal($actual, $expected, $message)`:
   ```php
   $patternResult = getPattern($dbMock, $dummyResults, 1);
   Assert::equal($patternResult[1]->id, 10, "Should identify Pattern 10");
   ```
