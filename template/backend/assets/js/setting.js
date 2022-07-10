/** Удаление куки и переадресация при выходе */

const linkExit = document.querySelector('.block_header_profile')

linkExit.addEventListener('click', function () {

  var cookies = document.cookie.split(";");
  for (var i = 0; i < cookies.length; i++) {
    var cookie = cookies[i];
    var eqPos = cookie.indexOf("=");
    var name = eqPos > -1 ? cookie.substr(0, eqPos) : cookie;
    document.cookie = name + "=;expires=Thu, 01 Jan 1970 00:00:00 GMT;";
    document.cookie = name + '=; path=/; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    window.location.reload()
  }

  setTimeout(window.location.reload(), 1000)

})

/** Скрытие и открытие Header */

const openHeaderBtn = document.querySelector('.open_header')
const closeHeaderBtn = document.querySelector('.caret_header .fas')
const header = document.querySelector('.header')
const copyrite = document.querySelector('.copyright')

openHeaderBtn.addEventListener('click', function (e) {
  header.style.display = 'flex'
  openHeaderBtn.style.display = 'none'
  copyrite.style.display = 'block'
})

closeHeaderBtn.addEventListener('click', function (e) {
  header.style.display = 'none'
  openHeaderBtn.style.display = 'flex'
  copyrite.style.display = 'none'
})

/** Скрытие и открытие настроек */

const menuOpen = document.querySelector(".top-nav .open_menu");
const menuClose = document.querySelector(".top-nav .menu-close");
const menuWrapper = document.querySelector(".top-nav .menu-wrapper");
const topBannerOverlay = document.querySelector(".top-banner-overlay");

function toggleMenu() {
  menuOpen.addEventListener("click", () => {
    menuWrapper.classList.add("is-opened");
  });

  menuClose.addEventListener("click", () => {
    menuWrapper.classList.remove("is-opened");
  });

}
toggleMenu();

/** Галочка для кнопки загрузки файлов */

$(function () {

  'use strict';

  $('.input-file').each(function () {
    var $input = $(this),
      $label = $input.next('.js-labelFile'),
      labelVal = $label.html();

    var validFormats = ['jpg', 'jpeg', 'png', 'gif'];

    /** Проверка расширения файла при загрузке со стороны пользователя с предепреждением */

    $input.on('change', function (element) {
      var extn = $(this).val().split(".").pop();

      if (validFormats.indexOf(extn) == -1) {
        $(this).val('');
        var message = document.querySelector('#message')
        message.innerHTML = `
              <div class="alert danger-alert">
                  <h4 class="danger">Ошибка! <span> Загружайте только .jpeg, .png, gif</span></h4>
              </div>
            `
        setTimeout(function () {
          message.innerHTML = ''

        }, 4000)
      } else {
        var fileName = '';
        if (element.target.value) fileName = element.target.value.split('\\').pop();
        fileName ? $label.addClass('has-file').find('.js-fileName').html(fileName) : $label.removeClass('has-file').html(labelVal);

        setTimeout(function () {
          $label.addClass('has-file').find('.js-fileName').html('Загрузить изображение')
          $label.removeClass('has-file').html(labelVal)
        }, 4000)

        var formData = new FormData();
        const section_background = document.querySelector('.section_background')

        var file = element.target.files[0];



        formData.append('upload_background', file)

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'core/request.php');
        xhr.onreadystatechange = function () {
          if (xhr.readyState == 4) {
            var result = xhr.responseText;
            if (result)
              section_background.innerHTML = result
            var background = document.querySelector('.app')
            background.style.background = 'url("template/backend/assets/images/background/uploads/' + file.name + '") center / cover no-repeat'
            var message = document.querySelector('#message')
            message.innerHTML = `
                  <div class="alert success-alert">
                      <h4 class="success">Изображение успешно загружено!</h4>
                  </div>
                `
            setTimeout(function () {
              message.innerHTML = ''

            }, 4000)
          }
          check()
        };
        xhr.send(formData);
      }
    });
  });
});

/** Выбор фона на доску */

