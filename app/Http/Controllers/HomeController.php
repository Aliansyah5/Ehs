<?php

namespace App\Http\Controllers;

use Charts;

use Illuminate\Http\Request;
use App\Transaksi;
use App\Anggota;
use App\Buku;
use App\Dashboard;
use App\User;
use Auth;
use DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        //diagram garis
        // $users = User::where(DB::raw("(DATE_FORMAT(created_at,'%Y'))"),date('Y'))->get();
        // $chart = Charts::database($users, 'bar', 'highcharts')
        // 	      ->title("Monthly new Register Users")
        // 	      ->elementLabel("Total Users")
        // 	      ->dimensions(400, 600)
        // 	      ->responsive(true)
        // 	      ->groupByMonth(date('Y'), true);

        //dashboard Produksi Forecast Actual BAR
        // $dashboard = Dashboard::paginate(10);
        $qDashboardProdForecast = DB::table('dashboard')
            ->select('PLANT AS TOTAL', '0 AS PLANTID')
            ->where('tipe', '=', 1)
            ->sum('plan');

        $qDashboardProdActual = DB::table('RProd')
            ->select('TOTAL AS PLANT', '0 AS PLANTID')
            ->sum('Qty');

        $chart_ForecastActual = Charts::create('bar', 'highcharts')
            ->backgroundColor('transparent')
            ->title('Production')
            ->yAxistitle('Qty(Ton)')
            ->labels(['Forecast', 'Actual'])
            ->elementLabel("Total")
            ->values([$qDashboardProdForecast, $qDashboardProdActual])
            ->dimensions(400, 400)
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->responsive(true);

        //Detail Production APP (ton) PIE
        $qdashboardDetailProduction = collect(DB::select('SELECT Qty, IsTop5 AS Jenis 
                        FROM                                                                                                
                        ( SELECT IsTop5, SUM(Qty) AS Qty
                        FROM rprod                                         
                        WHERE Qty > 0 
                        GROUP BY IsTop5
                        ) AS X  
                        ORDER BY Qty DESC'));

        $chart_DetailProduction = Charts::create('pie', 'highcharts')
            ->title('Detail Production AAP (ton)')
            ->labels([
                $qdashboardDetailProduction[0]->Jenis, $qdashboardDetailProduction[1]->Jenis,
                $qdashboardDetailProduction[2]->Jenis, $qdashboardDetailProduction[3]->Jenis,
                $qdashboardDetailProduction[4]->Jenis, $qdashboardDetailProduction[5]->Jenis,
            ])
            ->elementLabel("Total")
            ->values([
                $qdashboardDetailProduction[0]->Qty, $qdashboardDetailProduction[1]->Qty,
                $qdashboardDetailProduction[2]->Qty, $qdashboardDetailProduction[3]->Qty,
                $qdashboardDetailProduction[4]->Qty, $qdashboardDetailProduction[5]->Qty
            ])
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->dimensions(600, 400)
            ->responsive(true);

        //Chart 3 Kategori Produksi AAP AAS AAM
        //kalo group by harus ditampilkan semua select di group by
        $qDashboardProdKategori = collect(DB::select('SELECT SUM(R.Qty) AS `real`, plan, R.PLANT, R.PLANTID 
                                FROM RProd R
                                INNER JOIN dashboard D ON R.`PLANTID` = D.`PLANTID` AND D.Tipe=1
                                GROUP BY R.PLANTID, R.PLANT, plan
                                '));

        $chart_qDashboardProdKategori = Charts::multi('bar', 'highcharts')
            ->title('Chart Production')
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->yAxistitle('Qty(Ton)')
            ->labels(['AAP', 'AAS', 'AAM'])
            ->dataset('Real', [$qDashboardProdKategori[0]->real, $qDashboardProdKategori[1]->real, $qDashboardProdKategori[2]->real])
            ->dataset('Plan',  [$qDashboardProdKategori[0]->plan, $qDashboardProdKategori[1]->plan, $qDashboardProdKategori[2]->plan]);

        //Detail Production APP PLANT ID = 1  PIE
        $qDashboardProdKategoriAAP = collect(DB::select('SELECT Qty, IsTop5 AS Jenis FROM ( SELECT IsTop5, SUM(Qty) AS Qty 
        FROM rprod                                         
        WHERE Qty > 0 AND PlantID = 1 GROUP BY IsTop5 ) AS X ORDER BY Qty DESC'));

        $chart_qDashboardProdKategoriAAP = Charts::create('pie', 'highcharts')
            ->title('Detail Production AAP (ton)')
            ->labels([
                $qDashboardProdKategoriAAP[0]->Jenis, $qDashboardProdKategoriAAP[1]->Jenis,
                $qDashboardProdKategoriAAP[2]->Jenis, $qDashboardProdKategoriAAP[3]->Jenis,
                $qDashboardProdKategoriAAP[4]->Jenis, $qDashboardProdKategoriAAP[5]->Jenis,
            ])
            ->elementLabel("Total")
            ->values([
                $qDashboardProdKategoriAAP[0]->Qty, $qDashboardProdKategoriAAP[1]->Qty,
                $qDashboardProdKategoriAAP[2]->Qty, $qDashboardProdKategoriAAP[3]->Qty,
                $qDashboardProdKategoriAAP[4]->Qty, $qDashboardProdKategoriAAP[5]->Qty
            ])
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->dimensions(450, 300);

        //Detail Production AAS PLANT ID = 2  PIE
        $qDashboardProdKategoriAAS = collect(DB::select('SELECT Qty, IsTop5 AS Jenis FROM ( SELECT IsTop5, SUM(Qty) AS Qty 
        FROM rprod                                         
        WHERE Qty > 0 AND PlantID = 2 GROUP BY IsTop5 ) AS X ORDER BY Qty DESC'));

        $chart_qDashboardProdKategoriAAS = Charts::create('pie', 'highcharts')
            ->title('Detail Production AAS (ton)')
            ->labels([
                $qDashboardProdKategoriAAS[0]->Jenis, $qDashboardProdKategoriAAS[1]->Jenis,
                $qDashboardProdKategoriAAS[2]->Jenis, $qDashboardProdKategoriAAS[3]->Jenis,
                $qDashboardProdKategoriAAS[4]->Jenis
            ])
            ->elementLabel("Total")
            ->values([
                $qDashboardProdKategoriAAS[0]->Qty, $qDashboardProdKategoriAAS[1]->Qty,
                $qDashboardProdKategoriAAS[2]->Qty, $qDashboardProdKategoriAAS[3]->Qty,
                $qDashboardProdKategoriAAS[4]->Qty
            ])
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->dimensions(450, 300);

        //Detail Production AAM PLANT ID = 3  PIE
        $qDashboardProdKategoriAAM = collect(DB::select('SELECT Qty, IsTop5 AS Jenis FROM ( SELECT IsTop5, SUM(Qty) AS Qty 
         FROM rprod                                         
         WHERE Qty > 0 AND PlantID = 3 GROUP BY IsTop5 ) AS X ORDER BY Qty DESC'));

        $chart_qDashboardProdKategoriAAM = Charts::create('pie', 'highcharts')
            ->title('Detail Production AAM (ton)')
            ->labels([
                $qDashboardProdKategoriAAM[0]->Jenis, $qDashboardProdKategoriAAM[1]->Jenis,
                $qDashboardProdKategoriAAM[2]->Jenis, $qDashboardProdKategoriAAM[3]->Jenis
            ])
            ->elementLabel("Total")
            ->values([
                $qDashboardProdKategoriAAM[0]->Qty, $qDashboardProdKategoriAAM[1]->Qty,
                $qDashboardProdKategoriAAM[2]->Qty, $qDashboardProdKategoriAAM[3]->Qty
            ])
            ->colors([
                '#769ECB', '#9DBAD5', '#FAF3DD', '#C8D6B9', '#8FC1A9', '#7CAA98'
            ])
            ->dimensions(450, 300);

        // $chart_empat = Charts::multi('bar', 'chartjs')
        //             ->title("Trainee Divisions")
        //             ->dimensions(0, 500) 
        //             ->colors(['#058DC7', '#50B432', '#ED561B', '#DDDF00', '#24CBE5', '#64E572',   
        //             '#FF9655', '#FFF263', '#6AF9C4'])
        //             ->template("material")
        //             ->dataset('Trainee', [5,20,100])
        //             ->dataset('test', [5,20,100])
        //             ->dataset('mantapbro', [5,20,100])
        //             ->labels(['OPERATIONAL', 'INOC', 'Three'])
        //             ->responsive(false)
        //             ->Width(0);



        $transaksi = Transaksi::get();
        $anggota   = Anggota::get();
        $buku      = Buku::get();

        //Auth User
        if (Auth::user()->level == 'user') {
            $datas = Transaksi::where('status', 'pinjam')
                ->where('anggota_id', Auth::user()->anggota->id)
                ->get();
        } else {
            $datas = Transaksi::where('status', 'pinjam')->get();
        }
        return view('home', compact('transaksi', 'anggota', 'buku', 'datas', 'chart_qDashboardProdKategori', 'chart_ForecastActual', 'chart_DetailProduction', 'chart_qDashboardProdKategoriAAP', 'chart_qDashboardProdKategoriAAS', 'chart_qDashboardProdKategoriAAM'));
    }
}
