// Left menu

const menu = {
  btn: '#menu_checkbox',
  div: '#menu_gauche',
  texts: '.textgauche',
  images: '.img_menu_gauche_js',
  not_selected: '.notselectedmenu',
  selected: '.selectedmenu',
  burger: '#menu_checkbox'
}

$(menu.burger).click(function() {
  if (getCookie('menu') === 'open') closeMenu()
  else openMenu()
})

function closeMenu() {
  $(menu.div).css('transition-delay', "0s, 0s").css('width', '100px')
  $(menu.texts).css('opacity', 0)
  $(menu.images).css('margin-left', "-23px")
  $(menu.not_selected).css('padding-right', "0px")
  $(menu.selected).css('padding-right', "0px")

  setTimeout(() => {
    const width = parseInt(window.innerWidth);
    if (width <= 500) $(menu.div).css('margin-left', '-100px')
    else $(menu.div).css('margin-left', '0')
  }, 400)

  setCookie('menu', 'closed')
}

function openMenu() {
  $(menu.div).css('margin-left', "0").css('transition-delay', '0s, 0s')
  const width = parseInt(window.innerWidth);
  if (width <= 500) {
    setTimeout(() => {
      $(menu.div).css('width', "260px")
      $(menu.selected).css('padding-right', "90px")
      $(menu.images).css('margin-left', "0px")
      $(menu.not_selected).css('padding-right', "90px")
    }, 400)
    setTimeout(() => {
      $(menu.texts).css('opacity', 1)
    }, 600);
  } else {
    $(menu.div).css('width', "260px")
    $(menu.selected).css('padding-right', "90px")
    $(menu.images).css('margin-left', "0px")
    $(menu.not_selected).css('padding-right', "90px")
    setTimeout(() => {
      $(menu.texts).css('opacity', 1)
    }, 200);
  }
  setCookie('menu', 'open')
}

// Search into the page

const search = {
  input: "#findField",
  modal: '#not_find'
}

$(search.input).keyup(function(e) {
  if (e.keyCode === 13) {
    e.preventDefault();
    FindNext();
  }
})

function FindNext() {
  const str = $(search.input).val();

  // If void STOP
  if (str === "") return

  let supported = false;
  let found = false;
  if (window.find) {
    // If some content is selected, the start position of the search
    // will be the end position of the selection
    supported = true;
    found = window.find(str);
  } else if (document.selection && document.selection.createRange) {
    let textRange = document.selection.createRange();
    if (textRange.findText) {
      // If some content is selected, the start position of the search
      // will be the position after the start position of the selection
      supported = true;
      if (textRange.text.length > 0) {
        textRange.collapse(true);
        textRange.move("character", 1);
      }
      found = textRange.findText(str);
      if (found) textRange.select();
    }
  }

  if (supported && !found) modals.show(search.modal);
}

// Project

const project = {
  modal: '#project',
  btns: ['#switch_logo_img', '#project_actual'],
  add: {
    modal: '#create',
    btn: '#create_project_opener',
    form: "form[name='create_project_form']"
  },
  edit: {
    modal: '#edit_project',
    btn: '#edit_project_opener',
    form: "form[name='edit_project_form']"
  }
}

// Open project modal
project.btns.forEach((item) => {
  $(item).click(function() {
    modals.show(project.modal)
  })
})

// Open modal to create project
$(project.add.btn).click(function() {
  setTimeout(() => modals.show(project.add.modal, () => {
    $(project.add.form).find('input[placeholder], textarea[placeholder]').val('')
  }), 500)
})

// Open modal to edit the current project
$(project.edit.btn).click(function() {
  if (permissions !== 2) {
    const err = new Message('error', 'Action refusée...', "Vous n'avez pas l'autorisation nécessaire pour modifier le projet.")
    err.show()
    return
  }
  // Save old inputs values
  let values = []
  $(project.edit.form).find('input[placeholder], textarea[placeholder]').each(function(i) {
    values[i] = $(this).val()
  })
  setTimeout(() => modals.show(project.edit.modal, () => {
    $(project.edit.form).find('input[placeholder], textarea[placeholder]').each(function(i) {
      $(this).val(values[i])
    })
  }), 500)
})

// Settings

const settings = {
  modal: '#settings',
  btn: '#gear_logo_img',
  edit: {
    dark_mode: '#dark_mode',
    night_shift: '#night_shift',
    NS_changes: '#account_logo_img'
  }
}

// Show settings modal
$(settings.btn).click(function() {
  modals.show(settings.modal, () => {
    $(settings.input).val('')
  })
})

// Turn ON/OFF dark-mode

$(settings.edit.dark_mode).change(function() {
  if (this.checked) turnOnDarkMode()
  else turnOffDarkMode()
})

