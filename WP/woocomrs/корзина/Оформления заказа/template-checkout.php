<?php
/*
Template name: сheckout
*/
get_header();
breadcrumbs();
?>
    <?php echo do_shortcode('[woocommerce_checkout]'); ?>

<?php
get_footer();
