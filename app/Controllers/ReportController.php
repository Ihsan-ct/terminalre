<?php

namespace App\Controllers;

use App\Models\BusDepartureModel;
use App\Models\TerminalModel;
use CodeIgniter\Controller;

class ReportController extends Controller
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function index()
    {
        $busDepartureModel = new BusDepartureModel();
        $terminalModel = new TerminalModel();
        
        // Ambil semua data
        $allData = $busDepartureModel->getAllData();

        // Ambil semua terminal untuk filter
        $data['terminals'] = $terminalModel->findAll();
        
        // Load view dengan data
        return view('report_view', [
            'dailyReport' => $allData,
            'monthlyReport' => $allData,  // Ubah sesuai kebutuhan
            'yearlyReport' => $allData,    // Ubah sesuai kebutuhan
            'terminals' => $data['terminals'],
            'selectedTerminal' => null
        ]);
    }

    public function generateReport()
    {
        $busDepartureModel = new BusDepartureModel();
        $terminalId = $this->request->getGet('terminal');
        
        if ($terminalId) {
            $allData = $busDepartureModel->getReportsByTerminal($terminalId);
        } else {
            $allData = $busDepartureModel->getAllData();
        }

        // Nama file CSV
        $filename = 'laporan_keberangkatan_bus.csv';

        // Set header untuk file CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // Buka output untuk menulis data CSV
        $output = fopen('php://output', 'w');

        // Mengatur encoding UTF-8 dengan menambahkan BOM (Byte Order Mark)
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Menulis header kolom dengan pemisah titik koma
        fputcsv($output, ['ID', 'TNKB', 'Trayek', 'Waktu Keberangkatan', 'Waktu Kedatangan', 'Jumlah Penumpang Masuk', 'Jumlah Penumpang Keluar', 'Terminal', 'Status'], ';');

        // Menulis baris data dengan pemisah titik koma
        foreach ($allData as $report) {
            fputcsv($output, [
                $report['id'],
                $report['tnkb'],
                $report['trayek'],
                date('d-m-Y H:i', strtotime($report['departure_time'])),
                date('d-m-Y H:i', strtotime($report['arrival_time'])),
                $report['number_of_passengers'],
                $report['number_of_passengers_out'],
                $report['nama_terminal'],
                $report['status']
            ], ';');
        }

        // Tutup file output
        fclose($output);
        exit;
    }

    public function filterByTerminal()
    {
        $terminalId = $this->request->getGet('terminal');
        $busDepartureModel = new BusDepartureModel();
        $terminalModel = new TerminalModel();

        // Ambil semua terminal untuk filter
        $data['terminals'] = $terminalModel->findAll();
        
        // Ambil laporan berdasarkan terminal
        if ($terminalId) {
            $data['dailyReport'] = $busDepartureModel->getReportsByTerminal($terminalId);
            $data['selectedTerminal'] = $terminalId;
        } else {
            $data['dailyReport'] = $busDepartureModel->getAllData();
            $data['selectedTerminal'] = null;
        }

        return view('report_view', $data);
    }
}
