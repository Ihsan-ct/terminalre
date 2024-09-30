<?php

namespace App\Models;

use CodeIgniter\Model;

class BusDepartureModel extends Model
{

    public function getPassengerStats()
    {
        return $this->selectSum('number_of_passengers', 'total_in')
            ->selectSum('number_of_passengers_out', 'total_out')
            ->get()
            ->getRowArray();
    }
    protected $table = 'bus_departures'; // Sesuaikan dengan nama tabel yang benar
    protected $primaryKey = 'id';

    // Kolom yang dapat diisi oleh pengguna
    protected $allowedFields = [
        'bus_id',
        'departure_time',
        'number_of_passengers',
        'status',
        'arrival_time',
        'number_of_passengers_out',
        'terminal_id',
    ];

    // Aktifkan timestamps otomatis
    protected $useTimestamps = true;
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';

    // Validasi untuk input
    protected $validationRules = [
        'bus_id' => 'required|integer',
        'departure_time' => 'required|valid_date',
        'number_of_passengers' => 'required|integer',
        'status' => 'required|in_list[di_terminal,berangkat,tiba]',
        'arrival_time' => 'permit_empty|valid_date',
        'number_of_passengers_out' => 'permit_empty|integer',
    ];

    protected $validationMessages = [
        'bus_id' => [
            'required' => 'Bus ID harus diisi.',
            'integer' => 'Bus ID harus berupa angka.',
        ],
        'departure_time' => [
            'required' => 'Waktu keberangkatan harus diisi.',
            'valid_date' => 'Waktu keberangkatan harus berupa tanggal dan waktu yang valid.',
        ],
        'number_of_passengers' => [
            'required' => 'Jumlah penumpang harus diisi.',
            'integer' => 'Jumlah penumpang harus berupa angka.',
        ],
        'status' => [
            'required' => 'Status harus diisi.',
            'in_list' => 'Status harus di antara di_terminal, berangkat, atau tiba.',
        ],
        'arrival_time' => [
            'valid_date' => 'Waktu kedatangan harus berupa tanggal dan waktu yang valid.',
        ],
        'number_of_passengers_out' => [
            'integer' => 'Jumlah penumpang keluar harus berupa angka.',
        ],
    ];

    // Mendapatkan riwayat keberangkatan berdasarkan bus_id
    public function getAllData()
    {
        $builder = $this->db->table($this->table);
        $builder->select('bus_departures.id, buses.tnkb, buses.trayek, bus_departures.departure_time, bus_departures.number_of_passengers, bus_departures.status, bus_departures.arrival_time, bus_departures.number_of_passengers_out, terminals.nama_terminal');
        $builder->join('buses', 'bus_departures.bus_id = buses.id');
        $builder->join('terminals', 'bus_departures.terminal_id = terminals.id', 'left');

        // Ambil semua data
        return $builder->get()->getResultArray();
    }



    public function getDepartures($busId)
    {
        return $this->where('bus_id', $busId)->findAll();
    }

    public function getReportsByTerminal($terminalId)
    {
        return $this->select('bus_departures.*, buses.tnkb, buses.trayek, buses.status, terminals.nama_terminal')
            ->join('buses', 'buses.id = bus_departures.bus_id')
            ->join('terminals', 'buses.terminal_id = terminals.id')
            ->where('buses.terminal_id', $terminalId)
            ->findAll();
    }
}
