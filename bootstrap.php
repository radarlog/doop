<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;

require __DIR__ . '/vendor/autoload.php';

(new class ()
{
    private const APP_ENV = 'APP_ENV';
    private const PUT_ENV = true;

    private const ENV_PROD = 'prod';
    private const ENV_DEV = 'dev';
    private const ENV_TEST = 'test';

    private const APP_DEBUG = 'APP_DEBUG';

    /**
     * Load cached env vars if the .env.local.php file exists
     * Run "composer dump-env prod" to create it (requires symfony/flex >=1.2)
     */
    private const CACHED_ENV_FILE = __DIR__ . '/.env.local.php';

    public function __construct()
    {
        $this->loadCachedEnv();

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

    private function loadCachedEnv(): void
    {
        if (!file_exists(self::CACHED_ENV_FILE)) {
            return;
        }

        $cachedEnv = require self::CACHED_ENV_FILE;

        // phpcs:disable SlevomatCodingStandard.ControlStructures.EarlyExit
        if (is_array($cachedEnv)) {
            $_ENV += $cachedEnv;
        }
    }

    private function isAllowedEnv(string $appEnv): bool
    {
        return in_array($appEnv, [self::ENV_PROD, self::ENV_DEV, self::ENV_TEST], true);
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
