/**
 * Laravel IDE Helper - Request Methods Mixin
 * 
 * This file helps IDEs understand Laravel's dynamic methods
 * Add this to your project to eliminate false positive warnings
 */

namespace Illuminate\Http {
    /**
     * @method bool ajax()
     * @method mixed input(string $key, mixed $default = null)
     * @method mixed get(string $key, mixed $default = null)
     * @method bool wantsJson()
     * @method bool expectsJson()
     * @method bool isJson()
     * @method bool acceptsJson()
     * @method bool acceptsHtml()
     * @method mixed post(string $key = null, mixed $default = null)
     * @method mixed query(string $key = null, mixed $default = null)
     * @method mixed cookie(string $key = null, mixed $default = null)
     * @method mixed file(string $key = null, mixed $default = null)
     * @method mixed server(string $key = null, mixed $default = null)
     * @method bool has(string|array $key)
     * @method bool hasAny(string|array $keys)
     * @method bool filled(string|array $key)
     * @method array all(array|mixed $keys = null)
     * @method array only(array|mixed $keys)
     * @method array except(array|mixed $keys)
     */
    class Request {}
}
