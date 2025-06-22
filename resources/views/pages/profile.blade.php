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
      padding-bottom: 12px !important;
      padding-left: 16px !important;
      border: 1px solid lightgray;
      padding: 1rem 0.75rem 0.25rem 0.75rem;
      border-radius: 0.375rem;
      background: transparent;
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
    <div class="container-fluid mt-3">
        <div class="row">
          <div class="col-md-12 text-secondary">
            <div class="card shadow-sm rounded-0">
              <div class="card-header pb-0">
                <h4 style="font-weight: 500;">Gérer mon profil</h4>
              </div>
              <div class="card-body">
                <form class="form-wizard" id="regForm" action="{{route('auth.edit')}}" method="POST">
                  @csrf
                  <div class="tab pt-5">
                    <div class="row mb-5">
                      <div class="col-md-5 mx-5">
                       <div class="input-container">
                            <input class="form-control mb-2 rounded-0" id="nom" name="nom" type="text" placeholder="{{'Nom '. ucfirst(auth()->user()->role) }}" value="{{ auth()->user()->nom }}" autocomplete="off">
                            <label for="nom">Nom</label>
                            @error('nom')
                                <div class="text-danger" style="font-size:13px;">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="col-md-5">
                       <div class="input-container">
                            <input class="form-control mb-2 rounded-0" id="prenom" name="prenom" type="text" placeholder="{{'Prénom '. ucfirst(auth()->user()->role) }}" value="{{ auth()->user()->prenom }}" autocomplete="off">
                            <label for="prenom">Prénom</label>
                            @error('prenom')
                                <div class="text-danger" style="font-size:13px;">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="tab">
                    <div class="row mb-5">
                      <div class="col-md-5 mx-5">
                        <div class="input-container">
                            <input class="form-control mb-2 rounded-0" id="email" name="email" type="email" placeholder="{{'E-mail '. ucfirst(auth()->user()->role) }}" value="{{ auth()->user()->email }}" autocomplete="off">
                            <label for="email">E-mail</label>
                            @error('email')
                                <div class="text-danger" style="font-size:13px;">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="input-container">
                            <input class="form-control mb-2 rounded-0" type="text" maxlength="7" id="cin" name="cin" placeholder="Carte d'Identité Nationale" value="{{ auth()->user()->cin }}" autocomplete="off">
                            <label for="cin">CIN</label>
                            @error('cin')
                                <div class="text-muted" style="font-size:13px;">{{ $message }}</div>
                            @enderror
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-5 mx-5">
                        <label>Genre</label>
                        <div class="my-3">
                          <label for="male" class="me-5" style="cursor:pointer;">
                              <input class="radio_animated rounded-0" id="male" type="radio" name="genre" value="male" @checked(auth()->user()->genre == "male")>Homme
                          </label>
                          <label for="female" class="ms-2" style="cursor:pointer;">
                              <input class="radio_animated rounded-0" id="female" type="radio" name="genre" value="female" @checked(auth()->user()->genre == "female")>Femme
                          </label>
                          @error('genre')
                              <div class="text-danger" style="font-size:13px;">{{ $message }}</div>
                          @enderror
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
                  <div class="text-center"><span class="step"></span><span class="step"></span></div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>
@endsection

<script>
  document.addEventListener('DOMContentLoaded', function () {
      const cinInput = document.getElementById('cin');

      const cinPattern = /^[A-Za-z][0-9]{3,6}$/;

      function validateInput(input, pattern, errorMessage) {
          let errorElement = input.parentNode.querySelector('.text-muted');

          if (!errorElement) {
              errorElement = document.createElement('small');
              errorElement.classList.add('text-muted');
              input.parentNode.appendChild(errorElement);
          }

          if (input.value.trim() === '') {
              errorElement.textContent = '';
              return;
          }

          if (!pattern.test(input.value.trim())) {
              errorElement.textContent = errorMessage;
          } else {
              errorElement.textContent = '';
          }
      }

      cinInput.addEventListener('keyup', function () {
          validateInput(cinInput, cinPattern, 'La CIN doit être comprise entre 4 et 7 caractères.');
      });
  });
</script>

