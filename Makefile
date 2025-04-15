###
### VARIABLES
###
APP_NAME ?= CV

###
### DOCKER
###
.PHONY: help
.DEFAULT_GOAL := help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

watch: ## watch files
	cd themes/alchimy_theme_$(APP_NAME) && npm run watch

up: ## launching dockers
	$(info  )
	$(info  launching ///////////////////////////////////////)
	$(info )
	$(info     [$(APP_NAME)])
	$(info )
	$(info --------------------------------)
	$(info  )
	docker compose up -d --build || echo "\033[0;31m ^^^ Error | launch ^^^ \033[0m"
	make watch

up-staging: ## launching dockers
	$(info  )
	$(info  launching ///////////////////////////////////////)
	$(info )
	$(info     [$(APP_NAME)])
	$(info )
	$(info --------------------------------)
	$(info  )
	make permissions-staging
	make install
	docker compose -f docker-compose-staging.yml up -d --build --remove-orphans || echo "\033[0;31m ^^^ Error | launch ^^^ \033[0m"

### REBUILD
build: ## force building docker images again
	$(info  )
	$(info  forcing rebuild ///////////////////////////////////////)
	$(info )
	$(info     [$(APP_NAME)])
	$(info )
	$(info -------------------------------- )
	docker builder prune || echo "\033[0;31m ^^^ Error | prune ^^^ \033[0m"
	docker compose  build --pull --no-cache || echo "\033[0;31m ^^^ Error | build ^^^ \033[0m"

### STOP
stop: ## stopping dockers
	$(info  )
	$(info  stopping ///////////////////////////////////////)
	$(info )
	$(info     [$(APP_NAME)])
	$(info  )
	$(info -------------------------------- \033[0m)
	$(info  )
	docker compose stop || echo "\033[0;31m ^^^ Error | stop ^^^ \033[0m"

stop-staging: ## launching dockers
	$(info  )
	$(info  launching ///////////////////////////////////////)
	$(info     [$(APP_NAME)])
	$(info --------------------------------)
	$(info  )
	docker compose -f docker-compose-staging.yml stop || echo "\033[0;31m ^^^ Error | stop ^^^ \033[0m"

### BASH
bash: ## access bash in wordpress container
	docker compose exec -it $(APPLICATION_DOCKER_TAG) bash	

### LOGS
logs-wp: ## display 100 last logs lines (WORDPRESS)
	docker compose logs $(APPLICATION_DOCKER_TAG) --tail=100

logs-db: ## display 100 last logs lines (DB)
	docker compose logs db --tail=100

### INSTALL
install:
	cd themes/alchimy_theme_cv && composer install
	cd themes/alchimy_theme_cv && npm install
	cd themes/alchimy_theme_cv && npm run prod
	@git config --list | grep -q `pwd` && echo "Folder is already in git safe directories." || git config --global --add safe.directory `pwd`

### EXPORT WORDPRESS
wp-export: ## create a wordpress folder with a classic structure
	mkdir ./wp_export
	cp -a ./wp_data/. ./wp_export/.
	cp -a ./plugins/. ./wp_export/wp-content/plugins/.
	cp -a ./themes/. ./wp_export/wp-content/themes/.

### ENFORCE STAGING PERMISSIONS
permissions: ## enforce correct permissions
	sudo chown -R www-data:www-data ./themes
	sudo chown -R www-data:www-data ./plugins
	sudo chown -R www-data:www-data ./wp_data

### ENFORCE STAGING PERMISSIONS
permissions-staging: ## enforce correct permissions (staging)
	make permissions
	sudo chgrp -R developer ./.git
	sudo chmod g+w ./ -R
	sudo chmod g+w ./.git -R
