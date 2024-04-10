<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="article" />
<meta property="og:title" content="<?php echo $propiedad->nombre; ?>" />
<meta property="og:description" content="<?php echo str_replace("\n", "", substr(strip_tags($propiedad->texto), 0, 300) . ((strlen($propiedad->texto) > 300) ? "..." : "")); ?>" />
<?php
$imagen_ppal = "";
if (empty($propiedad->path) && !empty($propiedad->video)) {
  preg_match('/src="([^"]+)"/', $propiedad->video, $match);
  if (sizeof($match) > 0) {
    $src_iframe = $match[1];
    $id_video = str_replace("https://www.youtube.com/embed/", "", $src_iframe);
    $imagen_ppal = "https://img.youtube.com/vi/$id_video/0.jpg";
  }
} else {
  $imagen_ppal = current_url(TRUE) . "/admin/" . $propiedad->path;
}
if (empty($imagen_ppal)) $imagen_ppal = current_url(TRUE) . "/admin/" . $empresa->no_imagen;
?>
<meta property="og:image" content="<?php echo $imagen_ppal; ?>" />
