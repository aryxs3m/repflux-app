import {test, expect} from '@playwright/test';

test('login title', async ({page}) => {
    await page.goto('https://test.repflux.app/app/login');

    await expect(page).toHaveTitle(/Bejelentkezés/);
});

test('can register', async ({page}) => {
    await page.goto('https://test.repflux.app/app/register');

    await expect(page).toHaveTitle(/Regisztráció/);

    let random = Date.now() / 1000;

    await page.getByRole('textbox', {name: 'Név'}).fill('Playwright User ' + random);
    await page.getByRole('textbox', {name: 'Email cím'}).fill('playwright+' + random + '@repflux.app');
    await page.getByRole('textbox', {name: 'Jelszó*'}).fill('Playwright12345678');
    await page.getByRole('textbox', {name: 'Jelszó megerősítése'}).fill('Playwright12345678');

    await page.getByRole('button', {name: 'Regisztrálok'}).click();

    await expect(page).toHaveURL('https://test.repflux.app/app/new');

    await page.getByRole('button', {name: 'Csapat regisztrációja'}).click();

    await expect(page).toHaveTitle(/Áttekintés/);
});

test('can login', async ({page}) => {
    await page.goto('https://test.repflux.app/app/login');

    await expect(page).toHaveTitle(/Bejelentkezés/);

    await page.getByRole('textbox', {name: 'Email cím'}).fill('playwright@repflux.app');
    await page.getByRole('textbox', {name: 'Jelszó*'}).fill('Playwright12345678');

    await page.getByRole('button', {name: 'Bejelentkezés'}).click();

    await expect(page).toHaveTitle(/Áttekintés/);
});
