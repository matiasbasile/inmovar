<base href="/templates/<?php echo $empresa->template_path ?>/"/>
<meta http-equiv="content-type" content="text/html; charset=UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
<title><?php echo (isset($seo_title)) ? (html_entity_decode($seo_title,ENT_QUOTES)) : (html_entity_decode($empresa->seo_title,ENT_QUOTES)); ?></title>
<?php
$description = (isset($seo_description)) ? (html_entity_decode($seo_description,ENT_QUOTES)) : (html_entity_decode($empresa->seo_description,ENT_QUOTES));
$description = (str_replace("\n","",$description));
?>
<meta name="description" content="<?php echo $description; ?>">
<meta name="keywords" content="<?php echo (isset($seo_keywords)) ? (html_entity_decode($seo_keywords,ENT_QUOTES)) : (html_entity_decode($empresa->seo_keywords,ENT_QUOTES)); ?>">
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="/sistema/resources/css/common.css">
<link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/sistema/resources/css/bootstrap-cols.css">
<!--[if lt IE 9]>
<script src="js/html5shiv.js"></script>
<![endif]-->
<link rel="shortcut icon" href="images/favicon.png" type="image/x-icon">
<link href="css/main.css" type="text/css" media="all" rel="stylesheet">
<?php echo html_entity_decode($empresa->analytics,ENT_QUOTES); ?>    
<!-- TODO: unificar los JS -->
<!-- TODO: Poner los JS en la carpeta del sistema, para que pueda ser compartido por varios proyectos -->
<script type="text/javascript" src="/sistema/resources/js/common.js"></script>
<script type="text/javascript" src="/sistema/resources/js/main.js"></script>
<script type="text/javascript" src="/sistema/resources/js/md5.js"></script>
<script type="text/javascript">
// Constantes que se utilizan en el sistema
const ID_EMPRESA = "<?php echo $empresa->id ?>";
</script>
<?php echo html_entity_decode($empresa->zopim,ENT_QUOTES); ?>    