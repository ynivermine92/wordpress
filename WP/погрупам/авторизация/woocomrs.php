
<?

// Обработка регистрации
add_action('init', 'my_custom_registration_handler');
function my_custom_registration_handler()
{
    if (isset($_POST['custom_registration_form'])) {

        if (
            !isset($_POST['custom_registration_nonce']) ||
            !wp_verify_nonce($_POST['custom_registration_nonce'], 'custom_registration')
        ) {
            wc_add_notice('Security error, please try again.', 'error');
            return;
        }

        if (empty($_POST['terms'])) {
            wc_add_notice('You must agree with terms.', 'error');
            return;
        }

        $username = sanitize_user($_POST['username']);
        $email = sanitize_email($_POST['email']);
        $password = $_POST['password'];

        if (username_exists($username)) {
            wc_add_notice('Username already exists.', 'error');
            return;
        }

        if (email_exists($email)) {
            wc_add_notice('Email already registered.', 'error');
            return;
        }

        $user_id = wp_create_user($username, $password, $email);

        if (is_wp_error($user_id)) {
            wc_add_notice('Could not create user.', 'error');
            return;
        }

        wp_set_current_user($user_id);
        wp_set_auth_cookie($user_id);
        do_action('wp_login', $username, get_user_by('id', $user_id));

        wp_safe_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }
}

// Обработка логина
add_action('init', 'my_custom_login_handler');
function my_custom_login_handler()
{
    if (isset($_POST['custom_login_form'])) {

        if (
            !isset($_POST['custom_login_nonce']) ||
            !wp_verify_nonce($_POST['custom_login_nonce'], 'custom_login')
        ) {
            wc_add_notice('Security error, please try again.', 'error');
            return;
        }

        $username = sanitize_user($_POST['username']);
        $password = $_POST['password'];
        $remember = !empty($_POST['remember']);

        $creds = array(
            'user_login'    => $username,
            'user_password' => $password,
            'remember'      => $remember,
        );

        $user = wp_signon($creds, is_ssl());

        if (is_wp_error($user)) {
            wc_add_notice('Invalid login or password.', 'error');
            return;
        }

        wp_set_current_user($user->ID);
        wp_set_auth_cookie($user->ID, $remember);

        wp_safe_redirect(wc_get_page_permalink('myaccount'));
        exit;
    }
}
