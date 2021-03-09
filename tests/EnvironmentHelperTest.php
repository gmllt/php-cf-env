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

use Gmllt\CloudFoundry\EnvironmentHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class EnvironmentHelperTest
 *
 * @category Tests
 * @package  Gmllt\CloudFoundry\Tests
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
class EnvironmentHelperTest extends TestCase
{

    /**
     * Raw
     *
     * @var array|mixed
     */
    public array $raw = [];

    /**
     * Old envs
     *
     * @var array
     */
    public array $oldEnvs = [];

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->raw = json_decode(file_get_contents(__DIR__ . '/mock/environment.json'), true);
        $this->raw['VCAP_APPLICATION'] = file_get_contents(__DIR__ . '/mock/application.json');
        $this->raw['VCAP_SERVICES'] = file_get_contents(__DIR__ . '/mock/services.json');
        foreach ($this->raw as $key => $value) {
            $this->oldEnvs[$key] = $_ENV[$key] ?? null;
            $_ENV[$key] = $value;
        }
        parent::setUp();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown(): void
    {
        foreach ($this->oldEnvs as $key => $value) {
            if (null !== $value) {
                $_ENV[$key] = $value;
            } else {
                unset($_ENV[$key]);
            }
        }
        parent::tearDown();
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSimple(): void
    {
        $environment = new EnvironmentHelper();
        foreach ($this->raw as $key => $value) {
            if ($key == "CF_INSTANCE_PORTS") {
                $value = json_decode($value, true);
            }
            $message = "Error testing variable '$key'.";
            $parts = explode('_', $key);
            array_walk(
                $parts,
                function (&$item) {
                    $item = ucfirst(strtolower($item));
                }
            );
            $getter = 'get' . implode('', $parts);
            $actualFromVariable = $environment->$key;
            $actual = call_user_func_array([$environment, $getter], []);
            if (null !== $actual && !(is_array($actual) && empty($actual))) {
                switch (gettype($actual)) {
                    case 'string':
                        $expected = strval($value);
                        break;
                    case 'int':
                        $expected = intval($value);
                        break;
                    case 'float':
                        $expected = floatval($value);
                        break;
                    case 'bool':
                        $expected = boolval($value);
                        break;
                    case 'array':
                        $expected = (null === $value) ? [] : $value;
                        break;
                    default:
                        $expected = $value;
                }
                $this->assertEquals($expected, $actual, $message);
                $this->assertEquals($expected, $actualFromVariable, $message);
            }
        }
    }

}