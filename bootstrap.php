<?php

declare(strict_types=1);

use Symfony\Component\Dotenv\Dotenv;
use Symfony\Component\ErrorHandler\Debug;

require __DIR__ . '/vendor/autoload.php';

return (new class () {
    private const APP_ENV = 'APP_ENV';
    private const APP_DEBUG = 'APP_DEBUG';

    private const ENV_PROD = 'prod';
    private const ENV_DEV = 'dev';
    private const ENV_TEST = 'test';

    private string $appEnv = self::ENV_DEV;
    private bool $isDebug = false;

    public function __construct()
    {
        // phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable
        $appEnv = $_ENV[self::APP_ENV] ?? $this->appEnv;

        switch (true) {
            case !$this->isAllowedEnv($appEnv):
                throw new RuntimeException(sprintf('Unknown environment: "%s"', $appEnv));
            case $this->isDevEnv($appEnv):
                $this->loadDevEnv();
        }

        // phpcs:ignore SlevomatCodingStandard.Variables.DisallowSuperGlobalVariable
        $isDebug = $_ENV[self::APP_DEBUG] ?? $this->isDevEnv($appEnv);
        $isDebug = filter_var($isDebug, FILTER_VALIDATE_BOOLEAN);

        if ($isDebug) {
            umask(0000);
            Debug::enable();
        }

        $this->appEnv = $appEnv;
        $this->isDebug = $isDebug;
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
        // load all the .env files
        (new Dotenv(self::APP_ENV))->loadEnv(__DIR__ . '/.env');
    }

    /**
     * @return array{app_env: string, is_debug: bool}
     */
    public function __invoke(): array
    {
        return [
            'app_env' => $this->appEnv,
            'is_debug' => $this->isDebug,
        ];
    }
})();
