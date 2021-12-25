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

namespace PhpProfiler\Lib\PhpInternals;

use FFI;
use FFI\CData;
use PhpProfiler\Lib\FFI\CannotGetTypeForCDataException;
use PhpProfiler\Lib\FFI\CannotLoadCHeaderException;

final class ZendTypeReader
{
    public const V70 = 'v70';
    public const V71 = 'v71';
    public const V72 = 'v72';
    public const V73 = 'v73';
    public const V74 = 'v74';
    public const V80 = 'v80';
    public const V81 = 'v81';

    public const ALL_SUPPORTED_VERSIONS = [
        self::V70,
        self::V71,
        self::V72,
        self::V73,
        self::V74,
        self::V80,
        self::V81,
    ];

    private ?FFI $ffi = null;

    /**
     * @param value-of<self::ALL_SUPPORTED_VERSIONS> $php_version
     */
    public function __construct(
        private string $php_version
    ) {
    }

    private function loadHeader(string $php_version): FFI
    {
        if (!isset($this->ffi)) {
            if ($php_version === self::V81) {
                $php_version = self::V80;
            }
            $this->ffi = FFI::load(__DIR__ . "/Headers/{$php_version}.h")
                ?? throw new CannotLoadCHeaderException('cannot load headers for zend engine');
        }
        return $this->ffi;
    }

    public function readAs(string $type, CData $cdata): ZendTypeCData
    {
        $ffi = $this->loadHeader($this->php_version);
        return new ZendTypeCData($cdata, $ffi->cast($type, $cdata));
    }

    public function sizeOf(string $type): int
    {
        $ffi = $this->loadHeader($this->php_version);
        $cdata_type = $ffi->type($type)
            ?? throw new CannotGetTypeForCDataException(
                message: 'cannot get type for a C Data',
                type: $type
            );
        return FFI::sizeof($cdata_type);
    }
}
