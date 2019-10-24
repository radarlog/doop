<?php

declare(strict_types=1);

use Symfony\Component\Debug\Debug;
use Symfony\Component\Dotenv\Dotenv;

require __DIR__ . '/vendor/autoload.php';

// phpcs:disable PSR12.Classes.AnonClassDeclaration.CloseBraceSameLine
(new class ()
{
    private const APP_ENV = 'APP_ENV';
    private const PUT_ENV = true;

    private const ENV_PROD = 'prod';
    private const ENV_DEV = 'dev';
    private const ENV_TEST = 'test';

    private const APP_DEBUG = 'APP_DEBUG';

    public function __construct()
    {
        // Load cached env vars if the .env.local.php file exists
        // Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
        $env = @include_once __DIR__ . '/.env.local.php';

        if (is_array($env)) {
            $_ENV += $env;
        }

        $appEnv = $_ENV[self::APP_ENV] ?? self::ENV_DEV;

        switch (true) {
            case !$this->isAllowedEnv($appEnv):
                throw new RuntimeException(sprintf('Unknown environment: "%s"', $appEnv));
            case $this->isDevEnv($appEnv):
                $this->loadDevEnv();
        }

        $appDebug = $_ENV[self::APP_DEBUG] ?? $appEnv !== self::ENV_PROD;

        if (filter_var($appDebug, FILTER_VALIDATE_BOOLEAN)) {
            umask(0000);
            Debug::enable();
        }

        // store calculated values
        $_ENV[self::APP_ENV] = $appEnv;
        $_ENV[self::APP_DEBUG] = $appDebug;
    }

    private function isAllowedEnv(string $appEnv): bool
    {
        return in_array($appEnv, [self::ENV_PROD, self::ENV_DEV, self::ENV_TEST]);
    }

    private function isDevEnv(string $appEnv): bool
    {
        return $appEnv !== self::ENV_PROD;
    }

    private function loadDevEnv(): void
    {
        if (!class_exists(Dotenv::class)) {
            throw new RuntimeException('Please run "composer require --dev symfony/dotenv"');
        }

        // load all the .env files
        (new Dotenv(self::PUT_ENV))->loadEnv(__DIR__ . '/.env', self::APP_ENV);
    }
});
