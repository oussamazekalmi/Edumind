@extends('layout.master')


@section('title')
    Profile
@endsection

<style>
  .input-container {
      position: relative;
      margin-top: 1.5rem;
  }

  .input-container input {
      width: 100%;
      padding-bottom: 15px !important;
      padding-left: 16px !important;
      border: 1px solid lightgray;
      padding: 1rem 0.75rem 0.25rem 0.75rem;
      border-radius: 0.375rem;
      background: transparent;
      font-size: 14px !important;
  }

  .input-container label {
      position: absolute;
      top: -0.6rem;
      left: 0.75rem;
      background: white;
      padding: 0 0.25rem;
      font-size: 0.8rem;
      color: #333;
  }

  .footer {
      display:none;
      visibility:hidden;
  }
</style>

@section('content')
<div class="page-body">
    <div class="container-fluid mt-4">
        <div class="row">
          <div class="col-md-12 text-secondary">
            <div class="card shadow-sm rounded-0">
              <div class="card-header pb-0">
                <h4 style="font-weight: 500;">Gérer mon profil</h4>
              </div>
              <div class="card-body">
                <form class="form-wizard" id="regForm" action="{{ route('auth.editPassword') }}" method="POST">
                  @csrf

                  <div class="tab pt-5 pb-2">
                      <div class="row mb-5">
                          <div class="col-md-5 mx-5">
                              <div class="input-container position-relative">
                                <input class="form-control rounded-0 @error('password') border-danger @enderror" id="password" name="password" type="password" placeholder="xx- xxxx- xxxx- xx- xxxx" autocomplete="new-password">
                                <label for="password">Nouveau mot de passe</label>
                                <div class="show-hide" id="togglePassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                                    <i class="fa fa-eye"></i>
                                </div>
                              </div>

                              @error('password')
                                <div class="text-danger mt-2" style="font-size:13px;">{{ $message }}</div>
                              @enderror
                          </div>
                          <div class="col-md-5">
                            <div class="input-container position-relative">
                                <input class="form-control rounded-0" id="password_confirmation" name="password_confirmation" type="password" placeholder="xx- xxxx- xxxx- xx- xxxx" autocomplete="new-password">
                                <label for="password_confirmation">Confirmer votre mot de passe</label>
                                <div class="show-hide" id="toggleConfirmPassword" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); cursor:pointer;">
                                    <i class="fa fa-eye"></i>
                                </div>
                            </div>
                          </div>
                      </div>
                  </div>

                  <div class="text-end btn-mb">
                      <button class="btn rounded-2 text-white fw-bold bg-dark ms-5 px-4" style="position:absolute; bottom: 3%; left: 3%; background-color:lightgray !important;" id="prevBtn" type="button" onclick="nextPrev(-1)">
                          Précédent
                      </button>
                      <button class="btn rounded-2 text-white fw-bold bg-dark me-5 px-4" style="position:absolute; bottom: 3%; right: 4%; background-color:#02021d !important;" id="nextBtn" type="button" onclick="nextPrev(1)">
                          Suivant
                      </button>
                  </div>
              </form>
              </div>
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

@endsection
