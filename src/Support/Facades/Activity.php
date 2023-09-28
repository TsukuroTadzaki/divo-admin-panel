<?php

declare(strict_types=1);

namespace Orchid\Support\Facades;

use Illuminate\Support\Facades\Facade;
use Orchid\Activity\Activity as ActivityClass;

/**
 * Class Alert.
 *
 * @method static ActivityClass create(string $class, array $data = [])
 * @method static ActivityClass update(string $class, array $data = [])
 * @method static ActivityClass delete(string $class, array $data = [])
 */
class Activity extends Facade
{
    /**
     * Initiate a mock expectation on the facade.
     *
     * @return mixed
     */
    protected static function getFacadeAccessor()
    {
        return ActivityClass::class;
    }
}
