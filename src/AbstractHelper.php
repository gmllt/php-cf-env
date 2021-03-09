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
 * Class AbstractHelper
 *
 * @category Library
 * @package  Gmllt\CloudFoundry
 * @author   Gilles Miraillet <g.miraillet@gmail.com>
 * @license  https://github.com/gmllt/php-cf-env/LICENSE Apache License
 * @link     https://github.com/gmllt/php-cf-env
 */
abstract class AbstractHelper
{
    const TYPE_STRING = 'string';
    const TYPE_ARRAY = 'array';
    const TYPE_INT = 'int';
    const TYPE_FLOAT = 'float';
    const TYPE_BOOL = 'bool';
    const NO_TYPE = 'undefined';

    /**
     * Authorized
     *
     * @var array
     */
    protected static array $authorized = [];

    /**
     * Raw
     *
     * @var array
     */
    protected array $raw = [];

    /**
     * Extracted elements
     *
     * @var array
     */
    protected array $extracted = [];

    /**
     * Get raw elements
     *
     * @return array
     */
    public function getRaw(): array
    {
        return $this->raw;
    }

    /**
     * Get extracted typed elements
     *
     * @return array
     */
    public function getExtracted(): array
    {
        return $this->extracted;
    }

    /**
     * Magic call
     *
     * @param string $name      Method name
     * @param array  $arguments Arguments
     *
     * @return array|bool|float|int|mixed|string|null
     */
    public function __call(string $name, array $arguments)
    {
        $startsWith = function (string $haystack, string $needle): bool {
            if (function_exists('str_starts_with ')) {
                return str_starts_with($haystack, $needle);
            }
            return substr($haystack, 0, strlen($needle)) === $needle;
        };
        // getter
        if ($startsWith($name, 'get')) {
            $variable = strtolower(implode('_', preg_split('/(?=[A-Z])/', lcfirst(substr($name, 3)))));
            $this->extractValue($variable);
            return $this->extracted[$variable] ?? null;
        }
        return call_user_func_array([$this, $name], $arguments);
    }

    /**
     * Convert type
     *
     * @param mixed|null $value    Value to convert
     * @param string     $variable Variable to find
     *
     * @return array|bool|float|int|string|null
     */
    protected static function convertToType($value, string $variable)
    {
        switch (static::variableType($variable) ?? static::NO_TYPE) {
            case static::TYPE_ARRAY:
                return $value ?? [];
            case static::TYPE_STRING:
                return (null !== $value) ? strval($value) : null;
            case static::TYPE_INT:
                return (null !== $value) ? intval($value) : null;
            case static::TYPE_FLOAT:
                return (null !== $value) ? floatval($value) : null;
            case static::TYPE_BOOL:
                return (null !== $value) ? boolval($value) : null;
            default:
                return $value;
        }
    }

    /**
     * Get type for variable
     *
     * @param string $variable Variable name
     *
     * @return string|null
     */
    protected static function variableType(string $variable): ?string
    {
        return static::$authorized[$variable] ?? null;
    }

    /**
     * Magic get
     *
     * @param string $name Variable name
     *
     * @return mixed|null
     */
    public function __get(string $name)
    {
        $this->extractValue($name);
        return $this->extracted[$name] ?? null;
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
        if (static::isAuthorized($name) && !array_key_exists($name, $this->extracted)) {
            $this->extracted[$name] = static::convertToType($this->raw[$name] ?? null, $name);
        }
    }

    /**
     * Is authorized
     *
     * @param string $name Name
     *
     * @return bool
     */
    protected static function isAuthorized(string $name): bool
    {
        return array_key_exists($name, static::$authorized);
    }
}