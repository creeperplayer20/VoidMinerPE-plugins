<?php

namespace restartme\task;

use pocketmine\scheduler\PluginTask;
use restartme\RestartMe;

class RestartServerTask extends PluginTask{
    /** @var RestartMe */
    private $plugin;
    /**
     * @param RestartMe $plugin
     */
    public function __construct(RestartMe $plugin){
        parent::__construct($plugin);
        $this->plugin = $plugin;
    }
    /**
     * @param int $currentTick
     */
    public function onRun($currentTick){
        $timer = $this->plugin->getTimer();
        if(!$timer->isPaused()){
            $timer->subtractTime(1);
            if($timer->getTime() <= $this->plugin->getConfig()->get("startCountdown")){
                $timer->broadcastTime($this->plugin->getConfig()->get("countdownMessage"), $this->plugin->getConfig()->get("displayType"));
            }
            if($timer->getTime() < 1){
                $timer->initiateRestart(RestartMe::NORMAL);
            }
        }
    }
}