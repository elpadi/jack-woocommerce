.PHONY: none watch-css watch-js prod dev

CSS_FILES := src/css/main.css $(wildcard src/css/base/*.css) $(wildcard src/css/header/*.css) $(wildcard src/css/content/*.css)

JS_FILES := $(shell find src/js -type f -name '*.js')

none:
	echo "Please select a target."

prod: dist/prod.js dist/prod.css

dev: dist/dev.js dist/dev.css

watch-js:
	simplifyify --watch --debug -o dist/dev.js src/js/main.js

watch-css:
	echo $(CSS_FILES) | tr ' ' "\n" | entr sh -c 'make dist/dev.css'

dist/dev.css: $(CSS_FILES)
	cleancss --source-map -O0 -o $@ $^

dist/prod.css: $(CSS_FILES)
	cleancss --source-map -O2 -o $@ $^

dist/prod.js: package.json $(JS_FILES)
	simplifyify --debug --minify -o $@ src/js/main.js

dist/dev.js: package.json $(JS_FILES)
	simplifyify --debug -o $@ src/js/main.js

