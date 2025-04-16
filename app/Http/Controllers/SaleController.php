<?php

namespace App\Http\Controllers;

use App\Exports\SalesExport;
use App\Models\Product;
use App\Models\Sale;
use App\Models\Member;
use App\Models\DetailSale;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;

class SaleController extends Controller
{
    public static function middleware(): array
    {
        return [
            new Middleware('kasir', except: ['index']),
        ];
    }

    public function index()
    {
        $sales = Sale::with(['user', 'member'])->orderBy('id', 'DESC')->get();
        return view('sale.index', compact('sales'));
    }

    public function create()
    {
        if (!Gate::allows('akses-sales-create')) {
            abort(403, 'Anda tidak dapat mengakses halaman ini!');
        }

        $products = Product::all();
        return view('sale.create', compact('products'));
    }

    public function confirmTransaction(Request $request)
    {
        $quantities = $request->input('quantity');
        $cart = [];

        foreach ($quantities as $productId => $quantity) {
            if ($quantity > 0) {
                $product = Product::find($productId);
                if ($product) {
                    $total_price = $product->price * $quantity;

                    $cart[] = [
                        'product' => $product,
                        'quantity' => $quantity,
                        'total_price' => $total_price,
                    ];
                }
            }
        }

        return view('sale.transaction', [
            'cart' => $cart,
            'total' => array_sum(array_column($cart, 'total_price')),
        ]);
    }

    public function store(Request $request)
    {
        $productIds = $request->input('product_id');
        $quantities = $request->input('quantity');
        $isMember = $request->input('is_member') === 'member';
        $amountPaid = (int) $request->input('amount_paid');
        $memberPhone = $request->input('phone');
        $memberName = $request->input('name');

        if (!$productIds || !$quantities || count($productIds) !== count($quantities)) {
            return back()->with('error', 'Data produk tidak lengkap.');
        }

        $total = 0;
        $details = [];
        $salesProducts = [];

        $member = null;
        if ($isMember) {
            $member = Member::firstOrCreate(
                ['phone' => $memberPhone],
                ['name' => $memberName, 'total_points' => 0]
            );

            if (is_null($member->total_points)) {
                $member->total_points = 0;
                $member->save();
            }
        }

        foreach ($productIds as $index => $productId) {
            $product = Product::find($productId);
            $quantity = (int) $quantities[$index];

            if (!$product || $quantity < 1) continue;

            $subtotal = $product->price * $quantity;
            $total += $subtotal;

            $product->decrement('stock', $quantity);

            $details[] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'total_price' => $subtotal,
            ];

            $salesProducts[] = "{$product->product_name} ({$quantity} : Rp. {$product->price})";
        }

        $earnedPoints = $isMember ? floor($total / 100) : 0;

        $sale = Sale::create([
            'user_id'       => Auth::id(),
            'member_id'     => $isMember ? $member->id : null,
            'sales_product' => implode(', ', $salesProducts),
            'points_earned' => $earnedPoints,
            'points_used'   => 0,
            'total_price'   => $total,
            'amount_paid'   => $amountPaid,
            'change'        => $amountPaid - $total,
            'sale_date'     => now(),
        ]);

        foreach ($details as $detail) {
            DetailSale::create(array_merge($detail, ['sale_id' => $sale->id]));
        }

        return $isMember
            ? redirect()->route('sales.createMember', $sale->id)
            : redirect()->route('sales.invoice', $sale->id);
    }

    public function createMember($id)
    {
        $sale = Sale::with('member')->findOrFail($id);
        $member = $sale->member;
        $isFirst = Sale::where('member_id', $sale->member_id)->count() === 1;
        $detailSales = DetailSale::with('product')->where('sale_id', $id)->get();

        $paymentAmount = $sale->amount_paid;
        $earnedPoints = $sale->points_earned;

        return view('sale.member', compact('sale', 'member', 'detailSales', 'isFirst', 'paymentAmount', 'earnedPoints'));
    }

    public function storeMember(Request $request, $id)
    {
        $sale = Sale::with('member')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:225',
        ]);

        $member = $sale->member;
        $earnedPoints = floor($sale->total_price / 100);

        if ($request->input('check_point') === 'on') {
            $usedPoints = $member->total_points;

            $sale->points_used = $usedPoints;
            $sale->final_price_member = $sale->total_price - $usedPoints;
            $sale->change += $usedPoints;

            $member->total_points = max($member->total_points - $usedPoints, 0);
            $sale->save();
            $member->save();
        }

        // Tambahkan poin dari transaksi sekarang (setelah penggunaan poin)
        $member->increment('total_points', $earnedPoints);
        $sale->points_earned = $earnedPoints;
        $sale->save();

        $member->name = $request->input('name');
        $member->save();

        return redirect()->route('sales.invoice', $sale->id);
    }

    public function invoice(Sale $sale)
    {
        $sale->load('detailSale.product', 'user');
        return view('sale.invoice', compact('sale'));
    }

    public function downloadInvoice(Sale $sale)
    {
        $sale->load('detailSale.product', 'user');

        $pdf = Pdf::loadView('sale.pdf', compact('sale'));

        return $pdf->download('Struk_penjual_' . $sale->id . '.pdf');
    }

    public function show(Sale $sale)
    {
        $sale->load('detailSale.product', 'user', 'member');
        return view('sale.detail', compact('sale'));
    }

    public function exportExcel()
    {
        if (Auth::user()->role === 'admin') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses!');
        }

        return Excel::download(new SalesExport, 'laporan-penjualan.xlsx');
    }

    public function edit(Sale $sale) { }

    public function update(Request $request, Sale $sale) { }

    public function destroy($id)
    {
        Sale::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Berhasil menghapus data!');
    }
}
