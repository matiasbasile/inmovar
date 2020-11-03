<?php
$sql = "SELECT * FROM marcas WHERE id_empresa = $empresa->id AND path != '' ";
$q = mysqli_query($conx,$sql);
if (mysqli_num_rows($q)>0) { ?>
<section class="our-clients">
  <div class="container">
    <div class="row">
      <div class="owl-carousel">
        <?php while(($r=mysqli_fetch_object($q))!==NULL) { ?>
          <div class="client">
            <a href="<?php echo (!empty($r->link))?$r->link:"javascript:void(0)" ?>">
              <img src="/sistema/<?php echo $r->path; ?>" alt="<?php echo ($r->nombre); ?>" />
            </a>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
</section>
<?php } ?>