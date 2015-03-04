<?php

namespace gdmedia\SSAutoGitIgnore;

use Composer\Script\Event;

class UpdateScript {

    public static function Go(Event $event) {
        $gi          = new GitIgnoreEditor(getcwd() . '/.gitignore');
        $packageInfo = new SSPackageInfo($event->getComposer());
        $ignores     = array();
        foreach ($packageInfo->GetSSModules() as $value) {
            $ignores[] = "/" . $value["path"] . "/";
        }
        $gi->setLines($ignores);
        $gi->save();
    }

}
