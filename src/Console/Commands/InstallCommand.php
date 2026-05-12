<?php

namespace Leeuwenkasteel\Stock\Console\Commands;

use Illuminate\Console\Command;
use Artisan;

class InstallCommand extends Command{

    protected $signature = 'install:stock';
    protected $description = 'install stock package';

    public function handle(){
		
		Artisan::call('template:app', [
            'path' => 'stock.install',
            'title' => 'Stock',
            'permissions' => 'stock',
			'img' => 'vendor/stock/img/icons/stock-512.png',
			'color' => '#156082',
			'register' => true,
        ]);
		
		Artisan::call('vendor:publish', [
            '--tag' => 'public_stock'
        ]);
    }
}