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
 * Class EnvironmentHelper
 *
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 *
 * @method string|null getCfInstanceAddr() getCfInstanceAddr() Get environment variable 'CF_INSTANCE_ADDR'
 * @method string|null getCfInstanceGuid() getCfInstanceGuid() Get environment variable 'CF_INSTANCE_GUID'
 * @method int|null getCfInstanceIndex() getCfInstanceIndex() Get environment variable 'CF_INSTANCE_INDEX'
 * @method string|null getCfInstanceInternalIp() getCfInstanceInternalIp() Get environment variable
 *         'CF_INSTANCE_INTERNAL_IP'
 * @method string|null getCfInstanceIp() getCfInstanceIp() Get environment variable 'CF_INSTANCE_IP'
 * @method int|null getCfInstancePort() getCfInstancePort() Get environment variable 'CF_INSTANCE_PORT'
 * @method array getCfInstancePorts() getCfInstancePorts() Get environment variable 'CF_INSTANCE_PORTS'
 * @method string|null getCfStack() getCfStack() Get environment variable 'CF_STACK'
 * @method string|null getDatabaseUrl() getDatabaseUrl() Get environment variable 'DATABASE_URL'
 * @method string|null getHome() getHome() Get environment variable 'HOME'
 * @method string|null getInstanceGuid() getInstanceGuid() Get environment variable 'INSTANCE_GUID'
 * @method int|null getInstanceIndex() getInstanceIndex() Get environment variable 'INSTANCE_INDEX'
 * @method string|null getLang() getLang() Get environment variable 'LANG'
 * @method string|null getMemoryLimit() getMemoryLimit() Get environment variable 'MEMORY_LIMIT'
 * @method string|null getPath() getPath() Get environment variable 'PATH'
 * @method int|null getPort() getPort() Get environment variable 'PORT'
 * @method string|null getPwd() getPwd() Get environment variable 'PWD'
 * @method string|null getTmpdir() getTmpdir() Get environment variable 'TMPDIR'
 * @method string|null getUser() getUser() Get environment variable 'USER'
 * @method string|null getVcapAppHost() getVcapAppHost() Get environment variable 'VCAP_APP_HOST'
 * @method string|null getVcapAppPort() getVcapAppPort() Get environment variable 'VCAP_APP_PORT'
 * @method ApplicationHelper getVcapApplication() getVcapApplication() Get environment variable 'VCAP_APPLICATION'
 * @method ServicesHelper getVcapServices() getVcapServices() Get environment variable 'VCAP_SERVICES'
 *
 * @property-read string|null       $CF_INSTANCE_ADDR        Environment variable 'CF_INSTANCE_ADDR'
 * @property-read string|null       $CF_INSTANCE_GUID        Environment variable 'CF_INSTANCE_GUID'
 * @property-read int|null          $CF_INSTANCE_INDEX       Environment variable 'CF_INSTANCE_INDEX'
 * @property-read string|null       $CF_INSTANCE_INTERNAL_IP Environment variable 'CF_INSTANCE_INTERNAL_IP'
 * @property-read string|null       $CF_INSTANCE_IP          Environment variable 'CF_INSTANCE_IP'
 * @property-read string|null       $CF_INSTANCE_PORT        Environment variable 'CF_INSTANCE_PORT'
 * @property-read array             $CF_INSTANCE_PORTS       Environment variable 'CF_INSTANCE_PORTS'
 * @property-read string|null       $CF_STACK                Environment variable 'CF_STACK'
 * @property-read string|null       $DATABASE_URL            Environment variable 'DATABASE_URL'
 * @property-read string|null       $HOME                    Environment variable 'HOME'
 * @property-read string|null       $INSTANCE_GUID           Environment variable 'INSTANCE_GUID'
 * @property-read int|null          $INSTANCE_INDEX          Environment variable 'INSTANCE_INDEX'
 * @property-read string|null       $LANG                    Environment variable 'LANG'
 * @property-read string|null       $MEMORY_LIMIT            Environment variable 'MEMORY_LIMIT'
 * @property-read string|null       $PATH                    Environment variable 'PATH'
 * @property-read int|null          $PORT                    Environment variable 'PORT'
 * @property-read string|null       $PWD                     Environment variable 'PWD'
 * @property-read string|null       $TMPDIR                  Environment variable 'TMPDIR'
 * @property-read string|null       $USER                    Environment variable 'USER'
 * @property-read string|null       $VCAP_APP_HOST           Environment variable 'VCAP_APP_HOST'
 * @property-read int|null          $VCAP_APP_PORT           Environment variable 'VCAP_APP_PORT'
 * @property-read ApplicationHelper $VCAP_APPLICATION        Environment variable 'VCAP_APPLICATION'
 * @property-read ServicesHelper    $VCAP_SERVICES           Environment variable 'VCAP_SERVICES'
 */
