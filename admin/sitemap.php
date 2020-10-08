<?php
$xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8"?><urlset/>');
$xml->addAttribute("xmlns","http://www.sitemaps.org/schemas/sitemap/0.9");

// PAGINAS ESPECIFICAS ADMINISTRADAS POR EL USUARIO
$q = mysqli_query($conx,"SELECT * FROM web_sitemap WHERE id_empresa = $empresa->id AND activo = 1 ORDER BY priority DESC");
while(($r=mysqli_fetch_object($q))!==NULL) {
  $url = $xml->addChild("url");
  $url->addChild("loc",mklink($r->url));
  if ($r->lastmod != "0000-00-00") $url->addChild("lastmod",$r->lastmod);
  if (!empty($r->changefreq)) $url->addChild("changefreq",$r->changefreq);
  if (!empty($r->priority)) $url->addChild("priority",$r->priority);
}

// PAGINAS DINAMICAS
// ====================================================

// Articulos
$q = mysqli_query($conx,"SELECT * FROM articulos WHERE id_empresa = $empresa->id AND lista_precios >= 1 ORDER BY last_update DESC");
while(($r=mysqli_fetch_object($q))!==NULL) {
  $url = $xml->addChild("url");
  $url->addChild("loc",utf8_encode(mklink($r->link)));
  $url->addChild("lastmod",date("Y-m-d H:i:s",$r->last_update));
  $url->addChild("changefreq","weekly");
  $url->addChild("priority","0.6");
}

// Propiedades
$q = mysqli_query($conx,"SELECT * FROM inm_propiedades WHERE id_empresa = $empresa->id AND activo = 1");
while(($r=mysqli_fetch_object($q))!==NULL) {
  $url = $xml->addChild("url");
  $url->addChild("loc",utf8_encode(mklink($r->link)));
}

// Categorias de noticias

// Entradas
$q = mysqli_query($conx,"SELECT * FROM not_entradas WHERE id_empresa = $empresa->id AND activo = 1 AND seo_ocultar_sitemap = 0 ");
while(($r=mysqli_fetch_object($q))!==NULL) {
  $url = $xml->addChild("url");
  $url->addChild("loc",utf8_encode(mklink($r->link)));
  if (!empty($r->seo_sitemap_change_freq)) $url->addChild("changefreq",$r->seo_sitemap_change_freq);
  if (!empty($r->seo_sitemap_priority)) $url->addChild("priority",$r->seo_sitemap_priority);
}

echo $xml->asXML();
?>