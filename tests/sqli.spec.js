const { test, expect } = require('@playwright/test');

const LOGIN_URL = 'https://intern.amhtechno.com/main/loginform.php';
const DASHBOARD_PATTERNS = [
  /manager\/indexadmin\.php/i,
  /memstock\/indexmem\.php/i,
  /indexadmin/i,
  /indexmem/i,
];

// Payload SQL injection klasik untuk bypass login
const SQL_PAYLOADS = [
  { label: "Classic OR true",        user: "' OR '1'='1",       pass: "' OR '1'='1"      },
  { label: "OR 1=1 comment (--)",    user: "' OR 1=1--",         pass: "apapun"           },
  { label: "OR 1=1 comment (#)",     user: "' OR 1=1#",          pass: "apapun"           },
  { label: "Admin comment",          user: "admin'--",           pass: "apapun"           },
  { label: "Blank password bypass",  user: "' OR ''='",          pass: "' OR ''='"        },
  { label: "Always true string",     user: "' OR 'x'='x",       pass: "' OR 'x'='x"      },
  { label: "UNION based",            user: "' UNION SELECT 1,1,1--", pass: "apapun"       },
  { label: "Double dash comment",    user: "admin' --",          pass: "apapun"           },
  { label: "Null byte",              user: "admin\x00",          pass: "apapun"           },
  { label: "OR with parens",         user: "') OR ('1'='1",      pass: "') OR ('1'='1"    },
];

function isMasukDashboard(url) {
  return DASHBOARD_PATTERNS.some((pattern) => pattern.test(url));
}

test.describe('SQL Injection - Login Bypass', () => {

  for (const payload of SQL_PAYLOADS) {
    test(`Payload: ${payload.label}`, async ({ page }) => {
      await page.goto(LOGIN_URL);

      await page.fill('#login', payload.user);
      await page.fill('#password', payload.pass);

      let alertMessage = null;
      page.once('dialog', async (dialog) => {
        alertMessage = dialog.message();
        await dialog.accept();
      });

      await page.click('#btLogin');
      await page.waitForLoadState('networkidle');

      const currentUrl = page.url();
      const berhasilMasuk = isMasukDashboard(currentUrl);

      if (berhasilMasuk) {
        // Test GAGAL — sistem rentan, injection berhasil bypass login
        console.error(`VULNERABLE! Payload berhasil masuk: [${payload.label}]`);
        console.error(`  Username : ${payload.user}`);
        console.error(`  Password : ${payload.pass}`);
        console.error(`  URL      : ${currentUrl}`);
      } else {
        console.log(`Aman dari: [${payload.label}] | Alert: ${alertMessage ?? '(tidak ada)'}`);
      }

      // Assertion: login TIDAK boleh berhasil dengan payload injection
      expect(berhasilMasuk, `VULNERABLE terhadap SQL injection payload: "${payload.label}"`).toBe(false);
    });
  }

});
