# Laravel 11 用於尋找資源路由中遺漏方法的命令

路由是指應用程式的網址和相應的控制器方法之間的對應。每當用戶訪問一個網址時，會查找與該網址對應的路由，並執行相應的控制器方法。

## 使用方式
- 把整個專案複製一份到你的電腦裡，這裡指的「內容」不是只有檔案，而是指所有整個專案的歷史紀錄、分支、標籤等內容都會複製一份下來。
```sh
$ git clone
```
- 將 __.env.example__ 檔案重新命名成 __.env__，如果應用程式金鑰沒有被設定的話，你的使用者 sessions 和其他加密的資料都是不安全的！
- 當你的專案中已經有 composer.lock，可以直接執行指令以讓 Composer 安裝 composer.lock 中指定的套件及版本。
```sh
$ composer install
```
- 產生 Laravel 要使用的一組 32 字元長度的隨機字串 APP_KEY 並存在 .env 內。
```sh
$ php artisan key:generate
```
- 執行 __Artisan__ 指令的 __route:check-resources__ 來尋找資源路由中遺漏方法。
```sh
$ php artisan route:check-resources
```

----

## 畫面截圖
![](https://i.imgur.com/56D3cPo.png)
> 避免資源路由找不到對應的控制器方法
