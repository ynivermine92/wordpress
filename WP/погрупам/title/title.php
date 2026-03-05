
<? function title()
{
  if (function_exists('is_woocommerce') && is_woocommerce()) {
        echo woocommerce_page_title(false);
  } else {
    the_title();
  }
}

/* выводит сразу так как вокомерсет так и на обычной странице */