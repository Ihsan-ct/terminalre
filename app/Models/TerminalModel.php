<?php namespace App\Models;

use CodeIgniter\Model;

class TerminalModel extends Model
{
    protected $table = 'terminals';
    protected $primaryKey = 'id';

    protected $allowedFields = ['nama_terminal'];

    public function get_all_terminals()
    {
        return $this->findAll();
    }

    public function get_terminal_statistics($terminal_id)
    {
        // Misalnya query untuk mendapatkan statistik
        // Sesuaikan query dengan tabel dan kolom yang Anda miliki
        $builder = $this->db->table('bus_departure');
        $builder->select('COUNT(*) as total_buses, SUM(number_of_passengers) as total_passengers');
        $builder->where('terminal_id', $terminal_id);
        $query = $builder->get();
        return $query->getRowArray();
    }

    public function get_buses_in_terminal($terminal_id)
    {
        $builder = $this->db->table('buses');
        $builder->where('terminal_id', $terminal_id);
        $query = $builder->get();
        return $query->getResultArray();
    }
}
