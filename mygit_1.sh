#!/usr/bin/env bash

git remote set-url origin https://github.com/HCarlos/siac.git
#git remote add origin https://github.com/HCarlos/siac.git

# git remote set-url origin git@github.com:HCarlos/siac.git

# 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

# pwd : postg  = R=D7,Z)$F%q,Kj?CP,DM{1CFNTtQ1B@4=V!d

git config --global user.email "r0@tecnointel.mx"
git config --global user.name "HCarlos"
git config --global color.ui true
git config core.fileMode false
git config --global push.default simple

git checkout master

git status

#git rm --cached /.env
git rm -r --cached .csv
git rm -r --cached public/csv
git rm -r --cached public/csv/
git rm -r --cached .env
git rm -r --cached .env.example
git rm -r --cached .env_prod
git rm -r --cached .gitignore
git rm -r --cached .gitattributes
git rm -r --cached ./.editorconfig
git rm -r --cached ./.buildconfig
git rm -r --cached .sh
git rm -r --cached .idea
git rm -r --cached otros
git rm -r --cached laravel-echo-server.json

git rm -r --cached composer.json
git rm -r --cached composer.lock

git add .

git commit -m "SIAC - B00 | L7.30.6 Production"

git push -u origin main --force

exit


