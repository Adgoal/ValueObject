.PHONY: lint layer style coding-standards
static-analysis: lint style coding-standards ## Run phpstan, deprac, easycoding standarts code static analysis

.PHONY: phpstan psalm
style: phpstan psalm ## executes php analizers


.PHONY: ecs-fixer
coding-standards-fixer: ecs-fixer

.PHONY: ecs phpmd
coding-standards: ecs phpmd


.PHONY: lint
lint: ## checks syntax of PHP files
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/parallel-lint ./ --exclude vendor'

.PHONY: layer
layer: ## check issues with layers (deptrac tool)
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/deptrac analyze'

.PHONY: ecs
ecs:
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/ecs check src tests'

.PHONY: ecs-fixer
ecs-fixer:
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/ecs check src tests --fix'

.PHONY: phpmd
phpmd:
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/phpmd src/ text phpmd.xml'


.PHONY: infection
infection: ## executes mutation framework infection
	docker-compose run --rm --no-deps php-fpm sh -lc './vendor/bin/infection --min-msi=70 --min-covered-msi=80 --threads=$(JOBS) --coverage=var/report'

.PHONY: phpstan
phpstan: ## phpstan - PHP Static Analysis Tool
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/phpstan analyse -l 6 -c phpstan.neon src tests'

.PHONY: psalm
psalm: ## psalm is a static analysis tool for finding errors in PHP applications
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/psalm --config=psalm.xml'

.PHONY: psalm-fixer
psalm-fixer: ## psalm is a static analysis tool for finding errors in PHP applications
	docker-compose run --rm --no-deps php sh -lc './vendor/bin/psalm --config=psalm.xml --alter --issues=MissingParamType --dry-run'

.PHONY: phan
phan: ## phan is a static analyzer for PHP that prefers to minimize false-positives.
	docker-compose run --rm --no-deps php sh -lc 'PHAN_DISABLE_XDEBUG_WARN=1 PHAN_ALLOW_XDEBUG=1 php -d zend.enable_gc=0 ./vendor/bin/phan --config-file phan.php --require-config-exists'
