<?php if (sizeof($vc_listado) > 0 && $vc_total_paginas > 1) { ?>
  <nav aria-label="Page navigation example">
    <ul class="pagination">

      <?php if ($vc_page > 0) { ?>
        <li class="page-item first"><a class="page-link" href="javascript:void(0)" onclick="pagination(<?php echo ($vc_page-1) ?>)"></a></li>
      <?php } ?>

      <?php for($i=0;$i<$vc_total_paginas;$i++) { ?>
        <?php if (abs($vc_page-$i)<3) { ?>
          <?php if ($i == $vc_page) { ?>
            <li class="page-item active"><a class="page-link"><?php echo $i+1 ?></a></li>
          <?php } else { ?>
            <li class="page-item"><a class="page-link" href="javascript:void(0)" onclick="pagination(<?php echo $i ?>)"><?php echo $i+1 ?></a></li>
          <?php } ?>
        <?php } ?>
      <?php } ?>

      <?php if ($vc_page < $vc_total_paginas-1) { ?>
        <li class="page-item last"><a class="page-link" href="javascript:void(0)" onclick="pagination(<?php echo ($vc_page+1) ?>)"></a></li>
      <?php } ?>

    </ul>
  </nav>
<?php } ?>