setup:
	- rm -rf public/ui_resources
	- git clone https://github.com/Khoacannotcode/ui_resources.git
	- mv ui_resources public/
	- echo "public/ui_resources" | tee -a .gitignore >/dev/null
	- sudo composer install
	- cp .env.example .env
	- php artisan key:generate
	- sudo chmod -R 777 .

update_ui:
	- rm -rf public/ui_resources
	- git clone https://github.com/Khoacannotcode/ui_resources.git
	- mv ui_resources public/
	- sudo chmod -R 777 public/ui_resources