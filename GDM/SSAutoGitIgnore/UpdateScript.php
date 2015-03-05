<?php

namespace GDM\SSAutoGitIgnore;

use Composer\Script\Event;

class UpdateScript {

    public static function Go(Event $event) {
        $event->getIO()->writeError('<info>Generating .gitignore: </info>', false);
        $gi          = new GitIgnoreEditor(getcwd() . '/.gitignore');
        $packageInfo = new SSPackageInfo($event->getComposer());
        $ignores     = array();
        foreach ($packageInfo->GetSSModules() as $value) {
            $ignores[] = "/" . $value["path"] . "/";
        }
        sort($ignores);

        $gi->setLines($ignores);
        $gi->save();
        $event->getIO()->writeError('<info>Done - Set to ignore '.count($ignores).' packages</info>');
    }

}
