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
 * Class ApplicationHelper
 *
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 *
 * @method string|null getApplicationId() getApplicationId() Get 'application_id'
 * @method string|null getApplicationName() getApplicationName() Get 'application_name'
 * @method string[] getApplicationUris() getApplicationUris() Get 'application_uris'
 * @method string|null getApplicationVersion() getApplicationVersion() Get 'application_version'
 * @method string|null getCfApi() getCfApi() Get 'cf_api'
 * @method string|null getHost() getHost() Get 'host'
 * @method string[] getLimits() getLimits() Get 'limits'
 * @method string|null getName() getName() Get 'name'
 * @method string|null getOrganizationId() getOrganizationId() Get 'organization_id'
 * @method string|null getOrganizationName() getOrganizationName() Get 'organization_name'
 * @method string|null getProcessId() getProcessId() Get 'process_id'
 * @method string|null getProcessType() getProcessType() Get 'process_type'
 * @method string|null getSpaceId() getSpaceId() Get 'space_id'
 * @method string|null getSpaceName() getSpaceName() Get 'space_name'
 * @method string|null getStart() getStart() Get 'start'
 * @method string|null getStartedAt() getStartedAt() Get 'started_at'
 * @method int|null getStartedAtTimestamp() getStartedAtTimestamp() Get 'started_at_timestamp'
 * @method int|null getStateTimestamp() getStateTimestamp() Get 'state_timestamp'
 * @method string[] getUris() getUris() Get 'uris'
 * @method string[] getUsers() getUsers() Get 'users'
 * @method string|null getVersion() getVersion() Get 'version'
 *
 * @property-read string|null $application_id       Field 'application_id'
 * @property-read string|null $application_name     Field 'application_name'
 * @property-read string[]    $application_uris     Field 'application_uris'
 * @property-read string|null $application_version  Field 'application_version'
 * @property-read string|null $cf_api               Field 'cf_api'
 * @property-read string|null $host                 Field 'host'
 * @property-read string[]    $limits               Field 'limits'
 * @property-read string|null $name                 Field 'name'
 * @property-read string|null $organization_id      Field 'organization_id'
 * @property-read string|null $organization_name    Field 'organization_name'
 * @property-read string|null $process_id           Field 'process_id'
 * @property-read string|null $process_type         Field 'process_type'
 * @property-read string|null $space_id             Field 'space_id'
 * @property-read string|null $space_name           Field 'space_name'
 * @property-read string|null $start                Field 'start'
 * @property-read string|null $started_at           Field 'started_at'
 * @property-read int|null    $started_at_timestamp Field 'started_at_timestamp'
 * @property-read int|null    $state_timestamp      Field 'state_timestamp'
 * @property-read string[]    $uris                 Field 'uris'
 * @property-read string[]    $users                Field 'users'
 * @property-read string|null $version              Field 'version'
 */
class ApplicationHelper extends AbstractHelper
{

    /**
     * Authorized
     *
     * @var array
     */
    protected static array $authorized = [
        'application_id' => AbstractHelper::TYPE_STRING,
        'application_name' => AbstractHelper::TYPE_STRING,
        'application_uris' => AbstractHelper::TYPE_ARRAY,
        'application_version' => AbstractHelper::TYPE_STRING,
        'cf_api' => AbstractHelper::TYPE_STRING,
        'host' => AbstractHelper::TYPE_STRING,
        'limits' => AbstractHelper::TYPE_ARRAY,
        'name' => AbstractHelper::TYPE_STRING,
        'organization_id' => AbstractHelper::TYPE_STRING,
        'organization_name' => AbstractHelper::TYPE_STRING,
        'process_id' => AbstractHelper::TYPE_STRING,
        'process_type' => AbstractHelper::TYPE_STRING,
        'space_id' => AbstractHelper::TYPE_STRING,
        'space_name' => AbstractHelper::TYPE_STRING,
        'start' => AbstractHelper::TYPE_STRING,
        'started_at' => AbstractHelper::TYPE_STRING,
        'started_at_timestamp' => AbstractHelper::TYPE_INT,
        'state_timestamp' => AbstractHelper::TYPE_INT,
        'uris' => AbstractHelper::TYPE_ARRAY,
        'users' => AbstractHelper::TYPE_ARRAY,
        'version' => AbstractHelper::TYPE_STRING,
    ];

    /**
     * ApplicationHelper constructor.
     */
    public function __construct()
    {
        $raw = EnvironmentHelper::readEnv('VCAP_APPLICATION');
        $this->raw = json_decode($raw, true) ?? [];
    }

}