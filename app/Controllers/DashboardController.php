<?php

namespace App\Controllers;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\BusModel;
use App\Models\BusDepartureModel;
use App\Models\TerminalModel;

class DashboardController extends BaseController
{
    public function adminDashboard()
    {
        $busModel = new BusModel();
        $terminalModel = new TerminalModel(); // Inisialisasi model Terminal
        $pager = \Config\Services::pager();

        // Ambil parameter pencarian, filter, dan terminal dari request
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';
        $selectedTerminal = $this->request->getGet('terminal') ?? ''; // Ambil terminal yang dipilih dari request

        // Menangani parameter untuk pagination
        $currentPage = $this->request->getGet('page') ?? 1;
        $perPage = 10; // Jumlah item per halaman

        // Query dasar untuk mengambil data bus
        $query = $busModel->asArray();

        // Filter berdasarkan pencarian TNKB
        if (!empty($search)) {
            $query = $query->like('tnkb', $search);
        }

        // Filter berdasarkan status
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        // Filter berdasarkan terminal yang dipilih
        if (!empty($selectedTerminal)) {
            $query = $query->where('terminal_id', $selectedTerminal);
        }

        // Mendapatkan data bus dengan pagination dan filter yang sudah diterapkan
        $data['buses'] = $query->paginate($perPage, 'default', $currentPage);
        $data['pager'] = $query->pager;

        // Statistik bus
        $data['stats'] = [
            'di_terminal' => $busModel->where('status', 'di_terminal')->countAllResults(),
            'berangkat' => $busModel->where('status', 'berangkat')->countAllResults(),
        ];

        // Ambil data terminal untuk dropdown
        $data['terminals'] = $terminalModel->findAll();

        // Kirim terminal yang dipilih ke view
        $data['selectedTerminal'] = $selectedTerminal;

        // Ambil data bus untuk dropdown atau daftar bus yang tersedia
        $data['busList'] = $busModel->findAll(); // Definisikan busList di sini

        // Kirim data pencarian dan filter ke view
        $data['search'] = $search;
        $data['status'] = $status;

        return view('admin_dashboard', $data);
    }




    public function userDashboard()
    {
        $busModel = new BusModel();
        $pager = \Config\Services::pager();

        // Ambil parameter pencarian dan filter dari request
        $search = $this->request->getGet('search') ?? '';
        $status = $this->request->getGet('status') ?? '';

        // Menangani parameter untuk pagination
        $currentPage = $this->request->getGet('page') ?? 1;
        $perPage = 10; // Jumlah item per halaman

        // Query dasar untuk mengambil data bus
        $query = $busModel->asArray(); // Pastikan menggunakan asArray() untuk hasil array

        // Penerapan filter berdasarkan pencarian TNKB
        if (!empty($search)) {
            $query = $query->like('tnkb', $search);
        }

        // Penerapan filter berdasarkan status
        if (!empty($status)) {
            $query = $query->where('status', $status);
        }

        // Mendapatkan data bus dengan pagination dan filter yang sudah diterapkan
        $data['buses'] = $query->paginate($perPage, 'default', $currentPage);
        $data['pager'] = $query->pager;

        // Statistik bus (user mungkin tidak perlu statistik lengkap seperti admin)
        $data['stats'] = [
            'di_terminal' => $busModel->where('status', 'di_terminal')->countAllResults(),
            'berangkat' => $busModel->where('status', 'berangkat')->countAllResults(),
        ];

        // Kirim data pencarian dan filter ke view
        $data['search'] = $search;
        $data['status'] = $status;

        // Ambil data bus untuk dropdown (hanya bus yang ada di terminal)
        $data['busList'] = $busModel->where('status', 'di_terminal')->findAll();

        return view('user_dashboard', $data);
    }

    public function showBus($id)
    {
        $busModel = new BusModel();
        $departureModel = new BusDepartureModel();

        // Mengambil data bus berdasarkan ID
        $data['bus'] = $busModel->find($id);

        if (!$data['bus']) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Bus tidak ditemukan');
        }

        // Mengambil riwayat keberangkatan bus berdasarkan bus_id
        $data['history'] = $departureModel->where('bus_id', $id)->findAll();

