# SSAutoGitIgnore
A Composer post-update-cmd script to automatically add Composer managed SilverStripe modules and themes to .gitignore

## Install instructions
### Add it to your project with:
`composer require gdmedia/ss-auto-git-ignore`
### Add the following to your composer.json
```
"scripts": {
     "post-update-cmd": "GDM\\SSAutoGitIgnore\\UpdateScript::Go"
}
```
