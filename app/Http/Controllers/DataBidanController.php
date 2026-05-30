<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Bidan;

class DataBidanController extends Controller
{
    public function dataBidan()
{
    $b = Bidan::find(1); 

    if (!$b) {
        $b = (object) [
            'id' => 1, 
            'nama' => 'Siti Fatimah, Amd.Keb', 
            'email' => 'bidan@demo.com', 
            'nip' => '-', 
            'sip' => '-'
        ];
    }
    return view('admin.master.dataBidan', compact('b'));
}

    public function updateBidan(Request $request, $id)
{
    $bidan = \App\Models\Bidan::findOrFail($id);

    // Ambil semua data kecuali token CSRF dan method
    $data = $request->except(['_token', '_method']);

    // Simpan ke database
    $bidan->update($data);

    return redirect()->back()->with('success', 'Data Bidan berhasil diperbarui!');
}
}