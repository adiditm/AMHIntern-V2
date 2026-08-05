const { test, expect } = require('@playwright/test');

const LOGIN_URL = 'https://intern.amhtechno.com/main/loginform.php';

test.describe('Login Page - Autentikasi', () => {

  test('Menolak login dengan kredensial salah (Pebisnis)', async ({ page }) => {
    await page.goto(LOGIN_URL);

    // Pastikan halaman login termuat
    await expect(page).toHaveTitle(/AMH|Login|Aminah/i);

    // Isi username dan password dengan data salah
    await page.fill('#login', 'USERTEST_SALAH');
    await page.fill('#password', 'passwordsalah123');

    // Tangani kemungkinan JS alert muncul setelah klik Login
    let alertMessage = null;
    page.once('dialog', async (dialog) => {
      alertMessage = dialog.message();
      await dialog.accept();
    });

    // Klik tombol Login
    await page.click('#btLogin');

    // Tunggu navigasi atau respons selesai
    await page.waitForLoadState('networkidle');

    // Verifikasi 1: jika ada alert JS, pesannya bukan kosong
    if (alertMessage !== null) {
      expect(alertMessage.length).toBeGreaterThan(0);
      console.log('Alert muncul:', alertMessage);
    } else {
      // Verifikasi 2: jika tidak ada alert, pastikan tidak masuk ke halaman dashboard
      // (URL harus tetap di area login/main, bukan di manager/ atau memstock/)
      const currentUrl = page.url();
      expect(currentUrl).not.toMatch(/manager\/indexadmin\.php/i);
      expect(currentUrl).not.toMatch(/memstock\/indexmem\.php/i);

      // Verifikasi 3: cek pesan error inline di halaman
      const bodyText = await page.locator('body').innerText();
      const adaErrorLogin = /gagal|salah|invalid|error|tidak.*valid|wrong|failed/i.test(bodyText);
      const kembaliKeLogin = currentUrl.includes('login') || currentUrl.includes('main');

      expect(adaErrorLogin || kembaliKeLogin).toBeTruthy();
    }
  });

  test('Menolak login dengan username kosong', async ({ page }) => {
    await page.goto(LOGIN_URL);

    // Biarkan username kosong, isi password saja
    await page.fill('#password', 'passwordsalah123');

    let alertMessage = null;
    page.once('dialog', async (dialog) => {
      alertMessage = dialog.message();
      await dialog.accept();
    });

    await page.click('#btLogin');
    await page.waitForLoadState('networkidle');

    // Tidak boleh masuk ke dashboard
    const currentUrl = page.url();
    expect(currentUrl).not.toMatch(/manager\/indexadmin\.php/i);
    expect(currentUrl).not.toMatch(/memstock\/indexmem\.php/i);
  });

  test('Menolak login dengan password kosong', async ({ page }) => {
    await page.goto(LOGIN_URL);

    await page.fill('#login', 'USERTEST_SALAH');
    // Biarkan password kosong

    let alertMessage = null;
    page.once('dialog', async (dialog) => {
      alertMessage = dialog.message();
      await dialog.accept();
    });

    await page.click('#btLogin');
    await page.waitForLoadState('networkidle');

    const currentUrl = page.url();
    expect(currentUrl).not.toMatch(/manager\/indexadmin\.php/i);
    expect(currentUrl).not.toMatch(/memstock\/indexmem\.php/i);
  });

  test('Halaman login memiliki elemen form yang lengkap', async ({ page }) => {
    await page.goto(LOGIN_URL);

    // Pastikan semua elemen form ada
    await expect(page.locator('#login')).toBeVisible();
    await expect(page.locator('#password')).toBeVisible();
    await expect(page.locator('#btLogin')).toBeVisible();

    // Pastikan radio button tipe login tersedia
    await expect(page.locator('#rbLoginN')).toBeVisible(); // Pebisnis
    await expect(page.locator('#rbLoginJ')).toBeVisible(); // Jamaah
  });

});
