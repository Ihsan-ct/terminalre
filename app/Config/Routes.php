<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Rute Otentikasi
$routes->get('/', 'AuthController::login'); // Halaman login - menampilkan halaman login
$routes->get('/login', 'AuthController::login'); // Halaman login - menampilkan halaman login
$routes->post('/authenticate', 'AuthController::authenticate'); // Proses autentikasi - memproses login pengguna
$routes->get('/logout', 'AuthController::logout'); // Logout - mengeluarkan pengguna dari sesi

// Rute Dashboard Admin dan User
$routes->get('/admin/dashboard', 'DashboardController::adminDashboard', ['filter' => 'auth:admin']); // Dashboard admin - menampilkan dashboard untuk admin
$routes->get('/user/dashboard', 'DashboardController::userDashboard', ['filter' => 'auth:user']); // Dashboard pengguna - menampilkan dashboard untuk pengguna biasa

// Rute Manajemen Bus
$routes->get('/bus_list', 'DashboardController::busList'); // Daftar bus - menampilkan daftar bus
$routes->get('/bus/create', 'BusController::create', ['filter' => 'auth:admin']); // Form tambah bus - menampilkan form untuk menambahkan bus baru
$routes->post('/bus/store', 'BusController::store', ['filter' => 'auth:admin']); // Simpan bus baru - menyimpan data bus yang baru ditambahkan
$routes->post('/bus/update/(:num)', 'BusController::update/$1'); // Update bus - memperbarui data bus berdasarkan ID
$routes->get('/bus/delete/(:num)', 'BusController::delete/$1'); // Hapus bus - menghapus bus berdasarkan ID
$routes->get('/bus/edit/(:num)', 'BusController::edit/$1', ['filter' => 'auth:admin']); // Form edit bus - menampilkan form untuk mengedit data bus
$routes->post('/bus/updateStatus/(:num)', 'BusController::updateStatus/$1', ['filter' => 'auth:admin']); // Update status bus - memperbarui status bus berdasarkan ID
$routes->get('/bus/departure/(:num)', 'BusController::departure/$1', ['filter' => 'auth:admin']); // Form keberangkatan bus - menampilkan form untuk mencatat keberangkatan bus
$routes->post('/bus/saveDeparture', 'BusController::saveDeparture', ['filter' => 'auth:admin']); // Simpan data keberangkatan bus - menyimpan data keberangkatan bus
$routes->get('/bus/returnToTerminal/(:num)', 'BusController::returnToTerminal/$1', ['filter' => 'auth:admin']); // Kembalikan bus ke terminal - mengatur bus kembali ke terminal
$routes->post('/bus/saveArrival', 'BusController::saveArrival'); // Simpan kedatangan bus - menyimpan data kedatangan bus

// Rute Laporan
$routes->get('/report', 'ReportController::index', ['filter' => 'auth:admin']); // Lihat laporan - menampilkan laporan untuk admin
$routes->post('/report/generate', 'ReportController::generateReport', ['filter' => 'auth:admin']); // Generate laporan - menghasilkan laporan berdasarkan permintaan
$routes->get('/report/generate', 'ReportController::generateReport'); // Generate laporan - menampilkan halaman untuk menghasilkan laporan
$routes->get('/report/filterByTerminal', 'ReportController::filterByTerminal'); // Filter laporan berdasarkan terminal
$routes->get('/bus/export', 'BusController::export');


// Rute Profil Pengguna
$routes->get('/user/profile', 'UserController::profile', ['filter' => 'auth:user']); // Profil pengguna - menampilkan profil pengguna
$routes->post('/user/update', 'UserController::update', ['filter' => 'auth:user']); // Update profil pengguna - memperbarui data profil pengguna

// Rute Dashboard Tambahan
$routes->get('/dashboard/showBus/(:num)', 'DashboardController::showBus/$1', ['filter' => 'auth:admin']); // Tampilkan detail bus - menampilkan detail bus berdasarkan ID
$routes->get('/dashboard/exportPdf', 'DashboardController::exportPdf', ['filter' => 'auth:admin']); // Ekspor PDF - mengekspor data dashboard dalam format PDF

// Rute Manajemen Pengguna
$routes->get('/admin/list', 'UserController::list'); // Daftar pengguna admin - menampilkan daftar pengguna untuk admin
$routes->get('/users/create', 'UserController::create', ['filter' => 'auth:admin']); // Form tambah pengguna - menampilkan form untuk menambahkan pengguna baru
$routes->post('/user/store', 'UserController::store', ['filter' => 'auth:admin']); // Simpan pengguna baru - menyimpan data pengguna yang baru ditambahkan
$routes->get('/user/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth:admin']); // Form edit pengguna - menampilkan form untuk mengedit data pengguna
$routes->post('/user/update/(:num)', 'UserController::updateUser/$1', ['filter' => 'auth:admin']); // Update pengguna - memperbarui data pengguna berdasarkan ID
$routes->get('/user/delete/(:num)', 'UserController::delete/$1', ['filter' => 'auth:admin']); // Hapus pengguna - menghapus pengguna berdasarkan ID

$routes->get('/admin/users/edit/(:num)', 'UserController::edit/$1', ['filter' => 'auth:admin']); // Form edit pengguna - menampilkan form untuk mengedit pengguna oleh admin
$routes->post('/admin/users/update/(:num)', 'UserController::updateUser/$1', ['filter' => 'auth:admin']); // Update pengguna - memperbarui data pengguna oleh admin

// Rute Terminal
$routes->get('/terminals', 'DashboardController::terminals'); // Daftar terminal - menampilkan daftar terminal
$routes->get('/terminals/create', 'TerminalController::create'); // Form tambah terminal - menampilkan form untuk menambahkan terminal baru
$routes->post('/terminals/store', 'TerminalController::store'); // Simpan terminal baru - menyimpan data terminal yang baru ditambahkan

// Rute Statistik Terminal
$routes->get('/admin/terminal_statistics', 'TerminalController::index'); // Statistik terminal admin - menampilkan statistik terminal untuk admin
$routes->get('/terminal_statistics', 'TerminalController::index'); // Statistik terminal - menampilkan statistik terminal untuk pengguna umum
