<?php

namespace Leeuwenkasteel\Stock\Livewire;

use Livewire\Component;
use Leeuwenkasteel\Webshop\Models\Product;
use Leeuwenkasteel\Webshop\Models\Stock;

class Scan extends Component
{
    public $barcode = '';
    public $table = [];

    protected $listeners = ['barcodeScanned' => 'handleBarcode'];

    public function mount()
    {
        $this->loadTable();
    }

    public function loadTable()
    {
        $this->table = Stock::with('product.translations')
			->orderBy('created_at', 'desc')
            ->get();
    }

    public function handleBarcode($code)
    {
        $this->barcode = $code;

        $product = Product::where('nr', $code)->first();

        if (!$product) {
			$this->dispatch('productNotFound', code: $code);
			return;
		}

        $stock = Stock::firstOrCreate(
            ['product_id' => $product->id],
            ['quantity' => 0]
        );

        $stock->increment('quantity');

        // 🔥 snel refresh (simpel en stabiel)
        $this->loadTable();
    }

    public function updateTitle($id, $title)
    {
        $stock = Stock::findOrFail($id);
        $stock->product->translations()->update(['title' => $title]);
    }

    public function updateQuantity($id, $qty)
    {
        Stock::where('id', $id)->update(['quantity' => (int)$qty]);
        $this->loadTable();
    }

    public function updatePrint($id, $qty)
    {
        Stock::where('id', $id)->update(['print' => (int)$qty]);
    }

    public function toggleLabelOnly($id, $val)
    {
        Stock::where('id', $id)->update(['labelOnly' => (bool)$val]);
    }
	
	public function delete($id)
{
    Stock::where('id', $id)->delete();

    $this->loadTable();
}

    public function render()
    {
        return view('stock::livewire.scan');
    }
}