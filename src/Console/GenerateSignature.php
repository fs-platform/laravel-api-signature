<?php

namespace Aron\Signature\Console;

use Illuminate\Console\Command;

class GenerateSignature extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'signature:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '生成签名密钥';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @Notes: ${NOTES}
     * @author: Aron
     * @Date: 2021/3/19
     * @Time: 3:37 下午
     */
    public function handle(): void
    {
        $payload = $this->ask('请输入请求payload');
        $nonce = \Signature::generateNonce();
        $timestamps = strval(time());
        $apiSecret = env('SIGNATURE_SECRET');
        $apiKey = env('SIGNATURE_API_KEY');
        $clientSignature = \Signature::generateSignature($timestamps, $nonce, $payload, $apiSecret);
        dd(compact('nonce', 'timestamps', 'clientSignature', 'apiKey'));
    }
}
