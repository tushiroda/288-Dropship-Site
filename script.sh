#!/bin/bash

#pass in the bestbuy file first, then the ebay
readarray -t bestBuy < $1
readarray -t eBay < $2

while true; do
	for i in {0..19}; do
		wget --no-verbose ${bestBuy[$i]} -O "b$i.html"
		wget --no-verbose ${eBay[$i]} -O "e$i.html"
	done

	java -jar tagsoup-1.2.1.jar --files *.html
	sed -i 's/&#[0-9]*;//g' e*.xhtml

	python3 parser.py
	
	rm *.html
	rm *.xhtml

	sleep 6h
done
