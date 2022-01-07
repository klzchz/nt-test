<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GuzzleHttp\Client;
use App\Models\Account;
use Carbon\Carbon;

class AttachJson extends Command
{
    protected $account;
    protected $client;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'attach:json';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Attachment: JSON file: "challenge.json".';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Client $client,Account $account)
    {   
        $this->account = $account;
        $this->client = $client;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->registeringJson();
        return 0;
    }

    public function registeringJson()
    {
        $reponse = $this->client->request('GET','http://nt-test.test/file');
        $json = json_decode($reponse->getBody());

        $bar = $this->output->createProgressBar(count($json));
        $bar->start();

        foreach($json as $key => $value){
       
            $dataAccount = (array) $value;
            $data = (array) array_pop($dataAccount);

            if(strtotime($dataAccount['date_of_birth'])) {
                $dataAccount['date_of_birth'] = Carbon::parse($dataAccount['date_of_birth']); 
            }elseif(!preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$dataAccount['date_of_birth'])){
                $date = str_replace('/','-',$dataAccount['date_of_birth']);
                $dataAccount['date_of_birth'] = date("Y-m-d",strtotime($date));   
            }
            
            $age = Carbon::parse($dataAccount['date_of_birth'])->age;

            if($age >=18 && $age <=65){
                   if($this->account->where('account',$dataAccount['account'])
                              ->orWhere('email',$dataAccount['email'])->get()->count() === 0)
                {
                    if($account=$this->account->create($dataAccount)){
                        if($account->cards()->get()->count() === 0){
                           $account->cards()->create($data);
                        }
                    }
                }

            }
                
            
            $bar->advance();
            
        }
        
        $bar->finish();
    } 
}
