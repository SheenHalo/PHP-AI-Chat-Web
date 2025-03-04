<?php
// 在文件开头添加
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json');

// 如果是预检请求，直接返回
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    exit(0);
}

// API 配置
$API_CONFIG = array(
    'CHATGPT' => array(
        'url' => ‘’,
        'key' => ‘’
    ),
    'DEEPSEEK' => array(
        'url' => '',
        'key' => ‘’
    )
);

// 获取请求体
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!$data) {
    http_response_code(400);
    echo json_encode(array('error' => '无效的请求数据'));
    exit;
}

$ai_type = $data['ai_type'];
$messages = $data['messages'];
$model = $ai_type === 'CHATGPT' ? 'gpt-4o' : 'deepseek-chat';

if (!isset($API_CONFIG[$ai_type])) {
    http_response_code(400);
    echo json_encode(array('error' => '不支持的 AI 类型'));
    exit;
}

$config = $API_CONFIG[$ai_type];

// 创建 cURL 请求
$ch = curl_init($config['url']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Authorization: Bearer ' . $config['key']
));

// 添加 SSL 验证选项
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 禁用证书验证
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); // 禁用主机验证

// 准备请求数据
$request_data = array(
    'model' => $model,
    'messages' => $messages,
    'stream' => true
);

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($request_data));

// 设置写入回调函数来处理流式响应
curl_setopt($ch, CURLOPT_WRITEFUNCTION, function($ch, $data) {
    echo $data;
    flush();
    ob_flush();
    return strlen($data);
});

// 执行请求
curl_exec($ch);

// 在 curl 请求部分添加错误日志
if (curl_errno($ch)) {
    $error_message = curl_error($ch);
    error_log("CURL Error: " . $error_message);
    http_response_code(500);
    echo json_encode(array('error' => $error_message));
}

curl_close($ch);