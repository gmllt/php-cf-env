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
 * Class Service
 *
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 *
 * @method string|null getBindingName() getBindingName() Get 'binding_name'
 * @method array getCredentials() getCredentials() Get 'credentials' as array
 * @method string|null getInstanceName() getInstanceName() Get 'instance_name'
 * @method string|null getLabel() getLabel() Get 'label'
 * @method string|null getName() getName() Get 'name'
 * @method string|null getPlan() getPlan() Get 'plan'
 * @method string|null getProvider() getProvider() Get 'provider'
 * @method string|null getSyslogDrainUrl() getSyslogDrainUrl() Get syslog_drain_url
 * @method array getVolumeMounts() getVolumeMounts() Get 'volume_mounts'
 * @method string[] getTags() getTags() Get 'tags' as array
 *
 * @property-read string|null $binding_name     Field 'binding_name'
 * @property-read array       $credentials      Field 'credentials'
 * @property-read string|null $instance_name    Field 'instance_name'
 * @property-read string|null $label            Field 'label'
 * @property-read string|null $name             Field 'name'
 * @property-read string|null $plan             Field 'plan'
 * @property-read string|null $provider         Field 'provider'
 * @property-read string|null $syslog_drain_url Field 'syslog_drain_url'
 * @property-read array       $volume_mounts    Field 'volume_mounts'
 * @property-read string[]    $tags             Field 'tags'
 */
class Service extends AbstractHelper
{


    /**
     * Authorized keys with types
     *
     * @var array|string[]
     */
    protected static array $authorized = [
        'binding_name' => AbstractHelper::TYPE_STRING,
        'credentials' => AbstractHelper::TYPE_ARRAY,
        'instance_name' => AbstractHelper::TYPE_STRING,
        'label' => AbstractHelper::TYPE_STRING,
        'name' => AbstractHelper::TYPE_STRING,
        'plan' => AbstractHelper::TYPE_STRING,
        'provider' => AbstractHelper::TYPE_STRING,
        'syslog_drain_url' => AbstractHelper::TYPE_STRING,
        'volume_mounts' => AbstractHelper::TYPE_ARRAY,
        'tags' => AbstractHelper::TYPE_ARRAY,
    ];


    /**
     * Service constructor.
     *
     * @param array $raw Raw
     */
    public function __construct(array $raw)
    {
        $this->raw = $raw;
    }

}