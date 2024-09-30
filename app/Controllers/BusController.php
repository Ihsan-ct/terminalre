<?php

namespace App\Controllers;

use App\Models\BusModel;
use App\Models\BusDepartureModel;
use CodeIgniter\Controller;
use CodeIgniter\Exceptions\PageNotFoundException;

class BusController extends Controller
{
    /**
     * Menampilkan daftar semua bus
     */
    public function index()
    {
        $busModel = new BusModel();
        $data['buses'] = $busModel->findAll();
        return view('bus_index', $data);
    }

    /**
     * Menghapus bus berdasarkan ID
     */
    public function delete($id)
    {
        $busModel = new BusModel();

        // Periksa apakah bus ada
        if (!$busModel->find($id)) {
            throw new PageNotFoundException("Bus dengan ID $id tidak ditemukan.");
        }

        // Hapus bus
        $busModel->delete($id);

        return redirect()->to('/bus_list')->with('message', 'Bus berhasil dihapus.');
    }

    /**
     * Menampilkan form edit bus
     */
    public function edit($id)
    {
        $busModel = new BusModel();
        $bus = $busModel->find($id);

        if (!$bus) {
            throw new PageNotFoundException("Bus dengan ID $id tidak ditemukan.");
        }

        $data['bus'] = $bus;
        return view('edit_bus', $data);
    }

