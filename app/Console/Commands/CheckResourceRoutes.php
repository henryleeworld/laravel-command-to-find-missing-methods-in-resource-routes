<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Route;
use ReflectionClass;

class CheckResourceRoutes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'route:check-resources';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Find missing methods in resource routes';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
	        $resourceRoutes = collect(Route::getRoutes())->filter(function ($route) {
            return $route->getActionName() !== 'Closure' &&
                strpos($route->getActionName(), '@') !== false;
        });
 
        $missingMethods = [];
 
        foreach ($resourceRoutes as $route) {
            $action = $route->getActionName();
            [$controller, $method] = explode('@', $action);
 
            if (!class_exists($controller)) {
                $missingMethods[$controller][] = ['method' => $method, 'uri' => $route->uri()];
                continue;
            }
 
            $reflection = new ReflectionClass($controller);
            if (!$reflection->hasMethod($method)) {
                $missingMethods[$controller][] = ['method' => $method, 'uri' => $route->uri()];
            }
        }
 
        if (empty($missingMethods)) {
            $this->info(__('All resource routes have matching controller methods.'));
        } else {
            $this->info(__('The following resource routes do not have a matching matching controller method.'));
            foreach ($missingMethods as $controller => $methods) {
                $this->warn(__('Controller: ') . $controller);
                foreach ($methods as $method) {
                    $this->line('  - ' . __('Method: ') . $method['method'] . ', URI: ' . $method['uri']);
                }
            }
        }
    }
}
