<?php
/*
BISMILLAAHIRRAHMAANIRRAHIIM - In the Name of Allah, Most Gracious, Most Merciful
================================================================================
FILENAME     : run_tests.php
DESC         : Native PHP Unit Testing Runner for disc_id
AUTHOR       : CAHYA DSN & Antigravity
CREATED DATE : 2026-07-20
UPDATED DATE : 2026-07-30 21:43:04
================================================================================
MIT License

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.

copyright (c) 2026 by cahya dsn; cahyadsn@gmail.com
================================================================================
*/
require_once __DIR__ . '/../inc/formula.php';

// Colored terminal output helper functions
function print_colored($text, $color_code) {
    // Check if terminal supports colors (not Windows CMD without ANSI support, though PowerShell/modern terminals support it)
    $use_color = (DIRECTORY_SEPARATOR === '/' || getenv('ANSICON') !== false || getenv('term') === 'xterm' || (defined('STDOUT') && function_exists('posix_isatty') && posix_isatty(STDOUT)));
    
    // Default color codes
    $colors = [
        'green'  => "\033[32m",
        'red'    => "\033[31m",
        'yellow' => "\033[33m",
        'cyan'   => "\033[36m",
        'reset'  => "\033[0m"
    ];

    if ($use_color || DIRECTORY_SEPARATOR === '\\') { // Enable color sequences
        echo $colors[$color_code] . $text . $colors['reset'];
    } else {
        echo $text;
    }
}

// 1. Mock DB Classes to simulate mysqli behavior without a real database
class MockMySQLi {
    public $queries = [];
    public $responses = [];

    public function query($sql) {
        // Standardize whitespace for logging/verification
        $this->queries[] = trim(preg_replace('/\s+/', ' ', $sql));
        $resp = array_shift($this->responses);
        return new MockMySQLiResult($resp);
    }
}

class MockMySQLiResult {
    private $data;

    public function __construct($data) {
        $this->data = $data;
    }

    public function fetch_object() {
        if ($this->data === null) {
            return null;
        }
        return (object) $this->data;
    }

    public function free() {
        // Mock free result
    }
}

// 2. Test Assertion Helper
class Assert {
    private static $passed = 0;
    private static $failed = 0;

    public static function equal($actual, $expected, $message = '') {
        if ($actual === $expected) {
            self::$passed++;
            print_colored("  [PASS] ", 'green');
            echo $message . "\n";
        } else {
            self::$failed++;
            print_colored("  [FAIL] ", 'red');
            echo $message . "\n";
            echo "         Expected: " . var_export($expected, true) . "\n";
            echo "         Actual:   " . var_export($actual, true) . "\n";
        }
    }

    public static function getFailedCount() {
        return self::$failed;
    }

    public static function getPassedCount() {
        return self::$passed;
    }
}

// 3. Execution of tests
print_colored("=== Running Native PHP Unit Tests ===\n\n", 'cyan');

// --- Test Group 1: getDISCResults ---
print_colored("Test Group: getDISCResults()\n", 'yellow');

$dbMock = new MockMySQLi();
// Seed mock response for a line's D, I, S, C values mapping
$dbMock->responses[] = ['d' => 6, 'i' => 2, 's' => -1, 'c' => 5];

$dummyResults = [
    'D' => [1 => 12],
    'I' => [1 => 10],
    'S' => [1 => 5],
    'C' => [1 => 8]
];

$discResults = getDISCResults($dbMock, $dummyResults, 1);
Assert::equal($discResults->d, 6, "D value mapped correctly");
Assert::equal($discResults->i, 2, "I value mapped correctly");
Assert::equal($discResults->s, -1, "S value mapped correctly");
Assert::equal($discResults->c, 5, "C value mapped correctly");
Assert::equal(count($dbMock->queries), 1, "Exactly one query was executed");


// --- Test Group 2: getPattern ---
print_colored("\nTest Group: getPattern()\n", 'yellow');

// Test case A: Pattern 1 (D<=0 && I<=0 && S<=0 && C>0)
$dbMock = new MockMySQLi();
$dbMock->responses[] = ['d' => -2, 'i' => 0, 's' => -1, 'c' => 3]; // getDISCResults values
$dbMock->responses[] = ['id' => 1, 'pattern' => 'Objective Thinker', 'behaviour' => 'Logical,Analytical', 'description' => 'Objective description', 'jobs' => 'Engineer']; // getPattern details

$patternResult = getPattern($dbMock, $dummyResults, 1);
Assert::equal($patternResult[1]->id, 1, "Correctly identifies Pattern 1 (Objective Thinker)");
Assert::equal($patternResult[1]->pattern, 'Objective Thinker', "Retrieves correct pattern name for Pattern 1");

// Test case B: Pattern 2 (D>0 && I<=0 && S<=0 && C<=0)
$dbMock = new MockMySQLi();
$dbMock->responses[] = ['d' => 4, 'i' => -1, 's' => 0, 'c' => 0];
$dbMock->responses[] = ['id' => 2, 'pattern' => 'Developer', 'behaviour' => 'Direct,Demanding', 'description' => 'Developer description', 'jobs' => 'Manager'];

$patternResult = getPattern($dbMock, $dummyResults, 1);
Assert::equal($patternResult[1]->id, 2, "Correctly identifies Pattern 2 (Developer)");

// Test case C: Fallback Pattern 0
$dbMock = new MockMySQLi();
$dbMock->responses[] = ['d' => 0, 'i' => 0, 's' => 0, 'c' => 0];
$dbMock->responses[] = ['id' => 0, 'pattern' => 'Unknown', 'behaviour' => '', 'description' => '', 'jobs' => ''];

$patternResult = getPattern($dbMock, $dummyResults, 1);
Assert::equal($patternResult[1]->id, 0, "Correctly falls back to Pattern 0 when values are all zero");


// --- Summary ---
echo "\n" . str_repeat('=', 40) . "\n";
print_colored("TEST EXECUTION SUMMARY:\n", 'cyan');
print_colored("  Passed: " . Assert::getPassedCount() . "\n", 'green');

$failed = Assert::getFailedCount();
if ($failed > 0) {
    print_colored("  Failed: " . $failed . "\n", 'red');
    exit(1);
} else {
    print_colored("  All tests passed successfully!\n", 'green');
    exit(0);
}
