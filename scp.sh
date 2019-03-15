#!/bin/bash

SSH_DSN="elpadi@thejackmag.com"
SSH_PATH="/home2/elpadi/woocommerce.thejackmag.com"
SSH_PORT="2222"

upload() {
	echo "Uploading $1"
	scp -r -P $SSH_PORT "$1" "$SSH_DSN:$SSH_PATH/$1"
}

download() {
	echo "Downloading $1"
	scp -r -P $SSH_PORT "$SSH_DSN:$SSH_PATH/$1" "$1"
}

while [[ $# > 0 ]]; do
	if [[ -z $ACTION ]]; then
		if [[ "$1" != "u" ]] && [[ "$1" != "d" ]]; then
			echo "First param must be 'u' or 'd'"
			exit 1
		fi
		ACTION="$1"
	else
		if [[ "$ACTION" == "u" ]]; then upload "$1"; fi
		if [[ "$ACTION" == "d" ]]; then download "$1"; fi
	fi
	shift
done

exit 0
