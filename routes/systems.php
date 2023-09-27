<?php

declare(strict_types=1);

use Orchid\Platform\Http\Controllers\RepeaterController;

$this->router->post('repeater', [RepeaterController::class, 'view'])->name('systems.repeater');
