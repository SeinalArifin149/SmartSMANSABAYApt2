<?php
// edit_profil.php - Formulir Edit dengan Animasi

// --- DATA USER (DUMMY) ---
$user = [
    "nama"      => "Senaif Arifin",
    "kelas"     => "XII MIPA 2",
    "bio"       => "tetap sakit walau tersakiti",
    "nis"       => "123456789",
    "hp"        => "081234567890",
    "email"     => "senaif@gmail.com",
    "password"  => "" 
];

// Variabel untuk trigger SweetAlert
$updateSuccess = false;

// --- LOGIKA PENYIMPANAN ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Simulasi proses simpan data...
    $nama_baru  = $_POST['nama'];
    // ... logic update db di sini ...

    // Set flag sukses menjadi true agar JS di bawah bisa menangkapnya
    $updateSuccess = true;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary-green': '#00A859',
                        'light-bg': '#F8F9FD',
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    
    <style>
        body { font-family: 'Poppins', sans-serif; }

        /* --- Custom Keyframes --- */
        @keyframes fadeInUpSoft {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* Kelas Animasi Masuk */
        .animate-enter { 
            opacity: 0; 
            animation: fadeInUpSoft 0.8s cubic-bezier(0.2, 0.8, 0.2, 1) forwards; 
        }

        /* Delay Staggering (Bergantian) */
        .delay-0 { animation-delay: 0ms; }
        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        /* --- Interaksi Form --- */
        /* Saat input difokus, ubah warna border dan icon */
        .input-group:focus-within .input-icon {
            color: #00A859;
            transform: scale(1.1);
        }
        
        .input-field {
            transition: all 0.3s ease;
        }
        
        .input-field:focus {
            border-color: #00A859;
            box-shadow: 0 4px 20px rgba(0, 168, 89, 0.1);
            transform: translateY(-2px);
            background-color: #fff;
        }
    </style>
</head>
<body class="bg-light-bg min-h-screen pb-10">

<div class="container mx-auto max-w-md relative">

    <div class="bg-primary-green h-64 rounded-b-[40px] absolute top-0 left-0 w-full z-0 shadow-lg"></div>

    <div class="relative z-10 px-6 pt-12">
        
        <header class="flex justify-between items-center text-white mb-8 animate-enter delay-0">
            <a href="profile_user.php" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white/20 backdrop-blur-md hover:bg-white/30 transition text-sm font-semibold hover:scale-110 active:scale-95 duration-200">
                <i class="fas fa-times"></i>
            </a>
            
            <h1 class="text-lg font-bold tracking-wide drop-shadow-md">Edit Profil</h1>
            
            <button type="button" onclick="confirmSave()" class="flex items-center justify-center w-10 h-10 rounded-xl bg-white text-primary-green hover:bg-green-50 transition shadow-lg hover:scale-110 active:scale-95 duration-200">
                <i class="fas fa-check"></i>
            </button>
        </header>
        
        <div class="bg-white p-6 rounded-[30px] shadow-xl animate-enter delay-100 mt-4 pb-10">
            
            <div class="flex justify-center -mt-16 mb-6 relative animate-enter delay-100">
                <div class="p-1.5 bg-white rounded-full shadow-md relative group cursor-pointer transition-transform hover:scale-105 duration-300">
                    <img src="https://img.freepik.com/free-vector/businessman-character-avatar-isolated_24877-60111.jpg" 
                         alt="Profile Avatar" 
                         class="w-24 h-24 rounded-full object-cover border-4 border-gray-100 group-hover:border-green-100 transition-colors">
                    
                    <div class="absolute inset-0 bg-black/40 rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition duration-300 backdrop-blur-[1px]">
                        <i class="fas fa-camera text-white text-xl animate-bounce"></i>
                    </div>
                    
                    <div class="absolute bottom-1 right-1 bg-primary-green text-white w-8 h-8 rounded-full flex items-center justify-center border-2 border-white shadow-sm group-hover:rotate-12 transition-transform">
                        <i class="fas fa-pen text-xs"></i>
                    </div>
                </div>
            </div>

            <form id="editForm" method="POST" action="" class="space-y-6">

                <div class="animate-enter delay-200">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 pl-1 border-l-4 border-primary-green/50 ml-1">&nbsp;Info Umum</h3>
                    
                    <div class="space-y-4">
                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">Nama Lengkap</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-user"></i></span>
                                <input type="text" name="nama" value="<?= $user['nama'] ?>" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field" required>
                            </div>
                        </div>

                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">Kelas</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-graduation-cap"></i></span>
                                <input type="text" name="kelas" value="<?= $user['kelas'] ?>" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field">
                            </div>
                        </div>

                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">Bio Singkat</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-quote-left"></i></span>
                                <textarea name="bio" rows="2" 
                                          class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field resize-none"><?= $user['bio'] ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-dashed border-gray-200 my-2">

                <div class="animate-enter delay-300">
                    <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3 pl-1 border-l-4 border-primary-green/50 ml-1">&nbsp;Data Pribadi</h3>
                    
                    <div class="space-y-4">
                        <div class="group input-group opacity-70">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1">NIS <span class="text-[9px] text-gray-400">(Tidak dapat diubah)</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon"><i class="fas fa-id-card"></i></span>
                                <input type="text" name="nis" value="<?= $user['nis'] ?>" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-100 border border-gray-200 rounded-xl text-sm font-medium text-gray-500 focus:outline-none cursor-not-allowed" readonly>
                            </div>
                        </div>

                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">No. WhatsApp</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-phone"></i></span>
                                <input type="number" name="hp" value="<?= $user['hp'] ?>" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field">
                            </div>
                        </div>

                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">Email</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-envelope"></i></span>
                                <input type="email" name="email" value="<?= $user['email'] ?>" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field">
                            </div>
                        </div>

                        <div class="group input-group">
                            <label class="block text-[11px] font-medium text-gray-500 mb-1 ml-1 group-hover:text-primary-green transition-colors">Password Baru</label>
                            <div class="relative">
                                <span class="absolute left-4 top-3.5 text-gray-400 input-icon transition-all duration-300"><i class="fas fa-lock"></i></span>
                                <input type="password" name="password" placeholder="Biarkan kosong jika tetap" 
                                       class="w-full pl-10 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 focus:outline-none input-field placeholder:text-gray-300 transition-all">
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
        
        <div class="h-10"></div>

    </div>

</div>

<script>
    // 1. Fungsi Konfirmasi Simpan (Klik Tombol Centang)
    function confirmSave() {
        // Validasi form sederhana (opsional)
        const form = document.getElementById('editForm');
        
        // Trigger submit form
        form.submit();
    }

    // 2. Cek apakah PHP berhasil update (untuk menampilkan animasi sukses)
    <?php if ($updateSuccess): ?>
        Swal.fire({
            title: 'Berhasil Disimpan!',
            text: 'Data profil Anda telah diperbarui.',
            icon: 'success',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            // Animasi Popup
            showClass: {
                popup: 'animate__animated animate__zoomIn'
            },
            hideClass: {
                popup: 'animate__animated animate__fadeOutUp'
            }
        }).then(() => {
            // Redirect setelah animasi selesai
            window.location.href = 'profile_user.php';
        });
    <?php endif; ?>
</script>

</body>
</html>