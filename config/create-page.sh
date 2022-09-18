#!/bin/bash
filename="pages.txt"
cat $filename | while read -r LINE; do
    wp post create --post_type=page --post_title="$LINE" --post_status=publish --post_author=1
done
