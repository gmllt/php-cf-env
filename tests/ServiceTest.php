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
use Gmllt\CloudFoundry\Service;
use PHPUnit\Framework\TestCase;

/**
 * Class ServiceTest
 *
 * @category Tests
 * @package  Gmllt\CloudFoundry\Tests
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
class ServiceTest extends TestCase
{

    /**
     * Assert service
     *
     * @param array   $raw        RAw
     * @param Service $service    Service
     * @param string  $withoutKey Missing key
     *
     * @return void
     */
    protected function assertIsService(array $raw, Service $service, string $withoutKey): void
    {
        $message = "Error occurred when key '$withoutKey' is missing.";
        $this->assertInstanceOf(Service::class, $service, $message);
        $this->assertInstanceOf(AbstractHelper::class, $service, $message);
        $this->assertRawMatch($raw, $service, $message);
        $this->assertEquals($raw, $service->getRaw(), $message);
        $this->assertRawMatch($service->getRaw(), $service, $message);
    }

    /**
     * Assert raw match with service
     *
     * @param array   $raw     Raw
     * @param Service $service Service
     * @param string  $message Message
     *
     * @return void
     */
    protected function assertRawMatch(array $raw, Service $service, string $message): void
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
            $current = call_user_func_array([$service, $getter], []);
            $currentFromVar = $service->$key;
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
                $this->assertEquals($expected, $current, $message);
                $this->assertEquals($expected, $currentFromVar, $message);
            }
        }
    }

    /**
     * Test
     *
     * @return void
     */
    public function testAll(): void
    {
        $raw = json_decode(file_get_contents(__DIR__ . '/mock/service.json'), true);
        foreach ($raw as $key => $value) {
            $currentRaw = $raw;
            unset($currentRaw[$key]);
            $service = new Service($currentRaw);
            $this->assertIsService($currentRaw, $service, $key);
        }
    }

}