async function check() {
  const checkAll = document.querySelectorAll('.check_img')

  for (let s = 0; s < checkAll.length; s++) {
    const inp = checkAll[s]

    inp.addEventListener('change', function (e) {

      if (inp.type == "radio" && inp.checked) {
        const value = inp.value
        const background = document.querySelector('.app')
        background.style.background = 'url("template/backend/assets/images/background/uploads/' + value + '") center / cover no-repeat'

        var formData = new FormData()
        formData.append('check_background', value);
        $.ajax({
          url: 'core/request.php',
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function () {},
          success: function (result) {}
        })

      }
    })
  }
}
check()

/** Отображение даты и месяца на русском языке */

async function DataView() {

  Data = new Date();
  Year = Data.getFullYear();
  Month = Data.getMonth();
  Day = Data.getDate();

  fMonth = ['января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'октября', 'ноября', 'декабря'];

  const data = document.querySelector('#numberOfDay')
  data.innerHTML = Day + " " + fMonth[Month] + " " + Year + " года"
}
DataView()

async function settingsWindows() {
  const btnSettingManagment = document.querySelector('.title_managment')
  const btnSettingBackground = document.querySelector('.title_background')
  const sectionSettingManagment = document.querySelector('.main_settings')
  const sectionSettingBackground = document.querySelector('.background_settings')

  btnSettingManagment.addEventListener('click', function (e) {
    sectionSettingManagment.style.display = 'block'
    sectionSettingBackground.style.display = 'none'
  })
  if (btnSettingBackground) {
    btnSettingBackground.addEventListener('click', function (e) {
      sectionSettingManagment.style.display = 'none'
      sectionSettingBackground.style.display = 'block'
    })
  }

}
settingsWindows()

async function currentUser() {
  $id_user = intval($_COOKIE['id']);
}

/** Растягивание Textarea */

$(document).on("input", "textarea", function () {

  $(this).outerHeight(38).outerHeight(this.scrollHeight);

});

/** Добавление участника */

async function addMember() {
  var message = document.getElementById('message')
  const btn_add_member = document.querySelector('.btn_add_member')

  if (btn_add_member) {
    btn_add_member.addEventListener('click', function (e) {

      var username_member = document.getElementById('username_member')
      var email_member = document.getElementById('email_member')
	  var phone_member = document.getElementById('phone_member')
      var role_member = document.getElementById('role_member')
	  var rank_member = document.getElementById('rank_member')
	  var group_member = document.getElementById('group_member')
      var password_member = document.getElementById('password_member')
      var avatar_member = document.getElementById('avatar_member')

      if (username_member.value != '' && role_member.value != '' && email_member.value != '' && password_member.value != '') {

        var formData = new FormData()
        formData.append('chek_email_member', email_member.value);

        $.ajax({
          url: 'core/request.php',
          type: 'POST',
          data: formData,
          cache: false,
          contentType: false,
          processData: false,
          beforeSend: function () {},
          success: function (result) {
            if (result != 0) {
              message.innerHTML = `
                    <div class="alert danger-alert">
                        <h4 class="danger">Email ${result} уже существует!</h4>
                    </div>
                  `
              setTimeout(function () {
                message.innerHTML = ''
              }, 4000)
              email_member.value = ''
            } else {
              var formData = new FormData()

              if (avatar_member.files[0]) {
                var file_name = '';
                var file = avatar_member.files[0];
                var file_name = Math.random() + '-' + file.name
              } else {
                var file_name = 'default.png'
              }

              formData.append('add_member', username_member.value);
              formData.append('email_member', email_member.value);
			  formData.append('phone_member', phone_member.value);
              formData.append('role_member', role_member.value);
			  formData.append('rank_member', rank_member.value);
			  formData.append('group_member', group_member.value);
              formData.append('password_member', password_member.value);
			  
              formData.append('avatar_member', file_name);
              formData.append('avatar_file', file)

              $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {

                },
                success: function (result) {
                  username_member.value = ''
                  email_member.value = ''
				  phone_member.value = ''
                  role_member.value = 'member'
				  rank_member.value = ''
				  
                  password_member.value = ''
				  
				  var formData = new FormData()
					const dnd_conacts = document.querySelector('.dnd_conacts')
					formData.append('open_page_contacts', 'id_group');

					$.ajax({
						url: 'core/request.php',
						type: 'POST',
						data: formData,
						cache: false,
						contentType: false,
						processData: false,
						beforeSend: function () {},
						success: function (result) {
							dnd_conacts.innerHTML = result
							actionsContacts()
							delContacts()
						}
					})
				  
                  const avatar_member = document.querySelector('#avatar_member_view')
                  avatar_member.style.background = 'url("template/backend/assets/images/users/default.png") center / cover no-repeat'
                  message.innerHTML = `
                        <div class="alert success-alert">
                            <h4 class="success">Пользователь ${result} успешно добавлен!</h4>
                        </div>
                      `
                  setTimeout(function () {
                    message.innerHTML = ''
                  }, 4000)
				  
				  

                }
				
              })
			  
            }
			
          }
        })


      } else {
        message.innerHTML = `
              <div class="alert danger-alert">
                  <h4 class="danger">Заполните все поля!</h4>
              </div>
            `
        setTimeout(function () {
          message.innerHTML = ''
        }, 4000)

      }
    })
  }


}
addMember()

