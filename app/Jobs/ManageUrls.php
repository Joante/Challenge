<?php

namespace App\Jobs;

use App\Models\Url;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Embed\Embed;
use Illuminate\Support\Facades\DB;

class ManageUrls implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $url;


    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url)
    {
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //Look it up the title with the Embed class
        $embed = new Embed();

        $info = $embed->get($this->url['original']);

        if($info->title){
            $this->url['title'] = $info->title;
        }else{
            $stringArray = explode('.',$this->url['original']);
            $this->url['title'] = ucfirst($stringArray[1]);
        }
        
        //Create the record in the database
        DB::table('urls')->insert($this->url);
    }
}
