# PHP AI Chat Web

一个基于 PHP 和 Vue.js 开发的 AI 聊天应用，支持与 ChatGPT 和 DeepSeek 进行对话。适用于环境没人敢动，但是碰巧安装了PHP的服务器。 

## 功能特点

- 🤖 支持多个 AI 模型（ChatGPT、DeepSeek）
- 💬 实时流式对话响应
- 📝 支持 Markdown 格式渲染
- 💾 本地存储聊天历史
- 📋 消息快捷复制
- 🔄 多会话管理
- ✏️ 会话标题编辑
- 🗑️ 历史记录清理

## 技术栈

- 前端：Vue.js 3.0 + Marked.js
- 后端：PHP
- API：ChatGPT API + DeepSeek API

## 快速开始
1. 配置环境要求
- PHP 5.6+
- Apache/Nginx
- PHP CURL 扩展

2. 克隆项目到本地
将下面4个文件复制到www/html/目录下：
- phpBackend/chat.php
- phpBackend/demo.html
- phpBackend/marked.min.js
- phpBackend/vue.global.js

3. 配置 API 密钥：
在 phpBackend/chat.php 中配置你的 API 密钥：
```PHP
$API_CONFIG = array(
    'CHATGPT' => array(
        'url' => 'your-api-url',
        'key' => 'your-api-key'
    ),
    'DEEPSEEK' => array(
        'url' => 'your-api-url',
        'key' => 'your-api-key'
    )
);
```
4. 启动服务器并访问 demo.html

## 没有任何后端
没关系，还提供了一个不需要后端的方案。  
1. 克隆项目到本地
将下面3个文件复制到本地目录：
- NoBackend/demo.html
- NoBackend/marked.min.js
- NoBackend/vue.global.js

2. 配置 API 密钥：
在 NoBackend/demo.html 中配置你的 API 密钥：
```JS
<script>
    // API 配置
    const API_CONFIG = {
        CHATGPT: {
            url: 'your-api-url',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'your-api-key' // 替换为你的 API key
            }
        },
        DEEPSEEK: {
            url: 'your-api-url',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'your-api-key' // 替换为你的 API key
            }
        }
    }
</script>
```
3. 使用浏览器打开 demo.html
4. 警告！这个方式非常危险，任何能够打开demo.html的人都可以看到你的 API 密钥。