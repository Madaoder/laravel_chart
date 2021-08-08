## laravel簡易購物車
- 建立、修改、刪除訂單

## 學習目標
- RESTful API
- M:N relationship

## 使用工具
- 前端:bootstrap
- 框架:laravel
- 資料庫:mySQL

## 遇到問題
- 使用Order->items()->attach()的時候出現Illuminate\Database\Eloquent\Collection::items
    - 在使用query builder的時候find()與where()的不同，find()傳回的是instance(parameter是primary key所以回傳是單一物件)，where()搭配get()傳回的是collection(不只一個物件)