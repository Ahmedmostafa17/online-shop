$(function () {
  'use strict'
  $('[placeholder]')
    .focus(function () {
      $(this).attr('data-text', $(this).attr('placeholder'))
      $(this).attr('placeholder', ' ')
    })
    .blur(function () {
      $(this).attr('placeholder', $(this).attr('data-text'))
    })

  // show passeord
  var passField = $('.password')
  $('.show-pass').hover(
    function () {
      passField.attr('type', 'text')
    },
    function () {
      passField.attr('type', 'password')
    }
  )

  // serach in manage member
  /*
    let searchInput = document.getElementById('SearchInput');
    let tableInputs = document.querySelectorAll('#items tbody tr');

    searchInput.addEventListener('input', () => {


        tableInputs.forEach((item) => {

            if (item.innerText.toLowerCase().includes(searchInput.value)) {

                item.style.display = 'table-row'

            } else {

                item.style.display = 'none';

            }

        })

    });
    */

  $('.confirm').on('click', function (e) {
    const href = $(this).attr('href')
    e.preventDefault()
    Swal.fire({
      title: 'Are you sure?',
      text: "You won't be able to revert this!",
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Yes, delete it!'
    }).then(result => {
      if (result.value) {
        Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
        document.location.href = href
      }
    })
  })

  // tables
  $(document).ready(function () {
    $('#items').DataTable()
  })

  // lastes Items
  $('.toggle-info').click(function () {
    $(this)
      .toggleClass('selected')
      .parent()
      .next('.card-body')
      .fadeToggle(100)
    if ($(this).hasClass('selected')) {
      $(this).html('<i class = "fa fa-minus fa-lg" >  </i>')
    } else {
      $(this).html('<i class = "fa fa-plus fa-lg" >  </i>')
    }
  })
  /* file import */
  $('.custom-file-input').on('change', function () {
    var fileName = $(this)
      .val()
      .replace('C:\\fakepath\\', '')
    $(this)
      .next('.custom-file-label')
      .html(fileName)
  })
  /**category show child links */

  $('.child-link').hover(
    function () {
      $('.show-link').fadeIn(400)
    },
    function () {
      $('.show-link').fadeOut(400)
    }
  )
})

/* validation for update password*/
function validation () {
  var password = document.getElementById('password').value
  var conf_password = document.getElementById('conf-password').value
  var error = document.getElementById('error')
  var text

  if (password == '') {
    text = 'Please full the password '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (password.Length < 6) {
    text = 'Password must be at least 6 characters long'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (conf_password == '') {
    text = 'Please full the Retry-password '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (password != conf_password) {
    text = 'the password not same'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  text = ' The update successfully'
  error.classList.add('alert', 'alert-success', 'text-center')
  error.innerHTML = text
  return true
}

/* validation for update information  */
function validations () {
  var username = document.getElementById('username').value
  var email = document.getElementById('email').value
  var fullname = document.getElementById('fullname').value

  var error = document.getElementById('error1')
  var text
  var atposition = email.indexOf('@')
  var dotposition = email.lastIndexOf('.')

  if (username == '') {
    text = 'Please full the UserName  field'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (username.Length < 4) {
    text = 'Username cant not be less than 4 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (username.Length > 20) {
    text = 'Username cant not be More than 20 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (email == '') {
    text = 'Please full the Email field '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (
    atposition < 1 ||
    dotposition < atposition + 2 ||
    dotposition + 2 >= email.length
  ) {
    text = 'Please Inter Valide Email'
    error.classList.add('alert', 'alert-danger', 'text-center')
    error.innerHTML = text
    return false
  }

  if ((fullname = '')) {
    text = 'Please Full the FullName field'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (fullname.Length < 4) {
    text = 'FullName cant not be More than 4 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  text = ' The update successfully'
  error.classList.add('alert', 'alert-success', 'text-center')
  error.innerHTML = text

  return true
}
/* validation for add member information  */
function addValidations () {
  var username = document.getElementById('username').value
  var email = document.getElementById('email').value
  var fullname = document.getElementById('fullname').value
  var password = document.getElementById('password').value

  var error = document.getElementById('error1')
  var text
  var atposition = email.indexOf('@')
  var dotposition = email.lastIndexOf('.')

  if (username == '') {
    text = 'Please full the UserName  field'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (username.Length < 4) {
    text = 'Username cant not be less than 4 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (username.Length > 20) {
    text = 'Username cant not be More than 20 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (email == '') {
    text = 'Please full the Email field '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (
    atposition < 1 ||
    dotposition < atposition + 2 ||
    dotposition + 2 >= email.length
  ) {
    text = 'Please Inter Valide Email'
    error.classList.add('alert', 'alert-danger', 'text-center')
    error.innerHTML = text
    return false
  }

  if ((fullname = '')) {
    text = 'Please Full the FullName field'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (fullname.Length < 4) {
    text = 'FullName cant not be More than 4 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (password == '') {
    text = 'Please Full the Password '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (password.length < 6) {
    text = 'write more than 6 characters'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  text = ' The Insert successfully'
  error.classList.add('alert', 'alert-success', 'text-center')
  error.innerHTML = text

  return true
}

function addCategoryValidations () {
  var name = document.getElementById('name').value
  var Descripted = document.getElementById('Descripted').value
  var ordering = document.getElementById('ordering').value
  var selected = document.getElementById('selected ')

  var error = document.getElementById('error1')
  var text

  if (name == '') {
    text = 'Please full Name of Category  field'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (name.Length < 4) {
    text = 'Name cant not be less than 4 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (name.Length > 20) {
    text = 'Name cant not be More than 20 characters '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (Descripted == '') {
    text = 'Please full the Description field '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  if (Descripted.length < 5) {
    text = 'Please Full More THAN 20 CHARACTERS'
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }
  if (ordering == ' ') {
    text = 'FullName THE Ordering field '
    error.classList.add('alert', 'alert-danger', 'text-center')

    error.innerHTML = text
    return false
  }

  text = ' The Insert successfully'
  error.classList.add('alert', 'alert-success', 'text-center')
  error.innerHTML = text

  return true
}
// clear inputs

// var clear = document.getElementById('clear');

// // clear.addEventListener('click', function() {
// //     var username = document.getElementById('username').value = '';
// //     var email = document.getElementById('email').value = '';
// //     var fullname = document.getElementById('fullname').value = '';

// // });
function confirm () {
  Swal.fire({
    title: 'Are you sure?',
    text: "You won't be able to revert this!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, delete it!'
  }).then(result => {
    if (result.value) {
      Swal.fire('Deleted!', 'Your file has been deleted.', 'success')
    }
  })
}