    /**
     * Memperbarui data bus
     */
    public function update($id)
    {
        $busModel = new BusModel();
        $bus = $busModel->find($id);

        if (!$bus) {
            throw new PageNotFoundException("Bus dengan ID $id tidak ditemukan.");
        }

        $data = [
            'tnkb' => $this->request->getPost('tnkb'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'trayek' => $this->request->getPost('trayek'),
            'status' => $this->request->getPost('status'),
        ];

        $busModel->update($id, $data);
        return redirect()->to('/admin/dashboard')->with('message', 'Data bus berhasil diperbarui.');
    }

    /**
     * Memperbarui status dan jumlah penumpang bus
     */
    public function updateStatus($id)
    {
        $busModel = new BusModel();
        $bus = $busModel->find($id);

        if (!$bus) {
            throw new PageNotFoundException("Bus dengan ID $id tidak ditemukan.");
        }

        $data = [
            'status' => $this->request->getPost('status'),
            'passenger_count' => $this->request->getPost('passenger_count'),
        ];

        $busModel->update($id, $data);
        return redirect()->to('/admin/dashboard')->with('message', 'Status bus berhasil diperbarui.');
    }

    /**
     * Menampilkan form tambah bus baru
     */
    public function create()
    {
        // Ambil data terminal dari model
        $terminalModel = new \App\Models\TerminalModel();
        $terminals = $terminalModel->findAll();

        // Kirim data terminal ke view
        return view('bus_create', ['terminals' => $terminals]);
    }

    /**
     * Menyimpan bus baru
     */
    public function store()
    {
        $busModel = new BusModel();
        $data = [
            'tnkb' => $this->request->getPost('tnkb'),
            'nama_perusahaan' => $this->request->getPost('nama_perusahaan'),
            'trayek' => $this->request->getPost('trayek'),
            'terminal_id' => $this->request->getPost('terminal_id'),
            'status' => 'di_terminal', // Default status saat ditambahkan
        ];

        $busModel->save($data);
        return redirect()->to('/bus_list')->with('message', 'Bus baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form keberangkatan bus
     */
    public function departure($bus_id)
    {
        // Ambil data bus berdasarkan ID
        $busModel = new \App\Models\BusModel();
        $bus = $busModel->find($bus_id);

        if (!$bus) {
            throw new PageNotFoundException("Bus dengan ID $bus_id tidak ditemukan.");
        }

        // Ambil data terminal yang sesuai dengan terminal_id dari bus
        $terminalModel = new \App\Models\TerminalModel();
        $terminal = $terminalModel->find($bus['terminal_id']); // Ambil terminal sesuai terminal_id bus

        // Kirim data bus dan terminal ke view
        $data = [
            'bus_id' => $bus_id,
            'bus' => $bus,
            'terminal' => $terminal
        ];

        return view('bus_departure_form', $data);
    }

    /**
     * Menyimpan data keberangkatan bus
     */
    public function saveDeparture()
    {
        $busDepartureModel = new BusDepartureModel();

        // Validasi input data
        $rules = [
            'bus_id' => 'required|integer',
            'departure_time' => 'required|valid_date',
            'number_of_passengers' => 'required|integer',
            'status' => 'required|in_list[di_terminal,berangkat]',
            'terminal_id' => 'required|integer'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->with('errors', $this->validator->getErrors());
        }

        // Simpan data keberangkatan
        $data = [
            'bus_id' => $this->request->getPost('bus_id'),
            'departure_time' => $this->request->getPost('departure_time'),
            'number_of_passengers' => $this->request->getPost('number_of_passengers'),
            'status' => $this->request->getPost('status'),
            'terminal_id' => $this->request->getPost('terminal_id'),
        ];

        $busDepartureModel->save($data);

        // Update status bus di tabel buses
        $busModel = new BusModel();
        $busModel->update($data['bus_id'], ['status' => 'berangkat']);

        return redirect()->to('/admin/dashboard')->with('message', 'Keberangkatan bus berhasil diatur.');
    }

    /**
     * Menampilkan form kedatangan bus
     */
    public function returnToTerminal($id)
    {
        $departureModel = new BusDepartureModel();
        $departure = $departureModel->where('bus_id', $id)->first();

        return view('bus_arrival_form', ['departure' => $departure]);
    }


    /**
     * Menyimpan data kedatangan bus
     */
    public function saveArrival()
    {
        $busDepartureModel = new BusDepartureModel();
        $busModel = new BusModel();

        $id = $this->request->getPost('id');
        $busId = $this->request->getPost('bus_id');
        $arrivalTime = $this->request->getPost('arrival_time');
        $numberOfPassengersOut = $this->request->getPost('number_of_passengers_out');

        if (
            $this->validate([
                'arrival_time' => 'required',
                'number_of_passengers_out' => 'required|numeric'
            ])
        ) {
            $data = [
                'arrival_time' => $arrivalTime,
                'number_of_passengers_out' => $numberOfPassengersOut,
                'status' => 'di_terminal', // Ganti status menjadi 'di_terminal'
                'updated_at' => date('Y-m-d H:i:s')
            ];

            // Debug output
            log_message('debug', 'Data to update: ' . print_r($data, true));

            if ($busDepartureModel->update($id, $data)) {
                log_message('debug', 'Update successful');
                $busModel->updateStatus($busId, 'di_terminal');
                return redirect()->to('/admin/dashboard')->with('success', 'Data kedatangan berhasil disimpan.');
            } else {
                log_message('error', 'Update failed: ' . print_r($busDepartureModel->errors(), true));
                return redirect()->back()->withInput()->with('errors', $busDepartureModel->errors());
            }
        } else {
            // Debug validasi gagal
            log_message('error', 'Validation errors: ' . print_r($this->validator->getErrors(), true));
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
    }






    /**
     * Mengekspor data bus ke dalam file CSV
     */
    public function export()
    {
        $busModel = new BusModel();
        $buses = $busModel->findAll();

        // Set header untuk file CSV
        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment;filename="buses.csv"');
        header('Cache-Control: must-revalidate');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Menulis header CSV
        fputcsv($output, ['ID', 'TNKB', 'Nama Perusahaan', 'Trayek', 'Status'], ';');

        // Menulis data bus ke CSV
        foreach ($buses as $bus) {
            fputcsv($output, [
                $bus['id'],
                $bus['tnkb'],
                $bus['nama_perusahaan'],
                $bus['trayek'],
                $bus['status']
            ], ';');
        }

        // Menutup output stream
        fclose($output);
        exit;
    }
}
