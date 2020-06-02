<?php

namespace App\Http\Controllers;

use App\Dformula;
use App\Http\Requests\Formulasi\Store;
use App\Mobil;
use Auth;
use Session;
use Illuminate\Support\Facades\DB;

class FormulasiController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

     
        $username = Auth::user()->username;
        // $items = Mobil::all(['nama', 'harga']);
        //menampilkan project dari user di table
        $projectDevs = collect(DB::select("SELECT H.NoForm AS NoProject, H.FormID AS ProjectID, 
        D.Idx AS ProjectIdx,F.NoForm, F.FormID, H.NamaProject, H.TipeProject, D.Duedate, F.Qty, F.NoReff,
        P.Nama AS Chemist,P.PegawaiID AS ChemistID, H.Tujuan 
        FROM HProject H 
        INNER JOIN DProject D ON (H.FormID=D.FormID) 
        INNER JOIN HFormula F ON (F.ProjectID=D.FormID AND F.ProjectIdx=D.Idx) 
        LEFT JOIN MPegawai P ON (P.PegawaiID=D.PICID OR P.PegawaiID=D.PICID2) 
        LEFT JOIN MUser U ON (U.PegawaiID=P.PegawaiID) 
        WHERE U.UserName= '$username' AND D.TglClose IS NULL"));

        //dd($projectDevs);

        return view('formulasi.index', compact('projectDevs'));

    }

    public function create($FormID)
    {

        //frame tugas project formulasi untuk user chemist
        $username = Auth::user()->username;
        $formulaHeader = collect(DB::select("SELECT H.NoForm AS NoProject, F.TglForm, H.FormID AS ProjectID, 
        D.Idx AS ProjectIdx,F.NoForm, F.formID , H.NamaProject, H.TipeProject, D.Duedate, F.Qty, F.NoReff,
        P.Nama AS Chemist,P.PegawaiID AS ChemistID, H.Tujuan 
        FROM HProject H 
        LEFT JOIN DProject D ON (H.FormID=D.FormID) 
        LEFT JOIN HFormula F ON (F.ProjectID=D.FormID AND F.ProjectIdx=D.Idx) 
        LEFT JOIN MPegawai P ON (P.PegawaiID=D.PICID OR P.PegawaiID=D.PICID2) 
        LEFT JOIN MUser U ON (U.PegawaiID=P.PegawaiID) 
        WHERE U.UserName='$username' AND F.formID = $FormID AND D.TglClose IS NULL
        "));

        $formid = $formulaHeader[0]->formID;
        $idx = $formulaHeader[0]->ProjectIdx;

        if(count($formulaHeader) == 0) {
            Session::flash('message', 'Data Formulasi Belum dibuat!');
            Session::flash('message_type', 'danger');
            return redirect()->to('formulasi');
        };

        //query tabel spreadsheet
        $formula = collect(DB::select("SELECT D.Idx, D.FormID, IFNULL(I.Kode,I.KodeSample) AS Kode ,D.ItemName,  
        D.WT,D.PersenWT,D.WT1, D.PersenWT1, D.Note
        FROM DFormula D 
        LEFT JOIN MItem I ON (I.ItemID=D.ItemID) 
        LEFT JOIN DFormulasi F ON (F.Idx=D.FormulasiIdx AND F.FormID= D.ProjectID) 
        WHERE D.FormID= $FormID 
        ORDER BY D.idx"));

        //$items = Mobil::orderBy('posisi')->get(['id', 'nama', 'harga']);
 
        return view('formulasi.create', compact('formula', 'formulaHeader'));

    }

    public function store(Store $request)
    {

        $data = $request->get('data');
        dd($data);

        // SELECT book_name,dt_of_pub,pub_lang,no_page,book_price  
        // FROM book_mast        
        // WHERE book_price NOT IN (100,200);

        //  dd($data);


        //delete table
        DB::transaction(function () use ($data) {

            $ids = collect($data)->pluck('Idx');
            $formid = collect($data)->pluck('FormID');

            // if (!empty($ids)) {
            //     Dformula::whereNotIn('Idx', $ids)
            //     ->where('FormID',$formid)->delete(); 
            // }

            foreach ($data as $row) {
                //update isi formulasi berdasarkan request
                //request berasal dari row tabel dicacah
                if ($row['Idx']) {
                    Dformula::whereRaw("Idx = '" . $row['Idx'] . "'")
                    ->whereRaw("FormID = '" . $row['FormID'] . "'")->update($row);
                } else {
                    //insert new atau before row 
                    //pakai create request 
                    Dformula::create($row);
                }
            }
        });

        //raw dformula tidak pas dengan query cari commad untuk paskan di table dformula

        // Kode' => $row[1],
        //         'ItemName' => $row[2],
        //         'WT' => filter_var($row[3], FILTER_SANITIZE_NUMBER_INT),
        //         'PersenWT' => filter_var($row[4], FILTER_SANITIZE_NUMBER_INT),
        //         'WT1' => filter_var($row[5], FILTER_SANITIZE_NUMBER_INT),
        //         'PersenWT1' => filter_var($row[6], FILTER_SANITIZE_NUMBER_INT),
        //         'Note'

        //merubah request table menjadi json
        if ($request->expectsJson()) {
            sleep(1);
            $items = Dformula::orderBy('Idx')
                ->get(['Idx', 'ItemName', 'WT', 'PersenWT', 'WT1', 'PersenWT1', 'Note'])
                ->transform(function ($item) {
                    return array_values($item->toArray());
                });

            return response()->json($items);
        }

        Session::flash('message', 'Data Formulasi Berhasil dirubah!');
        Session::flash('message_type', 'success');

        return redirect()->back()->withSuccess(sprintf("Berhasil menyimpan %d data mobil", count($data)));
    }

    // public function edit($FormID)
    // {
        
    //     //detail formula tugas project formulasi untuk user chemist

    //     $formulaHeader = collect(DB::select("SELECT H.NoForm AS NoProject, H.FormID AS ProjectID, 
    //     D.Idx AS ProjectIdx,F.NoForm, H.NamaProject, H.TipeProject, D.Duedate, F.Qty, F.NoReff,
    //     P.Nama AS Chemist,P.PegawaiID AS ChemistID, H.Tujuan 
    //     FROM HProject H 
    //     LEFT JOIN DProject D ON (H.FormID=D.FormID) 
    //     LEFT JOIN HFormula F ON (F.ProjectID=D.FormID AND F.ProjectIdx=D.Idx) 
    //     LEFT JOIN MPegawai P ON (P.PegawaiID=D.PICID OR P.PegawaiID=D.PICID2) 
    //     LEFT JOIN MUser U ON (U.PegawaiID=P.PegawaiID) 
    //     WHERE U.UserName='RDP09' AND F.formID = $FormID AND D.TglClose IS NULL
    //     "));

    //     dd($formulaHeader);
    //     return view('welcome');
    // }
}
