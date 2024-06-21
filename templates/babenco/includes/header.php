<header class="header">
  <div class="logo">
    <a href="<?php echo mklink("/") ?>"><img src="assets/images/logo.png" alt="logo"></a>
  </div>
  <div class="right-nav">
    <nav class="navbar navbar-expand-lg">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">
            <li class="nav-item">
              <a class="nav-link" href="<?php echo mklink("/") ?>">inicio</a></li>
            <li class="nav-item dropdown-nav">
              <a class="nav-link" href="#">la plata</a>
              <ul class="dropdown">
                <li><a href="#0">Venta</a></li>
                <li><a href="#0">Alquiler</a></li>
                <li><a href="#0">Emprendimientos</a></li>
              </ul>
            </li>
            <li class="nav-item dropdown-nav">
              <a class="nav-link" href="#">punta del este</a>
              <ul class="dropdown">
                <li><a href="#0">Venta</a></li>
                <li><a href="#0">Alquiler</a></li>
                <li><a href="#0">Emprendimientos</a></li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo mklink("/web/nosotros/") ?>">nosotros</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="<?php echo mklink("/contacto") ?>">contacto</a>
            </li>
            <div class="whishlist">
              <a href="#0">
              <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd" d="M12 6.00019C10.2006 3.90317 7.19377 3.2551 4.93923 5.17534C2.68468 7.09558 2.36727 10.3061 4.13778 12.5772C5.60984 14.4654 10.0648 18.4479 11.5249 19.7369C11.6882 19.8811 11.7699 19.9532 11.8652 19.9815C11.9483 20.0062 12.0393 20.0062 12.1225 19.9815C12.2178 19.9532 12.2994 19.8811 12.4628 19.7369C13.9229 18.4479 18.3778 14.4654 19.8499 12.5772C21.6204 10.3061 21.3417 7.07538 19.0484 5.17534C16.7551 3.2753 13.7994 3.90317 12 6.00019Z" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
              </svg><span>2</span></a>
            </div>
            <div class="socials">
              <ul>
                <?php if (!empty($empresa->facebook)) { ?>
                  <li>
                    <a target="_blank" href="<?php echo $empresa->facebook ?>">
                      <svg fill="#000000" width="800px" height="800px" viewBox="0 0 32 32" id="Camada_1" version="1.1" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><style type="text/css">  .st0{fill-rule:evenodd;clip-rule:evenodd;}</style><path class="st0" d="M12.6,16.1v11.6c0,0.2,0.1,0.3,0.3,0.3h4.6c0.2,0,0.3-0.1,0.3-0.3V15.9h3.4c0.2,0,0.3-0.1,0.3-0.3l0.3-3.6  c0-0.2-0.1-0.3-0.3-0.3h-3.7V9.2c0-0.6,0.5-1.1,1.2-1.1h2.6C21.9,8.1,22,8,22,7.8V4.3C22,4.1,21.9,4,21.7,4h-4.4  c-2.6,0-4.7,1.9-4.7,4.3v3.4h-2.3c-0.2,0-0.3,0.1-0.3,0.3v3.6c0,0.2,0.1,0.3,0.3,0.3h2.3V16.1z"/></svg>
                    </a>
                  </li>
                <?php } ?>
                <?php if (!empty($empresa->instagram)) { ?>
                  <li>
                    <a target="_blank" href="<?php echo $empresa->instagram ?>">
                      <svg width="800px" height="800px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M12 18C15.3137 18 18 15.3137 18 12C18 8.68629 15.3137 6 12 6C8.68629 6 6 8.68629 6 12C6 15.3137 8.68629 18 12 18ZM12 16C14.2091 16 16 14.2091 16 12C16 9.79086 14.2091 8 12 8C9.79086 8 8 9.79086 8 12C8 14.2091 9.79086 16 12 16Z" fill="#0F0F0F"/>
                      <path d="M18 5C17.4477 5 17 5.44772 17 6C17 6.55228 17.4477 7 18 7C18.5523 7 19 6.55228 19 6C19 5.44772 18.5523 5 18 5Z" fill="#0F0F0F"/>
                      <path fill-rule="evenodd" clip-rule="evenodd" d="M1.65396 4.27606C1 5.55953 1 7.23969 1 10.6V13.4C1 16.7603 1 18.4405 1.65396 19.7239C2.2292 20.8529 3.14708 21.7708 4.27606 22.346C5.55953 23 7.23969 23 10.6 23H13.4C16.7603 23 18.4405 23 19.7239 22.346C20.8529 21.7708 21.7708 20.8529 22.346 19.7239C23 18.4405 23 16.7603 23 13.4V10.6C23 7.23969 23 5.55953 22.346 4.27606C21.7708 3.14708 20.8529 2.2292 19.7239 1.65396C18.4405 1 16.7603 1 13.4 1H10.6C7.23969 1 5.55953 1 4.27606 1.65396C3.14708 2.2292 2.2292 3.14708 1.65396 4.27606ZM13.4 3H10.6C8.88684 3 7.72225 3.00156 6.82208 3.0751C5.94524 3.14674 5.49684 3.27659 5.18404 3.43597C4.43139 3.81947 3.81947 4.43139 3.43597 5.18404C3.27659 5.49684 3.14674 5.94524 3.0751 6.82208C3.00156 7.72225 3 8.88684 3 10.6V13.4C3 15.1132 3.00156 16.2777 3.0751 17.1779C3.14674 18.0548 3.27659 18.5032 3.43597 18.816C3.81947 19.5686 4.43139 20.1805 5.18404 20.564C5.49684 20.7234 5.94524 20.8533 6.82208 20.9249C7.72225 20.9984 8.88684 21 10.6 21H13.4C15.1132 21 16.2777 20.9984 17.1779 20.9249C18.0548 20.8533 18.5032 20.7234 18.816 20.564C19.5686 20.1805 20.1805 19.5686 20.564 18.816C20.7234 18.5032 20.8533 18.0548 20.9249 17.1779C20.9984 16.2777 21 15.1132 21 13.4V10.6C21 8.88684 20.9984 7.72225 20.9249 6.82208C20.8533 5.94524 20.7234 5.49684 20.564 5.18404C20.1805 4.43139 19.5686 3.81947 18.816 3.43597C18.5032 3.27659 18.0548 3.14674 17.1779 3.0751C16.2777 3.00156 15.1132 3 13.4 3Z" fill="#0F0F0F"/>
                      </svg>
                    </a>
                  </li>
                <?php } ?>
              </ul>
            </div>
        </ul>
        </div>
    </nav>
  </div>
</header>