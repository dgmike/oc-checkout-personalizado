VERSION := $(shell which stepup > /dev/null && stepup version --next-release --format mvn)
USER := $(shell git config user.name)
DATE := $(shell date +'%b/%d %Y %H:%M %z')
CHECK_FILES := $(shell find -type f -name '*.php' -or -name '*.tpl')
CHANGELOG_FILE := Changelog.wiki
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
	echo '==' ${VERSION} '('${DATE} 'by '${USER}') ==' > ${CHANGELOG_FILE}
	stepup notes | sed "s/^---$$//" >> ${CHANGELOG_FILE}
	echo >> ${CHANGELOG_FILE}
	stepup changelog -f wiki >> ${CHANGELOG_FILE}
	git add ${CHANGELOG_FILE}
	git commit -m 'Updating changelog'
	sed -i 's,<version>.*</version>,<version>${VERSION}</version>,' install.xml
	git add install.xml
	git commit -m "dump version ${VERSION}"
	stepup version create --no-editor
	git push origin master
	git push --tags

package:
	zip -v -r checkoutp-${VERSION}.ocmod.zip * -x '.git' -x 'Makefile' -x '.stepuprc' -x 'checkoutp*.zip'

check: checking $(CHECK_FILES)

checking: ; @echo " checking files"

.PHONY: $(CHECK_FILES)
$(CHECK_FILES) :
	@echo -ne '    \033[0;34mchecking\033[0m' $@
	@php -l $@ > /dev/null 2>&1
	@echo -e \\r '  \033[1;32m[success]\033[0m '

clean:
	rm -v *.ocmod.zip
