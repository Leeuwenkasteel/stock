<?php

namespace Leeuwenkasteel\Stock;

use Illuminate\Support\ServiceProvider;
use Leeuwenkasteel\Stock\Console\Commands\InstallCommand;
use Leeuwenkasteel\Stock\View\Components\StockComponent;
use Illuminate\Support\Facades\Blade;

use Leeuwenkasteel\Stock\Livewire\Scan;

use Livewire;

class StockPackageServiceProvider extends ServiceProvider{

  public function register(): void{
    $this->commands([
        InstallCommand::class,
    ]);
  }

  public function boot(): void{
    $this->loadViewsFrom(__DIR__.'/../resources/views', 'stock');
    $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

    
	$langPath = $this->app->langPath('vendor/stock');
    $pathToLoad = !empty($langPath) && is_dir($langPath) ? $langPath : __DIR__.'/../resources/lang';
	
	$this->publishes([
        __DIR__.'/../public' => public_path('vendor/stock'),
    ], 'public_stock');

    //$this->loadJsonTranslationsFrom($pathToLoad);
	
	$this->publishes([
        __DIR__.'/../resources/lang' => $this->app->langPath('vendor/stock'),
    ], 'trans_stock');
	
	if ($this->app->runningInConsole()) {
      $this->commands([
          InstallCommand::class
      ]);
    }
	Livewire::component('stock::scan', Scan::class);
	
	Blade::component('stock::layout', StockComponent::class);
	
  }
}