.PHONY: none watch-css watch-js prod dev

CSS_FILES := src/css/main.css $(wildcard src/css/base/*.css) $(wildcard src/css/header/*.css) $(wildcard src/css/content/*.css)

JS_FILES := $(shell find src/js -type f -name '*.js')

none:
	echo "Please select a target."

prod: dist/prod.js dist/prod.css

dev: dist/dev.js dist/dev.css

watch-js:
	watchify src/js/main.js -o dist/dev.js --debug --verbose --poll

watch-css:
	echo $(CSS_FILES) | tr ' ' "\n" | entr sh -c 'make dist/dev.css'

dist/dev.css: $(CSS_FILES)
	cleancss --source-map --source-map-inline-sources -O0 -o $@ $^

dist/prod.css: $(CSS_FILES)
	cleancss -O2 -o $@ $^

dist/prod.js: package.json $(JS_FILES)
	browserify src/js/main.js -o $@

dist/dev.js: package.json $(JS_FILES)
	browserify src/js/main.js -o $@ --debug 

