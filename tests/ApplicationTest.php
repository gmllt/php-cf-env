<?php

/**
 * Apache License
 * Version 2.0, January 2004
 * http://www.apache.org/licenses/
 *
 * TERMS AND CONDITIONS FOR USE, REPRODUCTION, AND DISTRIBUTION
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
 * FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
 * COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN
 * AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 * PHP Version 7.4
 *
 * @category Tests
 * @package  Gmllt\CloudFoundry\Tests
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */

namespace Gmllt\CloudFoundry\Tests;

use Gmllt\CloudFoundry\AbstractHelper;
use Gmllt\CloudFoundry\ApplicationHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ApplicationTest
 *
 * @category Tests
 * @package  Gmllt\CloudFoundry\Tests
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
class ApplicationTest extends TestCase
{
    /**
     * Old vcap
     *
     * @var string|mixed|null
     */
    protected ?string $oldVcap = '';

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->oldVcap = $_ENV['VCAP_APPLICATION'] ?? null;
        parent::setUp();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown(): void
    {
        if (null !== $this->oldVcap) {
            $_ENV['VCAP_APPLICATION'] = $this->oldVcap;
        } else {
            unset($_ENV['VCAP_APPLICATION']);
        }
        parent::tearDown();
    }

    /**
     * Assert application
     *
     * @param array             $raw         Raw
     * @param ApplicationHelper $application ApplicationHelper
     * @param string            $withoutKey  Removed key
     *
     * @return void
     */
    protected function assertIsApplication(array $raw, ApplicationHelper $application, string $withoutKey): void
    {
        $message = "Error occurred when key '$withoutKey' is missing.";
        $this->assertInstanceOf(ApplicationHelper::class, $application, $message);
        $this->assertInstanceOf(AbstractHelper::class, $application, $message);
        $this->assertRawMatch($raw, $application, $message);
        $this->assertEquals($raw, $application->getRaw(), $message);
        $this->assertRawMatch($application->getRaw(), $application, $message);
    }

    /**
     * Assert that raw matches application
     *
     * @param array             $raw         Raw
     * @param ApplicationHelper $application Application helper
     * @param string            $message     message
     *
     * @return void
     */
    protected function assertRawMatch(array $raw, ApplicationHelper $application, string $message): void
    {
        foreach ($raw as $key => $value) {
            $parts = explode('_', $key);
            array_walk(
                $parts,
                function (&$item) {
                    $item = ucfirst(strtolower($item));
                }
            );
            $getter = 'get' . implode('', $parts);
            $expected = $value;
            $current = call_user_func_array([$application, $getter], []);
            $currentFromVar = $application->$key;
            if (null !== $current && !(is_array($current) && empty($current))) {
                switch (gettype($current)) {
                    case 'string':
                        $expected = strval($expected);
                        break;
                    case 'int':
                        $expected = intval($expected);
                        break;
                    case 'float':
                        $expected = floatval($expected);
                        break;
                    case 'bool':
                        $expected = boolval($expected);
                        break;
                    case 'array':
                        $expected = (null === $expected) ? [] : $expected;
                }
                $this->assertEquals($value, $current, $message);
                $this->assertEquals($value, $currentFromVar, $message);
            }
        }
    }

    /**
     * Test all
     *
     * @return void
     */
    public function testAll(): void
    {
        $file = __DIR__ . '/mock/application.json';
        $raw = json_decode(file_get_contents($file), true);
        foreach ($raw as $key => $value) {
            $currentRaw = $raw;
            unset($currentRaw[$key]);
            $_ENV['VCAP_APPLICATION'] = json_encode($currentRaw);
            $application = new ApplicationHelper();
            $this->assertIsApplication($currentRaw, $application, $key);
        }
    }

}