#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$(git tag | tail -n 1)
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

# Build new release
mkdir -p FroshGrafana
git archive --format zip --output FroshGrafana/FroshGrafana-${commit}.zip $1
