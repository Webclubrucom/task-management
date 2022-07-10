<section class="bg-home d-flex align-items-center position-relative" style="background: url('template/backend/assets/images/background/uploads/<?= $settings[2]['value'] ?>') center / cover no-repeat; transition: background 1s ease;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-signin p-4 bg-white rounded shadow">

                    <!--<a href="index.html"><img src="template/frontend/assets/images/logo-icon.png" class="avatar avatar-small mb-4 d-block mx-auto" alt=""></a>-->
                    <h3 class="mb-3 text-white text-center"><?php echo $settings[0]['value']; ?></h3>

                    <div class="form-floating mb-2">
                        <input id="email" name="email" type="email" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <label for="floatingInput">Email адрес</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input id="password" name="password" type="password" class="form-control" id="floatingPassword" placeholder="Пароль">
                        <label for="floatingPassword">Пароль</label>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                <label class="form-check-label text-white" for="flexCheckDefault">Запомнить меня</label>
                            </div>
                        </div>
                        <p class="forgot-pass mb-0"><a href="/reset_password" class="text-white small fw-bold">Забыли пароль ?</a></p>
                    </div>

                    <div class="btn btn-primary w-100 btn_login" name="submit" type="submit">Вход</div>
                    <!--
                        <div class="col-12 text-center mt-3">
                            <p class="mb-0 mt-3"><small class="text-dark me-2">Don't have an account ?</small> <a href="auth-bs-signup.html" class="text-dark fw-bold">Sign Up</a></p>
                        </div>
                        end col-->

                    <p class="mb-0 text-white mt-3 text-center">© <script>
                            document.write(new Date().getFullYear())
                        </script> <?php echo $settings[0]['value']; ?>.</p>

                </div>
            </div>
        </div>
    </div>
    <div id="message"></div>
</section>

<script>
    /** Проверка Email при входе и вывод ошибки */

    function autorize() {
        const submit = document.querySelector('.btn_login');

        submit.addEventListener('click', function(e) {
            var email = document.getElementById('email')
            var password = document.getElementById('password')

            if (email.value != '' && password.value != '') {

                var formData = new FormData()
                formData.append('check_email', email.value);

                $.ajax({
                    url: 'core/login.php',
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {},
                    success: function(result) {

                        if (result != 0) {
                            var formData = new FormData()
                            formData.append('autorize_check', email.value);
                            formData.append('password', password.value);
                            $.ajax({
                                url: 'core/login.php',
                                type: 'POST',
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {

                                },
                                success: function(result) {
                                    if (result == 1) {
                                        message.innerHTML = `
                                        <div class="alert danger-alert">
                                            <p class="danger">Вы ввели неправильный логин или пароль!</p>
                                        </div>
                                        `
                                        setTimeout(function() {
                                            message.innerHTML = ''
                                        }, 4000)
                                    } else {
                                        window.location.href = '/dashboard'
                                    }

                                }
                            })
                        } else {
                            message.innerHTML = `
                            <div class="alert danger-alert">
                                <p class="danger">Вы ввели неправильный логин или пароль!</p>
                            </div>
                            `
                            setTimeout(function() {
                                message.innerHTML = ''
                            }, 4000)
                        }
                    }
                })
            }





        })

    }
    autorize()
</script>