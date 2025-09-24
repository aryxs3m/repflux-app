import {test, expect} from '../playwright/fixtures';

test('can create category', async ({page}) => {
    await page.goto('https://test.repflux.app/app');

    await expect(page).toHaveTitle(/Áttekintés/);

    await page.getByRole('link', {name: 'Gyakorlat kategóriák'}).click();

    await expect(page).toHaveTitle(/Gyakorlat kategóriák/);
    await expect(page.getByText(/Nincs megjeleníthető elem/)).toBeVisible();

    await page.getByRole('link', {name: 'Kategória hozzáadása'}).click();
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Category');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Kategória szerkesztése/);

    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');
});
