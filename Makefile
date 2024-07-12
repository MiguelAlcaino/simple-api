.PHONY: db-create
db-create:
	@echo "Creating database..."
	docker compose exec php bin/console doctrine:database:create --if-not-exists

.PHONY: db-update
db-update:
	@echo "Migrating database..."
	docker compose exec php bin/console doctrine:schema:update --force

.PHONY: destroy
destroy:
	@echo "Destroying containers..."
	docker compose down --volumes

.PHONY: build
build:
	@echo "Building containers..."
	docker compose up -d --build
