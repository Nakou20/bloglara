# Script de restauration des composants originaux

$componentsPath = "C:\Users\sasha\Desktop\BTS SIO 2\SLAM4\TP-Restoration\bloglara\resources\views\components"

# primary-button.blade.php
$primaryButtonContent = @'
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
'@

# secondary-button.blade.php
$secondaryButtonContent = @'
<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
'@

# danger-button.blade.php
$dangerButtonContent = @'
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 active:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
'@

# nav-link.blade.php
$navLinkContent = @'
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-indigo-400 dark:border-indigo-600 text-sm font-medium leading-5 text-gray-900 dark:text-gray-100 focus:outline-none focus:border-indigo-700 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-700 focus:outline-none focus:text-gray-700 dark:focus:text-gray-300 focus:border-gray-300 dark:focus:border-gray-700 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
'@

# responsive-nav-link.blade.php
$responsiveNavLinkContent = @'
@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-indigo-400 dark:border-indigo-600 text-start text-base font-medium text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 focus:outline-none focus:text-indigo-800 dark:focus:text-indigo-200 focus:bg-indigo-100 dark:focus:bg-indigo-900 focus:border-indigo-700 dark:focus:border-indigo-300 transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-gray-600 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 hover:border-gray-300 dark:hover:border-gray-600 focus:outline-none focus:text-gray-800 dark:focus:text-gray-200 focus:bg-gray-50 dark:focus:bg-gray-700 focus:border-gray-300 dark:focus:border-gray-600 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
'@

# dropdown-link.blade.php
$dropdownLinkContent = @'
<a {{ $attributes->merge(['class' => 'block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out']) }}>{{ $slot }}</a>
'@

# Créer les fichiers
$primaryButtonContent | Out-File -FilePath "$componentsPath\primary-button.blade.php" -Encoding UTF8 -NoNewline
$secondaryButtonContent | Out-File -FilePath "$componentsPath\secondary-button.blade.php" -Encoding UTF8 -NoNewline
$dangerButtonContent | Out-File -FilePath "$componentsPath\danger-button.blade.php" -Encoding UTF8 -NoNewline
$navLinkContent | Out-File -FilePath "$componentsPath\nav-link.blade.php" -Encoding UTF8 -NoNewline
$responsiveNavLinkContent | Out-File -FilePath "$componentsPath\responsive-nav-link.blade.php" -Encoding UTF8 -NoNewline
$dropdownLinkContent | Out-File -FilePath "$componentsPath\dropdown-link.blade.php" -Encoding UTF8 -NoNewline

Write-Host "✅ Tous les composants ont été restaurés avec succès!" -ForegroundColor Green
Write-Host ""
Write-Host "Composants restaurés:" -ForegroundColor Cyan
Write-Host "  - primary-button.blade.php" -ForegroundColor White
Write-Host "  - secondary-button.blade.php" -ForegroundColor White
Write-Host "  - danger-button.blade.php" -ForegroundColor White
Write-Host "  - nav-link.blade.php" -ForegroundColor White
Write-Host "  - responsive-nav-link.blade.php" -ForegroundColor White
Write-Host "  - dropdown-link.blade.php" -ForegroundColor White

