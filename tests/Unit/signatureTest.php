<?php

namespace Tests\Unit;

use Aron\Signature\Service\AuthSignatureService;
use Tests\TestCase;
use Tests\CreatesApplication;

class signatureTest extends TestCase
{
    use CreatesApplication;

    /**
     * @var AuthSignatureService
     */
    protected AuthSignatureService $service;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->createApplication();
        $this->service = new AuthSignatureService();
    }

    /**
     * @Notes: 生成测试数据
     *
     * @return array
     * @author: Aron
     * @Date: 2021/3/15
     * @Time: 7:04 下午
     */
    private function generateTestData(): array
    {
        $timestamps = strval(time());
        $nonce = $this->service->generateNonce();
        $payload = [
            'name' => 'aron',
            'sex' => 'boy'
        ];
        $payload = json_encode($payload);
        $apiKey = 'yuxuanxuanpc';
        $signatureSecret = $this->service->getSignatureApiSecret($apiKey);
        $arr = [
            $timestamps,
            $nonce,
            $payload,
            $signatureSecret
        ];
        $clientSignature = $this->service->generateSignature(...$arr);
        return compact('timestamps', 'nonce', 'payload', 'apiKey', 'clientSignature');
    }

    /**
     * @Notes: 验证签名
     *
     * @author: Aron
     * @Date: 2021/3/15
     * @Time: 4:58 下午
     */
    public function testVerification(): void
    {
        $testData = array_values($this->generateTestData());
        $this->assertTrue($this->service->verifySignature(...$testData));
    }
}
