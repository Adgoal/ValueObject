include .env
export

include .make/static-analysis.mk
include .make/composer.mk
include .docker/docker.mk

sources = bin/console config src
version = $(shell git describe --tags --dirty --always)
build_name = application-$(version)
# use the rest as arguments for "run"
RUN_ARGS := $(wordlist 2,$(words $(MAKECMDGOALS)),$(MAKECMDGOALS))
# ...and turn them into do-nothing targets
#$(eval $(RUN_ARGS):;@:)

.PHONY: fix-permission
fix-permission: ## fix permission for docker env
	sudo chown -R $(shell whoami):$(shell whoami) *
	sudo chown -R $(shell whoami):$(shell whoami) .docker/*



.PHONY: phpunit
phpunit: ## execute project unit tests
	docker-compose run --rm php sh -lc  "./vendor/bin/phpunit $(conf)"

.PHONY: logs
logs: ## look for service logs
	docker-compose logs -f $(RUN_ARGS)

.PHONY: help
help: ## Display this help message
	    @cat $(MAKEFILE_LIST) | grep -e "^[a-zA-Z_\-]*: *.*## *" | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: php-shell
php-shell: ## PHP shell
	docker-compose run --rm php sh -l

tests-unit: ## Run unit-tests suite
	docker-compose run --rm php sh -lc 'XDEBUG_MODE=coverage vendor/bin/phpunit --testsuite unit-tests --configuration phpunit.xml.dist'

.PHONY: build composer-install
install: build composer-install

.PHONY: test lint static-analysis phpunit coding-standards tests-unit
test: build lint static-analysis coding-standards tests-unit stop ## Run all test suites
