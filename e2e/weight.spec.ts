import {test, expect} from '../playwright/fixtures';

test('can add and update weight', async ({page}) => {
    await page.goto('https://test.repflux.app/app');

    await expect(page).toHaveTitle(/Áttekintés/);

    await page.getByRole('link', {name: 'Testsúly', exact: true}).click();

    await expect(page).toHaveTitle(/Testsúly napló/);
    await expect(page.getByText(/Nincs megjeleníthető elem/)).toBeVisible();

    await page.getByRole('link', {name: 'Mérés hozzáadása'}).click();
    await expect(page).toHaveTitle(/Mérés hozzáadása/);

    await page.getByLabel('Weight').click();
    await page.getByLabel('Weight').fill('100');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Mérés szerkesztése/);

    await expect(page.locator('.fi-no-notification-text').last()).toHaveText('Létrehozva');

    await page.getByLabel('Weight').click();
    await page.getByLabel('Weight').fill('150');
    await page.getByRole('button', {name: 'Mentés', exact: true}).click();

    await expect(page.locator('.fi-no-notification-text').last()).toHaveText('Mentve');
});
