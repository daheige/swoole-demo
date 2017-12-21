<?php
class Server
{
    private $serv;
    private $domain;
    private $port;

    public function __construct($domain = "0.0.0.0", $port = 8080)
    {
        $this->domain = $domain;
        $this->port   = $port;
        $this->serv   = new swoole_server($this->domain, $this->port);
        $this->serv->set([
            'worker_num'    => 8,
            'daemonize'     => false,
            'max_request'   => 10000, //最大连接数
            'dispatch_mode' => 2,
            'debug_mode'    => 1, //开启调试模式
        ]);
        $this->serv->on('Start', [$this, 'onStart']);
        $this->serv->on('Connect', [$this, 'onConnect']);
        $this->serv->on('Receive', [$this, 'onReceive']);
        $this->serv->on('Close', [$this, 'onClose']);
        $this->serv->start(); // 启动应用
    }

    // //开始连接
    public function onStart($serv)
    {
        echo "Start connection....\n";
    }

    //当客户端连接上了就发送消息
    public function onConnect($serv, $fd, $from_id)
    {
        $serv->send($fd, 'hello ' . $fd . 'ddddd');
    }

    public function onReceive(swoole_server $serv, $fd, $from_id, $data)
    {
        echo "Get message from client {$fd}:{$data}\n";
    }

    public function onClose($serv, $fd, $from_id)
    {
        echo "client {$fd} has closed\n";
    }
}
