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

namespace PhpProfiler\Inspector\Daemon\Reader\Context;

use Amp\Parallel\Context;

final class PhpReaderContextCreator implements PhpReaderContextCreatorInterface
{
    public function create(): PhpReaderContextInterface
    {
        return new PhpReaderContext(Context\create(__DIR__ . '/php-reader.php'));
    }
}
