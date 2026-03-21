<?php
// Проверяем, есть ли строки в flexible_content


$hero_data = get_field('flexible_content'); // массив всех блоков

?>
<div class="green-block">
    <?= esc_html($hero_data['flexible_title']); ?>

</div>


<style>
    .green-block {
        background-color: black;
        color: red;
        padding: 20px;
        margin-bottom: 20px;
        height: 100px;
        width: 100%;
    }

    .gallery-block img {
        width: 150px;
        margin: 5px;
    }
</style>