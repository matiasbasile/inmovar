<?php
$testimonios = $web_model->get_testimonios();
if (sizeof($testimonios)>0) { ?>
  <section id="testimonials" class="block">
    <div class="container">
      <header class="section-title"><h2>Testimonios</h2></header>
      <div class="owl-carousel testimonials-carousel">
        <?php foreach($testimonios as $r) { ?>
        <blockquote class="testimonial">
          <?php if (!empty($r->path)) { ?>
          <figure>
            <div class="image">
              <img alt="<?php echo $r->nombre ?>" src="<?php echo $r->path ?>">
            </div>
          </figure>
          <?php } ?>
          <aside class="cite">
            <p><?php echo $r->texto ?></p>
            <footer><?php echo $r->nombre ?></footer>
          </aside>
        </blockquote>
        <?php } ?>
      </div><!-- /.testimonials-carousel -->
    </div><!-- /.container -->
  </section>
<?php } ?>