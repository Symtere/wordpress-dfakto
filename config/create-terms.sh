#!/bin/bash
filename="terms.txt"
cat $filename | while read -r LINE; do
    wp term create brand "$LINE"
done