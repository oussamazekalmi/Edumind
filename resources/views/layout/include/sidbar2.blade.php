<style>
    .archive-btn:hover {
        color: #F9B948 !important;
        border-bottom: 2px solid #F9B948 !important;
        font-weight: 600 !important;
        transition: all .2s linear;
    }
</style>

<div class="header-wrapper row m-0">
    <div class="header-logo-wrapper col-auto p-0">
      <div class="toggle-sidebar">
        <i class="status_toggle middle sidebar-toggle" data-feather="grid"> </i>
      </div>
      <div class="logo-header-main" style="margin-bottom: -20px;">
        <a href="">
          <img class="for-light img-100"  src="{{asset('assets/images/logo/logo4-1.png')}}" alt="">
        </a>
      </div>
    </div>
    <div class="left-header col horizontal-wrapper ps-0">
        <a href="{{route('eleves.index')}}" class="text-black me-4" style="cursor:pointer; font-size: 22px;"><i class="fas fa-home" style="color: #02021d;"></i></a>
        <a style="font-size: 20px; font-weight: 500;">Espace {{ ucfirst(auth()->user()->role) }}</a>
        <audio id="relax-audio" loop>
            <source src="{{ asset('audio/calm-music.mp3') }}?v={{ \Illuminate\Support\Str::random(8) }}" type="audio/mpeg">
        </audio>
   </div>
   <div class="nav-right col-md-6 pull-right right-header p-0">
      <ul class="nav-menus">
        <li></li>
        <a href="{{ route('archive.frais') }}" class="text-black me-5 mt-1 px-1 archive-btn" style="cursor:pointer; border-bottom:solid black 1px;" id="archive-link">
            Archiver Frais
        </a>
        <button onclick="toggleAudio()" style="border:none; background:none; cursor:pointer; margin-right: 12px;">
            <i id="music-icon" class="fas fa-volume-up" style="font-size: 16px; color: #444;"></i>
        </button>
        <li class="maximize"><a href="#" onclick="javascript:toggleFullScreen()"><i data-feather="maximize-2"></i></a></li>
        <li class="profile-nav onhover-dropdown">
          <div class="account-user"><i data-feather="user"></i></div>
          <ul class="profile-dropdown onhover-show-div rounded-0" style="width: 180px !important; padding: 8px;">
            <li><a href="{{route('auth.profile')}}"><i data-feather="user"></i><span>profile</span></a></li>
            <li><a href="{{route('auth.logout')}}"><i data-feather="log-in"> </i><span>déconnexion </span></a></li>
          </ul>
        </li>
      </ul>
    </div>

    <script>
        const audio = document.getElementById("relax-audio");
        const icon = document.getElementById("music-icon");

        function restoreAudioState() {
            const savedTime = localStorage.getItem('audioTime');
            const isPaused = localStorage.getItem('audioPaused') === 'true';

            if (savedTime) {
                audio.currentTime = parseFloat(savedTime);
            }

            if (isPaused) {
                audio.pause();
                icon.style.color = "#F9B948";
            } else {
                audio.play().then(() => {
                    icon.style.color = "#444";
                }).catch(() => {
                });
            }
        }

        function toggleAudio() {
            if (audio.paused) {
                audio.play();
                icon.style.color = "#444";
                localStorage.setItem('audioPaused', 'false');
            } else {
                audio.pause();
                icon.style.color = "#F9B948";
                localStorage.setItem('audioPaused', 'true');
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            restoreAudioState();

            audio.addEventListener('timeupdate', () => {
                localStorage.setItem('audioTime', audio.currentTime);
            });

            audio.addEventListener('pause', () => {
                localStorage.setItem('audioPaused', 'true');
            });

            audio.addEventListener('play', () => {
                localStorage.setItem('audioPaused', 'false');
            });

            audio.addEventListener('ended', () => {
                localStorage.removeItem('audioTime');
                localStorage.setItem('audioPaused', 'true');
            });
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            let currentDate = new Date();
            let year = currentDate.getFullYear();

            let startDate = new Date(year, 6, 1);
            let endDate = new Date(year, 8, 1);

            if (currentDate >= startDate && currentDate <= endDate) {
                document.getElementById('archive-link').style.display = 'inline';
            } else {
                document.getElementById('archive-link').style.display = 'none';
            }
        });
    </script>

    <script class="result-template" type="text/x-handlebars-template">
      <div class="ProfileCard u-cf">
      <div class="ProfileCard-avatar"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-airplay m-0"><path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1"></path><polygon points="12 15 17 21 7 21 12 15"></polygon></svg></div>
      <div class="ProfileCard-details">
      <div class="ProfileCard-realName">name</div>
      </div>
      </div>
    </script>
    <script class="empty-template" type="text/x-handlebars-template"><div class="EmptyMessage">Your search turned up 0 results. This most likely means the backend is down, yikes!</div></script>
</div>
