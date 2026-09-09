<?php header("Content-Type: application/xml; charset=utf-8"); echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>";
$proto = (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] !== "off") ? "https" : "http";
$host = $_SERVER["HTTP_HOST"] ?? "localhost";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
  <url><loc><?= htmlspecialchars("$proto://$host/", ENT_QUOTES) ?></loc><changefreq>weekly</changefreq><priority>1.0</priority></url>
</urlset>
