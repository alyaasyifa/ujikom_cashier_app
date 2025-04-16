<?php
namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{

    public function index()
    {
        $latestCreatedAt = DB::table('sales')
        ->orderBy('created_at', 'desc')
        ->value('created_at');

        // Ubah ke format dan timezone yang diinginkan
        $todayCarbon = Carbon::parse($latestCreatedAt)->timezone('Asia/Jakarta');
        $todayFormatted = $todayCarbon->translatedFormat('d F Y H:i'); // buat tampil di UI


        // Produk terlaris hari ini (Pie chart)
        $produkTerlaris = DB::table('detail_sales')
            ->join('products', 'detail_sales.product_id', '=', 'products.id')
            ->join('sales', 'detail_sales.sale_id', '=', 'sales.id')
            ->select('products.product_name as label', DB::raw('SUM(detail_sales.quantity) as value'))
            ->groupBy('products.product_name')
            ->get()
            ->toArray();

        // Penjualan tahunan (Bar chart)
        $startOfYear = Carbon::now()->startOfYear();
        $endOfYear = Carbon::now()->endOfYear();

        $penjualanTahunan = DB::table('sales')
            ->selectRaw("
                DATE(created_at) as tanggal,
                SUM(CASE WHEN member_id IS NULL THEN 1 ELSE 0 END) as non_member,
                SUM(CASE WHEN member_id IS NOT NULL THEN 1 ELSE 0 END) as member
            ")
            ->whereBetween('created_at', [$startOfYear, $endOfYear])
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->tanggal)->format('d F Y'),
                    'member' => $item->member,
                    'non_member' => $item->non_member,
                ];
            })
            ->toArray();

            return view('dashboard.home', [
                'totalPenjualanHariIni' => Sale::whereDate('created_at', $todayCarbon->format('Y-m-d'))->count(),
                'produkTerlaris' => $produkTerlaris,
                'penjualanTahunan' => $penjualanTahunan,
                'today' => $todayFormatted, // buat blade
            ]);
    }


    public function showLoginForm()
    {
        return view('login');
    }

    public function loginStore(Request $request)
    {
        $credential = $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:4'
        ]);

        if ( Auth::attempt($credential)) {
            return redirect('/')->with('success', 'Login Berhasil');
        }

        return back()->with('error','Email atau Password Salah');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Berhasil logout.');
    }
}
