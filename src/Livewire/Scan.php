<?php

namespace Leeuwenkasteel\Stock\Livewire;

use Livewire\Component;
use Leeuwenkasteel\Webshop\Models\Product;
use Leeuwenkasteel\Webshop\Models\Stock;
use Leeuwenkasteel\Cashdesk\Models\Labels;

class Scan extends Component
{
    public $barcode = '';
    public $table = [];
	public $add;

    protected $listeners = ['barcodeScanned' => 'handleBarcode', 'printLabels' => 'printLabels'];

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

    public function handleBarcode($code = null)
    {
        $this->barcode = $code ?? $this->add;

        $product = Product::with('translations')->where('nr', $this->barcode)->first();

        if (!$product) {
			$this->dispatch('productNotFound', code: $code);
			return;
		}
		$find = Stock::whereProductId($product->id)->first();
		if($find){
			$find->update(['quantity' => $find->quantity+1]);
		}else{
			$new = new Stock();
			$new->product_id = $product->id;
			$new->quantity = 1;
			$new->labelOnly = 1;
			$new->save();
		}
		$this->add = '';
        $this->loadTable();
    }

    public function updateQuantity($id, $qty){
        Stock::where('id', $id)->update(['quantity' => (int)$qty]);
        $this->loadTable();
    }

	
	public function delete($id){
		Stock::where('id', $id)->delete();

		$this->loadTable();
	}
	
	public function printLabels(){
		foreach(Stock::all() as $i){
			$product = Product::find($i->product_id);

			$t = new Labels();
			$t->product_id = $i->product_id;
			$t->amount = $i->quantity;
			$t->save();
			
			$i->delete();
		}
		$this->loadTable();
	}

    public function render()
    {
        return view('stock::livewire.scan');
    }
}