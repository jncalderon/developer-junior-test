$ErrorActionPreference = 'Stop'

Set-Location -LiteralPath $PSScriptRoot

function Invoke-CheckedCommand {
    param(
        [Parameter(Mandatory = $true)]
        [string]$Command,

        [Parameter(ValueFromRemainingArguments = $true)]
        [string[]]$Arguments
    )

    & $Command @Arguments
    if ($LASTEXITCODE -ne 0) {
        throw "Command failed with exit code ${LASTEXITCODE}: $Command $($Arguments -join ' ')"
    }
}

if (-not (Get-Command docker -ErrorAction SilentlyContinue)) {
    throw 'Docker is required. Install and start Docker Desktop, then run this script again.'
}

if (-not (Test-Path -LiteralPath '.env')) {
    Copy-Item -LiteralPath '.env.example' -Destination '.env'
}

New-Item -ItemType Directory -Force -Path @(
    'bootstrap/cache',
    'database',
    'storage/framework/cache/data',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs'
) | Out-Null

if (-not (Test-Path -LiteralPath 'database/database.sqlite')) {
    New-Item -ItemType File -Path 'database/database.sqlite' | Out-Null
}

if (-not (Test-Path -LiteralPath 'vendor/autoload.php')) {
    Write-Host 'Installing dependencies with Docker...'
    Invoke-CheckedCommand docker run --rm `
        --mount "type=bind,source=$PSScriptRoot,target=/app" `
        --workdir /app `
        composer:2 `
        composer install --no-interaction --prefer-dist
}

Invoke-CheckedCommand docker compose up -d --build
Invoke-CheckedCommand docker compose exec -T laravel.test php artisan key:generate --force
Invoke-CheckedCommand docker compose exec -T laravel.test php artisan migrate:fresh --seed

$appPort = 8080
$envContent = Get-Content -LiteralPath '.env' -ErrorAction SilentlyContinue
$portMatch = $envContent | Select-String -Pattern '^\s*APP_PORT\s*=\s*(\d+)\s*$' | Select-Object -First 1
if ($null -ne $portMatch) {
    $appPort = [int]$portMatch.Matches[0].Groups[1].Value
}

$url = "http://localhost:$appPort/up"
$ready = $false
for ($attempt = 1; $attempt -le 30; $attempt++) {
    try {
        Invoke-WebRequest -Uri $url -UseBasicParsing -TimeoutSec 2 | Out-Null
        $ready = $true
        break
    } catch {
        Start-Sleep -Seconds 1
    }
}

if ($ready) {
    Write-Host "`nReady: http://localhost:$appPort"
    exit 0
}

Write-Error "The container started, but $url is not responding."
Write-Host 'Check the logs with: docker compose logs'
exit 1
