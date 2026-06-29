## PURPOSE
AMHIntern is a production Multi-Level Marketing (MLM) and network management platform combined with e-commerce, tour booking, and e-wallet features. Its core focus is on tracking member genealogies, managing upline/downline relationships, calculating complex commission structures, and processing product sales.

## STACK
- **Language**: PHP (Legacy PHP 5.x code structure; requires PHP <= 5.6 or a compatibility shim due to deprecated mysql_* API usage).
- **Database**: MySQL.
- **Frontend**: Traditional server-rendered pages using HTML, CSS, JavaScript, and various vendor assets (jQuery, Bootstrap, select2, Chart.js, malihu-scrollbar, moment, etc.).
- **Server Environment**: Deployed on Apache + MySQL. Hostname-based environment routing selects the target database (Production: intern.amhtechno.com -> amhtechn_intern; Trial: trial.amhtechno.com -> amhtechn_intrial; Training: training.amhtechno.com -> amhtechn_intrain).

## ARCHITECTURE
- **Entry Points & Routing**: Standalone, procedural PHP files act as pages. No centralized router framework. `index.php` routes users depending on `$_SESSION['privilege']` to `/manager/indexadmin.php` (Admin), `/memstock/indexmem.php` (Member), or `/main/loginform.php` (Login).
- **Module Structure**:
  - `classes/`: Core business logic class containers (e.g., phplib.php, memberclass.php, networkclass.php, komisiclass.php, jualclass.php).
  - `main/`: Public facing pages, REST API endpoints, and standalone commission recalculation scripts (`calc*.php`).
  - `manager/`: Administrator-only operations, reporting, approvals, and system settings.
  - `memstock/`: Member-specific dashboards, wallet management, product purchases, and tour booking.
  - `masterdata/`: Configuration/CRUD interface for products, tours, banks, and geographical data.
  - `server/`: Environment boots and global DB connections setup (`server/config.php`).
- **Templates**: Standard PHP files rendering HTML and using mock-Blade syntax files from `framework/` rendered manually (e.g. `manager_topnav.blade.php`).

## PATTERNS
- **Database Connections**: Legacy DB wrapper `DB_MySQL` in `classes/phplib.php` is instantiated into multiple global connections ($db, $dbin, $db1, $dbmenu, $oDB, etc.) used simultaneously.
- **Dependency Management**: Class files are manually included via `include_once` or `require_once` statements at the top of page scripts. No class autoloader is configured.
- **SQL Interpolation**: SQL queries are constructed directly via string concatenation of input data. Enhancements must ensure inputs are properly escaped/validated to prevent SQL injection.
- **Snapshots**: Historical deployments are kept as timestamped archives inside `classes/Live_*/` subfolders (e.g. `Live_19042026`). These must not be altered.
- **Calculations**: Commission calculations (`calc*.php` files in `main/`) are triggered externally via HTTP GET parameters (`uStart`, `uDate`) and execute large batches of procedural network traversal queries.

## TRADEOFFS
- **Backward Compatibility over Modernization**: Keeping the legacy `mysql_*` structure avoids breaking existing complex SQL operations, at the expense of preventing easy PHP runtime upgrades.
- **Procedural Execution**: Simple deployment (direct FTP/file upload to Apache) at the cost of unified error/exception handling, middleware, and modular testing.

## PHILOSOPHY
The project values directness, low build overhead, and procedural simplicity. Changes should align with the existing procedural pattern, reuse instantiated database helper connections ($db, $dbin, etc.), and maintain manual include structures, while carefully checking for security and query performance in large tree traversals.