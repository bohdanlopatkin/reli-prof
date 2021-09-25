<?php

/**
 * This file is part of the sj-i/php-profiler package.
 *
 * (c) sji <sji@sj-i.dev>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace PhpProfiler\Lib\Libc\Errno;

class Errno
{
    /** @var \FFI\Libc\errno_ffi  */
    private \FFI $ffi;

    public function __construct()
    {
        /** @var \FFI\Libc\errno_ffi  */
        $this->ffi = \FFI::cdef('
           int errno;
       ', 'libc.so.6');
    }

    public function get(): int
    {
        return (int)$this->ffi->errno;
    }

    public function set(int $value): void
    {
        $this->ffi->errno = $value;
    }
}
