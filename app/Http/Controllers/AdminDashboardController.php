<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $summaryCards = [
            [
                'label' => 'Pendaftaran Reguler',
                'count' => $this->countTable('daftar_reguler'),
                'description' => 'Calon siswa jalur reguler yang perlu diproses admin.',
                'accent' => 'from-orange-500/30 to-amber-300/10',
            ],
            [
                'label' => 'Pendaftaran Beasiswa',
                'count' => $this->countTable('daftar_beasiswa'),
                'description' => 'Data pendaftar beasiswa beserta berkas seleksinya.',
                'accent' => 'from-sky-500/30 to-cyan-300/10',
            ],
            [
                'label' => 'Agenda & Jadwal',
                'count' => $this->countTable('agenda') + $this->countTable('jadwal_latihan'),
                'description' => 'Agenda kegiatan dan jadwal latihan yang aktif dikelola.',
                'accent' => 'from-emerald-500/30 to-lime-300/10',
            ],
            [
                'label' => 'Konten Publik',
                'count' => $this->countTable('profil_sekolah') + $this->countTable('info_promo') + $this->countTable('achievement') + $this->countTable('tournament'),
                'description' => 'Profil sekolah, promo, prestasi, dan turnamen.',
                'accent' => 'from-fuchsia-500/30 to-pink-300/10',
            ],
        ];

        $managementModules = [
            [
                'title' => 'Profil Sekolah',
                'table' => 'profil_sekolah',
                'description' => 'Kelola konten profil utama sekolah, foto, dan narasi institusi.',
                'status' => 'Konten website',
            ],
            [
                'title' => 'Info Promo',
                'table' => 'info_promo',
                'description' => 'Atur promo aktif, periode tayang, dan materi publikasi.',
                'status' => 'Promosi',
            ],
            [
                'title' => 'Prestasi',
                'table' => 'achievement',
                'description' => 'Masukkan capaian siswa atau tim untuk ditampilkan ke publik.',
                'status' => 'Portofolio',
            ],
            [
                'title' => 'Agenda',
                'table' => 'agenda',
                'description' => 'Atur kegiatan, jadwal acara, lokasi, dan keterangan pelaksanaan.',
                'status' => 'Operasional',
            ],
            [
                'title' => 'Jadwal Latihan',
                'table' => 'jadwal_latihan',
                'description' => 'Kelola sesi latihan berdasarkan kelompok kelas dan waktu latihan.',
                'status' => 'Operasional',
            ],
            [
                'title' => 'Turnamen',
                'table' => 'tournament',
                'description' => 'Data agenda turnamen, waktu kegiatan, dan deskripsi pertandingan.',
                'status' => 'Kompetisi',
            ],
            [
                'title' => 'Pendaftaran Reguler',
                'table' => 'daftar_reguler',
                'description' => 'Review data pendaftar reguler dan tindak lanjuti status pendaftaran.',
                'status' => 'Admission',
            ],
            [
                'title' => 'Pendaftaran Beasiswa',
                'table' => 'daftar_beasiswa',
                'description' => 'Validasi pendaftar beasiswa, dokumen sertifikat, dan video seleksi.',
                'status' => 'Admission',
            ],
            [
                'title' => 'Data Siswa',
                'table' => 'siswa',
                'description' => 'Monitoring data siswa aktif untuk kebutuhan administrasi internal.',
                'status' => 'Akademik',
            ],
            [
                'title' => 'Data Orang Tua',
                'table' => 'siswa_ortu',
                'description' => 'Kelola informasi wali atau orang tua yang terhubung dengan siswa.',
                'status' => 'Akademik',
            ],
            [
                'title' => 'Akun Pengguna',
                'table' => 'users',
                'description' => 'Manajemen akun, role pengguna, dan status akses sistem.',
                'status' => 'Akses',
            ],
        ];

        $managementModules = collect($managementModules)->map(function (array $module) {
            $module['count'] = $this->countTable($module['table']);

            return $module;
        })->all();

        $recentRegularRegistrations = $this->latestRows(
            'daftar_reguler',
            ['nama_lengkap', 'email', 'status_pendaftaran', 'created_at'],
            5
        );

        $recentScholarshipRegistrations = $this->latestRows(
            'daftar_beasiswa',
            ['nama_lengkap', 'email', 'status_pendaftaran', 'created_at'],
            5
        );

        $recentContentUpdates = collect([
            ...$this->latestLabeledRows('agenda', 'Agenda', 'judul', 'created_at', 3),
            ...$this->latestLabeledRows('info_promo', 'Info Promo', 'judul', 'created_at', 3),
            ...$this->latestLabeledRows('achievement', 'Prestasi', 'judul', 'created_at', 3),
            ...$this->latestLabeledRows('tournament', 'Turnamen', 'judul', 'created_at', 3),
        ])->sortByDesc('created_at')->take(6)->values();

        return view('admin.dashboard', [
            'adminName' => Auth::user()?->name ?? 'Admin',
            'summaryCards' => $summaryCards,
            'managementModules' => $managementModules,
            'recentRegularRegistrations' => $recentRegularRegistrations,
            'recentScholarshipRegistrations' => $recentScholarshipRegistrations,
            'recentContentUpdates' => $recentContentUpdates,
        ]);
    }

    protected function countTable(string $table): int
    {
        if (!Schema::hasTable($table)) {
            return 0;
        }

        return DB::table($table)->count();
    }

    protected function latestRows(string $table, array $columns, int $limit)
    {
        if (!Schema::hasTable($table)) {
            return collect();
        }

        return DB::table($table)
            ->select($columns)
            ->orderByDesc('created_at')
            ->orderByDesc('id')
            ->limit($limit)
            ->get();
    }

    protected function latestLabeledRows(string $table, string $label, string $titleColumn, string $dateColumn, int $limit): array
    {
        if (!Schema::hasTable($table)) {
            return [];
        }

        $query = DB::table($table)->select([$titleColumn, $dateColumn]);

        if (Schema::hasColumn($table, 'id')) {
            $query->orderByDesc($dateColumn)->orderByDesc('id');
        } else {
            $query->orderByDesc($dateColumn);
        }

        return $query->limit($limit)
            ->get()
            ->map(function ($item) use ($label, $titleColumn, $dateColumn) {
                return [
                    'type' => $label,
                    'title' => $item->{$titleColumn},
                    'created_at' => $item->{$dateColumn},
                ];
            })
            ->all();
    }
}
