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
    <title>forget password</title><link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/vendors/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/icofont.css">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/flag-icon.css">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
    <link id="color" rel="stylesheet" href="assets/css/color-1.css" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="assets/css/responsive.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
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
    <div class="container-fluid p-0">
      @if (session('danger'))
        <div style="background-color: #FF6347; position:fixed; top:3%; left:50%; transform:translateX(-50%); z-index: 9999; padding: 10px 20px; border-radius: 5px; min-width: 300px; text-align: center; background-color:lightgray;" class="alert text-white rounded-0 py-3" id="danger-message">
          <p class="text-white m-0">{{ session('danger') }}</p>
        </div>
      @endif
      <div class="row">
        <div class="col-12">
          <div class="login-card">
            <div>
              <div class="mb-5"><a class="logo" href="{{ route('auth.index') }}"> <img class="img-fluid for-light" src="{{asset('assets/images/logo/logo4.png')}}" alt="looginpage" height="200px" width="200px" style="margin-top: 30px; margin-bottom: -40px;"></a></div>
              <div class="login-main rounded-0 py-4 shadow-sm position-relative">
                <a class="btn rounded-0" href="{{ route('auth.index') }}" style="position:absolute; top:0; left:0; background-color: #F5F5F5; color: #6495ED; padding: 12px 16px; border-bottom-right-radius: 25px !important;">
                  <i class="fas fa-sign-in"></i>
                </a>
                <form class="theme-form px-0" action="{{route('auth.emailSearch')}}" method="POST">
                  @csrf

                  <h4 class="text-center mt-2 mb-4" style="font-weight: 400; font-size: large;">Récupération de mot de passe</h4>
                  <p class="text-center">Entrez votre e-mail</p>
                  <div class="form-group mb-5">
                    <label class="col-form-label" style="font-weight: 400;">Adresse e-mail</label>
                    <input class="form-control mt-1 mb-2 rounded-0"  type="email" name="email" placeholder="Exemple@gmail.com" autocomplete="off">
                    @if($errors->has('email'))
                        <span class="ms-1" style="color:#F9B948;">{{$errors->first('email')}}</span>
                    @endif
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
        // Masquer le message après 2 secondes
        setTimeout(function() {
            let dangerMessage = document.getElementById('danger-message');
            if (dangerMessage) {
                dangerMessage.style.transition = 'opacity 0.5s ease';
                dangerMessage.style.opacity = '0';
                setTimeout(() => dangerMessage.remove(), 3000); // Supprime après l'animation
            }
        }, 3000);
    </script>
      <!-- latest jquery-->
      <script src="assets/js/jquery-3.6.0.min.js"></script>
      <!-- Bootstrap js-->
      <script src="assets/js/bootstrap/bootstrap.bundle.min.js"></script>
      <!-- feather icon js-->
      <script src="assets/js/icons/feather-icon/feather.min.js"></script>
      <script src="assets/js/icons/feather-icon/feather-icon.js"></script>
      <!-- scrollbar js-->
      <!-- Sidebar jquery-->
      <script src="assets/js/config.js"></script>
      <!-- Template js-->
      <script src="assets/js/script.js"></script>
      <!-- login js-->
    </div>
  </body>
</html>
