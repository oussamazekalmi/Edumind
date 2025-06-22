<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="tivo admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Tivo admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="../assets/images/favicon/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="../assets/images/favicon/favicon.png" type="image/x-icon">
    <title>Réinitialisation du mot de passe</title><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/icofont.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/themify.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/flag-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/dropzone.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{asset('assets/css/color-1.css')}}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/responsive.css')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('fontawesome/css/all.min.css') }}">
  </head>
  <body>
    <!-- Loader starts-->
    <div class="loader-wrapper">
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"> </div>
      <div class="dot"></div>
    </div>
    <!-- Loader ends-->
    <!-- login page start-->
    <div class="container-fluid">
      <div style="position: fixed; top: 5%; left: 50%; transform: translateX(-50%) translateY(-50%); z-index: 9999;">
          <a class="logo" href="{{ route('auth.index') }}">
              <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo4-1.png')}}" alt="loginpage" height="250" width="250">
          </a>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="login-card">
            <div class="login-main rounded-0 py-4 mt-5 shadow-sm position-relative">
              <a class="btn rounded-0" href="{{ route('auth.index') }}" style="position:absolute; top:0; left:0; background-color: #F5F5F5; color: #6495ED; padding: 12px 16px; border-bottom-right-radius: 25px !important;">
                <i class="fas fa-sign-in"></i>
              </a>
              <form class="theme-form" action="{{route('auth.updatePassword',['user'=>$user->id])}}" method="POST">
                  @csrf

                <h4 class="text-center mt-2 mb-5" style="font-weight: 400; font-size: large;">Réinitialisation de mot de passe</h4>
                <div class="form-group mt-5">
                  <label class="col-form-label" style="font-weight: 400;" class="col-form-label">Veuillez entrer votre nouveau mot de passe</label>
                  <div class="position-relative">
                    <input class="form-control mt-1 mb-2 rounded-0" id="password" type="password" name="password" placeholder="nouveau mot de passe" autocomplete="off">
                    <div class="show-hide" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                      <i style="color:#6495ED;" class="fa fa-eye"></i>
                    </div>
                  </div>
                  @if($errors->has('password'))
                      <span class="text-danger">{{$errors->first('password')}}</span>
                  @endif
                </div>
                <div class="form-group mt-4">
                  <label class="col-form-label" style="font-weight: 400;" class="col-form-label">Veuillez confirmer le mot de passe</label>
                  <div class="position-relative">
                    <input class="form-control mt-1 mb-2 rounded-0" id="password_confirmation" type="password" name="password_confirmation" placeholder="confirmation de mot de passe" autocomplete="off">
                    <div class="show-hide" id="toggleConfirmPassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                      <i style="color:#6495ED;"  class="fa fa-eye"></i>
                    </div>
                  </div>
                </div>
                <div class="form-group mt-5">
                  <div class="text-end mb-3">
                    <button class="btn btn-block w-100 text-white" style="margin:20px auto -20px; background-color: #6495ED;" type="submit">Envoyer</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script>
      document.getElementById('togglePassword').addEventListener('click', function () {
          const passwordInput = document.getElementById('password');
          const icon = this.querySelector('i');
          if (passwordInput.type === 'password') {
              passwordInput.type = 'text';
              icon.classList.remove('fa-eye');
              icon.classList.add('fa-eye-slash');
          } else {
              passwordInput.type = 'password';
              icon.classList.remove('fa-eye-slash');
              icon.classList.add('fa-eye');
          }
      });

      document.getElementById('toggleConfirmPassword').addEventListener('click', function () {
          const passwordInput = document.getElementById('password_confirmation');
          const icon = this.querySelector('i');
          if (passwordInput.type === 'password') {
              passwordInput.type = 'text';
              icon.classList.remove('fa-eye');
              icon.classList.add('fa-eye-slash');
          } else {
              passwordInput.type = 'password';
              icon.classList.remove('fa-eye-slash');
              icon.classList.add('fa-eye');
          }
      });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- latest jquery-->
    <script src="{{asset('assets/js/jquery-3.6.0.min.js')}}"></script>
    <!-- Bootstrap js-->
    <script src="{{asset('assets/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
    <!-- feather icon js-->
    <script src="{{asset('assets/js/icons/feather-icon/feather.min.js')}}"></script>
    <script src="{{asset('assets/js/icons/feather-icon/feather-icon.js')}}"></script>
    <!-- scrollbar js-->
    <script src="{{asset('assets/js/scrollbar/simplebar.js')}}"></script>
    <script src="{{asset('assets/js/scrollbar/custom.js')}}"></script>
    <!-- Sidebar jquery-->
    <script src="{{asset('assets/js/config.js')}}"></script>
    <script src="{{asset('assets/js/sidebar-menu.js')}}"></script>
    <script src="{{asset('assets/js/dropzone/dropzone.js')}}"></script>
    <script src="{{asset('assets/js/dropzone/dropzone-script.js')}}"></script>
    <script src="{{asset('assets/js/tooltip-init.js')}}"></script>
    <!-- Template js-->
    <script src="{{asset('assets/js/script.js')}}"></script>
    <!-- login js-->
    </div>
  </body>
</html>
