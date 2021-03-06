<?php

declare(strict_types=1);
/**
 * This file is part of the Volta Project.
 *
 * Copyright (c) 2018 - 2019. AzuyaLabs
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author Sacha Telgenhof <me@sachatelgenhof.com>
 */

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

/**
 * Middleware to ensure only OctoPrint-Volta clients are allowed.
 *
 * This is not a perfect measure as HTTP headers can be spoofed, however is a good
 * first line of defense. (Note: this may need to be altered if other print hosts will be
 * supported).
 */
class TrustOctoPrintClient
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user_agent = $request->header('User-Agent');

        if (!isset($user_agent)) {
            return response()->json(['message' => 'Correct User-Agent header is missing'], 400);
        }

        $agent = explode('/', $request->header('User-Agent'));
        if ('OctoPrint-Volta' !== $agent[0]) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $accept_header = $request->header('Accept');
        if ('application/json' !== $accept_header) {
            return response()->json('', 406);
        }

        return $next($request);
    }
}
