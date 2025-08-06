import { test, expect } from '@playwright/test';

test('shows login form', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/login');
  await expect(page.getByLabel('Correo electrónico')).toBeVisible();
});

test('rejects invalid credentials', async ({ page }) => {
  await page.goto('http://127.0.0.1:8000/login');
  await page.fill('input[name="email"]', 'wrong@example.com');
  await page.fill('input[name="password"]', 'invalid');
  await page.click('button[type="submit"]');
  await expect(page).toHaveURL('http://127.0.0.1:8000/login');
});