function readAvatarMember(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    const avatar_member = document.querySelector('#avatar_member_view')

    reader.onload = function (e) {

      avatar_member.style.background = 'url("' + e.target.result + '") center / cover no-repeat'

    };

    reader.readAsDataURL(input.files[0]);
  }
}

$("#avatar_member").change(function () {

  var validFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  /** Проверка расширения файла при загрузке со стороны пользователя с предупреждением */

  var extn = $('#avatar_member').val().split(".").pop();

  if (validFormats.indexOf(extn) == -1) {

    var message = document.querySelector('#message')
    message.innerHTML = `
        <div class="alert danger-alert">
          <h4 class="danger">Ошибка! <span> Загружайте только .jpeg, .png, gif, webp</span></h4>
        </div>
      `
    setTimeout(function () {
      message.innerHTML = ""

    }, 4000)
  } else {
    readAvatarMember(this);

  }

});

function readAvatarProfile(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    const avatar_profile = document.querySelector('#avatar_profile_view')

    reader.onload = function (e) {

      avatar_profile.style.background = 'url("' + e.target.result + '") center / cover no-repeat'

    };

    reader.readAsDataURL(input.files[0]);
  }
}

$("#avatar_profile").change(function () {

  var validFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

  /** Проверка расширения файла при загрузке со стороны пользователя с предупреждением */

  var extn = $('#avatar_profile').val().split(".").pop();

  if (validFormats.indexOf(extn) == -1) {

    var message = document.querySelector('#message')
    message.innerHTML = `
        <div class="alert danger-alert">
          <h4 class="danger">Ошибка! <span> Загружайте только .jpeg, .png, gif, webp</span></h4>
        </div>
      `
    setTimeout(function () {
      message.innerHTML = ""

    }, 4000)
  } else {
    readAvatarProfile(this);

  }

});

/** Получение куки */

function get_cookie(cookie_name) {
  var results = document.cookie.match('(^|;) ?' + cookie_name + '=([^;]*)(;|$)');

  if (results)
    return (unescape(results[2]));
  else
    return null;
}

/** Изменение профиля */

