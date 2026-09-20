<?php
// menu.php -- static content only, .php extension is a deploy-naming
// requirement (the server target expects this exact filename), not an
// indicator of any server-side logic. There is none.
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Aminah Menu</title>
  <link rel="manifest" href="manifest.json">
  <link rel="icon" type="image/png" href="icons/icon-192.png">
  <link rel="apple-touch-icon" href="icons/icon-192.png">
  <meta name="theme-color" content="#0369a1">
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <style>
    :root {
      --amh-bg-gradient: radial-gradient(circle at 50% -10%, #0284c7 0%, #0369a1 35%, #0f172a 75%, #080d1a 100%);
      --amh-amber-300: #fbbf24;
      --amh-text: #e2e8f0;
      --amh-text-dim: #cbd5e1;
    }
    * { box-sizing: border-box; }
    body {
      margin: 0;
      min-height: 100vh;
      background: var(--amh-bg-gradient) fixed;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      color: var(--amh-text);
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 3rem 1.25rem;
    }
    .amh-menu-header {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 0.75rem;
      margin-bottom: 2.5rem;
    }
    .amh-menu-logo {
      width: 96px;
      height: 96px;
      background: #fff;
      border-radius: 999px;
      padding: 0.75rem;
      box-shadow: 0 0 20px rgba(212, 175, 55, 0.3);
    }
    .amh-menu-logo img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }
    .amh-menu-title {
      font-size: 1.5rem;
      font-weight: 800;
      color: var(--amh-amber-300);
      margin: 0;
      letter-spacing: 0.02em;
    }
    .amh-menu-list {
      width: 100%;
      max-width: 420px;
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .amh-menu-card {
      display: flex;
      align-items: center;
      gap: 1rem;
      padding: 1.1rem 1.25rem;
      background: rgba(15, 23, 42, 0.55);
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border: 1px solid rgba(255, 255, 255, 0.1);
      border-radius: 14px;
      text-decoration: none;
      color: var(--amh-text);
      transition: border-color 0.2s, transform 0.2s;
    }
    .amh-menu-card:hover, .amh-menu-card:focus {
      border-color: var(--amh-amber-300);
      transform: translateY(-2px);
    }
    .amh-menu-card-icon {
      width: 48px;
      height: 48px;
      border-radius: 12px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 1.4rem;
      color: #fff;
      flex-shrink: 0;
    }
    .amh-menu-card-icon.tour { background: linear-gradient(135deg, #38bdf8, #0369a1); }
    .amh-menu-card-icon.techno { background: linear-gradient(135deg, #fde68a, #f59e0b); color: #1e293b; }
    .amh-menu-card-icon.intern { background: linear-gradient(135deg, #4ade80, #15803d); }
    .amh-menu-card-icon.aminahku { background: linear-gradient(135deg, #f0abfc, #a21caf); }
    .amh-menu-card-label {
      font-size: 1.05rem;
      font-weight: 600;
    }
    #amh-install-btn {
      position: fixed;
      top: 1rem;
      right: 1rem;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: rgba(15, 23, 42, 0.7);
      border: 1px solid rgba(255, 255, 255, 0.15);
      display: none;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      padding: 0;
    }
    #amh-install-btn img {
      width: 22px;
      height: 22px;
    }
  </style>
</head>
<body>

  <button id="amh-install-btn" title="Install Aminah Menu" aria-label="Install Aminah Menu">
    <img src="icons/playstore-icon.png" alt="Install">
  </button>

  <div class="amh-menu-header">
    <div class="amh-menu-logo">
      <img src="icons/logo-header.png" alt="Aminah Logo">
    </div>
    <h1 class="amh-menu-title">Aminah Menu</h1>
  </div>

  <div class="amh-menu-list">
    <a class="amh-menu-card" href="https://www.aminahtour.co.id" target="_blank" rel="noopener">
      <span class="amh-menu-card-icon tour"><i class="fa fa-plane"></i></span>
      <span class="amh-menu-card-label">Aminah Tour</span>
    </a>
    <a class="amh-menu-card" href="https://www.amhtechno.com" target="_blank" rel="noopener">
      <span class="amh-menu-card-icon techno"><i class="fa fa-building"></i></span>
      <span class="amh-menu-card-label">AMH Techno</span>
    </a>
    <!-- Temporary: v2.amhtechno.com until intern.amhtechno.com goes live in production -->
    <a class="amh-menu-card" href="https://v2.amhtechno.com" target="_blank" rel="noopener">
      <span class="amh-menu-card-icon intern"><i class="fa fa-user-shield"></i></span>
      <span class="amh-menu-card-label">AMH Intern</span>
    </a>
    <a class="amh-menu-card" href="https://www.aminahku.com" target="_blank" rel="noopener">
      <span class="amh-menu-card-icon aminahku"><i class="fa fa-heart"></i></span>
      <span class="amh-menu-card-label">Aminahku</span>
    </a>
  </div>

  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', function () {
        navigator.serviceWorker.register('service-worker.js').catch(function (err) {
          console.error('Service worker registration failed:', err);
        });
      });
    }

    (function () {
      var installBtn = document.getElementById('amh-install-btn');
      var deferredPrompt = null;

      // Already running as an installed app -- never show the button.
      if (window.matchMedia('(display-mode: standalone)').matches) {
        return;
      }

      // Chrome/Edge only -- iOS Safari has no equivalent event at all, so
      // the button correctly never appears there (no programmatic install
      // path exists on iOS; users must use Share > Add to Home Screen).
      window.addEventListener('beforeinstallprompt', function (event) {
        event.preventDefault();
        deferredPrompt = event;
        installBtn.style.display = 'flex';
      });

      installBtn.addEventListener('click', function () {
        if (!deferredPrompt) return;
        deferredPrompt.prompt();
        deferredPrompt.userChoice.finally(function () {
          deferredPrompt = null;
        });
      });

      window.addEventListener('appinstalled', function () {
        installBtn.style.display = 'none';
        deferredPrompt = null;
      });
    })();
  </script>
</body>
</html>
