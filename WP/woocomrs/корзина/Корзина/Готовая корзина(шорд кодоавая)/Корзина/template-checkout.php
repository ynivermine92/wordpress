<?php
/*
Template name: сheckout
*/
get_header();
breadcrumbs();
?>

<div class="woocommerce">
    <?php echo do_shortcode('[woocommerce_cart]'); ?>
</div>


<?php
get_footer();
