<?php

namespace Leeuwenkasteel\Stock\Livewire;

use Livewire\Component;
use Leeuwenkasteel\Webshop\Models\Product;
use Leeuwenkasteel\Webshop\Models\Stock as St;
use Leeuwenkasteel\Cashdesk\Models\Labels;

class Stock extends Component
{
    public $barcode = '';
    public $table = [];
	public $add;

    protected $listeners = ['barcodeScanned' => 'handleBarcode', 'updateQnt' => 'updateQnt'];

    public function mount()
    {
        $this->loadTable();
    }

    public function loadTable()
    {
        $this->table = St::with('product.translations')
			->whereNotNull('quantity')
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
		$find = St::whereProductId($product->id)->whereNotNull('quantity')->first();
		if($find){
			$find->update(['quantity' => $find->quantity+1]);
		}else{
			$new = new St();
			$new->product_id = $product->id;
			$new->quantity = $product->stock;
			$new->labelOnly = 1;
			$new->save();
		}
		$this->add = '';
        $this->loadTable();
    }

    public function updateQuantity($id, $qty){
        St::where('id', $id)->whereNotNull('quantity')->update(['quantity' => (int)$qty]);
        $this->loadTable();
    }

	
	public function delete($id){
		St::where('id', $id)->whereNotNull('quantity')->delete();

		$this->loadTable();
	}
	
	public function updateQnt(){
		$stock = St::whereNotNull('quantity')->get();
		foreach($stock as $i){
			$p = Product::find($i->product_id)->update(['stock' => $i->quantity]);
			
			$i->delete();
		}
		$this->loadTable();
	}
	


    public function render()
    {
        return view('stock::livewire.stock');
    }
}