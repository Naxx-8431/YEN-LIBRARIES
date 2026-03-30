$htmlPath = "C:\Users\Fathima Afreen\OneDrive\Desktop\YEN-LIBRARY\index.html"
$html = Get-Content $htmlPath -Raw
$html = $html -replace ' *(?s)<!-- ══════════════ INTEGRATED DATABASES WIDGET ══════════════ -->\r?\n *<section class="section db-api-section">.*?</section>\r?\n+',"`r`n"
$html = $html -replace ' *(?s)<script>\r?\n *function openDbTab\(evt, tabId\).*?</script>\r?\n',""
Set-Content -Path $htmlPath -Value $html

$cssPath = "C:\Users\Fathima Afreen\OneDrive\Desktop\YEN-LIBRARY\assets\css\components.css"
$css = Get-Content $cssPath -Raw
$css = $css -replace '(?s)/\* ─── DATABASE API WIDGET ────────────────────── \*/.*',""
$css = $css.TrimEnd() + "`r`n"
Set-Content -Path $cssPath -Value $css
