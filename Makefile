VERSION := $(shell which stepup > /dev/null && stepup version --next-release --format mvn)
USER := $(shell git config user.name)
DATE := $(shell date +'%b/%d %Y %H:%M %z')
CHECK_FILES := $(shell find -type f -name '*.php' -or -name '*.tpl')
ifdef VERSION
STEPUP_HAS_NOTES := $(shell test `stepup notes | wc -l` -gt 1 && echo true)
endif

default: clean check build package

build:
ifndef VERSION
	$(error "step-up gem is required")
endif
ifndef STEPUP_HAS_NOTES
	$(error "no notes found")
endif
	@echo "generating version... ${VERSION}"
	echo ${VERSION} '('${DATE} 'by '${USER}')' > Changelog
	stepup notes | sed "s/^---$$//" >> Changelog
	echo >> Changelog
	stepup changelog | sed -r "s/\x1B\[([0-9]{1,2}(;[0-9]{1,2})?)?[m|K]//g" >> Changelog
	git add Changelog
	git commit -m 'Updating changelog'
	sed -i 's,<version>.*</version>,<version>${VERSION}</version>,' install.xml
	git add install.xml
	git commit -m "dump version ${VERSION}"
	stepup version create --no-editor

package:
	zip -v -r checkoutp-${VERSION}.ocmod.zip * -x '.git' -x 'Makefile' -x '.stepuprc' -x 'checkoutp*.zip'

check: $(CHECK_FILES)

.PHONY: $(CHECK_FILES)
$(CHECK_FILES) :
	@php -l $@ > /dev/null 2>&1

clean:
	rm -v *.ocmod.zip