function turnOnDarkMode() {
  // Dark-mode for all elements

  //Change css
  var stl = 'public/CSS/tasks-dark.css'
  $('#stl[rel=stylesheet]').attr('href', stl);
  //Darkmode body
  $('body').css('background-color', "#121212");

  //darkmode for findField
  $('#findField').css('color', "white");
  $('#findField').css('background-color', "#373737");
  $('#findField').css('border-color', "#373737");

  //Darkmode for button actual project
  $('#project_actual').css('color', "white");
  $('#project_actual').hover(
    function() {
      $('#project_actual').css('border-color', "white")
    },
    function() {
      $('#project_actual').css('border-color', "transparent")
    }
  );

  //darkmode icones en haut à droite
  $('#switch_logo_img').css('filter', "invert(100%)");
  $('#gear_logo_img').css('filter', "invert(100%)");
  $('#help_logo_img').css('filter', "invert(100%)");

  //Darkmoded for left menu
  $('.notselectedmenu').css('color', "white");
  $('.selectedmenu').css('color', "white");
  $('.selectedmenu').css('background-color', "#b41e10");
  $('.img_menu_gauche_js').css('filter', "invert(50%) brightness(20000%)");



  // Turn off night-shift
  $(settings.edit.night_shift)[0].checked = false
  turnOffNightShift()

  // Set dark-mode cookie
  setCookie('dark-mode', 'on')
}

function turnOffDarkMode() {
  // Reset all elements

  //Change css
  var stl = 'public/CSS/tasks.css'
  $('#stl[rel=stylesheet]').attr('href', stl);
  //Darkmode body
  $('body').css('background-color', "white");

  //darkmode for findField
  $('#findField').css('color', "black");
  $('#findField').css('background-color', "#f1f3f4");
  $('#findField').css('border-color', "#f1f3f4");

  //Darkmode for button actual project
  $('#project_actual').css('color', "black");
  $('#project_actual').hover(
    function() {
      $('#project_actual').css('border-color', "rgba(0, 0, 0, 0.164)")
    },
    function() {
      $('#project_actual').css('border-color', "transparent")
    }
  );

  //darkmode icones en haut à droite
  $('#switch_logo_img').css('filter', "invert(0%)");
  $('#gear_logo_img').css('filter', "invert(0%)");
  $('#help_logo_img').css('filter', "invert(0%)");

  //Darkmoded for left menu
  $('.notselectedmenu').css('color', "black");
  $('.selectedmenu').css('color', "#b41e10");
  $('.selectedmenu').css('background-color', "#fce8e6");
  $('.img_menu_gauche_js').css('filter', "invert(50%) brightness(0%)");


  // Set dark-mode cookie
  setCookie('dark-mode', null)
}

// Turn ON/OFF night-shift
$(settings.edit.night_shift).change(function() {
  if ($(settings.edit.night_shift)[0].checked) turnOnNightShift()
  else turnOffNightShift()
})

function turnOnNightShift() {
  // Turn off dark-mode
  $(settings.edit.dark_mode)[0].checked = false
  turnOffDarkMode();

  $('body').css('filter', "sepia(15%)")
  $(settings.edit.NS_chanches).css('filter', "invert(0%) hue-rotate(0deg)")

  // Set night-shift cookie
  setCookie('night-shift', 'on')
}

function turnOffNightShift() {
  $('body').css('filter', "sepia(0%)")
  $(settings.edit.NS_chanches).css('filter', "invert(0%) hue-rotate(0deg)")

  // Set night-shift cookie
  setCookie('night-shift', null)
}

// Help

const help = {
  modal: "#help_modal",
  btn: "#help_logo_img"
}

window.onclick = (e) => {
  // Close help modal
  const $help = $(help.modal)
  const $btn = $(help.btn)
  if ($help.css('display') === "block" && e.target !== $btn[0]) {
    $btn.removeClass("help_logo_onclick").css('filter', "invert(25%)")
    $help.css('display', 'none')
  }
}
$(help.btn).click(function() {
  const $help = $(help.modal)
  if ($help.css('display') === "block") {
    $(this).removeClass("help_logo_onclick").css('filter', "invert(25%)")
    $help.css('display', 'none')
  } else {
    $(this).addClass("help_logo_onclick").css('filter', "invert(100%) hue-rotate(160deg) grayscale(100%)")
    $help.css('display', 'block')
  }
})

// Account

const account = {
  modal: '#my_informations',
  btn: '#button_my_account',
  select: {
    modal: '#account',
    btn: '#account_logo_img',
    settings_btn: '#button_option'
  },
  edit: {
    img: {
      form: '#form_add_img',
      input: '#input_img',
      text: '#img_text',
      img: '#img_account_changeimg'
    },
    text: {
      input: '#textarea_pseudo',
      old_value: $('#textarea_pseudo').val(), // Update it if you updated account.edit.text.input
      validate: '#validate_textarea_pseudo',
      btn: '#modify_textarea_pseudo',
      submit: '#cancel_submit_changes'
    }
  },
  delete: {
    modal: '#delete',
    confirm: '#confirm_open',
    cancel: '#no_delete'
  }
}

