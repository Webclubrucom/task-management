<section class="bg-home d-flex align-items-center position-relative" style="background: url('template/backend/assets/images/background/uploads/<?= $settings[2]['value'] ?>') center / cover no-repeat; transition: background 1s ease;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="form-signin p-4 bg-white rounded shadow">


                    <h5 class="mb-3 text-center text-white">Новый пароль</h5>



                    <div class="form-floating mb-3">
                        <input type="text" class="form-control input_update_password" id="floatingInput">
                        <label class="text-white" for="floatingInput">Введите новый пароль</label>
                    </div>

                    <button class="btn btn-primary w-100 btn_update_password" type="submit">Сохранить</button>

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
        const btnUpdatePassword = document.querySelector('.btn_update_password')
        const message = document.querySelector('#message')

        btnUpdatePassword.addEventListener('click', function(e) {
            var input_update_password = document.querySelector('.input_update_password')
            var email = '<?php echo $email; ?>'

            var formData = new FormData();
            formData.append('update_password', input_update_password.value);
            formData.append('email', email);
            $.ajax({
                type: "POST",
                url: 'core/login.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                beforeSend: function() {},
                success: function(result) {
                    window.location.href = '/'
                }
            })
        })
    }
    resetPassword()
</script>