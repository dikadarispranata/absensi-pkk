<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.2.0/remixicon.css">
   <link rel="stylesheet" href="{{ asset('css/style.css') }}">
   
   <title>Dashboard</title>
</head>

<body>
   <header class="header" id="header">
      <div class="header__container">
         <a href="#" class="header__logo">
            <i class="ri-cloud-fill"></i>
            <span>Absensi</span>
         </a>

         <button class="header__toggle" id="header-toggle">
            <i class="ri-menu-line"></i>
         </button>
      </div>
   </header>
   <nav class="sidebar" id="sidebar">
      <div class="sidebar__container">
         <div class="sidebar__user">
            <div class="sidebar__img">
               <i class="ri-user-fill"></i>
            </div>

            <div class="sidebar__info">
               <h3>{{Auth::user()->username}}</h3>
               <span>{{ Auth::user()->email }}</span>
            </div>
         </div>

         <div class="sidebar__content">
            <div>
               <h3 class="sidebar__title">MANAGE</h3>

               <div class="sidebar__list">
                  @if (auth()->user()->role == 'karyawan')
                     <a href="/dashboard" class="sidebar__link {{ request()->is('dashboard*') ? 'active-link' : '' }}">
                        <i class="ri-pie-chart-2-fill"></i>
                        <span>Dashboard</span>
                     </a>
                     <a href="absen/scan" class="sidebar__link {{ request()->is('absen/scan*') ? 'active-link' : '' }}">
                        <i class="ri-qr-scan-line"></i>
                        <span>Scan</span>
                     </a>
                     <a href="/absensis" class="sidebar__link {{ request()->is('absensi*') ? 'active-link' : '' }}">
                        <i class="ri-calendar-fill"></i>
                        <span>Absensi Saya</span>
                     </a>
                     <a href="/izins" class="sidebar__link {{ request()->is('izin*') ? 'active-link' : '' }}">
                        <i class="ri-file-list-fill"></i>
                        <span>Ajukan Izin</span>
                     </a>

                  @endif
                  @if (auth()->user()->role == 'admin')
                     <a href="/dashboard" class="sidebar__link {{ request()->is('dashboard') ? 'active-link' : '' }}">
                        <i class="ri-pie-chart-2-fill"></i>
                        <span>Dashboard</span>
                     </a>

                     <a href="/karyawan" class="sidebar__link  {{ request()->is('karyawan*') ? 'active-link' : '' }}">
                        <i class="ri-user-3-fill"></i>
                        <span>Karyawan</span>
                     </a>
                     <a href="/departemens" class="sidebar__link {{ request()->is('departemen*') ? 'active-link' : '' }}">
                        <i class="ri-community-fill"></i>
                        <span>Departemen</span>
                     </a>
                     <a href="/jabatans" class="sidebar__link  {{ request()->is('jabatan*') ? 'active-link' : '' }}">
                        <i class="ri-user-2-fill"></i>
                        <span>Jabatan</span>
                     </a>
                     <a href="/jadwals" class="sidebar__link {{ request()->is('jadwal*') ? 'active-link' : '' }}">
                        <i class="ri-calendar-fill"></i>
                        <span>Jadwal</span>
                     </a>
                     <a href="/izins" class="sidebar__link {{ request()->is('izin*') ? 'active-link' : '' }}">
                        <i class="ri-file-list-fill"></i>
                        <span>Izin Cuti</span>
                     </a>
                     <a href="/absensis" class="sidebar__link {{ request()->is('absensi*') ? 'active-link' : '' }}">
                        <i class="ri-calendar-event-fill"></i>
                        <span>Absensi</span>
                     </a>
                     <a href="{{ route('absen.qr') }}"
                        class="sidebar__link {{ request()->routeIs('absen.qr*') ? 'active-link' : '' }}">
                        <i class="ri-barcode-line"></i>
                        <span>Qr</span>
                     </a>
                     <div class="select-wrapper">
                         <i class="ri-file-chart-line select-icon"></i>
                        <select class="sidebar-select {{ request()->is('laporan*') ? 'active-select' : '' }}"
                           onchange="handleLaporanChange(this)">
                           <option value="">Pilih Laporan</option>
                           <option value="{{ route('laporan.index') }}" {{ request()->is('laporan') && !request()->is('laporan/rekap*') ? 'selected' : '' }}>
                              Laporan Absen
                           </option>
                           <option value="{{ route('laporan.rekap') }}" {{ request()->is('laporan/rekap*') ? 'selected' : '' }}>
                              Rekap Laporan
                           </option>
                        </select>
                     </div>
                  @endif

               </div>
            </div>

            <!-- <div>
               <h3 class="sidebar__title">SETTINGS</h3>

               <div class="sidebar__list">
                  <a href="#" class="sidebar__link {{ request()->is('pengaturan*') ? 'active-link' : '' }}">
                     <i class="ri-settings-3-fill"></i>
                     <span>Pengaturan</span>
                  </a>
               </div> -->
            </div>
         </div>
         <div class="sidebar__actions">
            <form id="logoutForm" action="/logout" method="POST" class="'inline logout-form">
               @csrf
               <button type="button" class="sidebar__link">
                  <i class="ri-logout-box-r-fill"></i>
                  <span>Log Out</span>
               </button>
            </form>
         </div>
      </div>
   </nav>


   <main class="main w-full" id="main">
      @yield('content')
   </main>

   <script src="{{ asset('js/main.js') }}"></script>
   <script src="https://cdn.tailwindcss.com"></script>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
   <script>
      document.querySelectorAll('.logout-form button').forEach(button => {
         button.addEventListener('click', function (e) {
            e.preventDefault();
            let form = this.closest('form');

            Swal.fire({
               title: 'Apakah Anda yakin?',
               text: "Anda akan keluar dari website!",
               icon: 'warning',
               showCancelButton: true,
               confirmButtonColor: '#d33',
               cancelButtonColor: '#3085d6',
               confirmButtonText: 'Ya, keluar',
               cancelButtonText: 'Batal'
            }).then((result) => {
               if (result.isConfirmed) {
                  form.submit();
               }
            })
         });
      });
   </script>
   <script>
      function handleLaporanChange(select) {
         const selectedValue = select.value;
         if (selectedValue) {
            window.location.href = selectedValue;
         }
      }
   </script>
</body>

</html>