class EnvironmentHelper extends AbstractHelper
{

    /**
     * Authorized
     *
     * @var array
     */
    protected static array $authorized = [
        'CF_INSTANCE_ADDR' => self::TYPE_STRING,
        'CF_INSTANCE_GUID' => self::TYPE_STRING,
        'CF_INSTANCE_INDEX' => self::TYPE_INT,
        'CF_INSTANCE_INTERNAL_IP' => self::TYPE_STRING,
        'CF_INSTANCE_IP' => self::TYPE_STRING,
        'CF_INSTANCE_PORT' => self::TYPE_INT,
        'CF_INSTANCE_PORTS' => self::TYPE_ARRAY,
        'CF_STACK' => self::TYPE_STRING,
        'DATABASE_URL' => self::TYPE_STRING,
        'HOME' => self::TYPE_STRING,
        'INSTANCE_GUID' => self::TYPE_STRING,
        'INSTANCE_INDEX' => self::TYPE_INT,
        'LANG' => self::TYPE_STRING,
        'MEMORY_LIMIT' => self::TYPE_STRING,
        'PATH' => self::TYPE_STRING,
        'PORT' => self::TYPE_INT,
        'PWD' => self::TYPE_STRING,
        'TMPDIR' => self::TYPE_STRING,
        'USER' => self::TYPE_STRING,
        'VCAP_APP_HOST' => self::TYPE_STRING,
        'VCAP_APP_PORT' => self::TYPE_STRING,
        'VCAP_APPLICATION' => self::NO_TYPE,
        'VCAP_SERVICES' => self::NO_TYPE,
    ];

    /**
     * EnvironmentHelper constructor.
     */
    public function __construct()
    {
        /*$this->extracted['vcap_application'] = new ApplicationHelper();
        $this->extracted['vcap_services'] = new ServicesHelper();*/
    }

    /**
     * Read env
     *
     * @param string $envVarName Environment variable name
     *
     * @return array|false|mixed|string|null
     */
    public static function readEnv(string $envVarName)
    {
        return $_ENV[$envVarName] ?? $_SERVER[$envVarName] ?? (getenv($envVarName) !== false ? getenv(
                $envVarName
            ) : null);
    }

    /**
     * Extract value
     *
     * @param string $name Value name
     *
     * @return void
     */
    protected function extractValue(string $name): void
    {
        $name = strtoupper($name);
        if (static::isAuthorized($name) && !array_key_exists(strtolower($name), $this->extracted)) {
            $value = static::readEnv($name) ?? null;
            if ($name == "CF_INSTANCE_PORTS") {
                $value = json_decode($value, true);
            }

            $this->extracted[strtolower($name)] = static::convertToType($value, $name);
        }
    }

    /**
     * Magic getter
     *
     * @param string $name Name
     *
     * @return mixed|void|null
     */
    public function __get(string $name)
    {
        return parent::__get(strtolower($name));
    }

}