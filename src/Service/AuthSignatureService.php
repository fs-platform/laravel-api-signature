<?php


namespace Aron\signature\Service;

use Illuminate\Support\Str;

class AuthSignatureService
{
    /**
     * @var array 签名验证信息
     */
    private array $signature;

    /**
     * @var string 加密方式
     */
    private string $signatureType = 'sha256';

    public function __construct()
    {

        $this->signature = app('config')->get('signature');
    }

    /**
     * @Notes: 注册model
     * @return $this
     *
     * @author: Aron
     * @Date: 2021/3/2
     * @Time: 12:20 下午
     */
    protected function registerModel(): self
    {
        // TODO: Implement registerModel() method.
        return $this;
    }

    /**
     * @Notes: 生成对称加密密钥
     *
     * @param string $timestamp 时间戳
     * @param string $nonce 16位随机字符串
     * @param string $payload 请求body
     * @param string $signatureSecret 签名密钥
     * @return string
     * @author: aron
     * @Date: 2021-03-01
     * @Time: 14:48
     */
    protected function generateSignature(
        string $timestamp,
        string $nonce,
        string $payload,
        string $signatureSecret
    ): string {
        $data = $timestamp . $nonce . $payload;
        $hmac = hash_hmac($this->signatureType, $data, $signatureSecret);
        return base64_encode($hmac);
    }

    /**
     * @Notes: 生成随机字符串
     *
     * @return string
     * @author: aron
     * @Date: 2021-03-01
     * @Time: 14:56
     */
    protected function generateNonce(): string
    {
        return Str::random(16);
    }


    /**
     * @Notes: 验证密钥是否正确
     *
     * @param string $timestamp //时间戳
     * @param string $nonce //16位随机字符串
     * @param string $payload // 请求荷载
     * @param string $signatureApiKey //服务端api key
     * @param string $clientSignature //客户端生成的 签名
     * @return bool
     * @author: aron
     * @Date: 2021-03-01
     * @Time: 15:12
     */
    public function verifySignature(
        string $timestamp,
        string $nonce,
        string $payload,
        string $signatureApiKey,
        string $clientSignature
    ): bool {
        $arguments = func_get_args();
        foreach ($arguments as $v) {
            if (empty($v)) {
                return false;
            }
        }
        $apiSecret = $this->getSignatureApiSecret($signatureApiKey);
        if (empty($apiSecret)) {
            return false;
        }
        $arg = [
            $timestamp,
            $nonce,
            $payload,
            $apiSecret
        ];
        $generateSignature = $this->generateSignature(...$arg);
        if ($generateSignature !== $clientSignature) {
            return false;
        }
        return true;
    }


    /**
     * @Notes: 根据api 获取api secret
     *
     * @param string $signatureApiKey
     * @return string
     * @author: aron
     * @Date: 2021/3/1
     * @Time: 5:23 下午
     */
    private function getSignatureApiSecret(string $signatureApiKey): string
    {
        $apiInfo = array_filter($this->signature, fn($item) => $item['signatureApiKey'] === $signatureApiKey);
        if (empty($apiInfo)) {
            return '';
        }
        return $apiInfo[0]['signatureSecret'];
    }
}
