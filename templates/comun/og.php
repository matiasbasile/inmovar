<meta property="og:url" content="<?php echo current_url(); ?>" />
<meta property="og:type" content="website" />
<meta property="og:description" content="<?php echo $propiedad->seo_description; ?>" />
<meta property="og:site_name" content="<?php echo $empresa->nombre ?>">
<meta property="og:title" content="<?php echo $propiedad->seo_title ?>" />
<meta property="og:image" content="<?php echo current_url(true) . ((!empty($propiedad->imagen)) ? $propiedad->imagen : $empresa->no_imagen); ?>" />
<meta property="og:image:width" content="800"/>
<meta property="og:image:height" content="600"/>