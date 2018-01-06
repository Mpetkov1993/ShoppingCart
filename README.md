1. composer update  
2. php bin/console doctrine:database:create  
3. php bin/console doctrine:schema:update  
4. run shopping_cart.sql  

Admin Profile:  
name: admin  
pass: admin  

Shopping cart  
Required functionalities:  
•	User registration / login and user profiles.  
•	User roles (user, administrator, editor)  
•	Initial cash for users  
•	Product categories  
•	Listing products in categories  
•	Add to cart functionality  
•	Promotions for certain time interval  
o	Promotions on certain products (% discount)  
o	Promotions on all products (% discount)  
o	Promotions on certain categories (% discount)  
o	Promotions for certain user criteria (registered more than X days, have more than X cash, etc…)  
o	If two or more promotions collide on a date period for certain product – the biggest one applies only  
•	Visibility only of available products  
•	Quantity visibility  
•	Checkout the cart  
•	View cart  
•	Users can sell bought products  
•	Editors can add/delete product categories  
•	Editors can add/delete products  
•	Editors can move products between categories  
•	Editors can change quantities  
•	Editors can reorder products  
•	Administrators have full access on products, categories, users and their possessions  
Bonus functionalities  
•	Managing the cart  
•	Users can sell products and put them promotions  
•	Users can make comments on products (review)  
•	Administrators: ban users  
•	Administrators: ban IP’s  
