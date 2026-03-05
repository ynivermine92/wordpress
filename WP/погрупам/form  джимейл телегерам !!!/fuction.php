
<?

/// -----------------------------
// 2️⃣ Обработка AJAX формы
function send_feedback()
{
  check_ajax_referer('feedback_nonce', 'nonce'); // защита

  $name    = sanitize_text_field($_POST['fb_name'] ?? '');
  $phone   = sanitize_text_field($_POST['fb_phone'] ?? '');
  $comment = sanitize_textarea_field($_POST['fb_comment'] ?? '');

  if (!$name || !$phone || !$comment) {
    wp_send_json_error('Заполните все поля');
  }

  // -----------------------
  // 3️⃣ Создаём запись в админке
  $post_id = wp_insert_post([
    'post_type'    => 'feedback',
    'post_title'   => $name,
    'post_content' => "Телефон: $phone\nСообщение: $comment",
    'post_status'  => 'publish',
  ]);

  if (!$post_id) {
    wp_send_json_error('Ошибка при добавлении в БД');
  }



  // ----------------- 4️⃣ Отправка в Telegram -----------------
// Проверяем, что токен есть
if (defined('BOT_TOKEN') && BOT_TOKEN !== '') {
    $chatId = "726820216"; // твой chat_id  получу когда по сссылке перейду  там будет айди бота

    $text = "Новая заявка с сайта:\n";
    $text .= "Имя: $name\n";
    $text .= "Телефон: $phone\n";
    $text .= "Сообщение:\n$comment";

    // Отправка в Telegram
    @file_get_contents("https://api.telegram.org/bot" . BOT_TOKEN . "/sendMessage?chat_id=$chatId&text=" . urlencode($text));
} else {
    // Если токен пустой, просто логируем
    error_log('Telegram бот токен не найден');
}









  // -----------------------
  // 4️⃣ Отправка письма на Gmail через SMTP
  $to      = 'impulsex92@gmail.com'; // <- сюда придёт письмо
  $subject = 'Новое сообщение с сайта';
  $body    = "Имя: $name\nТелефон: $phone\nСообщение:\n$comment";
  $headers = ['Content-Type: text/plain; charset=UTF-8'];

  $sent = wp_mail($to, $subject, $body, $headers);

  if ($sent) {
    wp_send_json_success('Сообщение успешно отправлено!');
  } else {
    wp_send_json_error('Письмо не отправлено, проверьте SMTP настройки.');
  }
}

// -----------------------------
// 5️⃣ Подключаем AJAX хуки
add_action('wp_ajax_send_feedback', 'send_feedback');       // для авторизованных
add_action('wp_ajax_nopriv_send_feedback', 'send_feedback'); // для гостей

// -----------------------------
// 6️⃣ Передача AJAX URL и nonce в JS
add_action('wp_enqueue_scripts', function () {
  wp_localize_script('fast-vid-script', 'feedback_ajax_obj', [
    'ajax_url' => admin_url('admin-ajax.php'),
    'nonce'    => wp_create_nonce('feedback_nonce')
  ]);
});










// -----------------------------
// 7️⃣ Настройка SMTP для Gmail
add_action('phpmailer_init', function ($phpmailer) {
  $phpmailer->isSMTP();
  $phpmailer->Host       = 'smtp.gmail.com';
  $phpmailer->SMTPAuth   = true;
  $phpmailer->Port       = 465;
  $phpmailer->Username   = GMAIL_USERNAME;
  $phpmailer->Password   = GMAIL_APP_PASSWORD;
  $phpmailer->SMTPSecure = 'ssl';
  $phpmailer->From       = GMAIL_USERNAME;
  $phpmailer->FromName   = 'Сайт loverflower';
});

// -----------------------------
// 8️⃣ Логирование ошибок SMTP (для отладки)
add_action('wp_mail_failed', function ($wp_error) {
  error_log(print_r($wp_error, true));
});


