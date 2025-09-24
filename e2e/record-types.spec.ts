import {test, expect} from '../playwright/fixtures';

test('can create category and type', async ({page}) => {
    await page.goto('https://test.repflux.app/app');

    // Create category
    await expect(page).toHaveTitle(/Áttekintés/);

    await page.getByRole('link', {name: 'Gyakorlat kategóriák'}).click();

    await expect(page).toHaveTitle(/Gyakorlat kategóriák/);

    await page.getByRole('link', {name: 'Kategória hozzáadása'}).click();
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Category');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Kategória szerkesztése/);
    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');

    // Create type
    await page.getByRole('link', {name: 'Gyakorlatok'}).click();

    await expect(page).toHaveTitle(/Gyakorlatok/);

    await page.getByRole('link', {name: 'Gyakorlat hozzáadása'}).click();
    await page.getByLabel('Record category').selectOption('Playwright Category');
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Type');
    await page.getByRole('textbox', {name: 'Base weight'}).fill('20');
    await page.getByRole('textbox', {name: 'Notes'}).fill('Some random notes.');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Gyakorlat szerkesztése/);
    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');
});

// FIXME
/*test('can create recordset', async ({page}) => {
    await page.goto('https://test.repflux.app/app');

    // Create category
    await expect(page).toHaveTitle(/Áttekintés/);

    await page.getByRole('link', {name: 'Gyakorlat kategóriák'}).click();

    await expect(page).toHaveTitle(/Gyakorlat kategóriák/);

    await page.getByRole('link', {name: 'Kategória hozzáadása'}).click();
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Category');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Kategória szerkesztése/);
    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');

    // Create type
    await page.getByRole('link', {name: 'Gyakorlatok'}).click();

    await expect(page).toHaveTitle(/Gyakorlatok/);

    await page.getByRole('link', {name: 'Gyakorlat hozzáadása'}).click();
    await page.getByLabel('Record category').selectOption('Playwright Category');
    await page.getByRole('textbox', {name: 'Name'}).fill('Playwright Type');
    await page.getByRole('textbox', {name: 'Base weight'}).fill('20');
    await page.getByRole('textbox', {name: 'Notes'}).fill('Some random notes.');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Gyakorlat szerkesztése/);
    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');

    // Create recordset

    await page.getByRole('link', {name: 'Sorozatok'}).click();

    await expect(page).toHaveTitle(/Sorozatok/);

    await page.getByRole('link', {name: 'Sorozat hozzáadása'}).click();
    await expect(page).toHaveTitle(/Sorozat hozzáadása/);

    await page.locator('.fi-fo-toggle-buttons-btn-ctn').first().click();
    await page.waitForLoadState("networkidle")
    await page.getByLabel('Record type id').last().selectOption('Playwright Type');
    await page.waitForLoadState("networkidle")
    await expect(page.getByLabel('Következő lépés')).toBeEnabled();
    await page.getByLabel('Következő lépés').click();
    await page.getByRole('textbox', {name: 'Repeat count'}).fill('10');
    await page.getByRole('textbox', {name: 'Weight'}).fill('10');
    await page.getByRole('button', {name: 'Létrehozás', exact: true}).click();

    await expect(page).toHaveTitle(/Sorozat megtekintése/);
    await expect(page.locator('.fi-no-notification-text')).toHaveText('Létrehozva');
});*/
