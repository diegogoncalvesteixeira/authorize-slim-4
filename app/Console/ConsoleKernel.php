<?php

namespace App\Console;

use Boot\Foundation\ConsoleKernel as Kernel;

class ConsoleKernel extends Kernel
{
    public $commands = [
        Commands\MakeEventCommand::class,
        Commands\MakeListenerCommand::class,
        Commands\MakeModelCommand::class,
        Commands\ViewClearCommand::class,
        Commands\MakeCommandCommand::class,
        Commands\MakeFactoryCommand::class,
        Commands\MakeRequestCommand::class,
        Commands\MakeControllerCommand::class,
        Commands\ErrorLogsClearCommand::class,
        Commands\MakeFactoryCommand::class,
        Commands\MakeServiceProviderCommand::class,
        Commands\MakeMiddlewareCommand::class,
        Commands\MakeTraitCommand::class
    ];
}
