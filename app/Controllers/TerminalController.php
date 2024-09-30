<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\BusModel;
use App\Models\TerminalModel;
use App\Models\BusDepartureModel;

class TerminalController extends Controller
{
    protected $busModel;
    protected $terminalModel;
    protected $busDepartureModel;

    public function __construct()
    {
        $this->busModel = new BusModel();
        $this->terminalModel = new TerminalModel();
        $this->busDepartureModel = new BusDepartureModel();
    }

    public function index()
    {
        $selectedTerminal = $this->request->getGet('terminal');
        $terminals = $this->terminalModel->findAll();

        $busData = [];
        $terminalStatistics = [];
        $totalPassengersIn = 0;
        $totalPassengersOut = 0;

        if ($selectedTerminal) {
            $busData = $this->busModel->where('terminal_id', $selectedTerminal)->findAll();

            if (!empty($busData)) {
                $totalBuses = count($busData);

                foreach ($busData as $bus) {
                    $departures = $this->busDepartureModel->getDepartures($bus['id']);
                    $totalPassengersIn += array_sum(array_column($departures, 'number_of_passengers'));
                    $totalPassengersOut += array_sum(array_column($departures, 'number_of_passengers_out'));
                }

                $terminalStatistics = [
                    'total_buses' => $totalBuses,
                    'total_passengers_in' => $totalPassengersIn,
                    'total_passengers_out' => $totalPassengersOut
                ];
            }
        } else {
            $busData = $this->busModel->findAll();
        }

        $data = [
            'terminals' => $terminals,
            'selectedTerminal' => $selectedTerminal,
            'terminalStatistics' => $terminalStatistics,
            'busData' => $busData
        ];

        return view('terminal_statistics', $data);
    }
}
