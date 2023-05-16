<?php
function item_entrada($ent)
{ ?>
  <div class="col-lg-4 col-md-6">
    <div class="img-block">
      <?php if (!empty($ent->path)) { ?>
        <img src="<?php echo $ent->path ?>" alt="Noticia">
      <?php } ?>
      <div class="date">
        <img src="assets/images/calender-icon.svg" alt="icon">
        <?php echo $ent->fecha ?>
      </div>
      <div class="inner-title">
        <?php if (!empty($ent->titulo)) { ?>
          <div class="entry-box-title">
            <h5><?php echo $ent->titulo ?></h5>
          </div>
        <?php } ?>
        <?php if (!empty($ent->plain_text)) { ?>
          <p><?php echo $ent->plain_text ?></p>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>

?>