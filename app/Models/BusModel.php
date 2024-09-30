<?php

namespace App\Models;

use CodeIgniter\Model;

class BusModel extends Model
{
    protected $table = 'buses';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'tnkb',
        'nama_perusahaan',
        'trayek',
        'status',
        'terminal_id'
    ];

    protected $useTimestamps = false;

    protected $validationRules = [
        'tnkb' => 'required|min_length[1]|max_length[20]',
        'nama_perusahaan' => 'required|min_length[1]|max_length[100]',
        'trayek' => 'required|min_length[1]|max_length[100]',
        'status' => 'required|in_list[di_terminal,berangkat]',
        'terminal_id' => 'permit_empty|integer'
    ];

    protected $validationMessages = [
        'tnkb' => [
            'required' => 'TNKB harus diisi.',
            'max_length' => 'TNKB tidak boleh melebihi 20 karakter.'
        ],
        'nama_perusahaan' => [
            'required' => 'Nama Perusahaan harus diisi.',
            'max_length' => 'Nama Perusahaan tidak boleh melebihi 100 karakter.'
        ],
        'trayek' => [
            'required' => 'Trayek harus diisi.',
            'max_length' => 'Trayek tidak boleh melebihi 100 karakter.'
        ],
        'status' => [
            'required' => 'Status harus diisi.',
            'in_list' => 'Status harus salah satu dari "di_terminal" atau "berangkat".'
        ],
        'terminal_id' => [
            'integer' => 'Terminal ID harus berupa integer.'
        ]
    ];

    public function getAllCompanies()
    {
        return $this->db->table($this->table)
            ->select('nama_perusahaan')
            ->distinct()
            ->get()
            ->getResultArray();
    }

    public function searchAndFilter($search = '', $status = '')
    {
        $builder = $this->builder();

        if (!empty($search)) {
            $builder->groupStart()
                ->like('tnkb', $search)
                ->orLike('nama_perusahaan', $search)
                ->orLike('trayek', $search)
                ->groupEnd();
        }

        if (!empty($status)) {
            $builder->where('status', $status);
        }

        return $builder;
    }

    public function getBusesInTerminal($terminal_id)
    {
        // Validasi input terminal_id
        if (!is_numeric($terminal_id)) {
            throw new \InvalidArgumentException('Terminal ID harus berupa angka.');
        }

        return $this->where('terminal_id', $terminal_id)
            ->where('status', 'di_terminal')
            ->findAll();
    }

    public function getBusDetails($id)
    {
        return $this->find($id);
    }

    public function getBusByTNKB($tnkb)
    {
        return $this->where('tnkb', $tnkb)->first();
    }

    public function getDepartures($busId)
    {
        return $this->db->table('bus_departures')
            ->where('bus_id', $busId)
            ->get()->getResultArray();
    }
    public function updateStatus($id, $status)
{
    return $this->update($id, ['status' => $status]);
}

}
