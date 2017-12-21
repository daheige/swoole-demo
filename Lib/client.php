<?php
class Client
{
    private $client;
    private $port;
    private $domain;

    public function __construct($domain = "0.0.0.0", $port = 8080)
    {
        $this->domain = $domain;
        $this->port   = $port;
        $this->client = new swoole_client(SWOOLE_SOCK_TCP);
    }

    //客户端连接上了触发的事件
    public function connect()
    {
        if (!$this->client->connect($this->domain, $this->port, 1)) {
            echo "Error: {$fp->errMsg}[{$fp->errCode}]\n";
        }

        $message = $this->client->recv(); //客户端接收信息
        echo "Get Message From Server:{$message}\n";

        fwrite(STDOUT, "请输入消息：");
        $msg = trim(fgets(STDIN));
        $this->client->send($msg);
    }

}
