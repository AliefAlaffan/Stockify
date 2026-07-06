<?php

namespace App\Http\Controllers;

use App\Services\StockOpnameService;
use Illuminate\Http\Request;

class StockOpnameController extends Controller
{
    protected StockOpnameService $stockOpnameService;

    public function __construct(StockOpnameService $stockOpnameService)
    {
        $this->stockOpnameService = $stockOpnameService;
    }

    public function index()
    {
        $products = $this->stockOpnameService->getOpnameOverview();
        return view('stock-opname.index', compact('products'));
    }

    public function store(Request $request)
    {
        $result = $this->stockOpnameService->processOpname($request->all());

        if ($result === null) {
            return redirect()->route('stock-opname.index')->with('success', 'Stok sudah sesuai, tidak ada penyesuaian diperlukan.');
        }

        return redirect()->route('stock-opname.index')->with('success', 'Penyesuaian stok berhasil dicatat.');
    }
}