<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Dumas;
use App\Models\UserData;
use App\Models\KategoriDumas;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class DumasController extends Controller
{
    // =======================================================================
    // API ENDPOINTS (UNTUK FLUTTER)
    // =======================================================================

    public function publicIndex()
    {
        $userId = request()->query('user_id');

        // PERBAIKAN: Eager load relasi 'kategori' untuk efisiensi
        $query = Dumas::with('kategori')->orderBy('created_at', 'desc');

        if (!is_null($userId) && $userId !== '') {
            $query->where('user_id', $userId);
        }

        $paginator = $query->paginate(10);

        $paginator->getCollection()->transform(function ($item) {
            if ($item->bukti_laporan) {
                $item->bukti_laporan = url(Storage::url($item->bukti_laporan));
            }
            // PERBAIKAN: Menambahkan nama kategori dari relasi
            $item->kategori_laporan = $item->kategori->nama_kategori ?? 'Umum';
            return $item;
        });

        return $paginator;
    }

    public function publikShow(Request $request, $id)
    {
        // Eager load relasi 'ratings' dan 'kategori'
        $dumas = Dumas::with(['ratings', 'kategori'])->find($id);

        if (!$dumas) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        $data = $dumas->toArray();
        if ($dumas->bukti_laporan) {
            $data['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }

        if ($dumas->foto_tanggapan) {
            $data['foto_tanggapan'] = url(Storage::url($dumas->foto_tanggapan));
        }

        $data['tanggapan_admin'] = $dumas->tanggapan;

        // Ambil ulasan pertama (dan satu-satunya) yang ada untuk laporan ini.
        $rating = $dumas->ratings->first();

        // Selalu sertakan data ulasan dalam respons jika ada
        $data['user_rating'] = $rating ? $rating->rating : null;
        $data['user_comment'] = $rating ? $rating->comment : null;

        // Hapus relasi mentah agar respons JSON bersih.
        unset($data['ratings']);

        return response()->json($data);
    }

    // --- PENAMBAHAN: Endpoint baru untuk mengambil daftar kategori ---
    public function getKategori()
    {
        // Ambil semua nama kategori unik dan urutkan berdasarkan nama
        $kategori = KategoriDumas::orderBy('nama_kategori', 'asc')->pluck('nama_kategori');

        return response()->json($kategori, 200);
    }

    public function show($id)
    {
        // Ambil data dengan relasi kategori & ratings
        $item = Dumas::with(['kategori', 'ratings'])->findOrFail($id);

        return view('admin.dumas.aduan.show', compact('item'));
    }

    // =======================================================================
    // ADMIN PANEL & API STORE (LOGIKA BARU ANDA)
    // =======================================================================

    public function index()
    {
        $user = Auth::guard('admin')->user();

        if ($user->role === 'superadmin') {
            $items = Dumas::with(['kategori.instansi', 'ratings'])
                ->orderByRaw("FIELD(status, 'selesai') ASC")
                ->orderBy('created_at', 'desc')
                ->get();

            // superadmin lihat semua instansi
            $instansiList = Instansi::orderBy('nama')->get();
        } else {
            $userData = UserData::where('id_admin', $user->id)->first();
            $idInstansi = $userData?->id_instansi;

            $items = Dumas::with(['kategori.instansi', 'ratings'])
                ->whereHas('kategori', function ($q) use ($idInstansi) {
                    $q->where('id_instansi', $idInstansi);
                })
                ->orderByRaw("FIELD(status, 'selesai') ASC")
                ->orderBy('created_at', 'desc')
                ->get();

            // admin dinas hanya tampilkan instansi miliknya (atau kosongkan jika mau)
            $instansiList = Instansi::where('id', $idInstansi)->orderBy('nama')->get();
        }

        $stats = [
            'menunggu' => Dumas::where('status', 'menunggu')->count(),
            'diproses' => Dumas::where('status', 'diproses')->count(),
            'selesai'  => Dumas::where('status', 'selesai')->count(),
            'ditolak'  => Dumas::where('status', 'ditolak')->count(),
        ];

        return view('admin.dumas.aduan.index', compact('items', 'stats', 'instansiList'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori'   => 'required|exists:kategori_dumas,nama_kategori',
            'jenis_laporan'   => 'required',
            'lokasi_laporan'  => 'required',
            'deskripsi'       => 'required',
            'pernyataan'      => 'nullable|string',
            'bukti_laporan'   => 'nullable|image',
        ]);

        // Cari kategori berdasarkan nama
        $kategori = KategoriDumas::where('nama_kategori', $request->nama_kategori)->first();

        $dumas = new Dumas();
        $dumas->id_kategori    = $kategori->id; // simpan id hasil pencarian
        $dumas->jenis_laporan  = $request->jenis_laporan;
        $dumas->lokasi_laporan = $request->lokasi_laporan;
        $dumas->pernyataan     = $request->pernyataan;
        $dumas->deskripsi      = $request->deskripsi;

        if ($request->user()) {
            $dumas->user_id = $request->user()->id;
        }

        if ($request->hasFile('bukti_laporan')) {
            $path = $request->file('bukti_laporan')->store('bukti_laporan', 'public');
            $dumas->bukti_laporan = $path;
        }

        $dumas->status = 'menunggu';
        $dumas->save();

        // Load relasi 'kategori' untuk disertakan dalam respons
        $dumasResponse = $dumas->load('kategori')->toArray();
        if ($dumas->bukti_laporan) {
            $dumasResponse['bukti_laporan'] = url(Storage::url($dumas->bukti_laporan));
        }
        // Tambahkan nama kategori secara manual untuk konsistensi
        $dumasResponse['kategori_laporan'] = $kategori->nama_kategori;

        $this->logAktivitas("Ada Pengaduan baru yang ditambahkan");
        $this->logNotifikasi("Ada Pengaduan baru yang ditambahkan");

        return response()->json([
            'message' => 'Pengaduan berhasil ditambahkan',
            'data'    => $dumasResponse,
        ], 201);
    }

    public function updateInstansi(Request $request, $id)
    {
        $request->validate([
            'id_instansi' => 'required|exists:instansi,id',
        ]);

        $dumas = Dumas::with('kategori')->findOrFail($id);

        // Update kategori berdasarkan instansi baru
        $kategoriBaru = KategoriDumas::where('id_instansi', $request->id_instansi)->first();

        if (!$kategoriBaru) {
            return back()->with('error', 'Kategori untuk instansi ini belum ada.');
        }

        $dumas->id_kategori = $kategoriBaru->id;
        $dumas->save();

        $this->logAktivitas("Kategori laporan diperbarui");
        $this->logNotifikasi("Kategori laporan diperbarui");

        return back()->with('success', 'Instansi berhasil diperbarui!');
    }

public function updateStatus(Request $request, $id)
    {
        $dumas = Dumas::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu,diproses,selesai,ditolak',
        ]);

        $dumas->status = $request->status;
        $dumas->save();

        // --- [MULAI KODE NOTIFIKASI BARU] ---
        if ($dumas->user_id) {
            $title = "Status Laporan Diperbarui";
            $body = "Status laporan Anda berubah menjadi: " . ucfirst($request->status);

            // Custom pesan biar lebih ramah
            if ($request->status == 'diproses') {
                $body = "Laporan Anda sedang ditindaklanjuti oleh petugas.";
            } elseif ($request->status == 'selesai') {
                $title = "Laporan Selesai";
                $body = "Laporan Anda telah selesai ditangani. Terima kasih atas informasinya.";
            } elseif ($request->status == 'ditolak') {
                $title = "Laporan Ditolak";
                $body = "Mohon maaf, laporan Anda tidak dapat kami proses.";
            }

            Notification::create([
                'id_user' => $dumas->user_id,
                'type'    => 'dumas',       // Tipe khusus dumas
                'data_id' => $dumas->id,    // ID Laporan untuk navigasi
                'title'   => $title,
                'body'    => $body,
                'is_read' => 0,
            ]);
        }
        // --- [SELESAI KODE NOTIFIKASI BARU] ---

        $this->logAktivitas("Status DUMAS diperbarui");
        $this->logNotifikasi("Status pengaduan diperbarui");

        return back()->with('success', 'Status berhasil diperbarui!');
    }

public function updateTanggapanFoto(Request $request, $id)
    {
        $dumas = Dumas::findOrFail($id);

        // Validasi tanggapan + foto
        $request->validate([
            'tanggapan'      => 'nullable|string',
            'foto_tanggapan' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        // Update tanggapan (boleh kosong)
        if ($request->filled('tanggapan')) {
            $dumas->tanggapan = $request->tanggapan;
        }

        // Kalau upload foto baru
        if ($request->hasFile('foto_tanggapan')) {

            // Hapus foto lama
            if ($dumas->foto_tanggapan && Storage::disk('public')->exists($dumas->foto_tanggapan)) {
                Storage::disk('public')->delete($dumas->foto_tanggapan);
            }

            // Simpan foto baru
            $file = $request->file('foto_tanggapan');
            $fotoName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('foto_tanggapan', $fotoName, 'public');

            $dumas->foto_tanggapan = $path;
        }

        $dumas->save();

        // --- [MULAI KODE NOTIFIKASI BARU] ---
        if ($dumas->user_id) {
            Notification::create([
                'id_user' => $dumas->user_id,
                'type'    => 'dumas',
                'data_id' => $dumas->id,
                'title'   => 'Tanggapan Baru',
                'body'    => 'Admin telah memberikan tanggapan atau bukti tindak lanjut pada laporan Anda.',
                'is_read' => 0,
            ]);
        }
        // --- [SELESAI KODE NOTIFIKASI BARU] ---

        $this->logAktivitas("Tanggapan & Foto DUMAS diperbarui");
        $this->logNotifikasi("Tanggapan dan foto pengaduan diperbarui");

        return back()->with('success', 'Tanggapan & foto berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $dumas = Dumas::findOrFail($id);

        if ($dumas->bukti_laporan && Storage::disk('public')->exists($dumas->bukti_laporan)) {
            Storage::disk('public')->delete($dumas->bukti_laporan);
        }

        $dumas->delete();

        $this->logAktivitas("Pengaduan telah dihapus");
        $this->logNotifikasi("Pengaduan telah dihapus");

        return back()->with('success', 'Data berhasil dihapus!');
    }

    protected $aktivitasTipe = 'dumas';

    protected function logAktivitas($pesan)
    {
        if (auth()->check()) {
            $user = auth()->user();

            \App\Models\Aktivitas::create([
                'user_id'     => $user->id,
                'tipe'        => $this->aktivitasTipe,
                'keterangan'  => $pesan,
                'role'        => $user->role,
                'id_instansi' => $user->id_instansi ?? null,
            ]);
        }
    }

    protected function logNotifikasi($pesan)
    {
        $user = auth()->user();

        \App\Models\NotifikasiAktivitas::create([
            'keterangan'   => $pesan,
            'dibaca'       => false,
            'url'          => route('admin.dumas.aduan.index'),
            'role'         => $user->role ?? 'admin',
            'id_instansi'  => $user->id_instansi ?? null,
        ]);
    }
}
