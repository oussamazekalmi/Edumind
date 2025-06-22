@extends('layout.master')


@section('title')
    Ajouter cycle
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }
</style>

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid">
      <div class="edit-profile">
        <div class="row d-flex justify-content-center">
          <div class="col-xl-12 col-lg-12">
            <form class="card rounded-0 shadow-sm" action="{{route('cycle.store')}}" method="POST">
              @csrf
              <div class="card-header pt-0 position-relative">
                <a class="btn px-3 rounded-0 text-secondary" href="{{ route('cycle.liste') }}" style="position:absolute; bottom:0; left:0; background-color: #F1F1FC;">
                    <i class="fas fa-rotate-left"></i>
                </a>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="col-md-3">
                    <div class="mb-3">
                      <label class="form-label f-w-500">Cycle</label>
                      <input class="form-control forms-administartion rounded-0 f-w-500 text-secondary mb-2" type="text" name='cycle' value="{{old('cycle')}}" autocomplete="off">
                      @error('cycle')
                        <small class="text-danger ms-1" id="danger-message">{{ $message }}</small>
                      @enderror
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div>
                        <label for="montant_inscription" class="form-label">Montant inscription</label>
                        <input type="number" id="montant_inscription" name="montant_inscription" value="{{ old('montant_inscription') }}"
                            class="form-control forms-administartion rounded-0 f-w-500 text-secondary mb-2">
                        @error('montant_inscription')
                            <div class="text-danger ms-1">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                  <div class="col-md-3">
                    <div>
                        <label for="montant_transport" class="form-label">Montant transport</label>
                        <input type="number" id="montant_transport" name="montant_transport" value="{{ old('montant_transport') }}"
                            class="form-control forms-administartion rounded-0 f-w-500 text-secondary mb-2" autocomplete="off">
                        @error('montant_transport')
                            <div class="text-danger ms-1">{{ $message }}</div>
                        @enderror
                    </div>
                  </div>
                </div>
              </div>
              <div class="card-footer position-relative pt-5">
                <div style="position:absolute; bottom:20%; right:2%;">
                    <button class="btn me-5 py-2 px-4 rounded-1 text-white" type="submit" style="background-color: #ace1af;">Créer</button>
                    <a class="btn py-2 px-4 rounded-1 text-white" href="{{ route('cycle.liste') }}" style="background-color: #FA8072;">Annuler</a>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
