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
    <title>login!</title><link rel="preconnect" href="https://fonts.googleapis.com">
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
    <style>
      .container-fluid {
          height: 88vh;
          display: flex;
          align-items: center;
          justify-content: center;
      }

      .login-card {
          width: 440px;
          margin: 0 auto -10px;
          padding: 20px;
          overflow: hidden;
      }

      .form-control {
          height: 45px;
      }

      h4 {
          font-size: 24px;
          margin-bottom: 15px;
      }

      p {
          margin-bottom: 20px;
      }
    </style>
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
    <div class="container-fluid p-0">
      @if (session('success'))
        <div style="background-color: #6495ED; position:fixed; top:0; left:50%; transform:translateX(-50%); z-index: 9999; padding: 10px 20px; border-radius: 5px; min-width: 300px; text-align: center;" class="alert text-white rounded-0 py-3" id="success-message">
          <p class="text-white m-0">{{ session('success') }}</p>
        </div>
      @endif
      <div class="row m-0">
        <div class="col-12 p-0">
          <div class="login-card">
            <div>
              <div><a class="logo" href="index.html"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo4.png')}}" alt="looginpage" height="200px" width="200px" style="margin-top: 30px; margin-bottom: -40px;"></a></div>
              <div class="login-main">
                <form class="theme-form" action="{{route('auth.login')}}" method="GET">
                  @csrf
                  
                  <h4 class="text-center" style="font-weight:400 !important; margin:-10px auto 16px;">Se connecter à un compte</h4>
                  <p class="text-center">Saisissez votre e-mail et votre mot de passe.</p>
                  <div class="form-group">
                    <label style="font-weight: 400 !important;">Adresse e-mail</label>
                    <input class="form-control rounded-0 mb-2" type="email" name="email" placeholder="Exemple@gmail.com" autocomplete="off">
                    @if($errors->has('email'))
                        <span class="text-danger ps-2" style="font-size:13px;">{{$errors->first('email')}}</span>
                    @endif
                  </div>
                  <div class="form-group mt-4">
                      <label style="font-weight: 400 !important;">Mot de passe</label>
                      <div class="form-input position-relative mb-2">
                          <input class="form-control rounded-0 py-3" type="password" id="password" name="password" placeholder="mot de passe" autocomplete="off">
                          <i class="fa-solid fa-eye toggle-password" id="togglePassword" style="color:#6495ED; position:absolute; top:50%; right:15px; transform:translateY(-50%); cursor:pointer;"></i>
                      </div>
                      @if($errors->has('password'))
                          <span class="text-danger ps-2" style="font-size:13px;">{{$errors->first('password')}}</span> 
                      @endif
                  </div>
                  <div class="form-group mb-0">
                    <div class="checkbox p-0 mb-2">
                      <input id="remember" type="checkbox" name="remember">
                      <label class="text-muted" for="remember">Mémoriser le mot de passe</label>
                      <div>
                        <a class="link mt-4" href="{{route('auth.forgetPassword')}}" style="font-weight:400 !important; margin-top:30px !important; color:#6495ED;">Mot de passe oublié ?</a>
                    </div>
                    </div>
                    <div class="text-end mt-4">
                      <button class="btn btn-block w-100 text-white" style="margin:20px auto -20px; background-color: #6495ED;" type="submit">Se connecter</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
      <script>
        // Masquer le message après 2 secondes
        setTimeout(function() {
            let successMessage = document.getElementById('success-message');
            if (successMessage) {
                successMessage.style.transition = 'opacity 0.5s ease';
                successMessage.style.opacity = '0';
                setTimeout(() => successMessage.remove(), 3000); // Supprime après l'animation
            }
        }, 3000);
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
      <script>
          document.getElementById('togglePassword').addEventListener('click', function () {
              const passwordInput = document.getElementById('password');
              const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
              passwordInput.setAttribute('type', type);

              if (type === 'text') {
                  this.classList.remove('fa-eye');
                  this.classList.add('fa-eye-slash');
              } else {
                  this.classList.remove('fa-eye-slash');
                  this.classList.add('fa-eye');
              }
          });
      </script>
    </div>
  </body>
</html>
