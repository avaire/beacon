<?php

namespace App\Console\Commands;

use App\Bot;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;

class GenerateStatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'stats:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates the stats and caches it for use later.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Cache::forever('stats', $this->generateStats());

        return $this->info('Stats have been generated successfully.');
    }

    /**
     * Generates the stats array.
     * 
     * @return array
     */
    public function generateStats()
    {
        $bots = 0;
        $users = 0;
        $channels = 0;
        $guilds = 0;

        foreach (Bot::all() as $bot) {
            $bots++;

            foreach ($bot->shards as $shard) {
                $users += $shard['users'];
                $channels += $shard['channels'];
                $guilds += $shard['guilds'];
            }
        }

        $active_bots = Bot::where('updated_at', '>=', Carbon::now()->subDays(7))->count();

        return array_merge(compact('bots', 'active_bots', 'guilds', 'channels', 'users'), [
            'updatedAt' => Carbon::now()->toRfc850String()
        ]);
    }
}
