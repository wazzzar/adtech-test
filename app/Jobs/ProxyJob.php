<?php

namespace App\Jobs;

use App\Models\Proxy;
use Faker\Generator;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ProxyJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct()
    {
    }

    public function handle(): void
    {
        $faker = new Generator;
        foreach (Proxy::cursor() as $proxy) {
            $proxy->update([
                'status' => $faker->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
