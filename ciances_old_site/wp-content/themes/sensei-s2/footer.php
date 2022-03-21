<?php
/**
 * The template for displaying the footer
 *
 * @package Sensei S2
 * @version 2.2.5
 */

?>

<footer>
  <div class="footer spacer">
    <div class="line"></div>
    <div class="content clearfix">
      <div class="col-8">
        <div class="divider">
          <?php dynamic_sidebar( 'footer-left' )?>
        </div> <!-- divider -->
      </div> <!-- col-8 -->
      <div class="col-4">
        <div class="divider">
          <?php dynamic_sidebar( 'footer-right' )?>
        </div> <!-- divider -->
      </div> <!-- col-4 -->
    </div> <!-- content -->
</div> <!-- footer -->
</footer>
<?php wp_footer(); ?>
</body>
</html>
