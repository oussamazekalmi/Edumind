@extends('layout.master')

@section('title')
    Liste des cycles
@endsection

@section('content')
<div class="page-body">
    <!-- Container-fluid starts-->
    <div class="container-fluid basic_table">
      <div class="row">
        <div class="col-sm-12">
          <div class="card rounded-0 shadow-sm">
            <div class="card-header">
                <a href="{{ route('cycle.ajouter') }}" class="btn px-3 py-2 rounded-0 text-secondary tooltip-icon" data-tooltip="Ajouer cycle" style="position:absolute; top:0; left:0; background-color: #F1F1FC;"><i class="fas fa-plus"></i></a>
              </div>
            <div class="table-responsive theme-scrollbar mx-4 px-4 mb-4">
                <table class="table table-borderless text-center">
                    <thead class="thead-info">
                        <tr style="background-color: rgb(241, 241, 252)">
                            <th>Cycle</th>
                            <th>Montant inscription</th>
                            <th>Montant transport</th>
                            <th>Date de modification</th>
                            <th><i class="fas fa-sliders-h" style="font-size:20px; font-weight: 800;"></i></th>
                        </tr>
                    </thead>
                    <tbody>
                      @foreach ($cycles as $cycle)
                        <tr>
                            <td>
                                {{$cycle->nom}}
                            </td>
                            <td>
                                {{$cycle->montant_inscription}} DH
                            </td>
                            <td>
                                {{$cycle->montant_transport}} DH
                            </td>
                            <td>
                                {{date('d-m-Y',strToTime($cycle->updated_at))}}
                            </td>
                            <td>
                                <a class="btn px-3 py-2 text-light me-2 tooltip-icon" data-tooltip="Modifier cycle" href="{{ route('cycle.modifier', $cycle->id) }}" style="background-color: lightblue;"><i class="fas fa-edit"></i></a>
                                <button class="btn px-3 py-2 text-light delete-btn tooltip-icon" data-tooltip="Supprimer" data-id="{{ $cycle->id }}" style="background-color: #FA8072;"><i class="fas fa-trash-alt"></i></button>
                            </td>
                        </tr>
                      @endforeach
                    </tbody>
                </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content" style="border-radius: 0;">
        <div class="modal-header">
          <h5 class="modal-title" id="deleteModalLabel">Confirmation</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Êtes-vous sûr de vouloir supprimer ce cycle ?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn me-5 rounded-1 py-2" style="background-color: #dcdcdc; color: #0A0A23;" data-bs-dismiss="modal">Annuler</button>
          <form id="deleteForm" method="POST" style="display: inline-block;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn rounded-1 py-2" style="background-color: #0A0A23; color: white;">Confirmer</button>
          </form>
        </div>
      </div>
    </div>
  </div>

  <!-- JavaScript for Modal -->
  <script>
  document.addEventListener("DOMContentLoaded", function() {
      const deleteButtons = document.querySelectorAll('.delete-btn');
      const deleteForm = document.getElementById('deleteForm');
      const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));

      deleteButtons.forEach(button => {
          button.addEventListener('click', function() {
              const cycleId = button.getAttribute('data-id');
              const deleteUrl = `/supprimer/cycle/${cycleId}`; // Correct the URL here
              deleteForm.action = deleteUrl;
              deleteModal.show();
          });
      });
  });
</script>

@endsection
