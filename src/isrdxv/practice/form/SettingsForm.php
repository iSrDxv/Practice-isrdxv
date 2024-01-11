<?php

namespace isrdxv\practice\form;

use pocketmine\Server;
use pocketmine\player\Player;

use libs\formapi\{
  BaseForm,
  CustomForm,
  CustomFormResponse,
  element\Label,
  element\Input,
  element\Dropdown,
  element\Toggle
};

use isrdxv\practice\{
  Loader,
  session\Session,
  session\SessionManager,
  translation\Translation
};

class SettingsForm extends CustomForm
{
  
  public function __construct(Session $session)
  {
    parent::__construct(
      Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-title-form"),
      [
        new Label("text", Loader::getinstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-text-form")),
        new Dropdown("language", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-language-form"), [
          "es_ES",
          "en_US"
          ], Loader::getInstance()->getTranslation()->getNumberByLanguage($session->getLanguage())),
        new Toggle("cps", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-cps-form"), $session->getSetting("cps")),
        new Toggle("score", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-scoreboard-form"), $session->getSetting("score")),
        new Toggle("queue", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-queue-form"), $session->getSetting("queue")),
        new Toggle("auto-join", Loader::getInstance()->getTranslation()->sendTranslation($session->getLanguage(), "settings-join-form"), $session->getSetting("auto-join"))
      ],
      function(Player $player, CustomFormResponse $response): void {
        $session->setLanguage(Loader::getInstance()->getTranslation()->getLanguageByNumber($response->getInt("language")));
        $session->setSettings([
          "cps" => $response->getBool("cps"), 
          "score" => $response->getBool("score"),
          "queue" => $response->getBool("queue"),
          "auto-join" => $response->getBool("auto-join")
        ]);
        $player->sendMessage("§asuccesfully");
      }
    );
  }
}