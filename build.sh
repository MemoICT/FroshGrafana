#!/usr/bin/env bash

commit=$1
if [ -z ${commit} ]; then
    commit=$TRAVIS_COMMIT
    if [ -z ${commit} ]; then
        commit="master";
    fi
fi

echo "Packing commit/release: ${commit}"

# Build new release
mkdir -p FroshGrafana
git archive HEAD --format zip --output FroshGrafana/FroshGrafana-${commit}.zip
