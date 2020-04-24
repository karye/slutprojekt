#!/bin/sh

cat "$@" | while read user url;
do
    echo -e "Cloning $user repos: $url"
    mkdir $user
    git clone $url $user
done
