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
			->whereNotNull('label')
			->orderBy('created_at', 'desc')
            ->get();
    }

    public function handleBarcode($code = null)
    {
        $this->barcode = $code ?? $this->add;

		$count = Product::whereNr($this->barcode)->count();
        $product = Product::whereNr($this->barcode)->first();
        
        if ($count == 0) {

			$this->dispatch('productNotFound', code: $code);
			return;
		}

		$find = Stock::whereProductId($product->id)->whereNotNull('label')->first();
		if($find){
			$find->update(['label' => $find->label+1]);
		}else{
			$new = new Stock();
			$new->product_id = $product->id;
			$new->label = 1;
			$new->labelOnly = 1;
			$new->save();
		}
		$this->add = '';
		$this->barcode = '';
        $this->loadTable();
    }

    public function updateQuantity($id, $qty){
        Stock::where('id', $id)->whereNotNull('label')->update(['label' => (int)$qty]);
        $this->loadTable();
    }

	
	public function delete($id){
		Stock::where('id', $id)->whereNotNull('label')->delete();

		$this->loadTable();
	}
	
	public function printLabels(){
		$stock = Stock::whereNotNull('label')->get();
		foreach($stock as $i){
			$product = Product::find($i->product_id);

			$t = new Labels();
			$t->product_id = $i->product_id;
			$t->amount = $i->label;
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