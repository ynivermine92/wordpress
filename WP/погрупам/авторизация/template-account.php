<?php
/*
Template name: account
*/
get_header();
breadcrumbs();
?>

<?php if (is_user_logged_in()): ?>
    <section class="model">
        <div class="container">
            <?php
            $current_user = wp_get_current_user();
            ?>
                <h2 class="model__logaut-user"><span>Hello :</span>  <?php echo esc_html($current_user->display_name ? $current_user->display_name : $current_user->user_login); ?></h2>
            <div class="model__logaut-wrapper">
                <p class="model__text">You are already logged in.</p>
                <a class="model__logaut" href="<?php echo wp_logout_url(home_url()); ?>">Log out</a>
            </div>
        </div>
    </section>
<?php else: ?>
    <section class="model">
        <div class="container">
            <div class="model__links">
                <a class="model__link model__link--active" href="#" onclick="showTab(event, 'register')">Register</a>
                <a class="model__link" href="#" onclick="showTab(event, 'login')">Login</a>
            </div>

            <?php if (function_exists('wc_print_notices')) wc_print_notices(); ?>

            <!-- Registration Form -->
            <form class="model__form" method="post" id="register">
                <input type="hidden" name="custom_registration_form" value="1" />
                <?php wp_nonce_field('custom_registration', 'custom_registration_nonce'); ?>
                <label class="model__label">
                    Email address*
                    <input class="model__input" type="email" name="email" required />
                </label>
                <label class="model__label">
                    Username*
                    <input class="model__input" type="text" name="username" required />
                </label>
                <label class="model__label">
                    Password*
                    <input class="model__input" type="password" name="password" required />
                </label>
                <label class="model__label">
                    <input type="checkbox" name="terms" value="1" /> Agree with Terms & Conditions
                </label>
                <button class="model__btn" type="submit">Register</button>
            </form>

            <!-- Login Form -->
            <form class="model__form" method="post" id="login" style="display:none;">
                <input type="hidden" name="custom_login_form" value="1" />
                <?php wp_nonce_field('custom_login', 'custom_login_nonce'); ?>
                <label class="model__label">
                    Username or Email*
                    <input class="model__input" type="text" name="username" required />
                </label>
                <label class="model__label">
                    Password*
                    <input class="model__input" type="password" name="password" required />
                </label>
                <label class="model__label">
                    <input type="checkbox" name="remember" value="1"> Remember me
                </label>
                <button class="model__btn" type="submit">Log in</button>
                <a class="model__error" href="<?php echo esc_url(wp_lostpassword_url()); ?>">Lost your password?</a>
            </form>
        </div>
    </section>

    <script>
        function showTab(e, id) {
            e.preventDefault();
            document.getElementById('register').style.display = id === 'register' ? 'block' : 'none';
            document.getElementById('login').style.display = id === 'login' ? 'block' : 'none';
            var links = document.querySelectorAll('.model__link');
            links.forEach(link => link.classList.remove('model__link--active'));
            e.target.classList.add('model__link--active');
        }
    </script>
<?php endif; ?>

<?php get_footer(); ?>