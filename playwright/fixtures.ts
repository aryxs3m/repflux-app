import { test as baseTest, expect } from '@playwright/test';
// @ts-ignore
import fs from 'fs';
// @ts-ignore
import path from 'path';

export * from '@playwright/test';
export const test = baseTest.extend<{}, { workerStorageState: string }>({
    // Use the same storage state for all tests in this worker.
    storageState: ({ workerStorageState }, use) => use(workerStorageState),

    // Authenticate once per worker with a worker-scoped fixture.
    workerStorageState: [async ({ browser }, use) => {
        // Use parallelIndex as a unique identifier for each worker.
        const id = test.info().parallelIndex;
        const fileName = path.resolve(test.info().project.outputDir, `.auth/${id}.json`);

        if (fs.existsSync(fileName)) {
            // Reuse existing authentication state if any.
            await use(fileName);
            return;
        }

        // Important: make sure we authenticate in a clean environment by unsetting storage state.
        const page = await browser.newPage({ storageState: undefined });

        // Perform authentication steps. Replace these actions with your own.
        let random = Date.now() / 1000;
        await page.goto('https://test.repflux.app/app/register');
        await page.getByRole('textbox', { name: 'Név'}).fill('Playwright User '+random);
        await page.getByRole('textbox', { name: 'Email cím'}).fill('playwright+'+random+'@repflux.app');
        await page.getByRole('textbox', { name: 'Jelszó*'}).fill('Playwright12345678');
        await page.getByRole('textbox', { name: 'Jelszó megerősítése'}).fill('Playwright12345678');
        await page.getByRole('button', { name: 'Regisztrálok'}).click();
        await expect(page).toHaveURL('https://test.repflux.app/app/new');
        await page.getByRole('button', { name: 'Csapat regisztrációja'}).click();

        await expect(page).toHaveTitle(/Áttekintés/);

        await page.context().storageState({ path: fileName });
        await page.close();
        await use(fileName);
    }, { scope: 'worker' }],
});
