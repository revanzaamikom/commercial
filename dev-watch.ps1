#!/usr/bin/env pwsh
# PAKTJIP dev watcher — PHP server + Browsersync auto-reload
# Usage: pwsh dev-watch.ps1   (browser buka http://localhost:3000)
$root = "D:\Websites\CommercialPT\paktjip-website"
$php  = "C:\xampp\php\php.exe"

# 1. PHP server on 8001 (if not running)
try { Invoke-WebRequest -Uri "http://127.0.0.1:8001/" -UseBasicParsing -TimeoutSec 5 | Out-Null }
catch { Start-Process $php -ArgumentList "-S","0.0.0.0:8001","-t","$root\public" -WindowStyle Hidden; Start-Sleep 2 }

# 2. MySQL (if not running)
try { & "C:\xampp\mysql\bin\mysqladmin.exe" -u root ping 2>$null | Out-Null }
catch { Start-Process "C:\xampp\mysql\bin\mysqld.exe" -ArgumentList "--defaults-file=C:\xampp\mysql\bin\my.ini","--standalone" -WindowStyle Hidden; Start-Sleep 4 }

# 3. Browsersync proxy + watch
& "$env:TEMP\opencode\node_modules\.bin\browser-sync.cmd" start `
  --proxy "http://127.0.0.1:8001" `
  --files "$root\public\**\*.php","$root\public\assets\**\*.css","$root\public\assets\**\*.js","$root\public\assets\**\*.webp" `
  --port 3000 `
  --no-open
