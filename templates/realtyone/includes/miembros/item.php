<?php function item_miembros($m) { ?>
  <div class="col-lg-3 col-md-6 mt20">
    <div class="img-block">
      <img class="img-item" src="<?php echo $m->logo ?>" alt="<?php echo $m->nombre ?>">
      <div class="inner-title" style="border-top: 5px solid #8ec752;">
        <?php if (!empty($m->nombre)) { ?>
          <div class="entry-box-title tac">
            <h5><?php echo $m->nombre ?></h5>
          </div>
        <?php } ?>
      </div>
    </div>
  </div>
<?php } ?>