<section class="bg-home d-flex align-items-center position-relative" style="background: url('template/backend/assets/images/background/uploads/<?= $settings[2]['value'] ?>') center / cover no-repeat; transition: background 1s ease;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-signin p-4 bg-white rounded shadow">


                    <h5 class="mb-3 text-center text-white">Восстановление пароля</h5>

                    <p class="text-white">Пожалуйста, введите свой адрес электронной почты. Вы получите ссылку для создания нового пароля по электронной почте.</p>

                    <div class="form-floating mb-3">
                        <input type="email" class="form-control input_reset_email" id="floatingInput" placeholder="name@example.com">
                        <label class="text-white" for="floatingInput">Email адрес</label>
                    </div>

                    <button class="btn btn-primary w-100 btn_reset_password" type="submit">Отправить</button>

                    <div class="col-12 text-center mt-3">
                        <p class="mb-0 mt-3"><small class="text-white me-2">Вспомнили пароль ?</small> <a href="/" class="text-white fw-bold">Войти</a></p>
                    </div>

                    <p class="mb-0 text-white mt-3 text-center">©
                        <script>
                            document.write(new Date().getFullYear())
                        </script> <?php echo $settings[0]['value']; ?>.
                    </p>

                </div>
            </div>
        </div>
    </div>
    <div id="message"></div>
</section>

<script>
    async function resetPassword() {
        const btnResetPassword = document.querySelector('.btn_reset_password')
        const message = document.querySelector('#message')

        btnResetPassword.addEventListener('click', function(e) {
            var input_reset_email = document.querySelector('.input_reset_email')

            var formData = new FormData();
            formData.append('check_email_reset', input_reset_email.value);

            $.ajax({
                type: "POST",
                url: 'core/login.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function() {},
                success: function(result) {
                    if (result != 0) {
                        var formData = new FormData();
                        formData.append('send_email_reset_password', input_reset_email.value);

                        $.ajax({
                            type: "POST",
                            url: 'core/login.php',
                            cache: false,
                            contentType: false,
                            processData: false,
                            data: formData,
                            beforeSend: function() {},
                            success: function(result) {
                                message.innerHTML = `
                                    <div class="alert success-alert">
                                        <h4 class="success">Ссылка для восстановления пароля отправлена на почту ` + result + `!</span></h4>
                                    </div>
                                `
                                setTimeout(function() {
                                    message.innerHTML = ''
                                }, 4000)
                            }
                        })


                    } else {
                        message.innerHTML = `
                            <div class="alert danger-alert">
                                <h4 class="danger">Такой Email не зарегистрирован!</span></h4>
                            </div>
                        `
                        setTimeout(function() {
                            message.innerHTML = ''
                        }, 4000)
                    }
                }
            })
        })
    }
    resetPassword()
</script>