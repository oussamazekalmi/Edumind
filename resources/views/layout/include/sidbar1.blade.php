<div class="sidebar-wrapper">
    <div>
      <div class="logo-wrapper"><a href="#"><img class="img-fluid for-light" src="{{asset('assets/images/logo/logo4-1.png')}}" alt="" height="100px" width="100px" style="margin-top:-18px; margin-left: -15px;"></a>
        <div class="back-btn"><i data-feather="grid"></i></div>
        <div class="toggle-sidebar icon-box-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i></div>
      </div>
      <div class="logo-icon-wrapper"><a href="index.html">
          <div class="icon-box-sidebar"><i data-feather="grid"></i></div></a></div>
      <nav class="sidebar-main">
        <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
        <div id="sidebar-menu">
          <ul class="sidebar-links" id="simple-bar">
            <li class="back-btn">
              <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2" aria-hidden="true"></i></div>
            </li>
            <li class="pin-title sidebar-list">
              <h6>Pinned</h6>
            </li>
            <hr>
            @if (auth()->user()->role == 'directeur')
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" style="cursor:pointer;"><i data-feather="credit-card"></i><span>Caisse</span></a>
              <ul class="sidebar-submenu" >
                <li>
                  <a class="inner" href="{{route('index.frais')}}" style="cursor:pointer;"></i>Tous les frais</a>
                </li>
                <li class="my-1">
                  <a class="inner" href="{{ route('inscription.frais') }}">Frais inscription</a>
                </li>
                <li>
                  <a class="inner" href="{{ route('scolaire.frais') }}">Frais scolarité</a>
                </li>
                <li class="my-1">
                  <a class="inner" href="{{ route('transport.frais') }}">Frais transport</span></a>
                </li>
                <li>
                  <a class="inner" href="{{route('archived.frais')}}" style="cursor:pointer;">Frais archivés</a>
                </li>
                <li class="mt-1">
                  <a class="inner" href="{{route('frais.corbeille')}}" style="cursor:pointer;">Corbeille</a>
                </li>
              </ul>
              </li>
            @endif
            <li class="sidebar-list">
              <i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ route('eleves.index') }}"><i data-feather="users"></i><span>Liste élèves</span></a>
            </li>
            <li class="sidebar-list">
              <i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" href="{{ route('liste.reussis') }}"><i class="fas fa-trophy me-3 text-white"></i><span>Passation élèves</span></a>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i><a class="sidebar-link sidebar-title" style="cursor:pointer;"><i data-feather="target"></i><span>Administration</span></a>
              <ul class="sidebar-submenu">
                <li>
                  <a class="inner" href="{{route('eleve.ajoute')}}" style="cursor:pointer;"><span>Ajout élève</span></a>
                </li>
                <li>
                  <a class="inner" href="{{route('classes.index')}}" style="cursor:pointer;"><span>Groupe</span></a>
                </li>
                <li>
                  <a class="inner" href="{{route('niveau.liste')}}" style="cursor:pointer;"><span>Niveau</span></a>
                </li>
                <li>
                  <a class="inner" href="{{route('cycle.liste')}}" style="cursor:pointer;"><span>Cycle</span></a>
                </li>
              </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
              <a class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="user"></i><span>Préférence</span></a>
              <ul class="sidebar-submenu">
                <li>
                  <a class="inner" href="{{route('auth.profile')}}" style="cursor:pointer;"><span>Profil {{auth()->user()->role}}</span></a>
                </li>
                <li>
                  <a class="inner" href="{{route('auth.password')}}" style="cursor:pointer;"><span>Gestion mot de passe</span></a>
                </li>
                <li>
                    <a class="inner" href="{{ route('audio.settings') }}" style="cursor:pointer;">
                        <span>Musique d'arrière-plan</span>
                    </a>
                </li>
              </ul>
            </li>
            <li class="sidebar-list"><i class="fa fa-thumb-tack"></i>
              <a href="{{route('auth.logout')}}" class="sidebar-link sidebar-title" href="javascript:void(0)"><i data-feather="log-out"></i><span>Déconnecter</span></a>
            </li>
          </ul>
        </div>
        <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
      </nav>
    </div>
  </div>
