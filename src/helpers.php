<?php

/*
 * This file is part of the Easeava package.
 *
 * (c) Easeava <tthd@163.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Illuminate\Support\Str;

if (! function_exists('generate_sign'))
{
    /**
     * Generate a signature.
     *
     * @param array  $attributes
     * @param string $key
     * @param string $encryptMethod
     *
     * @return string
     */
    function generate_sign(array $attributes, $key, $encryptMethod = 'md5')
    {
        ksort($attributes);

        $attributes['key'] = $key;

        return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
    }
}

if (! function_exists('get_client_ip'))
{
    /**
     * Get client ip.
     *
     * @return string
     */
    function get_client_ip()
    {
        if (! empty($_SERVER['REMOTE_ADDR'])) {
            $ip = $_SERVER['REMOTE_ADDR'];
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

if (! function_exists('get_server_ip'))
{
    /**
     * Get current server ip.
     *
     * @return string
     */
    function get_server_ip()
    {
        if (! empty($_SERVER['SERVER_ADDR'])) {
            $ip = $_SERVER['SERVER_ADDR'];
        } elseif (! empty($_SERVER['SERVER_NAME'])) {
            $ip = gethostbyname($_SERVER['SERVER_NAME']);
        } else {
            // for php-cli(phpunit etc.)
            $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
        }

        return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
    }
}

if (! function_exists('current_url'))
{
    /**
     * Return current url.
     *
     * @return string
     */
    function current_url()
    {
        $protocol = 'http://';

        if ((! empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') === 'https') {
            $protocol = 'https://';
        }

        return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    }
}

if (! function_exists('str_random'))
{
    /**
     * Return random string.
     *
     * @param string $length
     *
     * @return string
     */
    function str_random($length)
    {
        return Str::random($length);
    }
}

if (! function_exists('rsa_public_encrypt'))
{
    /**
     * @param string $content
     * @param string $publicKey
     *
     * @return string
     */
    function rsa_public_encrypt($content, $publicKey)
    {
        $encrypted = '';
        openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public($publicKey), OPENSSL_PKCS1_OAEP_PADDING);

        return base64_encode($encrypted);
    }
}
