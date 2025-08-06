import { defineConfig } from '@playwright/test';

export default defineConfig({
  testDir: './e2e',
  webServer: {
    command: 'php artisan serve --host=127.0.0.1 --port=8000',
    port: 8000,
    reuseExistingServer: !process.env.CI,
    timeout: 120000
  }
});