        return view('bus_detail', $data);
    }

    public function createBus()
    {
        $busModel = new BusModel();

        $data = [
            'tnkb' => $this->request->getPost('tnkb'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'trayek' => $this->request->getPost('trayek'),
            'status' => $this->request->getPost('status'),
        ];

        if ($busModel->insert($data)) {
            return redirect()->to('/dashboard/admin')->with('message', 'Bus berhasil ditambahkan');
        } else {
            return redirect()->back()->with('errors', $busModel->errors());
        }
    }

    public function exportPdf()
    {
        $busModel = new BusModel();
        $data['buses'] = $busModel->findAll();

        // Inisialisasi Dompdf
        $pdf = new Dompdf();

        // Atur opsi dompdf
        $options = new Options();
        $options->set('defaultPaperSize', 'A4');
        $pdf->setOptions($options);

        // Load view ke dalam PDF
        $html = view('pdf_report', $data);
        $pdf->loadHtml($html);

        // Set ukuran dan orientasi kertas
        $pdf->setPaper('A4', 'portrait');

        // Render PDF (HTML ke PDF)
        $pdf->render();

        // Output PDF ke browser
        $pdf->stream('laporan_bus.pdf', ['Attachment' => 0]);
    }

    public function busList()
    {
        $db = \Config\Database::connect();
        $builder = $db->table('buses');

        // Dapatkan filter terminal dari request
        $terminalId = $this->request->getGet('terminal_id');

        $sort = $this->request->getGet('sort') ?? 'tnkb';
        $order = $this->request->getGet('order') ?? 'asc';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 10;

        $totalItems = $builder->countAll();
        $totalPages = ceil($totalItems / $perPage);
        $offset = ($page - 1) * $perPage;

        // Lakukan join dengan tabel terminals dan filter terminal jika ada
        $builder->select('buses.*, terminals.nama_terminal')
            ->join('terminals', 'buses.terminal_id = terminals.id', 'left')
            ->orderBy($sort, $order)
            ->limit($perPage, $offset);

        // Jika ada filter terminal, tambahkan ke query
        if ($terminalId) {
            $builder->where('buses.terminal_id', $terminalId);
        }

        $query = $builder->get();
        $buses = $query->getResultArray();

        $data = [
            'buses' => $buses,
            'current_page' => $page,
            'total_pages' => $totalPages,
            'sort' => $sort,
            'order' => $order,
            'terminals' => $db->table('terminals')->get()->getResultArray(), // Ambil data terminal untuk dropdown
            'selected_terminal' => $terminalId // Kirim data terminal yang dipilih
        ];

        return view('bus_list', $data);
    }




    public function filterByTerminal($terminalId)
    {
        $busModel = new BusModel();
        $data['buses'] = $busModel->where('terminal_id', $terminalId)->findAll();

        return view('bus_list', $data);
    }

    public function terminals()
    {
        $terminalModel = new TerminalModel();
        $busModel = new BusModel();

        // Mengambil semua terminal
        $terminals = $terminalModel->findAll();

        // Mengambil terminal yang dipilih (jika ada) dari query string
        $selectedTerminal = $this->request->getGet('terminal');

        // Jika terminal dipilih, ambil bus yang berada di terminal tersebut
        if ($selectedTerminal) {
            $buses = $busModel->where('terminal_id', $selectedTerminal)->findAll();
        } else {
            // Jika tidak ada terminal yang dipilih, ambil semua bus
            $buses = $busModel->findAll();
        }

        // Siapkan data yang akan diteruskan ke view
        $data = [
            'terminals' => $terminals,
            'buses' => $buses,
            'selectedTerminal' => $selectedTerminal,
        ];

        // Render view dengan data terminal dan bus
        return view('admin_dashboard', $data);
    }


    public function create()
    {
        return view('create_terminal');
    }

    public function store()
    {
        $terminalModel = new TerminalModel();
        $data = [
            'nama_terminal' => $this->request->getPost('nama_terminal'),
            'lokasi' => $this->request->getPost('lokasi'),
        ];

        if ($terminalModel->insert($data)) {
            return redirect()->to('/terminals')->with('message', 'Terminal berhasil ditambahkan');
        } else {
            return redirect()->back()->with('errors', $terminalModel->errors());
        }
    }
    public function getTerminalStatistics($terminalId)
    {
        $busModel = new BusModel();
        $busDeparturesModel = new BusDepartureModel();

        $totalBuses = $busModel->getBusesByTerminal($terminalId);
        $totalPassengers = $busDeparturesModel->where('terminal_id', $terminalId)->sum('number_of_passengers');

        return [
            'total_buses' => count($totalBuses),
            'total_passengers' => $totalPassengers,
        ];
    }

}
