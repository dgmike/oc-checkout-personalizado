VERSION := $(shell which stepup > /dev/null && stepup version --next-release --format mvn)
ifdef VERSION
STEPUP_HAS_NOTES := $(shell test `stepup notes | wc -l` -gt 1 && echo true)
endif

default: build

build:
ifndef VERSION
	$(error "step-up gem is required")
endif
ifndef STEPUP_HAS_NOTES
	$(error "no notes found")
endif
	@echo "generating version... ${VERSION}"
	sed -i 's,<version>.*</version>,<version>${VERSION}</version>,' install.xml
	git add install.xml
	git commit -m "dump version ${VERSION}"
	stepup version create --no-editor
