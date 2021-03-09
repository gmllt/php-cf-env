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
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */

namespace Gmllt\CloudFoundry;

/**
 * Class ServicesHelper
 *
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
class ServicesHelper
{
    /**
     * Raw
     *
     * @var array
     */
    protected array $raw = [];

    /**
     * Services
     *
     * @var Service[]
     */
    protected array $services = [];

    /**
     * Services by name
     *
     * @var Service[]
     */
    protected array $servicesByInstanceName = [];

    /**
     * Services by tags
     *
     * @var Service[][]
     */
    protected array $servicesByTag = [];

    /**
     * Services by service broker name
     *
     * @var Service[][]
     */
    protected array $servicesBySbName = [];

    /**
     * Services by binding name
     *
     * @var Service[]
     */
    protected array $servicesByBindingName = [];

    /**
     * ServicesHelper constructor.
     */
    public function __construct()
    {
        // get raw from env
        $raw = EnvironmentHelper::readEnv('VCAP_SERVICES');
        $this->raw = json_decode($raw, true) ?? [];
        // initialize services
        foreach ($this->raw as $key => $services) {
            $serviceBrokerName = $key;
            if (is_array($services)) {
                foreach ($services as $service) {
                    $currentService = new Service($service);
                    $this->services[] = $currentService;
                    $instanceName = $currentService->getInstanceName() ?? $currentService->getName();
                    if (null !== $instanceName) {
                        $this->servicesByInstanceName[$instanceName] = $currentService;
                    }
                    $this->servicesBySbName[$currentService->getLabel() ?? $serviceBrokerName][] = $currentService;
                    foreach ($currentService->getTags() as $tag) {
                        $this->servicesByTag[$tag][] = $currentService;
                    }
                    $bindingName = $currentService->getBindingName();
                    if (null !== $bindingName) {
                        $this->servicesByBindingName[$bindingName] = $currentService;
                    }
                }
            }
        }
    }

    /**
     * Get all services
     *
     * @return Service[]
     */
    public function getServices(): array
    {
        return $this->services;
    }

    /**
     * Get raw
     *
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * Get service by name
     *
     * @param string $name Name
     *
     * @return Service|null
     */
    public function getServiceByInstanceName(string $name): ?Service
    {
        return $this->servicesByInstanceName[$name] ?? null;
    }

    /**
     * Get service by binding name
     *
     * @param string $bindingName Binding name
     *
     * @return Service|null
     */
    public function getServiceByBindingName(string $bindingName): ?Service
    {
        return $this->servicesByBindingName[$bindingName] ?? null;
    }

    /**
     * Get services by tag
     *
     * @param string $tag Tag
     *
     * @return Service[]
     */
    public function getServicesByTag(string $tag): array
    {
        return $this->servicesByTag[$tag] ?? [];
    }

    /**
     * Get services by service broker name
     *
     * @param string $serviceBrokerName Service broker name
     *
     * @return Service[]
     */
    public function getServicesByServiceBrokerName(string $serviceBrokerName): array
    {
        return $this->servicesBySbName[$serviceBrokerName] ?? [];
    }

}