// Show select modal
$(account.select.btn).click(function() {
  modals.show(account.select.modal)
})
// Show account modal by select modal
$(account.btn).click(function() {
  setTimeout(() => modals.show(account.modal, () => {
    $(account.edit.text.validate).css('marginRight', "50px").css('opacity', "0")
    $(account.edit.text.input).attr('disabled', true)
    $(account.edit.text.submit).html("Annuler")
  }), 500)
})
// Show settings modal by select modal
$(account.select.settings_btn).click(function() {
  setTimeout(() => {
    modals.show(settings.modal, () => {
      $(settings.input).val('')
    })
  }, 500)
})

// Edit profil picture
$(account.edit.img.input).change(function() {
  $(account.edit.img.form).submit()
})
// Change profil picture btn on hover
$(account.edit.img.form)
  .mouseenter(function() {
    $(account.edit.img.img).css('filter', "brightness(40%)")
    $(account.edit.img.text).css('opacity', "1")
  }).mouseleave(function() {
    $(account.edit.img.img).css('filter', "brightness(100%)")
    $(account.edit.img.text).css('opacity', "0")
  })

// Enable edit pseudo
$(account.edit.text.btn).click(function() {
  console.log('enable');
  $(account.edit.text.validate).css('margin-right', "100px").css('opacity', "1")
  $(account.edit.text.input).attr('disabled', false).focus()
})
// Validate changes (without submit)
$(account.edit.text.validate).click(function() {
  console.log('validate');
  $(this).css('margin-right', '50px').css('opacity', 0)
  if ($(account.edit.text.input).val() !== account.edit.text.old_value) {
    $(account.edit.text.submit)
      .addClass('none').removeClass('close-modal')
      .attr('type', 'submit').text('Effectuer les changements')[0].removeEventListener('click', closeTemplateModal)
  }
})
// Submit changes
$(account.edit.text.submit).click(function() {
  $(account.edit.text.validate).click();
  setTimeout(() => {
    $(this).html("Annuler").attr('type', 'button')
  }, 500)
})

// Delete account
$(account.delete.confirm).click(function() {
  setTimeout(() => modals.show(account.delete.modal), 500)
})
$(account.delete.cancel).click(function() {
  setTimeout(() => modals.show(account.modal), 500)
})

/*
=========================
======= FUNCTIONS =======
=========================
*/

/**
 * Executed when the JS is loaded
 */
function wOnload() {
  // Manage Menu
  if (getCookie('menu') === 'open') {
    $(menu.texts).css('transition', 'all 0s')
    $(menu.images).css('transition', "all 0s")
    $(menu.not_selected).css('transition', "all 0s")
    $(menu.div).css('transition', "all 0s")
    $(menu.selected).css('transition', "all 0s")
    openMenu();

    setTimeout(() => {
      $(menu.texts).css('transition', 'all 0.2s')
      $(menu.images).css('transition', "all 0.2s")
      $(menu.not_selected).css('transition', "all 0.2s")
      $(menu.div).css('transition', "all 0.2s")
      $(menu.selected).css('transition', "all 0.2s")
      closeMenu();
    }, 1000)
  } else {
    // Avoid animation to disaprear
    $(menu.div).css('transition-duration', "0s, 0s")
    const width = parseInt(window.innerWidth);
    if (width <= 500) $(menu.div).css('margin-left', '-100px')
    else $(menu.div).css('margin-left', '0')
    closeMenu();
    $(menu.div).css('transition-duration', "0.3s, 0.3s")
  }
  setTimeout(() => {
    $('body').css('opacity', "1")
  }, 450)

  // Turn ON/OFF dark mode
  if (getCookie('dark-mode') === 'on') {
    turnOnDarkMode()
    $(settings.edit.dark_mode)[0].checked = true
  } else {
    turnOffDarkMode()
    $(settings.edit.dark_mode)[0].checked = false
  }


  // Turn ON/OFF night shift
  if (getCookie('night-shift') === 'on') {
    turnOnNightShift()
    $(settings.edit.night_shift)[0].checked = true
  } else {
    turnOffNightShift()
    $(settings.edit.night_shift)[0].checked = false
  }

  // Print modal div
  $('#modals').css('display', 'block')
}

/**
 * Get a specific cookie by its name
 * @param  {String} cname The cookie name
 * @return {String} The cookies value
 */
function getCookie(cname) {
  const name = cname + "=";
  const decodedCookie = decodeURIComponent(document.cookie);
  const ca = decodedCookie.split(';');
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

/**
 * Add / set a cookie
 * @param {String} cname The cookie name
 * @param {String} cvalue The cookie value
 */
function setCookie(cname, cvalue) {
  let d = new Date();
  d.setTime(d.getTime() + (365 * 24 * 60 * 60 * 1000));
  const expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}