## laravel簡易購物車
- 建立、修改、刪除訂單
- adminAc:wayne@mail.com
- adminPw:wayne123

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
- 使用下拉選單選擇購物車商品數量時改變小計
    - 在<select>增加屬性onchange，在改變選單時觸發javascript的函式submit()
- onchange無法動作
    - 使用<script>寫DOM'change'時submit()
- 使用下拉選單選擇購物車商品數量時商品位置因創造時間先後而亂跳導致購買數量與上品id在post的時候對不上，導致購買數量錯誤
    - 在controller不使用with('items')而是使用$order->items()另外提取商品在做orderBy()固定商品位置