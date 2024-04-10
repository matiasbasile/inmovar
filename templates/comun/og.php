<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php echo trim($propiedad->seo_description); ?>" />
<meta property="og:site_name" content="<?php echo trim($empresa->nombre) ?>">
<meta property="og:title" content="<?php echo trim($propiedad->seo_title) ?>" />

<?php
$imagen_ppal = "";
if (empty($propiedad->path) && !empty($propiedad->video)) {
  // Ponemos el preview del video
  preg_match('/src="([^"]+)"/', $propiedad->video, $match);
  if (sizeof($match) > 0) {
    $src_iframe = $match[1];
    $id_video = str_replace("https://www.youtube.com/embed/", "", $src_iframe);
    $imagen_ppal = "https://img.youtube.com/vi/$id_video/0.jpg";
  }
} else if (strpos($propiedad->path, "http") === 0) {
  // Es una imagen externa
  $imagen_ppal = $propiedad->path;
} else {
  $imagen_ppal = current_url(TRUE) . "/admin/" . $propiedad->path;
}
if (empty($imagen_ppal)) $imagen_ppal = current_url(TRUE) . "/admin/" . $empresa->no_imagen;
?>
<meta property="og:image" content="<?php echo $imagen_ppal; ?>" />
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="600"/>