import {test, expect} from '../playwright/fixtures';

test('can create measurement type', async ({page}) => {
    await page.goto('https://test.repflux.app/app');

    await expect(page).toHaveTitle(/Áttekintés/);

    await page.getByRole('link', {name: 'Testméret típusok'}).click();

    await expect(page).toHaveTitle(/Testméret típusok/);
    await expect(page.getByText(/Nincs megjeleníthető elem/)).toBeVisible();

    await page.getByRole('link', {name: 'Típus hozzáadása'}).click();
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Measurement Type');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Típus szerkesztése/);

    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');
});