async function editProfile() {
  var message = document.getElementById('message')
  const btn_edit_profile = document.querySelector('.btn_save_profile')

  btn_edit_profile.addEventListener('click', function (e) {

    var username_profile = document.getElementById('username_profile')
    var email_profile = document.getElementById('email_profile')
    var password_profile = document.getElementById('password_profile')
    var avatar_profile = document.getElementById('avatar_profile')
    var cookie_id = get_cookie("id")

    var formData = new FormData()
    formData.append('chek_email_profile', email_profile.value);

    $.ajax({
      url: 'core/request.php',
      type: 'POST',
      data: formData,
      cache: false,
      contentType: false,
      processData: false,
      beforeSend: function () {},
      success: function (result) {
        if (result != 0) {
          var formData = new FormData()

          if (avatar_profile.files[0]) {
            var file_name = '';
            var file = avatar_profile.files[0];
            var file_name = Math.random() + '-' + file.name
          } else {
            var file_name = cookie_id
          }
      
          if (password_profile.value != '') {
            formData.append('password_profile', password_profile.value);
          } else {
            formData.append('password_profile', cookie_id);
          }
      
          formData.append('edit_profile', username_profile.value);
          formData.append('email_profile', email_profile.value);
      
      
          formData.append('avatar_profile', file_name);
          formData.append('avatar_file', file)
      
          $.ajax({
            url: 'core/request.php',
            type: 'POST',
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function () {
      
            },
            success: function () {
              var formData = new FormData()
              var lists = document.querySelector('.lists')
              formData.append('avatar_lists', '2')
      
              $.ajax({
                url: 'core/request.php',
                type: 'POST',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
      
                },
                success: function (result) {
                  lists.innerHTML = result
                  password_profile.value = ''
                  showActions()
                  changeTitle()
                  delList()
                  addTask()
                  dragNdrop()
                  openModalTask()
                }
              })
      
              message.innerHTML = `
                            <div class="alert success-alert">
                                <h4 class="success">Профиль успешно изменен!</h4>
                            </div>
                          `
              setTimeout(function () {
                message.innerHTML = ''
              }, 4000)
      
            }
          })
        } else {
          message.innerHTML = `
              <div class="alert danger-alert">
                  <h4 class="danger">Такой Email уже зарегистрирован!</h4>
              </div>
            `
          setTimeout(function () {
            message.innerHTML = ''
          }, 4000)
        }
      }
    })


  })
}
editProfile()


/** Изменение профиля */

async function editSettingsSite() {
  var message = document.getElementById('message')
  const btn_save_setting_site = document.querySelector('.btn_save_setting_site')

  if (btn_save_setting_site) {
    btn_save_setting_site.addEventListener('click', function (e) {

      var title_site = document.getElementById('title_site')
      var desc_site = document.getElementById('desc_site')
      var email_site = document.getElementById('email_site')
      var favicon = document.getElementById('favicon_site')

      var formData = new FormData()



      formData.append('edit_settings_site', title_site.value);
      formData.append('desc_site', desc_site.textContent);
      formData.append('email_site', email_site.value);


      var file = favicon.files[0];

      if (file) {
        var file_name = '';
        var file_name = file.name;
        formData.append('favicon_site', file_name);
        formData.append('favicon_file', file)
      }


      $.ajax({
        url: 'core/request.php',
        type: 'POST',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend: function () {

        },
        success: function () {
          $('link[rel="shortcut icon"]').attr('href', 'template/backend/assets/images/' + file_name + "'");
          var logo_header = document.querySelector('.logo_header')
          logo_header.textContent = title_site.value
          message.innerHTML = `
                        <div class="alert success-alert">
                            <h4 class="success">Настройки успешно изменены!</h4>
                        </div>
                      `
          setTimeout(function () {
            message.innerHTML = ''
          }, 4000)

        }
      })



    })
  }


}
editSettingsSite()

function readFaviconSite(input) {

  if (input.files && input.files[0]) {
    var reader = new FileReader();

    const favicon_site = document.querySelector('#favicon_view')

    reader.onload = function (e) {

      favicon_site.style.background = 'url("' + e.target.result + '") center / cover no-repeat'

    };

    reader.readAsDataURL(input.files[0]);
  }
}

$("#favicon_site").change(function () {

  var validFormats = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'ico'];

  /** Проверка расширения файла при загрузке со стороны пользователя с предупреждением */

  var extn = $('#favicon_site').val().split(".").pop();

  if (validFormats.indexOf(extn) == -1) {

    var message = document.querySelector('#message')
    message.innerHTML = `
        <div class="alert danger-alert">
          <h4 class="danger">Ошибка! <span> Загружайте только .jpeg, .png, gif, webp, ico</span></h4>
        </div>
      `
    setTimeout(function () {
      message.innerHTML = ""

    }, 4000)
  } else {
    readFaviconSite(this);

  }

});