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

use Gmllt\CloudFoundry\Service;
use Gmllt\CloudFoundry\ServicesHelper;
use PHPUnit\Framework\TestCase;

/**
 * Class ServicesHelperTest
 *
 * @category Tests
 * @package  Gmllt\CloudFoundry\Tests
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
class ServicesHelperTest extends TestCase
{
    /**
     * Old vcap services
     *
     * @var string|mixed|null
     */
    public ?string $vcapServices = null;

    /**
     * Set up
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->vcapServices = $_ENV['VCAP_SERVICES'] ?? null;
        parent::setUp();
    }

    /**
     * Tear down
     *
     * @return void
     */
    public function tearDown(): void
    {
        if ($this->vcapServices !== null) {
            $_ENV['VCAP_SERVICES'] = $this->vcapServices;
        } else {
            unset($_ENV['VCAP_SERVICES']);
        }
        parent::tearDown();
    }

    /**
     * Assert service
     *
     * @param ServicesHelper $servicesHelper Service helper
     * @param Service        $service        Service
     *
     * @return void
     */
    protected function assertService(ServicesHelper $servicesHelper, Service $service): void
    {
        $this->assertInstanceOf(ServicesHelper::class, $servicesHelper);
        $checkSameService = function ($expected, $actual) {
            $this->assertEquals($expected, $actual, $expected->getName());
        };
        $name = $service->getInstanceName() ?? $service->getName();
        if (null !== $name) {
            $checkSameService($service, $servicesHelper->getServiceByInstanceName($name));
        }
        $bindingName = $service->getBindingName();
        if (null !== $bindingName) {
            $checkSameService($service, $servicesHelper->getServiceByBindingName($bindingName));
        }
        foreach ($service->getTags() as $tag) {
            $this->assertContains($service, $servicesHelper->getServicesByTag($tag));
        }
        $serviceBrokerName = $service->getLabel();
        if ($serviceBrokerName !== null) {
            $this->assertContains($service, $servicesHelper->getServicesByServiceBrokerName($serviceBrokerName));
        }
    }

    /**
     * Test
     *
     * @return void
     */
    public function testSimple(): void
    {
        $raw = file_get_contents(__DIR__ . '/mock/services.json') ?? '';
        $_ENV['VCAP_SERVICES'] = $raw;

        $servicesHelper = new ServicesHelper();
        $services = $servicesHelper->getServices();
        $this->assertCount(count(json_decode($raw, true) ?? []), $services);
        foreach ($services as $service) {
            $this->assertService($servicesHelper, $service);
        }
    }
}