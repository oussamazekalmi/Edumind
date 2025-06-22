@extends('layout.master')

@section('title')
    Fond sonore
@endsection

<style>
    .footer {
        display:none;
        visibility:hidden;
    }

    h4 {
        font-size: 16px !important;
        font-weight: 500 !important;
    }

    label {
        padding: 13px 19px !important;
        background-color: #f8f9fa !important;
        border: 1px solid #f8f9fa !important;
        font-weight: 400 !important;
        border-radius: .5rem 0 0 .5rem !important;
    }

    #file-name {
        padding: 13px 19px !important;
        border: 1px solid #f8f9fa !important;
        font-weight: 400 !important;
        border-radius: 0 .5rem .5rem 0 !important;
        min-width: 300px !important;
        text-align: center;
    }

    .custom-link {
        border-radius: .5rem !important;
    }

    label:hover {
        color: #6c757d !important;
        transition: all 0.5s ease !important;
    }

    .text-highlight {
        color: #F9B948 !important;
    }
</style>

@section('content')
    <div class="page-body">
        <div class="container-fluid mt-3">
            <div class="row">
                <div class="col-md-12 text-secondary">
                    <div class="card shadow-sm rounded-0">
                        <div class="card-header pb-0 position-relative">
                            <a class="btn rounded-0 tooltip-icon" data-tooltip="Profil" href="{{ route('auth.profile') }}" style="position:absolute; top:0; left:0; background-color: #f8f9fa !important; color: #6c757d !important; padding: 14px 18px; font-size: 16px;">
                                <i class="fas fa-user"></i>
                            </a>
                            <h4 class="text-secondary mt-5 ms-5">Choisir un nouveau fichier audio (.mp3)</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('audio.upload') }}" method="POST" enctype="multipart/form-data" class="mt-5 ms-5">
                                @csrf
                                <div class="mb-3 d-flex align-items-center gap-4">
                                    <div class="mb-3 d-flex align-items-center">
                                        <input id="customFile" type="file" name="audio" accept=".mp3,.wav,.ogg" style="display: none;">

                                        <label for="customFile" class="mb-0" style="cursor: pointer; color: #333;">
                                            Choisir un fichier audio
                                        </label>

                                        <span id="file-name" class="text-secondary mb-0">
                                            Aucun fichier sélectionné
                                        </span>
                                    </div>

                                    <div class="mb-3 d-flex align-items-center gap-4">
                                        <button type="submit" class="btn custom-link" style="background-color: #f8f9fa !important; color: #F9B948 !important; padding: 14px 18px; font-size: 16px;">
                                            <i class="fas fa-headphones"></i>
                                        </button>
                                        <a class="btn custom-link" href="{{ route('auth.profile') }}" style="background-color: #f8f9fa !important; color: #F9B948 !important; padding: 14px 18px; font-size: 16px;">
                                            <i class="fas fa-times"></i>
                                        </a>
                                    </div>
                                </div>
                            </form>
                            <div class="mt-5 ms-5">
                                <p style="font-size: 13px; font-weight:500;" class="text-secondary">
                                    Profitez de l'occasion pour choisir l'un de vos morceaux instrumentaux préférés via ce lien <a href="https://pixabay.com/music/search/instrumental" target="_blank" style="color: #F9B948; font-weight: 600;">ナルト</a>,<br/> puis téléchargez-le et plongez dans une expérience musicale unique <span style="color: #F9B948;">!</span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('customFile');
        const fileNameSpan = document.getElementById('file-name');

        fileInput.addEventListener('change', function () {
            const name = this.files.length > 0 ? this.files[0].name : 'Aucun fichier sélectionné';
            fileNameSpan.textContent = name;
        });
    });
</script>


